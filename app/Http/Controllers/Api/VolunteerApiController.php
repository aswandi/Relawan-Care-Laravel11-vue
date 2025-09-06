<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use App\Models\Beneficiary;
use App\Models\AidSession;
use App\Models\AidType;
use App\Models\VolunteerActivity;
use App\Models\ActivityAid;
use App\Models\ActivityPhoto;
use App\Models\AdministrativeRegion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class VolunteerApiController extends Controller
{
    public function getBeneficiaries(Request $request)
    {
        $volunteer = $request->user('volunteer');
        
        $beneficiaries = Beneficiary::where('is_active', true)
            ->where('desa_id', $volunteer->desa_id)
            ->with(['kabupaten', 'kecamatan', 'desa'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $beneficiaries
        ]);
    }

    public function getBeneficiary($id, Request $request)
    {
        $volunteer = $request->user('volunteer');
        
        $beneficiary = Beneficiary::where('id', $id)
            ->where('is_active', true)
            ->where('desa_id', $volunteer->desa_id)
            ->with(['kabupaten', 'kecamatan', 'desa'])
            ->first();

        if (!$beneficiary) {
            return response()->json([
                'success' => false,
                'message' => 'Penerima bantuan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $beneficiary
        ]);
    }

    public function getAidSessions(Request $request)
    {
        $sessions = AidSession::where('is_active', true)
            ->with(['items.aidType'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sessions
        ]);
    }

    public function getAidTypes(Request $request)
    {
        $aidTypes = AidType::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'data' => $aidTypes
        ]);
    }

    public function storeActivity(Request $request)
    {
        $request->validate([
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'aid_session_id' => 'required|exists:aid_sessions,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'notes' => 'nullable|string|max:1000',
            'aids' => 'required|array|min:1',
            'aids.*.aid_type_id' => 'required|exists:aid_types,id',
            'aids.*.quantity' => 'nullable|integer|min:1',
            'aids.*.nominal_amount' => 'nullable|numeric|min:0',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $volunteer = $request->user('volunteer');

        // Verify beneficiary is in volunteer's area
        $beneficiary = Beneficiary::where('id', $request->beneficiary_id)
            ->where('desa_id', $volunteer->desa_id)
            ->first();

        if (!$beneficiary) {
            return response()->json([
                'success' => false,
                'message' => 'Penerima bantuan tidak berada di wilayah Anda'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Create volunteer activity
            $activity = VolunteerActivity::create([
                'volunteer_id' => $volunteer->id,
                'beneficiary_id' => $request->beneficiary_id,
                'aid_session_id' => $request->aid_session_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'notes' => $request->notes,
                'activity_date' => now(),
            ]);

            // Store aids
            foreach ($request->aids as $aid) {
                ActivityAid::create([
                    'volunteer_activity_id' => $activity->id,
                    'aid_type_id' => $aid['aid_type_id'],
                    'quantity' => $aid['quantity'] ?? null,
                    'nominal_amount' => $aid['nominal_amount'] ?? null,
                ]);
            }

            // Store photos
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('activity-photos', 'public');
                    
                    ActivityPhoto::create([
                        'volunteer_activity_id' => $activity->id,
                        'photo_path' => $path,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Aktivitas berhasil disimpan',
                'data' => $activity->load(['beneficiary', 'aids.aidType', 'photos'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan aktivitas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getActivities(Request $request)
    {
        $volunteer = $request->user('volunteer');
        
        $activities = VolunteerActivity::where('volunteer_id', $volunteer->id)
            ->with(['beneficiary', 'aids.aidType', 'photos', 'aidSession'])
            ->orderBy('activity_date', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $activities
        ]);
    }

    public function getActivity($id, Request $request)
    {
        $volunteer = $request->user('volunteer');
        
        $activity = VolunteerActivity::where('id', $id)
            ->where('volunteer_id', $volunteer->id)
            ->with(['beneficiary', 'aids.aidType', 'photos', 'aidSession'])
            ->first();

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Aktivitas tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $activity
        ]);
    }

    public function getKecamatan($kabupatenId)
    {
        $kecamatan = AdministrativeRegion::where('level', 'kecamatan')
            ->where('parent_id', $kabupatenId)
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $kecamatan
        ]);
    }

    public function getDesa($kecamatanId)
    {
        $desa = AdministrativeRegion::where('level', 'desa')
            ->where('parent_id', $kecamatanId)
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $desa
        ]);
    }
}