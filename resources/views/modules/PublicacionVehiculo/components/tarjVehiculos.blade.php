
    <div class="body-tarjeta">

    <div class="tarj-content-prop">

        <h1 class="Texto-princ">Mis vehículos</h1>

        <div class="content-prop">

            <div class="tarjet-prop">
                <img class="fondo-auto" src="../ICONOS/AUTO.jpg" alt="Foto auto rojo">
                
                <div class="texto">
                    <h1>Toyota</h1>
                    <h2>RAV4 Híbrida 2022</h2>
                </div>

                <div class="botones">
                    <h3 class="eliminar">Eliminar</h3>
                    <h3 class="editar">Editar</h3>
                </div>
            </div>
            
        </div>

        <div class="content-prop">
            
            <div class="tarjet-prop">
                <img class="fondo-auto" src="../ICONOS/AUTO.jpg" alt="Foto auto rojo">
                
                <div class="texto">
                    <h1>Toyota</h1>
                    <h2>RAV4 Híbrida 2022</h2>
                </div>

                <div class="botones">
                    <h3 class="eliminar">Eliminar</h3>
                    <h3 class="editar">Editar</h3>
                </div>
            </div>
            
        </div>

        <div class="content-prop">
            
            <div class="tarjet-prop">
                <img class="fondo-auto" src="../ICONOS/AUTO.jpg" alt="Foto auto rojo">
                
                <div class="texto">
                    <h1>Toyota</h1>
                    <h2>RAV4 Híbrida 2022</h2>
                </div>

                <div class="botones">
                    <h3 class="eliminar">Eliminar</h3>
                    <h3 class="editar">Editar</h3>
                </div>
            </div>
            
        </div>

    </div>
  </div>

  

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

        @if (!$veh->disp)
          <div class="veh-tile__footer" style="margin-top: 1rem;">
            <form action="{{ route('vehiculo.publicar', ['codveh' => $veh->cod]) }}" method="POST">
              @csrf
              <button type="submit" class="veh-btn" style="width: 100%; padding: 0.5rem; font-size: 0.8rem;">
                Publicar Vehículo
              </button>
            </form>
          </div>
        @else
          <div class="veh-tile__footer" style="margin-top: 1rem; color: #2ecc71; font-weight: bold; font-size: 0.8rem;">
            ● Vehículo Publicado
          </div>
        @endif
      </div>
    </article>








  @empty
    <p>No tienes vehículos registrados.</p>
  @endforelse
</div>


