<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EscuelaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return session()->has('usuario_id')
        ? redirect('/dashboard')
        : redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('autenticado')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('escuelas', EscuelaController::class)->except('destroy');
    Route::delete('escuelas/{escuela}', [EscuelaController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('escuelas.destroy');
});
