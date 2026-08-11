<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Pago;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class PagoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Pago::with('alumno')->get(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'alumno_id'           => 'required|integer|exists:alumnos,id',
            'concepto'            => 'required|in:Colegiatura Ordinaria,Reinscripción,Derecho de Examen,Trámite de Titulación,Constancia',
            'monto'               => 'required|numeric|between:0,999999.99',
            'fecha_pago'          => 'nullable|date_format:Y-m-d',
            'estatus'             => 'required|in:Pendiente,Pagado,Condonado,Vencido',
            'referencia_bancaria' => 'nullable|string|max:50',
            'comprobante_url'     => 'nullable|string|max:255',
        ]);

        $pago = Pago::create($validated);
        return response()->json(['message' => 'Orden de pago generada', 'data' => $pago], 201);
    }

    public function show(Pago $pago): JsonResponse
    {
        return response()->json($pago->load('alumno'), 200);
    }

    public function update(Request $request, Pago $pago): JsonResponse
    {
        $validated = $request->validate([
            'fecha_pago'          => 'nullable|date_format:Y-m-d',
            'estatus'             => 'sometimes|required|in:Pendiente,Pagado,Condonado,Vencido',
            'referencia_bancaria' => 'nullable|string|max:50',
            'comprobante_url'     => 'nullable|string|max:255',
        ]);

        $pago->update($validated);
        return response()->json(['message' => 'Pago actualizado', 'data' => $pago], 200);
    }

    public function destroy(Pago $pago): JsonResponse
    {
        $pago->delete();
        return response()->json(['message' => 'Registro de pago eliminado'], 200);
    }
}