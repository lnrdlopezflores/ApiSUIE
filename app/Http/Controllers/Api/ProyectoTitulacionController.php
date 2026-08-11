<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\ProyectoTitulacion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProyectoTitulacionController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ProyectoTitulacion::with(['alumno', 'revisor'])->get(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'alumno_id'               => 'required|integer|exists:alumnos,id',
            'titulo'                  => 'required|string|max:150',
            'descripcion'             => 'nullable|string',
            'especialidad_historica'  => 'required|string|max:100',
            'documento_url'           => 'required|string|max:255',
            'estatus'                 => 'nullable|in:Revision,Modificaciones,Aprobado,Rechazado',
            'observaciones_revisor'   => 'nullable|string',
            'revisado_por_usuario_id' => 'nullable|integer|exists:usuarios,id',
        ]);

        $proyecto = ProyectoTitulacion::create($validated);
        return response()->json(['message' => 'Proyecto de titulación registrado', 'data' => $proyecto], 201);
    }

    public function show(ProyectoTitulacion $proyectoTitulacion): JsonResponse
    {
        return response()->json($proyectoTitulacion->load(['alumno', 'revisor']), 200);
    }

    public function update(Request $request, ProyectoTitulacion $proyectoTitulacion): JsonResponse
    {
        $validated = $request->validate([
            'titulo'                  => 'sometimes|required|string|max:150',
            'descripcion'             => 'nullable|string',
            'documento_url'           => 'sometimes|required|string|max:255',
            'estatus'                 => 'sometimes|required|in:Revision,Modificaciones,Aprobado,Rechazado',
            'observaciones_revisor'   => 'nullable|string',
            'revisado_por_usuario_id' => 'nullable|integer|exists:usuarios,id',
        ]);

        $proyectoTitulacion->update($validated);
        return response()->json(['message' => 'Proyecto actualizado con éxito', 'data' => $proyectoTitulacion], 200);
    }

    public function destroy(ProyectoTitulacion $proyectoTitulacion): JsonResponse
    {
        $proyectoTitulacion->delete();
        return response()->json(['message' => 'Proyecto eliminado'], 200);
    }
}
