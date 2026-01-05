<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Log::info('Register user', ['user_id' => $user->id]);

        return response()->json(['message' => 'Register berhasil'], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        Log::info('Login user', ['user_id' => Auth::id()]);

        return response()->json([
            'token' => $token,
            'type'  => 'Bearer'
        ]);
    }

    public function logout()
    {
        Auth::logout();

        Log::info('Logout user', ['user_id' => auth()->id()]);

        return response()->json(['message' => 'Logout berhasil']);
    }
}
