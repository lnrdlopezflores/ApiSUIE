<?php

use App\Models\Api\Usuario;
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
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // Buscar al usuario por username o clave
    $user = Usuario::where('username', $request->username)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Contraseña o usuario incorrectos.'
        ], 401);
    }

    if (isset($user->activo) && !$user->activo) {
        return response()->json([
            'success' => false,
            'message' => 'El usuario se encuentra inactivo.'
        ], 403);
    }

    return response()->json([
        'success' => true,
        'user' => $user
    ]);
});

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
