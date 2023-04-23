<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('jwt.auth')->group(function() {
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);

    Route::apiResource('demand', App\Http\Controllers\DemandController::class);
    Route::post('demand/open/{demand}', [App\Http\Controllers\DemandController::class, 'open'])->name('demand.open');
    Route::post('demand/conclude/{demand}', [App\Http\Controllers\DemandController::class, 'conclude'])->name('demand.conclude');
    Route::post('demand/cancel/{demand}', [App\Http\Controllers\DemandController::class, 'cancel'])->name('demand.cancel');
});

Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);