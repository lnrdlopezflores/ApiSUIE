<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Grupo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class GrupoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Grupo::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'semestre'       => 'required|in:1,2,3,4,5,6,Egresados',
            'grupo'          => 'required|string|max:1',
            'especialidad'   => 'required|string|max:100',
            'turno'          => 'nullable|in:Matutino,Vespertino',
            'ciclo_escolar'  => 'required|string|max:15',
            'estatus_egreso' => 'nullable|in:Regular,Egresado',
        ]);

        $grupo = Grupo::create($validated);
        return response()->json(['message' => 'Grupo creado', 'data' => $grupo], 201);
    }

    public function show(Grupo $grupo): JsonResponse
    {
        return response()->json($grupo->load('alumnos'), 200);
    }

    public function update(Request $request, Grupo $grupo): JsonResponse
    {
        $validated = $request->validate([
            'semestre'       => 'sometimes|required|in:1,2,3,4,5,6,Egresados',
            'grupo'          => 'sometimes|required|string|max:1',
            'especialidad'   => 'sometimes|required|string|max:100',
            'turno'          => 'nullable|in:Matutino,Vespertino',
            'ciclo_escolar'  => 'sometimes|required|string|max:15',
            'estatus_egreso' => 'nullable|in:Regular,Egresado',
        ]);

        $grupo->update($validated);
        return response()->json(['message' => 'Grupo actualizado', 'data' => $grupo], 200);
    }

    public function destroy(Grupo $grupo): JsonResponse
    {
        $grupo->delete();
        return response()->json(['message' => 'Grupo eliminado'], 200);
    }
}