<?php 
// test
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('provinces', ProvinceController::class);
    Route::apiResource('cities', CityController::class);
    Route::apiResource('districts', DistrictController::class);
    Route::apiResource('programs', ProgramController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});
