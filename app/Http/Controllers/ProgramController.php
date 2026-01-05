<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    public function index() {
        return Program::all();
    }

    public function store(Request $request) {
        return Program::create($request->all());
    }

    public function show($id) {
        return Program::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $program = Program::findOrFail($id);
        $program->update($request->all());
        return $program;
    }

    public function destroy($id) {
        Program::destroy($id);
        return response()->json(['message'=>'Deleted']);
    }
}
