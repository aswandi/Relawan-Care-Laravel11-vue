<?php

namespace App\Http\Controllers;

use App\Models\BeneficiaryGroup;
use Illuminate\Http\Request;

class BeneficiaryGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BeneficiaryGroup::withCount('beneficiaries');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $groups = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('beneficiary-groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('beneficiary-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug logging
        \Log::info('BeneficiaryGroup store method called', [
            'request_data' => $request->all(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        try {
            $request->validate([
                'name' => 'required|string|min:3|max:255|unique:beneficiary_groups,name',
                'description' => 'nullable|string|max:1000',
                'is_active' => 'boolean',
            ]);
            
            \Log::info('BeneficiaryGroup validation passed');

            $data = $request->all();
            $data['is_active'] = $request->has('is_active');

            \Log::info('BeneficiaryGroup data before create', ['data' => $data]);

            $group = BeneficiaryGroup::create($data);

            \Log::info('BeneficiaryGroup created successfully', [
                'group_id' => $group->id,
                'group_name' => $group->name
            ]);

            return redirect()->route('beneficiary-groups.index')
                ->with('success', 'Kelompok penerima bantuan berhasil ditambahkan');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('BeneficiaryGroup validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('BeneficiaryGroup creation failed', [
                'error_message' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan kelompok penerima bantuan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BeneficiaryGroup $beneficiaryGroup)
    {
        $beneficiaryGroup->loadCount('beneficiaries');
        $beneficiaryGroup->load(['beneficiaries' => function($query) {
            $query->with(['kabupaten', 'kecamatan', 'desa'])->limit(10);
        }]);

        return view('beneficiary-groups.show', compact('beneficiaryGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BeneficiaryGroup $beneficiaryGroup)
    {
        return view('beneficiary-groups.edit', compact('beneficiaryGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BeneficiaryGroup $beneficiaryGroup)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:beneficiary_groups,name,' . $beneficiaryGroup->id,
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $beneficiaryGroup->update($data);

        return redirect()->route('beneficiary-groups.index')
            ->with('success', 'Kelompok penerima bantuan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BeneficiaryGroup $beneficiaryGroup)
    {
        // Check if group has beneficiaries
        if ($beneficiaryGroup->beneficiaries()->count() > 0) {
            return redirect()->route('beneficiary-groups.index')
                ->with('error', 'Tidak dapat menghapus kelompok yang masih memiliki penerima bantuan');
        }

        $beneficiaryGroup->delete();

        return redirect()->route('beneficiary-groups.index')
            ->with('success', 'Kelompok penerima bantuan berhasil dihapus');
    }
}
