{{-- <x-page>
    <div class="mx-auto w-full max-w-6xl px-4 py-6">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @forelse ($vehiculos as $itemVeh)
                @php
                    $foto = $itemVeh->fotos->first();
                    $img = $foto ? asset('storage/' . $foto->ruta) : asset('AUTO.jpg');

                    $marca = $itemVeh->marca->des ?? '---';
                    $linea = $itemVeh->linea->des ?? '---';
                    $modelo = $itemVeh->mod ?? '---';
                    $color = $itemVeh->col ?? '---';
                @endphp

                <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <img src="{{ $img }}" alt="Foto vehículo" class="h-44 w-full object-cover" loading="lazy" />

                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm">
                            <div class="flex items-baseline gap-2">
                                <span class="font-bold text-gray-900">Marca:</span>
                                <span class="text-gray-700">{{ $marca }}</span>
                            </div>

                            <div class="flex items-baseline justify-end gap-2 text-right">
                                <span class="font-bold text-gray-900">Modelo:</span>
                                <span class="text-gray-700">{{ $modelo }}</span>
                            </div>

                            <div class="flex items-baseline gap-2">
                                <span class="font-bold text-gray-900">Línea:</span>
                                <span class="text-gray-700">{{ $linea }}</span>
                            </div>

                            <div class="flex items-baseline justify-end gap-2 text-right">
                                <span class="font-bold text-gray-900">Color:</span>
                                <span class="text-gray-700">{{ $color }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2">
                        <div
                            class="rounded-bl-2xl bg-slate-900 px-4 py-3 text-center text-sm font-extrabold text-white">
                            ${{ number_format((int) ($itemVeh->prerent ?? 0), 0, ',', '.') }} / DÍA
                        </div>

                        <a href="#"
                            class="rounded-br-2xl bg-rose-600 px-4 py-3 text-center text-sm font-extrabold text-white transition hover:bg-rose-700">
                            RENTAR
                        </a>
                    </div>
                </article>

            @empty
                <div
                    class="col-span-full rounded-xl border border-dashed border-gray-300 bg-white p-6 text-center text-gray-600">
                    No hay vehículos para los filtros seleccionados.
                </div>
            @endforelse

        </div>
    </div>
</x-page> --}}

<x-page>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div x-data="vehiculoModal()" class="mx-auto w-full max-w-6xl px-4 py-6">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @forelse ($vehiculos as $itemVeh)
                @php
                    $fotos = $itemVeh->fotos ?? collect();

                    $foto = $fotos->first();

                    // se optimiza el ternario con el fin de realizar una presentancion mas limpia
                    //  y mostrar un fallback mas elegante en caso de no encontrar la ruta

                    $img = $foto ? $foto->url : asset('img/no-image.jpg');
                    $miniaturas = $fotos->take(3)->map(fn($f) => $f->url)->values()->toArray();

                    $payload = [
                        'mainPhoto' => $img,
                        'thumbs' => $miniaturas,
                        'data' => [
                            'id' => $itemVeh->cod ?? '',
                            'marca' => $itemVeh->marca->des ?? '---',
                            'linea' => $itemVeh->linea->des ?? '---',
                            'modelo' => $itemVeh->mod ?? '---',
                            'color' => $itemVeh->col ?? '---',
                            'combustible' => $itemVeh->combustible->des ?? '---',
                            'asientos' => $itemVeh->pas ?? '---',
                            'precio' => number_format((float) ($itemVeh->prerent ?? 0), 0, ',', '.'),
                        ],
                    ];
                @endphp

                <article x-data='@json(['payload' => $payload])'
                    class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <img src="{{ $img }}" alt="Foto vehículo" class="h-44 w-full object-cover" loading="lazy" />

                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm">
                            <div class="flex items-baseline gap-2">
                                <span class="font-bold text-gray-900">Marca:</span>
                                <span class="text-gray-700">{{ $payload['data']['marca'] }}</span>
                            </div>

                            <div class="flex items-baseline justify-end gap-2 text-right">
                                <span class="font-bold text-gray-900">Modelo:</span>
                                <span class="text-gray-700">{{ $payload['data']['modelo'] }}</span>
                            </div>

                            <div class="flex items-baseline gap-2">
                                <span class="font-bold text-gray-900">Línea:</span>
                                <span class="text-gray-700">{{ $payload['data']['linea'] }}</span>
                            </div>

                            <div class="flex items-baseline justify-end gap-2 text-right">
                                <span class="font-bold text-gray-900">Color:</span>
                                <span class="text-gray-700">{{ $payload['data']['color'] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2">
                        <div
                            class="rounded-bl-2xl bg-slate-900 px-4 py-3 text-center text-sm font-extrabold text-white">
                            ${{ $payload['data']['precio'] }} / DÍA
                        </div>

                        <button type="button" @click="openModal(payload)"
                            class="rounded-br-2xl bg-rose-600 px-4 py-3 text-center text-sm font-extrabold text-white transition hover:bg-rose-700">
                            VER DETALLE
                        </button>
                    </div>
                </article>
            @empty
                <div
                    class="col-span-full rounded-xl border border-dashed border-gray-300 bg-white p-6 text-center text-gray-600">
                    No hay vehículos para los filtros seleccionados.
                </div>
            @endforelse

        </div>

        {{-- MODAL --}}
        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60" @click="close()"></div>

            <div @click.stop class="relative bg-white w-full max-w-5xl rounded-2xl shadow-xl overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b">
                    <h3 class="text-lg font-bold text-gray-900">
                        <span x-text="data.marca"></span>
                    </h3>

                    <button type="button" @click="close()"
                        class="px-3 py-1 text-sm rounded bg-gray-100 hover:bg-gray-200">
                        Cerrar
                    </button>
                </div>

                <div class="p-5 grid grid-cols-1 lg:grid-cols-2 gap-6 max-h-[75vh] overflow-auto">
                    {{-- IMÁGENES --}}
                    <div>
                        <div class="bg-gray-100 rounded-xl overflow-hidden h-64">
                            <img :src="mainPhoto" alt="Foto vehículo" class="h-full w-full object-cover block"
                                loading="lazy">
                        </div>

                        <div class="grid grid-cols-3 gap-3 mt-3">
                            <template x-for="(src, i) in thumbs" :key="i">
                                <button type="button"
                                    class="bg-gray-100 rounded-xl overflow-hidden h-20 ring-2 ring-transparent hover:ring-gray-300 transition"
                                    @click="mainPhoto = src">
                                    <img :src="src" alt="Miniatura" class="h-full w-full object-cover block"
                                        loading="lazy">
                                </button>
                            </template>

                            <template x-if="thumbs.length === 0">
                                <div class="col-span-3 text-sm text-gray-400 mt-2">
                                    Sin más fotos.
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- INFORMACIÓN --}}
                    <div class="space-y-4">
                        <div class="border rounded-xl p-4">
                            <h4 class="font-semibold text-gray-900 mb-2">Información del vehículo</h4>

                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <p>
                                    <span class="font-bold text-gray-900">Marca:</span>
                                    <span x-text="data.marca"></span>
                                </p>

                                <p>
                                    <span class="font-bold text-gray-900">Modelo:</span>
                                    <span x-text="data.modelo"></span>
                                </p>

                                <p>
                                    <span class="font-bold text-gray-900">Línea:</span>
                                    <span x-text="data.linea"></span>
                                </p>

                                <p>
                                    <span class="font-bold text-gray-900">Color:</span>
                                    <span x-text="data.color"></span>
                                </p>

                                <p>
                                    <span class="font-bold text-gray-900">Combustible:</span>
                                    <span x-text="data.combustible"></span>
                                </p>

                                <p>
                                    <span class="font-bold text-gray-900">Asientos:</span>
                                    <span x-text="data.asientos"></span>
                                </p>
                            </div>
                        </div>

                        <div class="border rounded-xl p-4">
                            <h4 class="font-semibold text-gray-900 mb-2">Tarifa</h4>

                            <div class="text-2xl font-extrabold text-gray-900">
                                $<span x-text="data.precio"></span> COP / DÍA
                            </div>

                            <p class="text-sm text-gray-600 mt-1">
                                Incluye impuestos, seguro y asistencia en carretera.
                            </p>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('pago.digital') }}"
                                    class="px-4 py-2 text-sm font-bold bg-rose-600 text-white rounded-xl hover:bg-rose-700 transition">
                                    RENTAR VEHÍCULO
                                </a>

                                <button type="button" @click="close()"
                                    class="px-4 py-2 text-sm font-bold bg-gray-200 rounded-xl hover:bg-gray-300 transition">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function vehiculoModal() {
                return {
                    open: false,
                    mainPhoto: '',
                    thumbs: [],
                    data: {
                        id: '',
                        marca: '',
                        linea: '',
                        modelo: '',
                        color: '',
                        combustible: '',
                        asientos: '',
                        precio: '0',
                    },

                    openModal(payload) {
                        this.mainPhoto = payload?.mainPhoto || '';
                        this.thumbs = Array.isArray(payload?.thumbs) ? payload.thumbs : [];
                        this.data = payload?.data || {
                            id: '',
                            marca: '',
                            linea: '',
                            modelo: '',
                            color: '',
                            combustible: '',
                            asientos: '',
                            precio: '0',
                        };
                        this.open = true;
                    },

                    close() {
                        this.open = false;
                    }
                }
            }
        </script>
    </div>
</x-page>
