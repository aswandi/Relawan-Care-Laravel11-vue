<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\AdministrativeRegion;
use App\Models\BeneficiaryGroup;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BeneficiaryImport;

class BeneficiaryController extends Controller
{
    public function index()
    {
        $beneficiaries = Beneficiary::with(['kabupaten', 'kecamatan', 'desa', 'beneficiaryGroup'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Statistics for dashboard cards
        $totalBeneficiaries = Beneficiary::count();
        $activeBeneficiaries = Beneficiary::where('is_active', true)->count();
        $maleBeneficiaries = Beneficiary::where('gender', 'male')->count();
        $femaleBeneficiaries = Beneficiary::where('gender', 'female')->count();

        return view('beneficiaries.index', compact(
            'beneficiaries', 
            'totalBeneficiaries', 
            'activeBeneficiaries', 
            'maleBeneficiaries', 
            'femaleBeneficiaries'
        ));
    }

    public function create()
    {
        $kabupatenList = AdministrativeRegion::kabupaten()->get();
        $beneficiaryGroups = BeneficiaryGroup::active()->get();
        
        return view('beneficiaries.create', compact('kabupatenList', 'beneficiaryGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'family_card_number' => 'required|string|unique:beneficiaries,family_card_number|max:20',
            'national_id' => 'required|string|unique:beneficiaries,national_id|max:20',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'kabupaten_id' => 'required|exists:administrative_regions,id',
            'kecamatan_id' => 'required|exists:administrative_regions,id',
            'desa_id' => 'required|exists:administrative_regions,id',
            'beneficiary_group_id' => 'nullable|exists:beneficiary_groups,id',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:male,female',
        ]);

        Beneficiary::create($request->all());

        return redirect()->route('beneficiaries.index')->with('success', 'Penerima bantuan berhasil ditambahkan');
    }

    public function show(Beneficiary $beneficiary)
    {
        $beneficiary->load(['kabupaten', 'kecamatan', 'desa', 'beneficiaryGroup']);
        
        return view('beneficiaries.show', compact('beneficiary'));
    }

    public function edit(Beneficiary $beneficiary)
    {
        $kabupatenList = AdministrativeRegion::kabupaten()->get();
        $kecamatanList = AdministrativeRegion::kecamatan()
            ->where('parent_id', $beneficiary->kabupaten_id)
            ->get();
        $desaList = AdministrativeRegion::desa()
            ->where('parent_id', $beneficiary->kecamatan_id)
            ->get();
        $beneficiaryGroups = BeneficiaryGroup::active()->get();
            
        return view('beneficiaries.edit', compact('beneficiary', 'kabupatenList', 'kecamatanList', 'desaList', 'beneficiaryGroups'));
    }

    public function update(Request $request, Beneficiary $beneficiary)
    {
        $request->validate([
            'family_card_number' => 'required|string|max:20|unique:beneficiaries,family_card_number,' . $beneficiary->id,
            'national_id' => 'required|string|max:20|unique:beneficiaries,national_id,' . $beneficiary->id,
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'kabupaten_id' => 'required|exists:administrative_regions,id',
            'kecamatan_id' => 'required|exists:administrative_regions,id',
            'desa_id' => 'required|exists:administrative_regions,id',
            'beneficiary_group_id' => 'nullable|exists:beneficiary_groups,id',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:male,female',
            'is_active' => 'boolean',
        ]);

        $updateData = $request->all();
        $updateData['is_active'] = $request->has('is_active');

        $beneficiary->update($updateData);

        return redirect()->route('beneficiaries.index')->with('success', 'Data penerima bantuan berhasil diupdate');
    }

    public function destroy(Beneficiary $beneficiary)
    {
        $beneficiary->delete();
        
        return redirect()->route('beneficiaries.index')->with('success', 'Penerima bantuan berhasil dihapus');
    }

    public function import()
    {
        return view('beneficiaries.import');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new BeneficiaryImport, $request->file('file'));
            
            return redirect()->route('beneficiaries.index')
                ->with('success', 'Data penerima bantuan berhasil diimpor dari Excel!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $filePath = public_path('template_beneficiaries.csv');
        
        if (file_exists($filePath)) {
            return response()->download($filePath, 'template_beneficiaries.csv');
        }
        
        return redirect()->back()->with('error', 'Template file tidak ditemukan.');
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