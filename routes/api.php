<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ProgramController;
// Import Controller Baru
use App\Http\Controllers\PopulationStatController;
use App\Http\Controllers\ProgramImplementationController;
use App\Http\Controllers\PublicFacilityController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (PUBLIC)
|--------------------------------------------------------------------------
| Rute untuk Login dan Register harus bersifat publik.
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (DATA WILAYAH)
|--------------------------------------------------------------------------
| Rute untuk melihat/listing data wilayah (READ) tanpa perlu token.
*/
Route::apiResource('provinces', ProvinceController::class)->only(['index', 'show']);
Route::apiResource('cities', CityController::class)->only(['index', 'show']);
Route::apiResource('districts', DistrictController::class)->only(['index', 'show']);


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (JWT)
|--------------------------------------------------------------------------
| Rute untuk operasi yang membutuhkan otorisasi (Create, Update, Delete).
*/
Route::middleware(['auth:api'])->group(function () {

    // 1. AUTH
    Route::post('/logout', [AuthController::class, 'logout']);

    // 2. DATA WILAYAH (Write Operations)
    // Create, Update, Delete untuk wilayah hanya boleh user login
    Route::apiResource('provinces', ProvinceController::class)->except(['index', 'show']);
    Route::apiResource('cities', CityController::class)->except(['index', 'show']);
    Route::apiResource('districts', DistrictController::class)->except(['index', 'show']);

    // 3. PROGRAMS (All CRUD)
    Route::apiResource('programs', ProgramController::class);

    // 4. STATISTIK PENDUDUK (FULL CRUD)
    Route::apiResource('population-stats', PopulationStatController::class);

    // 5. IMPLEMENTASI PROGRAM (FULL CRUD)
    Route::apiResource('program-implementations', ProgramImplementationController::class);

    // 6. FASILITAS PUBLIK (FULL CRUD)
    // PERBAIKAN DI SINI:
    // Sekarang menggunakan apiResource agar mendukung GET, POST, PUT, DELETE
    // (Pastikan Controller sudah Anda update dengan kode index & show yang saya berikan sebelumnya)
    Route::apiResource('public-facilities', PublicFacilityController::class);

});