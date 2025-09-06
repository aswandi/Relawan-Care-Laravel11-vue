<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\Beneficiary;
use App\Models\VolunteerActivity;
use App\Models\AidSession;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_volunteers' => Volunteer::count(),
            'total_beneficiaries' => Beneficiary::count(),
            'today_activities' => VolunteerActivity::whereDate('created_at', today())->count(),
            'active_sessions' => AidSession::where('is_active', true)->count(),
            'inactive_volunteers' => Volunteer::where('is_active', false)->count(),
        ];

        $recent_activities = VolunteerActivity::with(['volunteer', 'beneficiary.desa'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard', compact('stats', 'recent_activities'));
    }
}