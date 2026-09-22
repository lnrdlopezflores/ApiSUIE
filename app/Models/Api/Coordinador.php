<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Usuario;

class Coordinador extends Model
{
    use HasFactory;

    // Nombre de la tabla en MySQL
    protected $table = 'coordinador';

    // Desactivar timestamps ya que la tabla no incluye created_at ni updated_at
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apaterno',
        'telefono',
        'usuario_id',
    ];

    /**
     * Relación con la cuenta de usuario vinculada
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}