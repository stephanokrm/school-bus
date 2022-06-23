<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SchoolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->group(function() {
    Route::apiResource('absences', AbsenceController::class)->only(['index', 'store', 'destroy']);
    Route::apiResource('addresses', AddressController::class);
    Route::apiResource('drivers', DriverController::class);
    Route::apiResource('passengers', PassengerController::class);
    Route::apiResource('routes', RouteController::class);
    Route::apiResource('schools', SchoolController::class);
});
