<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Usuario extends Model
{
    protected $table = "usuarios";

    protected $fillable = [
        'username',
        'password',
        'rol',
        'activo',
    ];

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

    public function docente(): HasOne
    {
        return $this->hasOne(Docente::class, 'usuario_id');
    }

    public function proyectosRevisados(): HasMany
    {
        return $this->hasMany(ProyectoTitulacion::class, 'revisado_por_usuario_id');
    }
}
