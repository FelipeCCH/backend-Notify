<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notificacion;
use App\Models\Configuracion;
use Illuminate\Support\Facades\Mail;
use App\Mail\TareaRecordatorioMail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Tarea;

class EnviarRecordatoriosTareas extends Command
{
    protected $signature = 'tareas:enviar-recordatorios';
    protected $description = 'Envía correos de recordatorio antes del vencimiento de las tareas';

    public function handle()
    {
        $now = Carbon::now();

        $notificaciones = Notificacion::where('enviada', false)
            ->whereNotNull('fecha_envio')
            ->where('fecha_envio', '<=', $now)
            ->with(['tarea.usuario'])
            ->get();

        foreach ($notificaciones as $notificacion) {
            $tarea = $notificacion->getRelationValue('tarea');

            if ($tarea && $tarea->usuario && $tarea->usuario->correo) {
                $config = Configuracion::where('id_usuario', $tarea->id_usuario)->first();

                if ($config && ! $config->activar_notificaciones_por_defecto) {
                    Log::info("Notificación omitida para tarea '{$tarea->titulo}' porque el usuario tiene notificaciones desactivadas.");
                    continue;
                }

                try {
                    Mail::to($tarea->usuario->correo)->send(new TareaRecordatorioMail($tarea));

                    $notificacion->enviada = true;
                    $notificacion->fecha_envio = $now;
                    $notificacion->save();

                    $this->info("Recordatorio enviado a: {$tarea->usuario->correo} - {$tarea->titulo}");
                } catch (\Exception $e) {
                    Log::error("Error al enviar recordatorio para la tarea: {$tarea->titulo}. Error: {$e->getMessage()}");
                }
            } else {
                Log::warning("No se pudo enviar recordatorio. Datos incompletos para la tarea ID {$notificacion->id_tarea}");
            }
        }

        Log::info("Recordatorios procesados: " . $notificaciones->count());
    }
}
