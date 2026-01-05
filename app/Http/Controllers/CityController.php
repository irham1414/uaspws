<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province; // [Perbaikan 1] Import Model Province untuk validasi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/cities
     */
    public function index()
    {
        try {
            // [Perbaikan 2] Menggunakan import namespace yang benar: City::all()
            $cities = City::all(); 

            return response()->json([
                'status' => 'success',
                'data' => $cities
            ], 200);

        } catch (\Exception $e) {
            // Log error untuk debugging di server
            Log::error('Gagal mengambil daftar kota: ' . $e->getMessage()); 
            
            // Memberikan respons JSON 500
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data kota. Terjadi kesalahan server.'
            ], 500); 
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/cities
     */
    public function store(Request $request)
    {
        // [Perbaikan 3] Validasi lebih ketat dan benar
        $validatedData = $request->validate([
            // Memastikan province_id ada di tabel provinces
            'province_id' => 'required|exists:provinces,id', 
            // Memastikan code harus unik di tabel cities dan memiliki format string
            'code' => 'required|string|unique:cities,code|max:10', 
            'name' => 'required|string|max:255'
        ]);

        try {
            $city = City::create($validatedData);

            // [Perbaikan 4] Logging harus di dalam try-catch jika create berpotensi gagal
            Log::info('Tambah kota berhasil', ['user_id' => auth()->id() ?? 'guest', 'city_id' => $city->id]);
            
            return response()->json($city, 201);
            
        } catch (\Exception $e) {
             // Tangani error database (misalnya, foreign key error atau unique constraint)
            Log::error('Gagal membuat kota baru: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat data kota baru. Cek log server.'
            ], 500);
        }
    }
    
    // ... (method show, update, destroy dihilangkan untuk fokus pada perbaikan)
    
    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/cities/{city}
     */
    public function update(Request $request, $id)
{
    $city = City::find($id);

    if (!$city) {
        return response()->json([
            'message' => 'Data tidak ditemukan'
        ], 404);
    }

    $city->update($request->all());

    return response()->json([
        'message' => 'Berhasil diupdate',
        'data' => $city
    ]);
}


    /**
     * Remove the specified resource from storage.
     * DELETE /api/cities/{city}
     */
    public function destroy(City $city)
    {
        $city->delete();
        Log::info('Hapus kota berhasil', ['user_id' => auth()->id() ?? 'guest', 'city_id' => $city->id]);
        return response()->json(['message' => 'Kota berhasil dihapus'], 200);
    }

    // Method show
    public function show(City $city)
    {
        return response()->json($city);
    }
}