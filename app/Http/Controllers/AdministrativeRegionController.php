<?php

namespace App\Http\Controllers;

use App\Models\AdministrativeRegion;
use Illuminate\Http\Request;

class AdministrativeRegionController extends Controller
{
    public function index(Request $request)
    {
        // Always show only kabupaten level (tingkat 2)
        $kabupaten = AdministrativeRegion::where('tingkat', 2)
            ->orderBy('kab_nama')
            ->get();

        // Enrich with statistics for each kabupaten
        $kabupaten->each(function ($kab) {
            // Count kecamatan in this kabupaten
            $kab->jumlah_kecamatan = AdministrativeRegion::where('tingkat', 3)
                ->where('kab_id', $kab->kab_id)
                ->count();
            
            // Count kelurahan/desa in this kabupaten
            $kab->jumlah_kelurahan = AdministrativeRegion::where('tingkat', 4)
                ->where('kab_id', $kab->kab_id)
                ->count();
                
            // Count volunteers in this kabupaten (if any)
            $kab->jumlah_relawan = \App\Models\Volunteer::where('kabupaten_id', $kab->id)->count();
            
            // Count beneficiaries in this kabupaten (if any)
            $kab->jumlah_penduduk = \App\Models\Beneficiary::where('kabupaten_id', $kab->id)->count();
        });

        return view('administrative-regions.index', compact('kabupaten'));
    }

    public function create()
    {
        $kabupatenList = AdministrativeRegion::where('tingkat', 1)->get();
        $kecamatanList = AdministrativeRegion::where('tingkat', 2)->get();
        
        return view('administrative-regions.create', compact('kabupatenList', 'kecamatanList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:administrative_regions,code|max:30',
            'name' => 'required|string|max:255',
            'tingkat' => 'required|integer|in:1,2,3,4',
            'pro_id' => 'nullable|integer',
            'kab_id' => 'nullable|integer', 
            'kec_id' => 'nullable|integer',
            'kel_id' => 'nullable|integer',
            'pro_nama' => 'nullable|string|max:191',
            'kab_nama' => 'nullable|string|max:191',
            'kec_nama' => 'nullable|string|max:191',
            'kel_nama' => 'nullable|string|max:191',
        ]);

        AdministrativeRegion::create($request->all());

        return redirect()->route('administrative-regions.index')->with('success', 'Wilayah administrasi berhasil ditambahkan');
    }

    public function show(AdministrativeRegion $administrativeRegion)
    {
        return view('administrative-regions.show', compact('administrativeRegion'));
    }

    public function edit(AdministrativeRegion $administrativeRegion)
    {
        $kabupatenList = AdministrativeRegion::where('tingkat', 1)->get();
        $kecamatanList = AdministrativeRegion::where('tingkat', 2)->get();
        
        return view('administrative-regions.edit', compact('administrativeRegion', 'kabupatenList', 'kecamatanList'));
    }

    public function update(Request $request, AdministrativeRegion $administrativeRegion)
    {
        $request->validate([
            'code' => 'required|string|max:30|unique:administrative_regions,code,' . $administrativeRegion->id,
            'name' => 'required|string|max:255',
            'tingkat' => 'required|integer|in:1,2,3,4',
            'pro_id' => 'nullable|integer',
            'kab_id' => 'nullable|integer', 
            'kec_id' => 'nullable|integer',
            'kel_id' => 'nullable|integer',
            'pro_nama' => 'nullable|string|max:191',
            'kab_nama' => 'nullable|string|max:191',
            'kec_nama' => 'nullable|string|max:191',
            'kel_nama' => 'nullable|string|max:191',
        ]);

        $administrativeRegion->update($request->all());

        return redirect()->route('administrative-regions.index')->with('success', 'Wilayah administrasi berhasil diupdate');
    }

    public function destroy(AdministrativeRegion $administrativeRegion)
    {
        $administrativeRegion->delete();
        
        return redirect()->route('administrative-regions.index')->with('success', 'Wilayah administrasi berhasil dihapus');
    }

    public function showKecamatan($kabupaten_id)
    {
        $kabupaten = AdministrativeRegion::where('tingkat', 2)
            ->where('kab_id', $kabupaten_id)
            ->firstOrFail();
            
        $kecamatan = AdministrativeRegion::where('tingkat', 3)
            ->where('kab_id', $kabupaten_id)
            ->orderBy('kec_nama')
            ->get();
            
        // Enrich with statistics for each kecamatan
        $kecamatan->each(function ($kec) {
            // Count kelurahan/desa in this kecamatan
            $kec->jumlah_kelurahan = AdministrativeRegion::where('tingkat', 4)
                ->where('kec_id', $kec->kec_id)
                ->count();
                
            // Count volunteers in this kecamatan (if any)
            $kec->jumlah_relawan = \App\Models\Volunteer::where('kecamatan_id', $kec->id)->count();
            
            // Count beneficiaries in this kecamatan (if any)
            $kec->jumlah_penduduk = \App\Models\Beneficiary::where('kecamatan_id', $kec->id)->count();
        });

        return view('administrative-regions.kecamatan', compact('kabupaten', 'kecamatan'));
    }

    public function showDesa($kecamatan_id)
    {
        $kecamatan = AdministrativeRegion::where('tingkat', 3)
            ->where('kec_id', $kecamatan_id)
            ->firstOrFail();
            
        $kabupaten = AdministrativeRegion::where('tingkat', 2)
            ->where('kab_id', $kecamatan->kab_id)
            ->firstOrFail();
            
        $desa = AdministrativeRegion::where('tingkat', 4)
            ->where('kec_id', $kecamatan_id)
            ->orderBy('kel_nama')
            ->get();
            
        // Enrich with statistics for each desa
        $desa->each(function ($d) {
            // Count volunteers in this desa (if any)
            $d->jumlah_relawan = \App\Models\Volunteer::where('desa_id', $d->id)->count();
            
            // Count beneficiaries in this desa (if any)
            $d->jumlah_penduduk = \App\Models\Beneficiary::where('desa_id', $d->id)->count();
        });

        return view('administrative-regions.desa', compact('kabupaten', 'kecamatan', 'desa'));
    }
}