<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DistrictController extends Controller
{
    /**
     * 1. READ ALL (Index)
     * Menampilkan kecamatan beserta nama kotanya
     */
    public function index()
    {
        // with('city') digunakan agar data kota induknya ikut tampil
        $districts = District::with('city')->get();

        return response()->json([
            'success' => true,
            'data' => $districts
        ], 200);
    }

    /**
     * 2. SHOW (Read One)
     */
    public function show($id)
    {
        $district = District::with('city')->find($id);

        if (!$district) {
            return response()->json([
                'success' => false,
                'message' => 'Data kecamatan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $district
        ], 200);
    }

    /**
     * 3. CREATE (Store)
     */
    public function store(Request $request)
    {
        // PERBAIKAN: Menghapus 'code' karena tidak ada di database
        $validatedData = $request->validate([
            'city_id' => 'required|exists:cities,id', // Wajib ada di tabel cities
            'name'    => 'required|string|max:255'
        ]);

        try {
            $district = District::create([
                'city_id' => $validatedData['city_id'],
                'name'    => $validatedData['name']
            ]);

            Log::info('Tambah kecamatan', [
                'user_id' => auth()->id() ?? 'guest', 
                'district_id' => $district->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kecamatan berhasil ditambahkan',
                'data' => $district
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data'], 500);
        }
    }

    /**
     * 4. UPDATE
     */
    public function update(Request $request, $id)
    {
        $district = District::find($id);

        if (!$district) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        // Validasi input
        $validatedData = $request->validate([
            'city_id' => 'sometimes|exists:cities,id',
            'name'    => 'sometimes|string|max:255'
        ]);

        $district->update($validatedData);

        Log::info('Update kecamatan', [
            'user_id' => auth()->id() ?? 'guest', 
            'district_id' => $district->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kecamatan berhasil diupdate',
            'data' => $district
        ]);
    }

    /**
     * 5. DELETE (Destroy)
     */
    public function destroy($id)
    {
        $district = District::find($id);

        if (!$district) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $district->delete();

        Log::info('Hapus kecamatan', [
            'user_id' => auth()->id() ?? 'guest', 
            'district_id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kecamatan berhasil dihapus'
        ]);
    }
}