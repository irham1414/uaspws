<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    /**
     * 1. READ ALL (Index)
     * GET /api/cities
     */
    public function index()
    {
        // Menggunakan with('province') agar data provinsi induknya ikut terlihat
        $cities = City::with('province')->get();

        return response()->json([
            'success' => true,
            'data' => $cities
        ], 200);
    }

    /**
     * 2. SHOW (Read One)
     * GET /api/cities/{id}
     */
    public function show($id)
    {
        $city = City::with('province')->find($id);

        if (!$city) {
            return response()->json([
                'success' => false,
                'message' => 'Data kota tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $city
        ], 200);
    }

    /**
     * 3. CREATE (Store)
     * POST /api/cities
     */
    public function store(Request $request)
    {
        // PERBAIKAN: Menghapus validasi 'code' karena kolom tersebut TIDAK ADA di database
        $validatedData = $request->validate([
            'province_id' => 'required|exists:provinces,id', // Wajib ada di tabel provinces
            'name'        => 'required|string|max:255'
        ]);

        try {
            // Simpan data
            $city = City::create([
                'province_id' => $validatedData['province_id'],
                'name'        => $validatedData['name']
            ]);

            Log::info('Tambah kota berhasil', [
                'user_id' => auth()->id() ?? 'guest', 
                'city_id' => $city->id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Kota berhasil ditambahkan',
                'data' => $city
            ], 201);
            
        } catch (\Exception $e) {
            Log::error('Gagal membuat kota: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Gagal menyimpan data'
            ], 500);
        }
    }

    /**
     * 4. UPDATE
     * PUT /api/cities/{id}
     */
    public function update(Request $request, $id)
    {
        $city = City::find($id);

        if (!$city) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        // PERBAIKAN: Gunakan validasi agar aman (jangan pakai $request->all())
        $validatedData = $request->validate([
            'province_id' => 'sometimes|exists:provinces,id',
            'name'        => 'sometimes|string|max:255'
        ]);

        try {
            $city->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Data kota berhasil diupdate',
                'data' => $city
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal update data'], 500);
        }
    }

    /**
     * 5. DELETE (Destroy)
     * DELETE /api/cities/{id}
     */
    public function destroy($id)
    {
        $city = City::find($id);

        if (!$city) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $city->delete();

        Log::info('Hapus kota berhasil', [
            'user_id' => auth()->id() ?? 'guest', 
            'city_id' => $id
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Kota berhasil dihapus'
        ], 200);
    }
}