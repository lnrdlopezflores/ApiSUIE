<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Administrador;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdministradorController extends Controller
{
    /**
     * Listar administradores con su cuenta de usuario vinculada
     * GET /api/administradores
     */
    public function index(): JsonResponse
    {
        $administradores = Administrador::with('usuario')->get();
        return response()->json($administradores, 200);
    }

    /**
     * Registrar un nuevo administrador
     * POST /api/administradores
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre'     => 'nullable|string|max:300',
            'apaterno'   => 'nullable|string|max:300',
            'amaterno'   => 'nullable|string|max:300',
            'usuario_id' => 'nullable|integer|exists:usuarios,id',
        ]);

        $administrador = Administrador::create($validated);

        return response()->json([
            'message' => 'Administrador creado con éxito',
            'data'    => $administrador->load('usuario'),
        ], 201);
    }

    /**
     * Mostrar un administrador específico
     * GET /api/administradores/{id}
     */
    public function show($id): JsonResponse
    {
        $administrador = Administrador::with('usuario')->findOrFail($id);
        return response()->json($administrador, 200);
    }

    /**
     * Actualizar datos del administrador
     * PUT/PATCH /api/administradores/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $administrador = Administrador::findOrFail($id);

        $validated = $request->validate([
            'nombre'     => 'nullable|string|max:300',
            'apaterno'   => 'nullable|string|max:300',
            'amaterno'   => 'nullable|string|max:300',
            'usuario_id' => 'nullable|integer|exists:usuarios,id',
        ]);

        $administrador->update($validated);

        return response()->json([
            'message' => 'Administrador actualizado con éxito',
            'data'    => $administrador->fresh('usuario'),
        ], 200);
    }

    /**
     * Eliminar un administrador
     * DELETE /api/administradores/{id}
     */
    public function destroy($id): JsonResponse
    {
        $administrador = Administrador::findOrFail($id);
        $administrador->delete();

        return response()->json([
            'message' => 'Administrador eliminado con éxito'
        ], 200);
    }
}
