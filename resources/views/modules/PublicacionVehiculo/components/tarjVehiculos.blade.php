@php use App\Models\MER\FotoVehiculo; @endphp

<div class="veh-grid">
  @forelse($vehiculos as $veh)
    @php
      $foto = FotoVehiculo::where('codveh', $veh->cod)->orderBy('cod')->first();
      $src = $foto
          ? asset('storage/' . ltrim($foto->ruta, '/'))
          : 'https://picsum.photos/520/360?random=' . ($veh->cod ?? $loop->index + 1);
    @endphp

    <article class="veh-tile">
      <a class="veh-tile__media" href="#">
        <img src="{{ $src }}" alt="Vehículo {{ $veh->vin ?? '' }}" loading="lazy">
        <span class="veh-tile__tag">Premium</span>
      </a>

      <div class="veh-tile__content">
        <div class="veh-tile__top">
          <div class="veh-tile__title">
            <h3>{{ $veh->marca->des ?? 'Marca' }}</h3>
            <p>{{ $veh->linea->des ?? 'Línea' }} ({{ $veh->mod ?? '' }})</p>
          </div>

          <div class="veh-tile__price">
            <div class="veh-tile__price-main">— COP/ día</div>
            <div class="veh-tile__price-sub">— COP/ hora</div>
          </div>
        </div>

        <div class="veh-tile__meta">
          VIN: {{ $veh->vin ?? '—' }} 
          Modelo: {{ $veh->mod ?? '—' }}
        </div>
      </div>
    </article>

  @empty
    <p>No tienes vehículos registrados.</p>
  @endforelse
</div>
