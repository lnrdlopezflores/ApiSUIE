<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\CargaAcademica;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CargaAcademicaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(CargaAcademica::with(['docente', 'materia', 'grupo'])->get(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'docente_id' => 'required|integer|exists:docentes,id',
            'materia_id' => 'required|integer|exists:materias,id',
            'grupo_id'   => 'required|integer|exists:grupos,id',
            'aula'       => 'nullable|string|max:30',
            'horario'    => 'nullable|string',
        ]);

        // Validación manual de la Unique Key compuesta: unica_asignacion
        $exists = CargaAcademica::where('docente_id', $validated['docente_id'])
            ->where('materia_id', $validated['materia_id'])
            ->where('grupo_id', $validated['grupo_id'])
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'Esta asignación académica ya existe.'], 422);
        }

        $carga = CargaAcademica::create($validated);
        return response()->json(['message' => 'Carga académica asignada', 'data' => $carga], 201);
    }

    public function show(CargaAcademica $cargaAcademica): JsonResponse
    {
        return response()->json($cargaAcademica->load(['docente', 'materia', 'grupo']), 200);
    }

    public function update(Request $request, CargaAcademica $cargaAcademica): JsonResponse
    {
        $validated = $request->validate([
            'docente_id' => 'sometimes|required|integer|exists:docentes,id',
            'materia_id' => 'sometimes|required|integer|exists:materias,id',
            'grupo_id'   => 'sometimes|required|integer|exists:grupos,id',
            'aula'       => 'nullable|string|max:30',
            'horario'    => 'nullable|string',
        ]);

        $cargaAcademica->update($validated);
        return response()->json(['message' => 'Carga académica actualizada', 'data' => $cargaAcademica], 200);
    }

    public function destroy(CargaAcademica $cargaAcademica): JsonResponse
    {
        $cargaAcademica->delete();
        return response()->json(['message' => 'Asignación eliminada'], 200);
    }
}
