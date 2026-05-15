<x-mail::message>
# Tu reserva está confirmada

Hola {{ $reserva->user->nom }} {{ $reserva->user->ape }},

Has reservado con éxito el vehículo
**{{ $reserva->vehiculo->marca->des . ' ' . $reserva->vehiculo->linea->des . ' ' . $reserva->vehiculo->mod ?? 'Vehículo' }}**
para las fechas del {{ $reserva->fecini->format('d/m/Y') }} al {{ $reserva->fecfin->format('d/m/Y') }}.

### Datos del Propietario para contactarlo:
* **Nombre:** {{ $reserva->vehiculo->user->nom }} {{ $reserva->vehiculo->user->ape }}
* **Correo electrónico:** {{ $reserva->vehiculo->user->email }}
* **Teléfono:** {{ $reserva->vehiculo->user->tel ?? 'No registrado' }}

Por favor, ponte en contacto con el propietario para coordinar la entrega.

<x-mail::button :url="url('/dashboard')">
Ir a mis reservas
</x-mail::button>

Gracias por elegirnos,<br>
{{ config('app.name') }}
</x-mail::message>