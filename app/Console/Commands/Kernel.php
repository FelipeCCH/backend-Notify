<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\ActualizarTareasVencidas::class,
        \App\Console\Commands\EnviarRecordatoriosTareas::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tareas:actualizar-vencidas')
                ->everyMinute()
                ->withoutOverlapping();

        $schedule->command('tareas:enviar-recordatorios')
                ->everyMinute()
                ->withoutOverlapping();
    }


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
