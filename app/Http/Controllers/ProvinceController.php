<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProvinceController extends Controller
{
    /**
     * 1. READ ALL (Index)
     */
    public function index()
    {
        $data = Province::all();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * 2. READ ONE (Show)
     * Mencari berdasarkan kolom 'id' (standar Laravel)
     */
    public function show($id)
    {
        $province = Province::find($id);

        if (!$province) {
            return response()->json([
                'success' => false,
                'message' => 'Data provinsi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $province
        ]);
    }

    /**
     * 3. CREATE (Store)
     * Input dari Postman sekarang harus: 'code' dan 'name'
     */
    public function store(Request $request)
    {
        // PERBAIKAN: Validasi menggunakan nama kolom asli di database (code, name)
        $validatedData = $request->validate([
            'code' => 'required|string|max:255', 
            'name' => 'required|string|max:255'
        ]);

        // Simpan ke database
        $province = Province::create([
            'code' => $validatedData['code'],
            'name' => $validatedData['name']
        ]);

        Log::info('Tambah provinsi baru', [
            'user_id' => auth()->id(),
            'province_id' => $province->id // Menggunakan ID standar
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Provinsi berhasil ditambahkan',
            'data' => $province
        ], 201);
    }

    /**
     * 4. UPDATE
     */
    public function update(Request $request, Province $province)
    {
        // PERBAIKAN: Validasi menggunakan 'code' dan 'name'
        $validatedData = $request->validate([
            'code' => 'sometimes|string|max:255',
            'name' => 'sometimes|string|max:255'
        ]);

        // Update otomatis
        $province->update($validatedData);

        Log::info('Update provinsi', [
            'user_id' => auth()->id(),
            'province_id' => $province->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Provinsi berhasil diupdate',
            'data' => $province
        ]);
    }

    /**
     * 5. DELETE (Destroy)
     */
    public function destroy(Province $province)
    {
        $id = $province->id; // Ambil ID sebelum dihapus
        $province->delete();

        Log::info('Hapus provinsi', [
            'user_id' => auth()->id(),
            'province_id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Provinsi berhasil dihapus'
        ]);
    }
}