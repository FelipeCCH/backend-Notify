<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tarea;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ActualizarTareasVencidas extends Command
{
    protected $signature = 'tareas:actualizar-vencidas';
    protected $description = 'Actualiza automáticamente el estado de las tareas vencidas';

    public function handle()
    {
        $now = Carbon::now();

        $tareas = Tarea::where('estado', 'Pendiente')
            ->whereNotNull('fecha_limite')
            ->whereNotNull('hora_limite')
            ->whereRaw("STR_TO_DATE(CONCAT(fecha_limite, ' ', hora_limite), '%Y-%m-%d %H:%i:%s') < ?", [$now])
            ->get();

        foreach ($tareas as $tarea) {
            $tarea->estado = 'Vencido';
            $tarea->save();
        }

        $this->info("Tareas vencidas actualizadas: {$tareas->count()}");
        Log::info("Cron diario: tareas vencidas actualizadas. Total: {$tareas->count()}");
    }
}

