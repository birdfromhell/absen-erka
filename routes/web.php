<?php

use App\Http\Controllers\AbsenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [AuthController::class, 'dashboard']);

Route::get('/sign-in', [AuthController::class, 'signin']);
Route::get('/sign-up', [AuthController::class, 'signup']);

Route::post('/sign-in', [AuthController::class, 'signinUser']);
Route::post('/sign-up', [AuthController::class, 'signupUser']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/masuk', [AbsenController::class, 'masuk']);
Route::post('/keluar', [AbsenController::class, 'keluar']);
