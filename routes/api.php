<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\PasswordUpdateController;
use App\Http\Controllers\Api\V1\Auth\ProfileController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\ParkingController;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\Api\V1\ZoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    Route::put('/password', PasswordUpdateController::class);

    Route::post('/logout', LogoutController::class);

    Route::apiResource('vehicles', VehicleController::class);

    Route::prefix('/parkings')->group(function () {
        Route::post('/start', [ParkingController::class, 'start']);
        Route::get('/{parking}', [ParkingController::class, 'show'])->whereNumber('parking');
        Route::put('/{parking}', [ParkingController::class, 'stop'])->whereNumber('parking');
    });
});

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::apiResource('zones', ZoneController::class)->only('index');
