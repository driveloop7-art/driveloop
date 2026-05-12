<?php

namespace App\Modules\BusquedaReserva\Listeners;

use App\Modules\BusquedaReserva\Events\ReservaPagada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EnviarCorreosReserva implements ShouldQueue
{
    public function handle(ReservaPagada $event)
    {
        $reserva = $event->reserva;
        Mail::to($reserva->user->email)->send(new \App\Modules\BusquedaReserva\Mail\NotificacionReservaArrendatario($reserva));
        Mail::to($reserva->vehiculo->user->email)->send(new \App\Modules\BusquedaReserva\Mail\NotificacionReservaPropietario($reserva));
    }
}

