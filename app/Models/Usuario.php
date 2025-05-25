<?php

namespace App\Models;
use App\Models\Tarea;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
     use HasFactory;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'fecha_registro',
    ];

    protected $hidden = [
        'contrasena',
    ];

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'id_usuario', 'id_usuario');
    }
}
