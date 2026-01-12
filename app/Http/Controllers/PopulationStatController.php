<?php

namespace App\Http\Controllers;

use App\Models\PopulationStat;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PopulationStatController extends Controller
{
    /**
     * Tambah data statistik penduduk baru ke kota tertentu
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'city_id' => 'required|exists:cities,id', // Pastikan kota ada
            'year'    => 'required|integer|digits:4', // Tahun harus 4 digit
            'total_population' => 'required|integer|min:0',
            'density' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 2. Cek apakah data tahun tersebut sudah ada untuk kota ini?
        // (Opsional: agar tidak double data di tahun yang sama)
        $exists = PopulationStat::where('city_id', $request->city_id)
                    ->where('year', $request->year)
                    ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Data statistik untuk tahun ini sudah ada di kota tersebut.'
            ], 409); // Conflict
        }

        // 3. Simpan Data
        $stat = PopulationStat::create([
            'city_id' => $request->city_id,
            'year'    => $request->year,
            'total_population' => $request->total_population,
            'density' => $request->density
        ]);

        return response()->json([
            'message' => 'Data penduduk berhasil ditambahkan',
            'data'    => $stat
        ], 201);
    }
}