<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\EscuelaController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\ZonaController;
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
    Route::resource('programas', ProgramaController::class)->except('destroy');
    Route::delete('programas/{programa}', [ProgramaController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('programas.destroy');
    Route::resource('zonas', ZonaController::class)->except('destroy');
    Route::delete('zonas/{zona}', [ZonaController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('zonas.destroy');
    Route::resource('centros', CentroController::class)->except('destroy');
    Route::delete('centros/{centro}', [CentroController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('centros.destroy');
    Route::resource('periodos-academicos', PeriodoAcademicoController::class)
        ->parameters(['periodos-academicos' => 'periodoAcademico'])
        ->except('destroy');
    Route::delete('periodos-academicos/{periodoAcademico}', [PeriodoAcademicoController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('periodos-academicos.destroy');
    Route::resource('estudiantes', EstudianteController::class)->except('destroy');
    Route::delete('estudiantes/{estudiante}', [EstudianteController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('estudiantes.destroy');
    Route::resource('denuncias', DenunciaController::class)->except('destroy');
    Route::delete('denuncias/{denuncia}', [DenunciaController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('denuncias.destroy');
});
