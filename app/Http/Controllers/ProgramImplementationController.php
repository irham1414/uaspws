<?php

namespace App\Http\Controllers;

use App\Models\ProgramImplementation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramImplementationController extends Controller
{
    /**
     * Tetapkan/Jalankan Program di Kota Tertentu
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $validator = Validator::make($request->all(), [
            'program_id' => 'required|exists:programs,id',
            'city_id'    => 'required|exists:cities,id',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'status'     => 'required|in:planned,ongoing,completed',
            'budget_allocation' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 2. Simpan Data
        $implementation = ProgramImplementation::create($request->all());

        return response()->json([
            'message' => 'Program berhasil dijadwalkan di kota tersebut',
            'data'    => $implementation
        ], 201);
    }

    /**
     * Update Status Program (Misal: dari planned -> ongoing)
     */
    public function update(Request $request, $id)
    {
        $implementation = ProgramImplementation::find($id);

        if (!$implementation) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $implementation->update($request->only(['status', 'end_date', 'budget_allocation']));

        return response()->json([
            'message' => 'Status program berhasil diperbarui',
            'data'    => $implementation
        ]);
    }
}