<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ProgramController;
// TAMBAHAN: Import Controller Baru
use App\Http\Controllers\PopulationStatController;
use App\Http\Controllers\ProgramImplementationController;

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
// Hanya mengizinkan method GET (index dan show) agar publik.
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

    // Rute Logout harus terproteksi
    Route::post('/logout', [AuthController::class, 'logout']);

    // Operasi Create, Update, Delete (Store, Update, Destroy) untuk data wilayah.
    Route::apiResource('provinces', ProvinceController::class)->except(['index', 'show']);
    Route::apiResource('cities', CityController::class)->except(['index', 'show']);
    Route::apiResource('districts', DistrictController::class)->except(['index', 'show']);

    // Semua operasi CRUD pada Programs terproteksi.
    Route::apiResource('programs', ProgramController::class);

    /*
    |--------------------------------------------------------------------------
    | TAMBAHAN: STATISTIK PENDUDUK & IMPLEMENTASI PROGRAM
    |--------------------------------------------------------------------------
    */
    
    // 1. Input Data Statistik Penduduk
    Route::post('/population-stats', [PopulationStatController::class, 'store']);

    // 2. Input & Update Implementasi Program di Wilayah
    Route::post('/program-implementations', [ProgramImplementationController::class, 'store']);
    Route::put('/program-implementations/{id}', [ProgramImplementationController::class, 'update']);

});