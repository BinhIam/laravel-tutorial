<?php

use Illuminate\Support\Facades\Auth;
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
Route::get('/redis/users', [App\Http\Controllers\RedisController::class, 'view']);
Route::get('/redis/{id}', [App\Http\Controllers\RedisController::class, 'getVideo']);
Route::get('/redis/{id}/download', [App\Http\Controllers\RedisController::class, 'downloadVideo']);
Route::get('/login', [App\Http\Controllers\RedisController::class, 'login']);
# Google
Route::get('/oauthv1/login', [App\Http\Controllers\Auth\LoginController::class, 'loginWithGoogle'])->name('loginGoogle');
Route::get('/oauthv1/login/callback', [App\Http\Controllers\Auth\LoginController::class, 'loginWithGoogleCallBack']);
# Github
Route::get('/login/github', [App\Http\Controllers\Auth\LoginController::class, 'loginWithGitHub'])->name('loginGithub');
Route::get('/login/github/callback', [App\Http\Controllers\Auth\LoginController::class, 'loginWithGitHubCallBack']);
# Facebook
Route::get('/login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'loginWithFaceBook'])->name('loginFacebook');
Route::get('/login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'loginWithFaceBookCallBack']);

Auth::routes();
