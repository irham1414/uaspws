<?php
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('provinces', ProvinceController::class);
    Route::apiResource('cities', CityController::class);
    Route::apiResource('districts', DistrictController::class);
    Route::apiResource('programs', ProgramController::class);
});
