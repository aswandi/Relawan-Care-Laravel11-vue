<?php

namespace App\Http\Controllers;

use App\Models\VolunteerActivity;
use App\Models\Volunteer;
use App\Models\Beneficiary;
use App\Models\AidSession;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = VolunteerActivity::with(['volunteer', 'beneficiary.desa', 'aidSession', 'aids.aidType', 'photos']);

        // Filter by volunteer
        if ($request->filled('volunteer_id')) {
            $query->where('volunteer_id', $request->volunteer_id);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('visit_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('visit_date', '<=', $request->end_date);
        }

        // Filter by aid session
        if ($request->filled('aid_session_id')) {
            $query->where('aid_session_id', $request->aid_session_id);
        }

        $activities = $query->orderBy('visit_date', 'desc')->paginate(20);

        // Data for filters
        $volunteers = Volunteer::where('is_active', true)->orderBy('name')->get();
        $aidSessions = AidSession::where('is_active', true)->orderBy('name')->get();

        return view('activities.index', compact('activities', 'volunteers', 'aidSessions'));
    }

    public function show(VolunteerActivity $activity)
    {
        $activity->load(['volunteer', 'beneficiary.desa', 'aidSession', 'aids.aidType', 'photos']);
        
        return view('activities.show', compact('activity'));
    }
}