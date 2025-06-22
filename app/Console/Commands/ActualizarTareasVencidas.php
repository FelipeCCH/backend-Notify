<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tarea;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\TareaVencidaMail;
use Illuminate\Support\Facades\Mail;

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

            //Enviar correo de notificacion
            if($tarea->usuario && $tarea->usuario->correo){
                try {
                    Mail::to($tarea->usuario->correo)->send(new TareaVencidaMail($tarea));
                    $this->info("Correo enviado a: {$tarea->usuario->correo} para la tarea: {$tarea->titulo}");
                } catch (\Exception $e) {
                    Log::error("Error al enviar correo para la tarea: {$tarea->titulo}. Error: {$e->getMessage()}");
                }
            } else {
                Log::warning("No se pudo enviar correo, usuario o correo no disponible para la tarea: {$tarea->titulo}");
            }
        }

        $this->info("Tareas vencidas actualizadas: {$tareas->count()}");
        Log::info("Cron diario: tareas vencidas actualizadas. Total: {$tareas->count()}");
    }
}

