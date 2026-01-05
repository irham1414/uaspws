<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DistrictController extends Controller
{
    public function index()
    {
        return District::all();
    }

    public function store(Request $request)
    {
        $district = District::create($request->validate([
            'city_id' => 'required',
            'code' => 'required|unique:districts',
            'name' => 'required'
        ]));

        Log::info('Tambah kecamatan', ['user_id' => auth()->id()]);
        return response()->json($district, 201);
    }

    public function update(Request $request, District $district)
    {
        $district->update($request->all());
        Log::info('Update kecamatan', ['user_id' => auth()->id()]);
        return $district;
    }

    public function destroy(District $district)
    {
        $district->delete();
        Log::info('Hapus kecamatan', ['user_id' => auth()->id()]);
        return response()->json(['message' => 'Kecamatan dihapus']);
    }
}
