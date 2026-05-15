<?php

namespace App\Modules\BusquedaReserva\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\MER\Reserva;

class ReservaPagada
{
    use Dispatchable, SerializesModels;
    public $reserva;

    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva;
    }
}

