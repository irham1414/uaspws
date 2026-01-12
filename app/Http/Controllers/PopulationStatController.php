<?php

namespace App\Http\Controllers;

use App\Models\PopulationStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PopulationStatController extends Controller
{
    /**
     * 1. GET: Lihat Semua Data
     * Mengambil daftar statistik beserta nama kotanya.
     */
    public function index()
    {
        // Menggunakan 'with' agar data kota dan provinsi terbawa
        $stats = PopulationStat::with(['city.province'])->get();

        return response()->json([
            'success' => true,
            'data'    => $stats
        ]);
    }

    /**
     * 2. GET: Lihat Satu Data (Detail)
     */
    public function show($id)
    {
        $stat = PopulationStat::with(['city.province'])->find($id);

        if (!$stat) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $stat
        ]);
    }

    /**
     * 3. POST: Tambah Data Baru
     */
    public function store(Request $request)
    {
        // Validasi Input
        $validator = Validator::make($request->all(), [
            'city_id' => 'required|exists:cities,id', // Pastikan kota ada
            'year'    => 'required|integer|digits:4', // Tahun harus 4 digit
            'total_population' => 'required|integer|min:0',
            'density' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cek duplikasi: kota yang sama di tahun yang sama
        $exists = PopulationStat::where('city_id', $request->city_id)
                    ->where('year', $request->year)
                    ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Data statistik untuk tahun ini sudah ada di kota tersebut.'
            ], 409); // Conflict
        }

        // Simpan Data
        $stat = PopulationStat::create([
            'city_id' => $request->city_id,
            'year'    => $request->year,
            'total_population' => $request->total_population,
            'density' => $request->density
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data penduduk berhasil ditambahkan',
            'data'    => $stat
        ], 201);
    }

    /**
     * 4. PUT: Update Data
     */
    public function update(Request $request, $id)
    {
        $stat = PopulationStat::find($id);

        if (!$stat) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Validasi (gunakan 'sometimes' agar tidak wajib isi semua field)
        $validator = Validator::make($request->all(), [
            'year'    => 'sometimes|integer|digits:4',
            'total_population' => 'sometimes|integer|min:0',
            'density' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $stat->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui',
            'data'    => $stat
        ]);
    }

    /**
     * 5. DELETE: Hapus Data
     */
    public function destroy($id)
    {
        $stat = PopulationStat::find($id);

        if (!$stat) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $stat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}