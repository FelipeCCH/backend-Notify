<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Usuario;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificacion';
    protected $primaryKey = 'id_notificacion';
    public $timestamps = false;

    protected $fillable = [
        'id_tarea',
        'correo_destino',
        'horas_anticipacion',
        'enviada',
        'fecha_envio',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'id_tarea', 'id_tarea');
    }
}
