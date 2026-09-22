<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Alumno;
use App\Models\Api\Usuario;

class DocumentoTitulacion extends Model
{
    use HasFactory;

    protected $table = 'documentos_titulacion';

    // La tabla sí cuenta con timestamps (created_at y updated_at)
    public $timestamps = true;

    protected $fillable = [
        'alumno_id',
        'tipo_documento',
        'nombre_archivo',
        'ruta_archivo',
        'version',
        'estatus',
        'observaciones',
        'revisado_por',
        'fecha_revision',
    ];

    protected $casts = [
        'version'        => 'integer',
        'fecha_revision' => 'datetime',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
    ];

    /**
     * Alumno dueño del documento
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    /**
     * Usuario (Administrador/Control Escolar) que revisó el documento
     */
    public function revisor()
    {
        return $this->belongsTo(Usuario::class, 'revisado_por');
    }
}