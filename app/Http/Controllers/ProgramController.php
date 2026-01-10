<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    /**
     * 1. READ ALL (Index)
     * GET /api/programs
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Program::all()
        ]);
    }

    /**
     * 2. READ ONE (Show)
     * GET /api/programs/{id}
     */
    public function show($id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Data program tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $program
        ]);
    }

    /**
     * 3. CREATE (Store)
     * POST /api/programs
     */
    public function store(Request $request)
    {
        // Validasi: Wajib isi 'name' dan 'description' (Sesuai tabel)
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        // Simpan data
        $program = Program::create([
            'name'        => $validatedData['name'],
            'description' => $validatedData['description']
        ]);

        Log::info('Tambah program', [
            'user_id' => auth()->id() ?? 'guest', 
            'program_id' => $program->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Program berhasil ditambahkan',
            'data' => $program
        ], 201);
    }

    /**
     * 4. UPDATE
     * PUT /api/programs/{id}
     */
    public function update(Request $request, $id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        // Validasi (Gunakan 'sometimes' agar user bisa update salah satu saja)
        $validatedData = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'sometimes|string'
        ]);

        $program->update($validatedData);

        Log::info('Update program', [
            'user_id' => auth()->id() ?? 'guest', 
            'program_id' => $program->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Program berhasil diupdate',
            'data' => $program
        ]);
    }

    /**
     * 5. DELETE (Destroy)
     * DELETE /api/programs/{id}
     */
    public function destroy($id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $program->delete();

        Log::info('Hapus program', [
            'user_id' => auth()->id() ?? 'guest', 
            'program_id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Program berhasil dihapus'
        ]);
    }
}