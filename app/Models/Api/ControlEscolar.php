<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Usuario;

class ControlEscolar extends Model
{
    use HasFactory;

    // Nombre de la tabla en MySQL
    protected $table = 'control_escolar';

    // Desactivar timestamps ya que la tabla no tiene created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apaterno',
        'telefono',
        'usuario_id',
    ];

    /**
     * Relación uno a uno con la cuenta de usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}