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
use App\Http\Controllers\Api\AdministradorController;
use App\Http\Controllers\Api\DocumentoTitulacionController;
use App\Http\Controllers\Api\ControlEscolarController;
use App\Http\Controllers\Api\CoordinadorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('alumnos', AlumnoController::class); //LISTO
Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('grupos', GrupoController::class);
Route::apiResource('materias', MateriaController::class);
Route::apiResource('carga-academica', CargaAcademicaController::class); //LISTO
Route::apiResource('asistencias', AsistenciaController::class);//LISTO
Route::apiResource('pagos', PagoController::class);//LISTO
Route::apiResource('proyectos-titulacion', ProyectoTitulacionController::class);//LISTO
Route::apiResource('docentes', DocenteController::class);//LISTO
Route::apiResource('administradores', AdministradorController::class);//LISTO
Route::apiResource('documentos-titulacion', DocumentoTitulacionController::class); //LISTO
Route::apiResource('control-escolar', ControlEscolarController::class); //LISTO
Route::apiResource('coordinadores', CoordinadorController::class); //LISTO
