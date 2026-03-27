<div class="container-fluid page cont__gral_public">

    <section class="card">
        <header class="head">
            <h1>Registro de vehículo</h1>
            <p>Por favor llene toda la información solicitada, se verificará en las próximas 48 horas.</p>
            <div class="rule"></div>
        </header>

        <form class="veh-form" action="{{ route('publicacion.vehiculo.store') }}" method="post">
            @csrf
            <!-- Columna izquierda -->
            <div class="veh-col">
                <div class="grid__form__reg">

                    <div class="veh-field">
                        <input type="hidden" name="vin" value="pendiente">
                    </div>

                    <div class="veh-field veh-field_1"> <label class="veh-label" for="clase">Clase de
                            vehículo</label>
                        <div class="veh-select"> <select id="clase" name="codcla" required>
                                <option value="" selected disabled hidden>Seleccione un tipo de vehículo</option>
                                @foreach ($vehiculoClase as $item)
                                    <option value="{{ $item->cod }}">{{ $item->des }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="veh-field veh-field_2"> <label class="veh-label" for="marca">Marca</label>
                        <div class="veh-select"> <select id="marca" name="codmar" required>
                                <option value="" selected disabled hidden>Seleccione una marca</option>
                                @foreach ($vehiculoMarca as $itemMarca)
                                    <option value="{{ $itemMarca->cod }}">{{ $itemMarca->des }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="veh-field veh-field_3"> <label class="veh-label" for="linea">Linea</label>
                        <div class="veh-select">
                            <select id="linea" name="codlin" required disabled>
                                <option value="" selected disabled>Seleccione una marca primero</option>
                            </select>
                        </div>
                    </div>

                    <div class="veh-field veh-field_4">
                        <label class="veh-label" for="modelo_anio">Modelo (año)</label>
                        <input id="modelo_anio" name="mod" type="number" inputmode="numeric" min="1900"
                            max="2026" step="1" placeholder="Ej: 2026" required />
                    </div>

                    <div class="veh-field veh-field_5">
                        <label class="veh-label" for="pasajeros">Capacidad pasajeros</label>
                        <input id="pasajeros" name="pas" type="number" inputmode="numeric" min="1"
                            max="4" step="1" placeholder="" required />
                    </div>

                    <div class="veh-field veh-field_6"> <label class="veh-label" for="color">Color</label>
                        <input id="color" name="col" type="text" required />
                    </div>

                    <div class="veh-field veh-field_7">
                        <label class="veh-label" for="Cilindraje">Cilindraje</label>
                        <input id="Cilindraje" name="cil" type="number" inputmode="numeric" min="1000"
                            max="2500" step="1" placeholder="Ej: 2000" required />
                    </div>

                    <div class="veh-field">
                        <input type="hidden" name="codpol" value="1">
                    </div>

                    <div class="veh-field veh-field_8"> <label class="veh-label" for="combustible">Tipo de
                            combustible</label>
                        <div class="veh-select"> <select id="combustible" name="codcom" required>
                                <option value="" selected disabled hidden>Seleccione un tipo de combustible
                                </option>
                                @foreach ($vehiculoCombustible as $itemComb)
                                    <option value="{{ $itemComb->cod }}">{{ $itemComb->des }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="veh-field veh-field_9">
                        <label class="veh-label" for="prerent">Precio por día (24h)</label>
                        <input id="prerent" name="prerent" type="number" inputmode="decimal" step="0.01"
                            min="0" placeholder="Ej: 120000" required />
                    </div>

                </div>
            </div> <!-- Columna derecha -->
            <div class="veh-col">
                <div class="veh-block">

                    <div class="veh-block">
                        <h3>Por favor seleccione los accesorios del vehículo.</h3>
                        <div class="veh-accessories">
                            @foreach ($vehiculoAccesorios as $acc)
                                <label class="veh-check">
                                    <input type="checkbox" name="accesorios[]" value="{{ $acc->id }}">
                                    <span class="veh-dot"></span> {{ $acc->des }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="veh-block">
                        <h3>Por favor seleccione la ubicación donde se encuentra el vehículo.</h3>
                        <div class="veh-row2">
                            <div class="veh-field"> <label class="veh-label" for="depto">Departamento</label>
                                <div class="veh-select">
                                    <select id="depto" name="coddepveh" required>
                                        <option value="" selected disabled hidden>Seleccione un departamento
                                        </option>
                                        @foreach ($deptoVehiculo as $vehDpto)
                                            <option value="{{ $vehDpto->cod }}">{{ $vehDpto->des }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="veh-field"> <label class="veh-label" for="municipio_bottom">Municipio</label>
                                <div class="veh-select">
                                    <select id="municipio_bottom" name="codciu" required disabled>
                                        <option value="" selected disabled hidden>Seleccione un departamento
                                            primero
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="veh-btn" type="submit">Siguiente</button>
                </div>
            </div>
        </form>
    </section>
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


            console.log(
                'Depto seleccionado:',
                depto.options[depto.selectedIndex].text,
                'ID:',
                coddepveh
            );

            // (opcional) limpia antes de cargar
            ciudad.disabled = true;
            ciudad.innerHTML = '<option value="" selected disabled>Cargando...</option>';

            try {
                const res = await fetch(`/publi-vehiculo/departamentos/${coddepveh}/ciudades`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });


                if (!res.ok) {
                    const txt = await res.text();
                    console.error('HTTP', res.status, txt);
                    throw new Error('No se pudieron cargar las ciudades');
                }

                const data = await res.json();

                ciudad.innerHTML =
                    '<option value="" selected disabled>Seleccione una ciudad</option>';

                if (!Array.isArray(data) || data.length === 0) {
                    ciudad.innerHTML =
                        '<option value="" selected disabled>No hay ciudades para este departamento</option>';
                    ciudad.disabled = true;
                    return;
                }

                for (const c of data) {
                    const opt = document.createElement('option');
                    opt.value = c.cod;
                    opt.textContent = c.des;
                    ciudad.appendChild(opt);
                }

                ciudad.disabled = false;

            } catch (err) {
                console.error(err);
                ciudad.innerHTML =
                    '<option value="" selected disabled>Error cargando ciudades</option>';
                ciudad.disabled = true;
            }
        });
    });
</script>
