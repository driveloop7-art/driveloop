<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\MakeCustomCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        //
    }

    protected function commands(): void
    {
        // Carga todos los archivos de app/Console/Commands automáticamente
        $this->load(__DIR__.'/Commands');

        // Carga las rutas de consola
        require base_path('routes/console.php');
    }
}