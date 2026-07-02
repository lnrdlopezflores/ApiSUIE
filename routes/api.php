<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlumnoController;
use App\Http\Controllers\Api\UsuarioController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('alumnos', AlumnoController::class);
Route::apiResource('usuarios', UsuarioController::class);