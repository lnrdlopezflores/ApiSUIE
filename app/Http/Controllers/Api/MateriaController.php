<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Materia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class MateriaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Materia::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'clave'           => 'required|string|max:20|unique:materias,clave',
            'nombre'          => 'required|string|max:100',
            'horas_semanales' => 'nullable|integer',
        ]);

        $materia = Materia::create($validated);
        return response()->json(['message' => 'Materia creada', 'data' => $materia], 201);
    }

    public function show(Materia $materia): JsonResponse
    {
        return response()->json($materia, 200);
    }

    public function update(Request $request, Materia $materia): JsonResponse
    {
        $validated = $request->validate([
            'clave'           => 'sometimes|required|string|max:20|unique:materias,clave,' . $materia->id,
            'nombre'          => 'sometimes|required|string|max:100',
            'horas_semanales' => 'nullable|integer',
        ]);

        $materia->update($validated);
        return response()->json(['message' => 'Materia actualizada', 'data' => $materia], 200);
    }

    public function destroy(Materia $materia): JsonResponse
    {
        $materia->delete();
        return response()->json(['message' => 'Materia eliminada'], 200);
    }
}

