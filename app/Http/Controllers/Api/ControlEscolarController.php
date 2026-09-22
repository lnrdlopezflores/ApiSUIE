<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\ControlEscolar;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ControlEscolarController extends Controller
{
    /**
     * Listar personal de control escolar
     * GET /api/control-escolar
     */
    public function index(): JsonResponse
    {
        $personal = ControlEscolar::with('usuario')->get();
        return response()->json($personal, 200);
    }

    /**
     * Registrar un nuevo integrante de control escolar
     * POST /api/control-escolar
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre'     => 'nullable|string|max:300',
            'apaterno'   => 'nullable|string|max:300',
            'telefono'   => 'nullable|string|max:300',
            'usuario_id' => 'nullable|integer|exists:usuarios,id|unique:control_escolar,usuario_id',
        ]);

        $controlEscolar = ControlEscolar::create($validated);

        return response()->json([
            'message' => 'Registro de Control Escolar creado con éxito',
            'data'    => $controlEscolar->load('usuario'),
        ], 201);
    }

    /**
     * Mostrar un registro específico
     * GET /api/control-escolar/{id}
     */
    public function show($id): JsonResponse
    {
        $controlEscolar = ControlEscolar::with('usuario')->findOrFail($id);
        return response()->json($controlEscolar, 200);
    }

    /**
     * Actualizar datos del personal de control escolar
     * PUT/PATCH /api/control-escolar/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $controlEscolar = ControlEscolar::findOrFail($id);

        $validated = $request->validate([
            'nombre'     => 'nullable|string|max:300',
            'apaterno'   => 'nullable|string|max:300',
            'telefono'   => 'nullable|string|max:300',
            'usuario_id' => 'nullable|integer|exists:usuarios,id|unique:control_escolar,usuario_id,' . $controlEscolar->id,
        ]);

        $controlEscolar->update($validated);

        return response()->json([
            'message' => 'Registro de Control Escolar actualizado con éxito',
            'data'    => $controlEscolar->fresh('usuario'),
        ], 200);
    }

    /**
     * Eliminar registro
     * DELETE /api/control-escolar/{id}
     */
    public function destroy($id): JsonResponse
    {
        $controlEscolar = ControlEscolar::findOrFail($id);
        $controlEscolar->delete();

        return response()->json([
            'message' => 'Registro de Control Escolar eliminado con éxito'
        ], 200);
    }
}
