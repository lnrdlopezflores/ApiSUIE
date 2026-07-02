<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grupo extends Model
{
    protected $table = 'grupos';

    public $timestamps = false;

    protected $fillable = [
        'semestre',
        'grupo',
        'especialidad',
        'turno',
        'ciclo_escolar',
        'estatus_egreso',
    ];

    public function alumnos(): HasMany
    {
        return $this->hasMany(Alumno::class, 'grupo_id');
    }

    public function cargasAcademicas(): HasMany
    {
        return $this->hasMany(CargaAcademica::class, 'grupo_id');
    }
}
