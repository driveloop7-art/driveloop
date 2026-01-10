<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Driveloop') }}</title>

    <!-- Icon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/publicacion/pubVeh.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="min-h-screen img-background">
        <div class="mx-4 sm:mx-16 sm:px-6 lg:px-8 min-w-60">
            <div class="py-2">
                <div class="p-2">
                    @include('layouts.navigation')
                </div>
            </div>
            <!-- Page Heading -->
            <!-- @isset($header)
    <header class="shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
@endisset -->

            <!-- Page Content -->
            <main>
                <div class="py-1">
                    <div class="sm:rounded-lg">
                        <div class="p-2">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

{{-- Inicio Selecctor dinamico de lineas segun marca de vehiculo --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const marcaSelect = document.getElementById('marca');
            const lineaSelect = document.getElementById('linea');

            if (!marcaSelect || !lineaSelect) {
                console.error('No existe #marca o #linea en el DOM');
                return;
            }

            const endpointTemplate = @json(route('marcas.lineas', ['cod' => '__COD__']));

            function resetLineas(texto) {
                lineaSelect.innerHTML = `<option value="" selected disabled>${texto}</option>`;
                lineaSelect.disabled = true;
            }

            marcaSelect.addEventListener('change', async () => {
                const codMarca = marcaSelect.value;
                resetLineas('Cargando líneas...');

                try {
                    const url = endpointTemplate.replace('__COD__', encodeURIComponent(codMarca));

                    const res = await fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!res.ok) throw new Error('HTTP ' + res.status);

                    const data = await res.json();

                    if (!Array.isArray(data) || data.length === 0) {
                        return resetLineas('Esta marca no tiene líneas');
                    }

                    lineaSelect.disabled = false;
                    lineaSelect.innerHTML =
                        `<option value="" selected disabled>Seleccione una línea</option>`;
                    data.forEach(l => {
                        lineaSelect.insertAdjacentHTML('beforeend',
                            `<option value="${l.cod}">${l.des}</option>`);
                    });

                } catch (e) {
                    console.error(e);
                    resetLineas('No se pudieron cargar las líneas');
                }
            });

            resetLineas('Seleccione una marca primero');
        });
    </script>
    {{-- Fin Selecctor dinamico de lineas segun marca de vehiculo --}}



    
    {{-- Inicio Selector dinámico de ciudades según departamento --}}
    <script>
document.addEventListener('DOMContentLoaded', () => {
  const depto = document.getElementById('depto');
  const ciudad = document.getElementById('municipio_bottom');

  depto.addEventListener('change', async () => {
    const coddepveh = depto.value;

    ciudad.disabled = true;
    ciudad.innerHTML = '<option value="" selected disabled>Cargando...</option>';

    try {
      const res = await fetch(`/publi-vehiculo/departamentos/${coddepveh}/ciudades`, {
        headers: { 'Accept': 'application/json' }
      });

      if (!res.ok) throw new Error('No se pudieron cargar las ciudades');

      const data = await res.json();

      ciudad.innerHTML = '<option value="" selected disabled>Seleccione una ciudad</option>';

      if (!data.length) {
        ciudad.innerHTML = '<option value="" selected disabled>No hay ciudades para este departamento</option>';
        ciudad.disabled = true;
        return;
      }

      for (const c of data) {
        const opt = document.createElement('option');
        opt.value = c.codciuveh;
        opt.textContent = c.nomciuveh;
        ciudad.appendChild(opt);
      }

      ciudad.disabled = false;

    } catch (err) {
      console.error(err);
      ciudad.innerHTML = '<option value="" selected disabled>Error cargando ciudades</option>';
      ciudad.disabled = true;
    }
  });
});
</script>
    {{-- Fin Selector dinámico de ciudades según departamento --}}



</body>

</html>
