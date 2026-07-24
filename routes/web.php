<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AcercaSistemaController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ApelacionController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\DescargoController;
use App\Http\Controllers\DecisionController;
use App\Http\Controllers\EscuelaController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\NormatividadController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\ProcesoDisciplinarioController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SancionController;
use App\Http\Controllers\UsuarioController;
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
    Route::get('/ajax/zonas/{zona}/centros', [AjaxController::class, 'centrosPorZona'])->name('ajax.zonas.centros');
    Route::get('/ajax/escuelas/{escuela}/programas', [AjaxController::class, 'programasPorEscuela'])->name('ajax.escuelas.programas');
    Route::get('/ajax/procesos/{proceso}/descargos', [AjaxController::class, 'descargosPorProceso'])->name('ajax.procesos.descargos');
    Route::get('/ajax/procesos/{proceso}/sanciones', [AjaxController::class, 'sancionesPorProceso'])->name('ajax.procesos.sanciones');
    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('reportes/antecedentes-estudiante', [ReporteController::class, 'antecedentesEstudiante'])->name('reportes.antecedentes-estudiante');
    Route::get('reportes/procesos-historicos', [ReporteController::class, 'procesosHistoricos'])->name('reportes.procesos-historicos');
    Route::get('reportes/procesos-historicos/exportar-csv', [ReporteController::class, 'exportarProcesosHistoricosCsv'])->name('reportes.procesos-historicos.exportar-csv');
    Route::get('reportes/procesos-historicos/{proceso}', [ReporteController::class, 'procesoHistoricoDetalle'])->name('reportes.procesos-historicos.show');
    Route::get('administracion/acerca-del-sistema', [AcercaSistemaController::class, 'index'])->name('administracion.acerca');
    Route::resource('usuarios', UsuarioController::class)
        ->middleware('rol:Administrador')
        ->except('destroy');
    Route::delete('usuarios/{usuario}', [UsuarioController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('usuarios.destroy');
    Route::resource('normatividades', NormatividadController::class)
        ->parameters(['normatividades' => 'normatividad'])
        ->except('destroy');
    Route::delete('normatividades/{normatividad}', [NormatividadController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('normatividades.destroy');
    Route::resource('articulos', ArticuloController::class)->except('destroy');
    Route::delete('articulos/{articulo}', [ArticuloController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('articulos.destroy');
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
    Route::resource('procesos', ProcesoDisciplinarioController::class)->except('destroy');
    Route::delete('procesos/{proceso}', [ProcesoDisciplinarioController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('procesos.destroy');
    Route::resource('descargos', DescargoController::class)->except('destroy');
    Route::delete('descargos/{descargo}', [DescargoController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('descargos.destroy');
    Route::resource('pruebas', PruebaController::class)->except('destroy');
    Route::get('pruebas/{prueba}/archivo', [PruebaController::class, 'descargarArchivo'])
        ->name('pruebas.archivo');
    Route::delete('pruebas/{prueba}', [PruebaController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('pruebas.destroy');
    Route::resource('decisiones', DecisionController::class)
        ->parameters(['decisiones' => 'decision'])
        ->except('destroy');
    Route::get('decisiones/{decision}/archivo', [DecisionController::class, 'descargarArchivo'])
        ->name('decisiones.archivo');
    Route::delete('decisiones/{decision}', [DecisionController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('decisiones.destroy');
    Route::resource('sanciones', SancionController::class)
        ->parameters(['sanciones' => 'sancion'])
        ->except('destroy');
    Route::delete('sanciones/{sancion}', [SancionController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('sanciones.destroy');
    Route::resource('notificaciones', NotificacionController::class)
        ->parameters(['notificaciones' => 'notificacion'])
        ->except('destroy');
    Route::get('notificaciones/{notificacion}/archivo', [NotificacionController::class, 'descargarArchivo'])
        ->name('notificaciones.archivo');
    Route::delete('notificaciones/{notificacion}', [NotificacionController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('notificaciones.destroy');
    Route::resource('apelaciones', ApelacionController::class)
        ->parameters(['apelaciones' => 'apelacion'])
        ->except('destroy');
    Route::delete('apelaciones/{apelacion}', [ApelacionController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('apelaciones.destroy');
});
