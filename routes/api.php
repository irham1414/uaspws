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
    Route::apiResource('provinces', ProvinceController::class)->except(['index', 'show']);
    Route::apiResource('cities', CityController::class)->except(['index', 'show']);
    Route::apiResource('districts', DistrictController::class)->except(['index', 'show']);

    // 3. PROGRAMS (All CRUD)
    Route::apiResource('programs', ProgramController::class);

    // 4. STATISTIK PENDUDUK
    Route::post('/population-stats', [PopulationStatController::class, 'store']);

    // 5. IMPLEMENTASI PROGRAM
    Route::post('/program-implementations', [ProgramImplementationController::class, 'store']);
    Route::put('/program-implementations/{id}', [ProgramImplementationController::class, 'update']);

    // 6. FASILITAS PUBLIK (Baru Ditambahkan)
    // Langsung ditaruh di sini, tidak perlu buat grup middleware baru lagi
    Route::post('/public-facilities', [PublicFacilityController::class, 'store']); // Tambah
    Route::put('/public-facilities/{id}', [PublicFacilityController::class, 'update']); // Edit
    Route::delete('/public-facilities/{id}', [PublicFacilityController::class, 'destroy']); // Hapus

});