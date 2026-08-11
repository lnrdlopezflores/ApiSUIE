<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AsistenciaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Asistencia::with(['alumno', 'cargaAcademica'])->get(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'carga_academica_id' => 'required|integer|exists:carga_academica,id',
            'alumno_id'          => 'required|integer|exists:alumnos,id',
            'fecha'              => 'required|date_format:Y-m-d',
            'estatus'            => 'required|in:Asistencia,Falta,Justificado,Retardo',
            'observacion'        => 'nullable|string|max:150',
        ]);

        // Evita duplicados para el mismo alumno, misma materia/carga y mismo día
        $exists = Asistencia::where('carga_academica_id', $validated['carga_academica_id'])
            ->where('alumno_id', $validated['alumno_id'])
            ->where('fecha', $validated['fecha'])
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'Ya se registró asistencia para este alumno en esta fecha.'], 422);
        }

        $asistencia = Asistencia::create($validated);
        return response()->json(['message' => 'Asistencia tomada', 'data' => $asistencia], 201);
    }

    public function show(Asistencia $asistencia): JsonResponse
    {
        return response()->json($asistencia->load(['alumno', 'cargaAcademica']), 200);
    }

    public function update(Request $request, Asistencia $asistencia): JsonResponse
    {
        $validated = $request->validate([
            'estatus'     => 'sometimes|required|in:Asistencia,Falta,Justificado,Retardo',
            'observacion' => 'nullable|string|max:150',
        ]);

        $asistencia->update($validated);
        return response()->json(['message' => 'Asistencia modificada', 'data' => $asistencia], 200);
    }

    public function destroy(Asistencia $asistencia): JsonResponse
    {
        $asistencia->delete();
        return response()->json(['message' => 'Registro de asistencia eliminado'], 200);
    }
}