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

Route::post('/login', [App\Http\Controllers\Api\UserController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Api\UserController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [App\Http\Controllers\Api\UserController::class, 'index']);
    Route::post('/create-user', [App\Http\Controllers\Api\UserController::class, 'create']);
    Route::get('/view-user/{id}', [App\Http\Controllers\Api\UserController::class, 'view']);
    Route::put('/update-user/{id}', [App\Http\Controllers\Api\UserController::class, 'update']);
    Route::delete('/delete-user/{id}', [App\Http\Controllers\Api\UserController::class, 'destroy']);
    Route::post('/logout', [App\Http\Controllers\Api\UserController::class, 'logout']);
});



