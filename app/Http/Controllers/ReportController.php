<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\Beneficiary;
use App\Models\VolunteerActivity;
use App\Models\AidSession;
use App\Models\AidType;
use App\Models\AdministrativeRegion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function summary(Request $request)
    {
        $dateRange = $this->getDateRange($request);

        $summary = [
            'total_volunteers' => Volunteer::count(),
            'active_volunteers' => Volunteer::where('is_active', true)->count(),
            'total_beneficiaries' => Beneficiary::count(),
            'total_activities' => VolunteerActivity::whereBetween('visit_date', $dateRange)->count(),
            'total_aid_distributed' => VolunteerActivity::whereBetween('visit_date', $dateRange)
                ->with('aids')
                ->get()
                ->sum(function ($activity) {
                    return $activity->aids->sum('quantity');
                }),
            'regions_covered' => VolunteerActivity::whereBetween('visit_date', $dateRange)
                ->distinct('beneficiary_id')
                ->count(),
        ];

        // Activities by month
        $monthlyActivities = VolunteerActivity::whereBetween('visit_date', $dateRange)
            ->selectRaw('MONTH(visit_date) as month, YEAR(visit_date) as year, COUNT(*) as count')
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Top performing volunteers
        $topVolunteers = Volunteer::withCount(['activities' => function ($query) use ($dateRange) {
                $query->whereBetween('visit_date', $dateRange);
            }])
            ->orderBy('activities_count', 'desc')
            ->limit(10)
            ->get();

        return view('reports.summary', compact('summary', 'monthlyActivities', 'topVolunteers'));
    }

    public function distribution(Request $request)
    {
        $dateRange = $this->getDateRange($request);

        // Aid distribution by type
        $aidDistribution = DB::table('activity_aids')
            ->join('volunteer_activities', 'activity_aids.volunteer_activity_id', '=', 'volunteer_activities.id')
            ->join('aid_types', 'activity_aids.aid_type_id', '=', 'aid_types.id')
            ->whereBetween('volunteer_activities.visit_date', $dateRange)
            ->selectRaw('aid_types.name, aid_types.unit, SUM(activity_aids.quantity) as total_quantity, SUM(activity_aids.nominal_amount) as total_nominal')
            ->groupBy('aid_types.id', 'aid_types.name', 'aid_types.unit')
            ->get();

        // Distribution by region
        $regionDistribution = DB::table('volunteer_activities')
            ->join('beneficiaries', 'volunteer_activities.beneficiary_id', '=', 'beneficiaries.id')
            ->join('administrative_regions as kabupaten', 'beneficiaries.kabupaten_id', '=', 'kabupaten.id')
            ->join('administrative_regions as kecamatan', 'beneficiaries.kecamatan_id', '=', 'kecamatan.id')
            ->join('administrative_regions as desa', 'beneficiaries.desa_id', '=', 'desa.id')
            ->whereBetween('volunteer_activities.visit_date', $dateRange)
            ->selectRaw('kabupaten.kab_nama as kabupaten_name, kecamatan.kec_nama as kecamatan_name, desa.kel_nama as desa_name, COUNT(*) as activity_count')
            ->groupBy('kabupaten.id', 'kecamatan.id', 'desa.id', 'kabupaten.kab_nama', 'kecamatan.kec_nama', 'desa.kel_nama')
            ->orderBy('activity_count', 'desc')
            ->get();

        return view('reports.distribution', compact('aidDistribution', 'regionDistribution'));
    }

    public function volunteers(Request $request)
    {
        $dateRange = $this->getDateRange($request);

        $volunteerStats = Volunteer::with(['kabupaten', 'kecamatan', 'desa'])
            ->withCount(['activities' => function ($query) use ($dateRange) {
                $query->whereBetween('visit_date', $dateRange);
            }])
            ->get()
            ->map(function ($volunteer) use ($dateRange) {
                $activities = $volunteer->activities()
                    ->whereBetween('visit_date', $dateRange)
                    ->with('aids')
                    ->get();

                $totalAidsDistributed = $activities->sum(function ($activity) {
                    return $activity->aids->sum('quantity');
                });

                $uniqueBeneficiaries = $activities->pluck('beneficiary_id')->unique()->count();

                return [
                    'volunteer' => $volunteer,
                    'activities_count' => $volunteer->activities_count,
                    'total_aids_distributed' => $totalAidsDistributed,
                    'unique_beneficiaries' => $uniqueBeneficiaries,
                    'last_activity' => $activities->max('visit_date'),
                ];
            })
            ->sortByDesc('activities_count');

        return view('reports.volunteers', compact('volunteerStats'));
    }

    private function getDateRange(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        return [$startDate, $endDate];
    }
}