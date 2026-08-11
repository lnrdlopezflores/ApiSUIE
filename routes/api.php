<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlumnoController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\GrupoController;
use App\Http\Controllers\Api\MateriaController;
use App\Http\Controllers\Api\CargaAcademicaController;
use App\Http\Controllers\Api\AsistenciaController;
use App\Http\Controllers\Api\PagoController;
use App\Http\Controllers\Api\ProyectoTitulacionController;
use App\Http\Controllers\Api\DocenteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('alumnos', AlumnoController::class);
Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('grupos', GrupoController::class);
Route::apiResource('materias', MateriaController::class);
Route::apiResource('carga-academica', CargaAcademicaController::class);
Route::apiResource('asistencias', AsistenciaController::class);
Route::apiResource('pagos', PagoController::class);
Route::apiResource('proyectos-titulacion', ProyectoTitulacionController::class);
Route::apiResource('docentes', DocenteController::class);