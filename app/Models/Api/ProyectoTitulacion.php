<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProyectoTitulacion extends Model
{
    protected $table = 'proyectos_titulacion';

    public $timestamps = false;

    protected $fillable = [
    'alumno_id',
    'docente_asesor_id',
    'titulo',
    'modalidad',
    'resumen',
    'descripcion',
    'especialidad_historica',
    'documento_url',
    'presentacion_url',
    'video_url',
    'estatus',
    'observaciones_revisor',
    'revisado_por_usuario_id',
    ];

    public function docenteAsesor()
    {
        return $this->belongsTo(Docente::class, 'docente_asesor_id');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function revisor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'revisado_por_usuario_id');
    }
}
