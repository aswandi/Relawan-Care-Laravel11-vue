<?php

namespace App\Http\Controllers;

use App\Models\AidType;
use Illuminate\Http\Request;

class AidTypeController extends Controller
{
    public function index()
    {
        $aidTypes = AidType::orderBy('created_at', 'desc')->paginate(15);

        return view('aid-types.index', compact('aidTypes'));
    }

    public function create()
    {
        return view('aid-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'has_nominal' => 'boolean',
            'unit' => 'nullable|string|max:50',
        ]);

        $data = $request->all();
        $data['has_nominal'] = $request->has('has_nominal');
        $data['is_active'] = true;

        AidType::create($data);

        return redirect()->route('aid-types.index')->with('success', 'Jenis bantuan berhasil ditambahkan');
    }

    public function show(AidType $aidType)
    {
        return view('aid-types.show', compact('aidType'));
    }

    public function edit(AidType $aidType)
    {
        return view('aid-types.edit', compact('aidType'));
    }

    public function update(Request $request, AidType $aidType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'has_nominal' => 'boolean',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['has_nominal'] = $request->has('has_nominal');
        $data['is_active'] = $request->has('is_active');

        $aidType->update($data);

        return redirect()->route('aid-types.index')->with('success', 'Jenis bantuan berhasil diupdate');
    }

    public function destroy(AidType $aidType)
    {
        $aidType->delete();
        
        return redirect()->route('aid-types.index')->with('success', 'Jenis bantuan berhasil dihapus');
    }
}