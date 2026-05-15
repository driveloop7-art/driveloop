<x-mail::message>
# ¡Felicidades! Tienes una nueva reserva

Hola {{ $reserva->vehiculo->user->nom }} {{ $reserva->vehiculo->user->ape }},

Han reservado tu vehículo
**{{ $reserva->vehiculo->marca->des . ' ' . $reserva->vehiculo->linea->des . ' ' . $reserva->vehiculo->mod ?? 'Vehículo' }}**
para las fechas del {{ $reserva->fecini->format('d/m/Y') }} al {{ $reserva->fecfin->format('d/m/Y') }}.

### Datos del Arrendatario:
* **Nombre:** {{ $reserva->user->nom }} {{ $reserva->user->ape }}
* **Correo electrónico:** {{ $reserva->user->email }}
* **Teléfono:** {{ $reserva->user->tel ?? 'No registrado' }}

<x-mail::button :url="url('/dashboard')">
Ver Detalles en DriveLoop
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>