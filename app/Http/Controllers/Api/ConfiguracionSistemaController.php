<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\ConfiguracionSistema;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfiguracionSistemaController extends Controller
{
    /**
     * Listar todas las configuraciones del sistema.
     */
    public function index(): JsonResponse
    {
        $configuraciones = ConfiguracionSistema::all();
        return response()->json($configuraciones, 200);
    }

    /**
     * Crear una nueva configuración.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'clave' => 'required|string|max:50|unique:configuraciones_sistema,clave',
            'valor' => 'nullable|string',
        ]);

        $configuracion = ConfiguracionSistema::create($validated);

        return response()->json([
            'message' => 'Configuración creada correctamente',
            'data' => $configuracion
        ], 201);
    }

    /**
     * Mostrar una configuración específica por ID o por clave.
     */
   public function show($param)
{
    // Buscar por ID si es número, o por el nombre de la 'clave'
    $config = is_numeric($param) 
        ? ConfiguracionSistema::find($param) 
        : ConfiguracionSistema::where('clave', $param)->first();

    if (!$config) {
        return response()->json(['message' => 'Configuración no encontrada'], 404);
    }

    return response()->json($config, 200);
}

public function update(Request $request, $param)
{
    $config = is_numeric($param) 
        ? ConfiguracionSistema::find($param) 
        : ConfiguracionSistema::where('clave', $param)->first();

    if (!$config) {
        return response()->json(['message' => 'Configuración no encontrada'], 404);
    }

    $request->validate([
        'valor' => 'required|string',
    ]);

    $config->update([
        'valor' => $request->valor
    ]);

    return response()->json([
        'message' => 'Configuración actualizada correctamente',
        'data' => $config
    ], 200);
}

    /**
     * Eliminar una configuración.
     */
    public function destroy($id): JsonResponse
    {
        $configuracion = ConfiguracionSistema::find($id);

        if (!$configuracion) {
            return response()->json(['message' => 'Configuración no encontrada'], 404);
        }

        $configuracion->delete();

        return response()->json(['message' => 'Configuración eliminada'], 200);
    }
}