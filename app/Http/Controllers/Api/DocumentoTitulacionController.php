<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\DocumentoTitulacion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DocumentoTitulacionController extends Controller
{
    /**
     * Listar documentos (con filtro opcional por alumno_id)
     * GET /api/documentos-titulacion?alumno_id=1
     */
    public function index(Request $request): JsonResponse
    {
        $query = DocumentoTitulacion::with(['alumno', 'revisor']);

        if ($request->filled('alumno_id')) {
            $query->where('alumno_id', $request->query('alumno_id'));
        }

        return response()->json($query->orderBy('created_at', 'desc')->get(), 200);
    }

    /**
     * Subir o registrar un documento de titulación
     * POST /api/documentos-titulacion
     */
    public function store(Request $request): JsonResponse
    {
        $tiposPermitidos = [
            'Certificado_Secundaria',
            'Constancia_Liberacion_SS',
            'Acta_Nacimiento',
            'Cetificado_Bachillerato', // Tal cual está escrito en el enum de la BD
            'Curp',
            'Acta_Recepcion_Profesional'
        ];

        $request->validate([
            'alumno_id'      => 'required|integer|exists:alumnos,id',
            'tipo_documento' => ['required', Rule::in($tiposPermitidos)],
            'archivo'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Hasta 10MB
            'observaciones'  => 'nullable|string',
        ]);

        $archivo = $request->file('archivo');
        $nombreOriginal = $archivo->getClientOriginalName();
        $ruta = $archivo->store('titulacion', 'public');

        // Determinar versión si el alumno ya había subido este mismo tipo de documento
        $ultimaVersion = DocumentoTitulacion::where('alumno_id', $request->alumno_id)
            ->where('tipo_documento', $request->tipo_documento)
            ->max('version') ?? 0;

        $documento = DocumentoTitulacion::create([
            'alumno_id'      => $request->alumno_id,
            'tipo_documento' => $request->tipo_documento,
            'nombre_archivo' => $nombreOriginal,
            'ruta_archivo'   => $ruta,
            'version'        => $ultimaVersion + 1,
            'estatus'        => 'Pendiente',
            'observaciones'  => $request->observaciones,
        ]);

        return response()->json([
            'message' => 'Documento subido correctamente',
            'data'    => $documento,
        ], 201);
    }

    /**
     * Mostrar detalle de un documento
     * GET /api/documentos-titulacion/{id}
     */
    public function show($id): JsonResponse
    {
        $documento = DocumentoTitulacion::with(['alumno', 'revisor'])->findOrFail($id);
        return response()->json($documento, 200);
    }

    /**
     * Revisar y calificar documento (Aprobar o Rechazar)
     * PUT/PATCH /api/documentos-titulacion/{id}/revisar
     */
    public function revisar(Request $request, $id): JsonResponse
    {
        $documento = DocumentoTitulacion::findOrFail($id);

        $validated = $request->validate([
            'estatus'       => ['required', Rule::in(['Pendiente', 'En_Revision', 'Aprobado', 'Rechazado'])],
            'observaciones' => 'nullable|string',
            'revisado_por'  => 'required|integer|exists:usuarios,id',
        ]);

        $documento->update([
            'estatus'        => $validated['estatus'],
            'observaciones'  => $validated['observaciones'] ?? $documento->observaciones,
            'revisado_por'   => $validated['revisado_por'],
            'fecha_revision' => now(),
        ]);

        return response()->json([
            'message' => 'Estatus del documento actualizado',
            'data'    => $documento->load('revisor'),
        ], 200);
    }

    /**
     * Eliminar documento y su archivo físico
     * DELETE /api/documentos-titulacion/{id}
     */
    public function destroy($id): JsonResponse
    {
        $documento = DocumentoTitulacion::findOrFail($id);

        if ($documento->ruta_archivo && Storage::disk('public')->exists($documento->ruta_archivo)) {
            Storage::disk('public')->delete($documento->ruta_archivo);
        }

        $documento->delete();

        return response()->json([
            'message' => 'Documento eliminado correctamente'
        ], 200);
    }
}