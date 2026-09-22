<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Coordinador;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CoordinadorController extends Controller
{
    /**
     * Listar coordinadores con su usuario
     * GET /api/coordinadores
     */
    public function index(): JsonResponse
    {
        $coordinadores = Coordinador::with('usuario')->get();
        return response()->json($coordinadores, 200);
    }

    /**
     * Registrar un nuevo coordinador
     * POST /api/coordinadores
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre'     => 'nullable|string|max:300',
            'apaterno'   => 'nullable|string|max:300',
            'telefono'   => 'nullable|string|max:300',
            'usuario_id' => 'nullable|integer|exists:usuarios,id|unique:coordinador,usuario_id',
        ]);

        $coordinador = Coordinador::create($validated);

        return response()->json([
            'message' => 'Coordinador registrado con éxito',
            'data'    => $coordinador->load('usuario'),
        ], 201);
    }

    /**
     * Mostrar un coordinador específico
     * GET /api/coordinadores/{id}
     */
    public function show($id): JsonResponse
    {
        $coordinador = Coordinador::with('usuario')->findOrFail($id);
        return response()->json($coordinador, 200);
    }

    /**
     * Actualizar datos del coordinador
     * PUT/PATCH /api/coordinadores/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $coordinador = Coordinador::findOrFail($id);

        $validated = $request->validate([
            'nombre'     => 'nullable|string|max:300',
            'apaterno'   => 'nullable|string|max:300',
            'telefono'   => 'nullable|string|max:300',
            'usuario_id' => 'nullable|integer|exists:usuarios,id|unique:coordinador,usuario_id,' . $coordinador->id,
        ]);

        $coordinador->update($validated);

        return response()->json([
            'message' => 'Coordinador actualizado con éxito',
            'data'    => $coordinador->fresh('usuario'),
        ], 200);
    }

    /**
     * Eliminar coordinador
     * DELETE /api/coordinadores/{id}
     */
    public function destroy($id): JsonResponse
    {
        $coordinador = Coordinador::findOrFail($id);
        $coordinador->delete();

        return response()->json([
            'message' => 'Coordinador eliminado con éxito'
        ], 200);
    }
}
