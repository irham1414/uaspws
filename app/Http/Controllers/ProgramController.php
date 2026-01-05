<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    public function index()
    {
        return Program::all();
    }

    public function store(Request $request)
    {
        $program = Program::create($request->validate([
            'title' => 'required',
            'description' => 'required',
            'year' => 'required|digits:4'
        ]));

        Log::info('Tambah program', ['user_id' => auth()->id()]);
        return response()->json($program, 201);
    }

    public function update(Request $request, Program $program)
    {
        $program->update($request->all());
        Log::info('Update program', ['user_id' => auth()->id()]);
        return $program;
    }

    public function destroy(Program $program)
    {
        $program->delete();
        Log::info('Hapus program', ['user_id' => auth()->id()]);
        return response()->json(['message' => 'Program dihapus']);
    }
}
