<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    protected $table = 'materias';

    public $timestamps = false;

    protected $fillable = [
        'clave', 
        'nombre',
        'horas_semanales',
    ];

    public function cargasAcademicas(): HasMany
    {
        return $this->hasMany(CargaAcademica::class, 'materia_id');
    }
}
