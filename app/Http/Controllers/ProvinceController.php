<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProvinceController extends Controller
{
    public function index()
{
    $data = Province::all();

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}

    public function store(Request $request)
{
    // Hapus aturan unique:cities yang memicu error
    $validatedData = $request->validate([
        'province_id' => 'required|exists:provinces,id', 
        'code' => 'required|string|max:10', // <--- HANYA MENGGUNAKAN REQUIRED
        'name' => 'required|string|max:255'
    ]);
    
   }   // ... sisanya

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
