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
        return response()->json(
            ProyectoTitulacion::with(['alumno', 'docenteAsesor', 'revisor'])->get(), 
            200
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'alumno_id'               => 'required|integer|exists:alumnos,id',
            'docente_asesor_id'       => 'nullable|integer|exists:docentes,id',
            'titulo'                  => 'required|string|max:150',
            'modalidad'               => 'nullable|string|max:255',
            'resumen'                 => 'nullable|string',
            'descripcion'             => 'nullable|string',
            'especialidad_historica'  => 'required|string|max:100',
            'documento_url'           => 'nullable|string|max:255',
            'presentacion_url'        => 'nullable|string|max:255',
            'video_url'               => 'nullable|string|max:500',
            'estatus'                 => 'nullable|in:Pendiente,En_Revision,Liberado_Exposicion,Aprobado,Rechazado',
            'observaciones_revisor'   => 'nullable|string',
            'revisado_por_usuario_id' => 'nullable|integer|exists:usuarios,id',
        ]);

        $proyecto = ProyectoTitulacion::create($validated);
        return response()->json(['message' => 'Proyecto de titulación registrado con éxito', 'data' => $proyecto], 201);
    }

    public function show(ProyectoTitulacion $proyectoTitulacion): JsonResponse
    {
        return response()->json($proyectoTitulacion->load(['alumno', 'docenteAsesor', 'revisor']), 200);
    }

    public function update(Request $request, ProyectoTitulacion $proyectoTitulacion): JsonResponse
    {
        $validated = $request->validate([
            'alumno_id'               => 'sometimes|required|integer|exists:alumnos,id',
            'docente_asesor_id'       => 'nullable|integer|exists:docentes,id',
            'titulo'                  => 'sometimes|required|string|max:150',
            'modalidad'               => 'nullable|string|max:255',
            'resumen'                 => 'nullable|string',
            'descripcion'             => 'nullable|string',
            'especialidad_historica'  => 'sometimes|required|string|max:100',
            'documento_url'           => 'nullable|string|max:255',
            'presentacion_url'        => 'nullable|string|max:255',
            'video_url'               => 'nullable|string|max:500',
            'estatus'                 => 'sometimes|required|in:Pendiente,En_Revision,Liberado_Exposicion,Aprobado,Rechazado',
            'observaciones_revisor'   => 'nullable|string',
            'revisado_por_usuario_id' => 'nullable|integer|exists:usuarios,id',
        ]);

        $proyectoTitulacion->update($validated);
        return response()->json(['message' => 'Proyecto actualizado con éxito', 'data' => $proyectoTitulacion], 200);
    }

    public function destroy(ProyectoTitulacion $proyectoTitulacion): JsonResponse
    {
        $proyectoTitulacion->delete();
        return response()->json(['message' => 'Proyecto eliminado correctamente'], 200);
    }
}