<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Docente;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class DocenteController extends Controller
{
    // Listar todos los docentes
    public function index(): JsonResponse
    {
        $docentes = Docente::with('usuario')->get();
        return response()->json($docentes, 200);
    }

    // Registrar un docente
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'usuario_id'       => 'required|integer|exists:usuarios,id',
            'nombre'           => 'required|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'nullable|string|max:50',
            'correo'           => 'nullable|email|unique:docentes,correo|max:100',
            'telefono'         => 'nullable|string|max:15',
        ]);

        $docente = Docente::create($validated);

        return response()->json([
            'message' => 'Docente registrado con éxito.',
            'data'    => $docente
        ], 21);
    }

    // Mostrar un docente en particular
    public function show(Docente $docente): JsonResponse
    {
        return response()->json($docente->load('usuario'), 200);
    }

    // Actualizar datos del docente
    public function update(Request $request, Docente $docente): JsonResponse
    {
        $validated = $request->validate([
            'nombre'           => 'sometimes|required|string|max:50',
            'apellido_paterno' => 'sometimes|required|string|max:50',
            'apellido_materno' => 'nullable|string|max:50',
            'correo'           => 'nullable|email|max:100|unique:docentes,correo,' . $docente->id,
            'telefono'         => 'nullable|string|max:15',
        ]);

        $docente->update($validated);

        return response()->json([
            'message' => 'Datos del docente actualizados con éxito.',
            'data'    => $docente
        ], 200);
    }

    // Eliminar un docente
    public function destroy(Docente $docente): JsonResponse
    {
        $docente->delete();

        return response()->json([
            'message' => 'Docente eliminado correctamente.'
        ], 200);
    }
}