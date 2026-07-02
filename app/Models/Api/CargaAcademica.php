<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CargaAcademica extends Model
{
    protected $table = 'carga_academica';

    public $timestamps = false;

    protected $fillable = [
        'docente_id',
        'materia_id',
        'grupo_id',
        'aula',
        'horario',
    ];

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class,'grupo_id');
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'carga_academica_id');
    } 
}
