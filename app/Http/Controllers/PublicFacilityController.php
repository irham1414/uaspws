<?php

namespace App\Http\Controllers;

use App\Models\PublicFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicFacilityController extends Controller
{
    /**
     * 1. CREATE: Tambah Fasilitas Baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_id' => 'required|exists:cities,id',
            'name'    => 'required|string|max:255',
            'type'    => 'required|in:education,health,worship,security,transport,public_space',
            'address' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $facility = PublicFacility::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Fasilitas berhasil ditambahkan',
            'data'    => $facility
        ], 201);
    }

    /**
     * 2. UPDATE: Edit Data Fasilitas
     */
    public function update(Request $request, $id)
    {
        $facility = PublicFacility::find($id);

        if (!$facility) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $facility->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data fasilitas diperbarui',
            'data'    => $facility
        ]);
    }

    /**
     * 3. DELETE: Hapus Fasilitas
     */
    public function destroy($id)
    {
        $facility = PublicFacility::find($id);

        if (!$facility) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $facility->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fasilitas berhasil dihapus'
        ]);
    }
}