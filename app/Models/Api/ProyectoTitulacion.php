<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Alumno;
use App\Models\Api\Docente;
use App\Models\Api\Usuario;

class ProyectoTitulacion extends Model
{
    protected $table = 'proyectos_titulacion'; // o el nombre exacto de tu tabla

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

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function docenteAsesor()
    {
        return $this->belongsTo(Docente::class, 'docente_asesor_id');
    }

    public function revisor()
    {
        return $this->belongsTo(Usuario::class, 'revisado_por_usuario_id');
    }
}