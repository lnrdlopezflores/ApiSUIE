<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    protected $table = 'asistencias';

    public $timestamps = false;

    protected $fillable = [
        'carga_academica_id',
        'alumno_id',
        'fecha',
        'estatus',
        'observacion',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function cargaAcademica(): BelongsTo
    {
        return $this->belongsTo(CargaAcademica::class, 'carga_academica_id');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }
}
