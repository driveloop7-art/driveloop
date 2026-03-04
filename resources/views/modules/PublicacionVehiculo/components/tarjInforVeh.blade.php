<div class="flex gap-2 items-center" x-data="vehiculoModal()">
    {{-- VER --}}
    @php
        // Foto principal + miniaturas usando tu MISMA lógica
        $fotos = $vehiculo->fotos_vehiculos ?? collect();

        $makeUrl = function ($ruta) {
            if (!$ruta) {
                return asset('img/no-image.jpg');
            }
            if (str_starts_with($ruta, 'http')) {
                return $ruta;
            }

            $ruta = ltrim($ruta, '/');
            if (!str_starts_with($ruta, 'vehiculos/')) {
                $ruta = 'vehiculos/' . $ruta;
            }

            return \Illuminate\Support\Facades\Storage::disk('public')->url($ruta);
        };

        $fotoPrincipal = $makeUrl($fotos->first()?->ruta);

        $miniaturas = $fotos->take(3)->map(fn($f) => $makeUrl($f->ruta))->values();

        $precio = number_format((float) ($vehiculo->prerent ?? 0), 0, ',', '.');
    @endphp

    <button type="button"
        @click="openModal(@js($fotoPrincipal), @js($miniaturas), @js([
    'id' => $vehiculo->cod,
    'marca' => $vehiculo->marca?->des ?? '---',
    'linea' => $vehiculo->linea?->des ?? '---',
    'modelo' => $vehiculo->mod ?? '---',
    'clase' => $vehiculo->clase?->des ?? '---',
    'color' => $vehiculo->col ?? '---',
    'precio' => $precio,
]))"
        class="px-3 py-1 text-xs bg-gray-800 text-white rounded hover:bg-gray-900 transition">
        Ver
    </button>

    {{-- EDITAR --}}
    <a href="{{ route('vehiculos.edit', $vehiculo->cod) }}"
        class="px-3 py-1 text-xs bg-red-700 text-white rounded hover:bg-red-800 transition">
        Editar
    </a>

    {{-- MODAL (UNO SOLO, controlado por Alpine) --}}
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        {{-- overlay --}}
        <div class="absolute inset-0 bg-black/60" @click="close()"></div>

        {{-- caja --}}
        <div class="relative bg-white w-[95%] max-w-5xl rounded-2xl shadow-xl overflow-hidden">
            {{-- header --}}
            <div class="flex items-center justify-between px-5 py-4 border-b">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">
                        <span x-text="data.marca"></span>
                        {{-- <span x-text="data.linea"></span>
                        <span class="text-gray-500 font-medium" x-text="'· ' + data.modelo"></span> --}}
                    </h3>
                    
                </div>

                <button type="button" @click="close()" class="px-3 py-1 text-sm rounded bg-gray-100 hover:bg-gray-200">
                    Cerrar
                </button>
            </div>

            {{-- body --}}
            <div class="p-5 grid grid-cols-1 lg:grid-cols-2 gap-6 max-h-[75vh] overflow-auto">

                {{-- IMAGENES --}}
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

                        {{-- Si no hay miniaturas, relleno visual --}}
                        <template x-if="thumbs.length === 0">
                            <div class="text-sm text-gray-400 mt-2">Sin más fotos.</div>
                        </template>
                    </div>
                </div>

                {{-- INFO RELEVANTE --}}
                <div class="space-y-4">
                    <div class="border rounded-xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Información del
                            vehículo</h4>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <p><span class="font-bold text-gray-900">Marca:</span> <span x-text="data.marca"></span></p>
                            <p><span class="font-bold text-gray-900">Línea:</span> <span x-text="data.linea"></span></p>
                            <p><span class="font-bold text-gray-900">Modelo:</span> <span x-text="data.modelo"></span>
                            </p>
                            <p><span class="font-bold text-gray-900">Clase:</span> <span x-text="data.clase"></span></p>
                            <p><span class="font-bold text-gray-900">Color:</span> <span x-text="data.color"></span></p>
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
                            {{-- <a href="#"
                                class="px-4 py-2 text-sm font-bold bg-[#C91843] text-white rounded-xl hover:bg-[#B0174B] transition">
                                RENTAR
                            </a> --}}

                            <button type="button" @click="close()"
                                class="px-4 py-2 text-sm font-bold bg-gray-200 rounded-xl hover:bg-gray-300 transition">
                                Cerrar
                            </button>
                        </div>
                    </div>

                    {{-- Si quieres, aquí agregas observaciones / cobertura, pero ya con datos reales si existen --}}
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
                clase: '',
                color: '',
                precio: '0',
            },
            openModal(main, thumbs, data) {
                this.mainPhoto = main || '';
                this.thumbs = Array.isArray(thumbs) ? thumbs : [];
                this.data = data || this.data;
                this.open = true;
            },
            close() {
                this.open = false;
            }
        }
    }
</script>
