<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProvinceController extends Controller
{
    public function index()
    {
        return Province::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:provinces',
            'name' => 'required'
        ]);

        $province = Province::create($data);

        Log::info('Tambah provinsi', ['user_id' => auth()->id()]);

        return response()->json($province, 201);
    }

    public function update(Request $request, Province $province)
    {
        $province->update($request->only('code', 'name'));

        Log::info('Update provinsi', ['user_id' => auth()->id()]);

        return response()->json($province);
    }

    public function destroy(Province $province)
    {
        $province->delete();

        Log::info('Hapus provinsi', ['user_id' => auth()->id()]);

        return response()->json(['message' => 'Provinsi dihapus']);
    }
}
