<?php

namespace App\Http\Controllers\Api;
use App\Models\Api\Alumno;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AlumnoController extends Controller
{
    public function index(): JsonResponse
    {
        $alumnos = Alumno::with(['usuario', 'grupo'])->get();
        return response()->json($alumnos, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'usuario_id'       => 'required|exists:usuarios,id',
            'grupo_id'         => 'nullable|exists:grupos,id',
            'nombre'           => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'nombre_tutor'     => 'required|string|max:255',
            'telefono_tutor'   => 'required|string|max:20',
        ]);

        $alumno = Alumno::create($validate);
        
        return response()->json([
            'message' => 'Alumno creado exitosamente',
            'data' => $alumno
        ], 201);
    }

    public function show(Alumno $alumno): JsonResponse
    {
        return response()->json($alumno->load(['usuario','grupo']), 200);
    }

    public function update(Request $request, Alumno $alumno): JsonResponse
    {
        $validated = $request->validate([
            'grupo_id'         => 'nullable|integer|exists:grupos,id',
            'nombre'           => 'sometimes|required|string|max:50',
            'apellido_paterno' => 'sometimes|required|string|max:50',
            'apellido_materno' => 'nullable|string|max:50',
            'nombre_tutor'     => 'sometimes|required|string|max:100',
            'telefono_tutor'   => 'sometimes|required|string|max:15',
        ]);

        $alumno->update($validated);

        return response()->json([
            'message' => 'Datos del alumno actualizados con éxito.',
            'data'    => $alumno
        ], 200);
    }

    public function destroy(Alumno $alumno): JsonResponse
    {
        $alumno->delete();

        return response()->json([
            'message' => 'Alumno eliminado exitosamente.'
        ], 200);
    }
}
