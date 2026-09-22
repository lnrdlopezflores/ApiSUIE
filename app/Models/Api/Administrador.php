<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Usuario;

class Administrador extends Model
{
    use HasFactory;

    protected $table = 'administrador';

    // Desactivar timestamps
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apaterno',
        'amaterno',
        'usuario_id',
    ];

    /**
     * Relación con la tabla usuarios
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}