<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Usuario;
use App\Models\Notificacion;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tarea';
    protected $primaryKey = 'id_tarea';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'titulo',
        'descripcion',
        'categoria',
        'fecha_limite',
        'hora_limite',
        'estado',
        'fecha_creacion',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function notificacion()
    {
        return $this->hasOne(Notificacion::class, 'id_tarea', 'id_tarea');
    }
}
