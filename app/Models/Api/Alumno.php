<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumno extends Model
{
    protected $table = 'alumnos';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'grupo_id',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'nombre_tutor',
        'telefono_tutor',
    ];

    protected $casts = [
    'nombre'           => 'encrypted',
    'apellido_paterno' => 'encrypted',
    'apellido_materno' => 'encrypted',
    'nombre_tutor'     => 'encrypted',
    'telefono_tutor'   => 'encrypted',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'alumno_id');
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'alumno_id');
    }

    public function proyectosTitulacion(): HasMany
    {
        return $this->hasMany(ProyectoTitulacion::class, 'alumno_id');
    }
}
