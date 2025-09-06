<?php

namespace App\Http\Controllers;

use App\Models\AidSession;
use App\Models\AidType;
use App\Models\AidSessionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AidSessionController extends Controller
{
    public function index()
    {
        $aidSessions = AidSession::with(['items.aidType'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('aid-sessions.index', compact('aidSessions'));
    }

    public function create()
    {
        $aidTypes = AidType::where('is_active', true)->get();
        
        return view('aid-sessions.create', compact('aidTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'aid_items' => 'required|array|min:1',
            'aid_items.*.aid_type_id' => 'required|exists:aid_types,id',
            'aid_items.*.quantity_available' => 'nullable|integer|min:1',
            'aid_items.*.nominal_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $aidSession = AidSession::create([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => true,
            ]);

            foreach ($request->aid_items as $item) {
                AidSessionItem::create([
                    'aid_session_id' => $aidSession->id,
                    'aid_type_id' => $item['aid_type_id'],
                    'quantity_available' => $item['quantity_available'] ?? null,
                    'nominal_amount' => $item['nominal_amount'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('aid-sessions.index')->with('success', 'Sesi bantuan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan sesi bantuan: ' . $e->getMessage()]);
        }
    }

    public function show(AidSession $aidSession)
    {
        $aidSession->load(['items.aidType']);
        
        return view('aid-sessions.show', compact('aidSession'));
    }

    public function edit(AidSession $aidSession)
    {
        $aidSession->load(['items.aidType']);
        $aidTypes = AidType::where('is_active', true)->get();
        
        return view('aid-sessions.edit', compact('aidSession', 'aidTypes'));
    }

    public function update(Request $request, AidSession $aidSession)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'aid_items' => 'required|array|min:1',
            'aid_items.*.aid_type_id' => 'required|exists:aid_types,id',
            'aid_items.*.quantity_available' => 'nullable|integer|min:1',
            'aid_items.*.nominal_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $aidSession->update([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $request->has('is_active'),
            ]);

            // Delete existing items and recreate
            $aidSession->items()->delete();

            foreach ($request->aid_items as $item) {
                AidSessionItem::create([
                    'aid_session_id' => $aidSession->id,
                    'aid_type_id' => $item['aid_type_id'],
                    'quantity_available' => $item['quantity_available'] ?? null,
                    'nominal_amount' => $item['nominal_amount'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('aid-sessions.index')->with('success', 'Sesi bantuan berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate sesi bantuan: ' . $e->getMessage()]);
        }
    }

    public function destroy(AidSession $aidSession)
    {
        $aidSession->delete();
        
        return redirect()->route('aid-sessions.index')->with('success', 'Sesi bantuan berhasil dihapus');
    }
}