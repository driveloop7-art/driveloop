<x-page>
    <div class="container-fluid page cont__gral_public">
        <section class="card">
            <header class="head">
                <h1>Editar informacion del vehículo</h1>
                <div class="rule"></div>
            </header>

            <form class="veh-form" action="{{ route('vehiculos.update', $vehiculo->cod) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="veh-col">
                    <div class="grid__form__reg">

                        <div class="veh-field">
                            <input type="hidden" name="vin"
                                value="{{ old('vin', $vehiculo->vin ?? 'pendiente') }}">
                        </div>

                        {{-- Clase --}}
                        <div class="veh-field veh-field_1">
                            <label class="veh-label" for="clase">Clase de vehículo</label>
                            <div class="veh-select">
                                <select id="clase" name="codcla" required>
                                    <option value="" disabled hidden>Seleccione un tipo de vehículo</option>
                                    @foreach ($vehiculoClase as $item)
                                        <option value="{{ $item->cod }}" @selected(old('codcla', $vehiculo->codcla) == $item->cod)>
                                            {{ $item->des }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Marca --}}
                        <div class="veh-field veh-field_2">
                            <label class="veh-label" for="marca">Marca</label>
                            <div class="veh-select">
                                <select id="marca" name="codmar" required>
                                    <option value="" disabled hidden>Seleccione una marca</option>
                                    @foreach ($vehiculoMarca as $itemMarca)
                                        <option value="{{ $itemMarca->cod }}" @selected(old('codmar', $vehiculo->codmar) == $itemMarca->cod)>
                                            {{ $itemMarca->des }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Línea (dependiente) --}}
                        <div class="veh-field veh-field_3">
                            <label class="veh-label" for="linea">Linea</label>
                            <div class="veh-select">
                                <select id="linea" name="codlin" required disabled
                                    data-selected="{{ old('codlin', $vehiculo->codlin) }}">
                                    <option value="" selected disabled>Cargando líneas...</option>
                                </select>
                            </div>
                        </div>

                        {{-- Modelo --}}
                        <div class="veh-field veh-field_4">
                            <label class="veh-label" for="modelo_anio">Modelo (año)</label>
                            <input id="modelo_anio" name="mod" type="number" min="1900"
                                max="{{ date('Y') + 1 }}" step="1" value="{{ old('mod', $vehiculo->mod) }}"
                                required />
                        </div>

                        {{-- Pasajeros --}}
                        <div class="veh-field veh-field_5">
                            <label class="veh-label" for="pasajeros">Capacidad pasajeros</label>
                            <input id="pasajeros" name="pas" type="number" min="1" max="99"
                                step="1" value="{{ old('pas', $vehiculo->pas) }}" required />
                        </div>

                        {{-- Color --}}
                        <div class="veh-field veh-field_6">
                            <label class="veh-label" for="color">Color</label>
                            <input id="color" name="col" type="text"
                                value="{{ old('col', $vehiculo->col) }}" required />
                        </div>

                        {{-- Cilindraje --}}
                        <div class="veh-field veh-field_7">
                            <label class="veh-label" for="Cilindraje">Cilindraje</label>
                            <input id="Cilindraje" name="cil" type="number" min="50" max="10000"
                                step="1" value="{{ old('cil', $vehiculo->cil) }}" required />
                        </div>

                        <div class="veh-field">
                            <input type="hidden" name="codpol" value="{{ old('codpol', $vehiculo->codpol ?? 1) }}">
                        </div>

                        {{-- Combustible --}}
                        <div class="veh-field veh-field_8">
                            <label class="veh-label" for="combustible">Tipo de combustible</label>
                            <div class="veh-select">
                                <select id="combustible" name="codcom" required>
                                    <option value="" disabled hidden>Seleccione un tipo de combustible</option>
                                    @foreach ($vehiculoCombustible as $itemComb)
                                        <option value="{{ $itemComb->cod }}" @selected(old('codcom', $vehiculo->codcom) == $itemComb->cod)>
                                            {{ $itemComb->des }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Precio --}}
                        <div class="veh-field veh-field_9">
                            <label class="veh-label" for="prerent">Precio por día (24h)</label>
                            <input id="prerent" name="prerent" type="number" step="0.01" min="0"
                                value="{{ old('prerent', $vehiculo->prerent) }}" required />
                        </div>

                    </div>
                </div>

                <div class="veh-col">
                    <div class="veh-block">

                        {{-- Accesorios --}}
                        <div class="veh-block">
                            <h3>Por favor seleccione los accesorios del vehículo.</h3>

                            @php
                                $selectedAcc = collect(
                                    old('accesorios', $vehiculo->accesorios?->pluck('id')->all() ?? []),
                                )
                                    ->map(fn($v) => (int) $v)
                                    ->all();
                            @endphp

                            <div class="veh-accessories">
                                @foreach ($vehiculoAccesorios as $acc)
                                    <label class="veh-check">
                                        <input type="checkbox" name="accesorios[]" value="{{ $acc->id }}"
                                            @checked(in_array((int) $acc->id, $selectedAcc, true))>
                                        <span class="veh-dot"></span> {{ $acc->des }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Ubicación --}}
                        <div class="veh-block">
                            <h3>Por favor seleccione la ubicación donde se encuentra el vehículo.</h3>

                            <div class="veh-row2">
                                {{-- Departamento --}}
                                <div class="veh-field">
                                    <label class="veh-label" for="depto">Departamento</label>
                                    <div class="veh-select">
                                        <select id="depto" name="coddepveh" required
                                            data-selected="{{ old('coddepveh', $vehiculo->ciudad?->coddep ?? '') }}">
                                            <option value="" disabled hidden>Seleccione un departamento</option>
                                            @foreach ($deptoVehiculo as $vehDpto)
                                                <option value="{{ $vehDpto->cod }}" @selected(old('coddepveh', $vehiculo->ciudad?->coddep ?? '') == $vehDpto->cod)>
                                                    {{ $vehDpto->des }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Municipio --}}
                                <div class="veh-field">
                                    <label class="veh-label" for="municipio_bottom">Municipio</label>
                                    <div class="veh-select">
                                        <select id="municipio_bottom" name="codciu" required disabled
                                            data-selected="{{ old('codciu', $vehiculo->codciu) }}">
                                            <option value="" selected disabled>Cargando ciudades...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="veh-btn" type="submit">Guardar cambios</button>
                    </div>
                </div>
            </form>
        </section>
    </div>

    {{-- Script: Líneas según Marca (carga al entrar y en change) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const marcaSelect = document.getElementById('marca');
            const lineaSelect = document.getElementById('linea');

            if (!marcaSelect || !lineaSelect) return;

            const endpointTemplate = @json(route('marcas.lineas', ['cod' => '__COD__']));

            function resetLineas(texto) {
                lineaSelect.innerHTML = `<option value="" selected disabled>${texto}</option>`;
                lineaSelect.disabled = true;
            }

            async function loadLineas(codMarca, selectedLinea = null) {
                if (!codMarca) return resetLineas('Seleccione una marca primero');

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
                    lineaSelect.innerHTML = `<option value="" disabled>Seleccione una línea</option>`;

                    data.forEach(l => {
                        const opt = document.createElement('option');
                        opt.value = l.cod;
                        opt.textContent = l.des;

                        if (selectedLinea && String(l.cod) === String(selectedLinea)) {
                            opt.selected = true;
                        }

                        lineaSelect.appendChild(opt);
                    });

                    if (!lineaSelect.value) lineaSelect.selectedIndex = 0;

                } catch (e) {
                    console.error(e);
                    resetLineas('No se pudieron cargar las líneas');
                }
            }

            marcaSelect.addEventListener('change', () => {
                loadLineas(marcaSelect.value, null);
            });

            // ✅ Al entrar al edit
            const selectedLinea = lineaSelect.dataset.selected;
            if (marcaSelect.value) {
                loadLineas(marcaSelect.value, selectedLinea);
            } else {
                resetLineas('Seleccione una marca primero');
            }
        });
    </script>

    {{-- Script: Ciudades según Departamento (carga al entrar y en change) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const depto = document.getElementById('depto');
            const ciudad = document.getElementById('municipio_bottom');

            if (!depto || !ciudad) return;

            function resetCiudades(texto) {
                ciudad.disabled = true;
                ciudad.innerHTML = `<option value="" selected disabled>${texto}</option>`;
            }

            async function loadCiudades(coddepveh, selectedCiudad = null) {
                if (!coddepveh) return resetCiudades('Seleccione un departamento primero');

                resetCiudades('Cargando ciudades...');

                try {
                    const res = await fetch(
                        `/publi-vehiculo/departamentos/${encodeURIComponent(coddepveh)}/ciudades`, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                    if (!res.ok) throw new Error('HTTP ' + res.status);

                    const data = await res.json();

                    if (!Array.isArray(data) || data.length === 0) {
                        return resetCiudades('No hay ciudades para este departamento');
                    }

                    ciudad.disabled = false;
                    ciudad.innerHTML = `<option value="" disabled>Seleccione una ciudad</option>`;

                    data.forEach(c => {
                        const opt = document.createElement('option');
                        opt.value = c.cod;
                        opt.textContent = c.des;

                        if (selectedCiudad && String(c.cod) === String(selectedCiudad)) {
                            opt.selected = true;
                        }

                        ciudad.appendChild(opt);
                    });

                    if (!ciudad.value) ciudad.selectedIndex = 0;

                } catch (err) {
                    console.error(err);
                    resetCiudades('Error cargando ciudades');
                }
            }

            depto.addEventListener('change', () => {
                loadCiudades(depto.value, null);
            });

            // ✅ Al entrar al edit
            const selectedDepto = depto.dataset.selected;
            const selectedCiudad = ciudad.dataset.selected;

            // si por alguna razón no quedó seleccionado en el DOM, lo forzamos
            if (!depto.value && selectedDepto) depto.value = selectedDepto;

            if (depto.value) {
                loadCiudades(depto.value, selectedCiudad);
            } else {
                resetCiudades('Seleccione un departamento primero');
            }
        });
    </script>
</x-page>
