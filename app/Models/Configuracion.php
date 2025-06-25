<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Configuracion extends Model
{
    use HasFactory;

    // Nombre de la tabla y clave primaria
    protected $table = 'configuracion';
    protected $primaryKey = 'id_configuracion';
    public $timestamps = false;

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'id_usuario',
        'horas_anticipacion_default',
        'activar_notificaciones_por_defecto',
    ];

    /**
     * Relación con el usuario al que pertenece esta configuración.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
