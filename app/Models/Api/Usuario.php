<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens; // <--- 1. Importar Sanctum

class Usuario extends Model
{
    use HasApiTokens; // <--- 2. Agregar el Trait

    protected $table = "usuarios";

    protected $fillable = [
        'username',
        'password',
        'rol',
        'activo',
    ];

    // Ocultar la contraseña en las respuestas JSON por seguridad
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function alumno(): HasOne
    {
        return $this->hasOne(Alumno::class, 'usuario_id');
    }

    public function administrador()
    {
        return $this->hasOne(\App\Models\Api\Administrador::class, 'usuario_id');
    }

    public function controlEscolar()
    {
        return $this->hasOne(\App\Models\Api\ControlEscolar::class, 'usuario_id');
    }

    public function coordinador()
    {
        return $this->hasOne(\App\Models\Api\Coordinador::class, 'usuario_id');
    }

    public function docente(): HasOne
    {
        return $this->hasOne(Docente::class, 'usuario_id');
    }

    public function proyectosRevisados(): HasMany
    {
        return $this->hasMany(ProyectoTitulacion::class, 'revisado_por_usuario_id');
    }
}