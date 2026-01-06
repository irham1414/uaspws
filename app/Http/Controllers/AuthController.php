<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Guard; // <- penting untuk type hint
use App\Models\User;
use App\Helpers\ApiFormatter;

class AuthController extends Controller
{
    /**
     * REGISTER
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $userData = ApiFormatter::filterSensitiveData($user->toArray());

        return ApiFormatter::createJson(201, "Registrasi berhasil", $userData);
    }

    /**
     * LOGIN
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        /** @var \Tymon\JWTAuth\JWTGuard $auth */
        $auth = auth('api');

        if (!$token = $auth->attempt($credentials)) {
            return ApiFormatter::createJson(401, "Email atau password salah");
        }

        return ApiFormatter::createJson(200, "Login berhasil", [
            'token' => $token,
            'type'  => 'bearer'
        ]);
    }

    /**
     * LOGOUT
     */
    public function logout()
    {
        /** @var \Tymon\JWTAuth\JWTGuard $auth */
        $auth = auth('api');
        $auth->logout();

        return ApiFormatter::createJson(200, "Logout berhasil");
    }
}
