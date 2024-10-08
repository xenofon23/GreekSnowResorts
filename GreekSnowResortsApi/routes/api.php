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


Route::post('/register', [\App\Http\Controllers\UserController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\UserController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'user']);
    Route::post('booking', [\App\Http\Controllers\BookingController::class, 'store']);
    Route::get('mybooking', [\App\Http\Controllers\BookingController::class, 'index']);


});
Route::get('cost/{snowResortId}', [\App\Http\Controllers\CostsController::class, 'getBySnowResortId']);
Route::get('SnowResort/{snowResortId}', [\App\Http\Controllers\SnowResortController::class, 'show']);
Route::get('slopes', [\App\Http\Controllers\SlopesController::class, 'index']);
Route::get('lifts/{snowResortId}', [\App\Http\Controllers\LiftAvailabilityController::class, 'index']);
Route::get('SnowResorts', [\App\Http\Controllers\SnowResortController::class, 'index']);
Route::get('images', [\App\Http\Controllers\ImagesController::class, 'index']);





