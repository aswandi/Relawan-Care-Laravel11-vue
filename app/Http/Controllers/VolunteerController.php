<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\AdministrativeRegion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VolunteerController extends Controller
{
    public function index()
    {
        $volunteers = Volunteer::with(['kabupaten', 'kecamatan', 'desa'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('volunteers.index', compact('volunteers'));
    }

    public function create()
    {
        $kabupatenList = AdministrativeRegion::kabupaten()->get();
        
        return view('volunteers.create', compact('kabupatenList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:volunteers,phone|max:20',
            'kabupaten_id' => 'required|exists:administrative_regions,id',
            'kecamatan_id' => 'required|exists:administrative_regions,id',
            'desa_id' => 'required|exists:administrative_regions,id',
            'address' => 'required|string|max:500',
        ]);

        // Generate volunteer code
        $lastVolunteer = Volunteer::orderBy('volunteer_code', 'desc')->first();
        $nextNumber = $lastVolunteer ? (int)substr($lastVolunteer->volunteer_code, 3) + 1 : 1;
        $volunteerCode = 'REL' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Auto-generate 5-digit PIN
        $pin = str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
        
        Volunteer::create([
            'volunteer_code' => $volunteerCode,
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $pin,
            'kabupaten_id' => $request->kabupaten_id,
            'kecamatan_id' => $request->kecamatan_id,
            'desa_id' => $request->desa_id,
            'address' => $request->address,
            'is_active' => true,
        ]);

        return redirect()->route('volunteers.index')->with('success', "Relawan berhasil ditambahkan dengan kode: {$volunteerCode} dan PIN: {$pin}");
    }

    public function show(Volunteer $volunteer)
    {
        $volunteer->load(['kabupaten', 'kecamatan', 'desa', 'activities']);
        
        return view('volunteers.show', compact('volunteer'));
    }

    public function edit(Volunteer $volunteer)
    {
        $kabupatenList = AdministrativeRegion::kabupaten()->get();
        
        $kecamatanList = AdministrativeRegion::kecamatan()
            ->where('parent_id', $volunteer->kabupaten_id)
            ->get();
        $desaList = AdministrativeRegion::desa()
            ->where('parent_id', $volunteer->kecamatan_id)
            ->get();
            
        return view('volunteers.edit', compact('volunteer', 'kabupatenList', 'kecamatanList', 'desaList'));
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:volunteers,phone,' . $volunteer->id,
            'password' => 'nullable|string|size:5|regex:/^[0-9]+$/',
            'kabupaten_id' => 'required|exists:administrative_regions,id',
            'kecamatan_id' => 'required|exists:administrative_regions,id',
            'desa_id' => 'required|exists:administrative_regions,id',
            'address' => 'required|string|max:500',
            'is_active' => 'boolean',
        ]);

        $updateData = $request->only([
            'name', 'phone', 'kabupaten_id', 'kecamatan_id', 'desa_id', 'address'
        ]);

        $updateData['is_active'] = $request->has('is_active');

        if ($request->filled('password')) {
            $updateData['password'] = $request->password;
        }

        $volunteer->update($updateData);

        return redirect()->route('volunteers.index')->with('success', 'Data relawan berhasil diupdate');
    }

    public function destroy(Volunteer $volunteer)
    {
        $volunteer->delete();
        
        return redirect()->route('volunteers.index')->with('success', 'Relawan berhasil dihapus');
    }

    // AJAX endpoints for cascading dropdowns
    public function getKecamatan($kabupatenId)
    {
        $kecamatan = AdministrativeRegion::kecamatan()
            ->where('parent_id', $kabupatenId)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'display_name' => $item->kec_nama ?: $item->name
                ];
            });
            
        return response()->json($kecamatan);
    }

    public function getDesa($kecamatanId)
    {
        $desa = AdministrativeRegion::desa()
            ->where('parent_id', $kecamatanId)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'display_name' => $item->kel_nama ?: $item->name
                ];
            });
            
        return response()->json($desa);
    }
}