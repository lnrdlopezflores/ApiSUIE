<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Docente extends Model
{
    protected $table = 'docentes';
    
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'telefono',
    ];

    protected $casts = [
    'nombre'           => 'encrypted',
    'apellido_paterno' => 'encrypted',
    'apellido_materno' => 'encrypted',
    'telefono'         => 'encrypted',
    'correo'           => 'encrypted', 
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function cargasAcademicas(): HasMany
    {
        return $this->hasMany(CargaAcademica::class, 'docente_id');
    }
}
