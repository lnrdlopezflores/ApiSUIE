<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionSistema extends Model
{
    use HasFactory;

    // Especificamos el nombre exacto de la tabla de la BD
    protected $table = 'configuraciones_sistema';

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'clave',
        'valor',
    ];
}
