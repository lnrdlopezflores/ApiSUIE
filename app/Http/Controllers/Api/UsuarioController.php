<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Usuario::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:usuarios,username',
            'password' => 'required|string|min:6',
            'rol'      => 'required|in:Estudiante,Docente,Orientador,Control Escolar,Coordinador,administrador',
            'activo'   => 'boolean'
        ]);

        // Ciframos la contraseña usando el Hash nativo de Laravel
        $validated['password'] = Hash::make($validated['password']);

        $usuario = Usuario::create($validated);
        return response()->json(['message' => 'Usuario creado', 'data' => $usuario], 201);
    }

    public function show(Usuario $usuario): JsonResponse
    {
        return response()->json($usuario->load(['alumno', 'docente']), 200);
    }

    public function update(Request $request, Usuario $usuario): JsonResponse
    {
        $validated = $request->validate([
            'username' => 'sometimes|required|string|max:50|unique:usuarios,username,' . $usuario->id,
            'password' => 'nullable|string|min:6',
            'rol'      => 'sometimes|required|in:Estudiante,Docente,Orientador,Control Escolar,Coordinador,administrador',
            'activo'   => 'boolean'
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $usuario->update($validated);
        return response()->json(['message' => 'Usuario actualizado', 'data' => $usuario], 200);
    }

    public function destroy(Usuario $usuario): JsonResponse
    {
        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}
