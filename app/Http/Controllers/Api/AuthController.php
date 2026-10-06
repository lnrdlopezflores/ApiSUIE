<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Iniciar sesión y generar API Key (Token)
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('username', $request->username)->first();

        // Validar que el usuario exista y la contraseña sea correcta
        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'message' => 'Las credenciales ingresadas son incorrectas.'
            ], 401);
        }

        // Validar si el usuario está activo
        if (!$usuario->activo) {
            return response()->json([
                'message' => 'Tu cuenta se encuentra inactiva. Contacta al administrador.'
            ], 403);
        }

        // Cargar relaciones relevantes según el rol
        $usuario->load(['alumno', 'docente']);

        // Generar la API Key (Token de Sanctum)
        $token = $usuario->createToken('api_key_session')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'token'   => $token,
            'usuario' => $usuario,
        ], 200);
    }

    /**
     * Cerrar sesión (Revocar Token)
     */
    public function logout(Request $request): JsonResponse
    {
        // Revoca el token actual con el que el usuario hizo la petición
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada y token revocado exitosamente'
        ], 200);
    }
}