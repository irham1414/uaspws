<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    public function index()
    {
        return City::all();
    }

    public function store(Request $request)
    {
        $city = City::create($request->validate([
            'province_id' => 'required',
            'code' => 'required|unique:cities',
            'name' => 'required'
        ]));

        Log::info('Tambah kota', ['user_id' => auth()->id()]);
        return response()->json($city, 201);
    }

    public function update(Request $request, City $city)
    {
        $city->update($request->all());
        Log::info('Update kota', ['user_id' => auth()->id()]);
        return $city;
    }

    public function destroy(City $city)
    {
        $city->delete();
        Log::info('Hapus kota', ['user_id' => auth()->id()]);
        return response()->json(['message' => 'Kota dihapus']);
    }
}
