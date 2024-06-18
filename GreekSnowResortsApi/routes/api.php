<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

 Route::get('lifts/{snowResortId}', [\App\Http\Controllers\LiftAvailabilityController::class, 'index']);
Route::get('SnowResorts', [\App\Http\Controllers\SnowResortController::class, 'index']);
Route::get('SnowResorts/{snowResortId}', [\App\Http\Controllers\SnowResortController::class, 'show']);
Route::get('slopes', [\App\Http\Controllers\SlopesController::class, 'index']);



