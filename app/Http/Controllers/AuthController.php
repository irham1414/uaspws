<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil'
        ], 201);
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!$token = auth('api')->attempt($credentials)) {
        return response()->json([
            'error' => 'Email atau password salah'
        ], 401);
    }

    return response()->json([
        'token' => $token,
        'type'  => 'bearer'
    ]);
}


    public function logout()
{
    auth('api')->logout();

    return response()->json([
        'message' => 'Logout berhasil'
    ]);
}

}
