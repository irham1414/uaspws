<?php

namespace App\Http\Controllers;

use App\Models\ProgramImplementation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramImplementationController extends Controller
{
    /**
     * 1. GET: Lihat Semua Data Implementasi
     * (Menampilkan nama program dan nama kotanya)
     */
    public function index()
    {
        // Eager load 'program' dan 'city' beserta 'province' agar datanya lengkap
        $data = ProgramImplementation::with(['program', 'city.province'])->get();

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    /**
     * 2. GET: Lihat Detail Satu Implementasi
     */
    public function show($id)
    {
        $data = ProgramImplementation::with(['program', 'city.province'])->find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    /**
     * 3. POST: Jadwalkan Program Baru di Kota
     */
    public function store(Request $request)
    {
        // Validasi
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

        // Simpan Data
        $implementation = ProgramImplementation::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Program berhasil dijadwalkan di kota tersebut',
            'data'    => $implementation
        ], 201);
    }

    /**
     * 4. PUT: Update Status/Data Program
     */
    public function update(Request $request, $id)
    {
        $implementation = ProgramImplementation::find($id);

        if (!$implementation) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Validasi (start_date dll boleh diupdate juga jika perlu)
        $validator = Validator::make($request->all(), [
            'start_date' => 'sometimes|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'status'     => 'sometimes|in:planned,ongoing,completed',
            'budget_allocation' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $implementation->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data implementasi program berhasil diperbarui',
            'data'    => $implementation
        ]);
    }

    /**
     * 5. DELETE: Hapus Data Implementasi
     */
    public function destroy($id)
    {
        $implementation = ProgramImplementation::find($id);

        if (!$implementation) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $implementation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data implementasi program berhasil dihapus'
        ]);
    }
}