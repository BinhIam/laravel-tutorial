<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/caching', [App\Http\Controllers\CachingController::class, 'index']);
Route::get('/redis', [App\Http\Controllers\RedisController::class, 'index']);
Route::get('/redis/{id}', [App\Http\Controllers\RedisController::class, 'getVideo']);
Route::get('/redis/{id}/download', [App\Http\Controllers\RedisController::class, 'downloadVideo']);
