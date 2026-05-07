<x-modal class="xl:max-w-5xl" name="reserva-directa-car" title="Reservar vehículo" focusable>
    <div x-data="directReservaModal()" class="w-full px-2 py-2">
        <form action="{{ route('checkout.reserva') }}" method="POST" id="direct-booking-form">
            @csrf

            <input type="hidden" name="codveh" x-model="codveh">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- GALERÍA --}}
                <div>
                    <div class="bg-gray-100 rounded-xl overflow-hidden h-72">
                        <img :src="mainPhoto || '{{ asset('img/no-image.jpg') }}'"
                            alt="Vehículo seleccionado"
                            class="h-full w-full object-cover block">
                    </div>

                    <div class="grid grid-cols-3 gap-3 mt-3">
                        <template x-for="(src, i) in thumbs" :key="i">
                            <button type="button"
                                class="bg-gray-100 rounded-xl overflow-hidden h-20 ring-2 ring-transparent hover:ring-gray-300 transition"
                                @click="mainPhoto = src">
                                <img :src="src" alt="Miniatura" class="h-full w-full object-cover block">
                            </button>
                        </template>

                        <template x-if="thumbs.length === 0">
                            <div class="col-span-3 text-sm text-gray-400 mt-2">
                                Sin más fotos.
                            </div>
                        </template>
                    </div>
                </div>

                {{-- INFORMACIÓN + FECHAS --}}
                <div class="space-y-4">
                    <div class="border rounded-xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-3">Información del vehículo</h4>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <p>
                                <span class="font-bold text-gray-900">Marca:</span>
                                <span x-text="marca"></span>
                            </p>

                            <p>
                                <span class="font-bold text-gray-900">Modelo:</span>
                                <span x-text="modelo"></span>
                            </p>

                            <p>
                                <span class="font-bold text-gray-900">Línea:</span>
                                <span x-text="linea"></span>
                            </p>

                            <p>
                                <span class="font-bold text-gray-900">Color:</span>
                                <span x-text="color"></span>
                            </p>

                            <p>
                                <span class="font-bold text-gray-900">Combustible:</span>
                                <span x-text="combustible"></span>
                            </p>

                            <p>
                                <span class="font-bold text-gray-900">Asientos:</span>
                                <span x-text="pasajeros"></span>
                            </p>
                        </div>
                    </div>

                    <div class="border rounded-xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Tarifa</h4>

                        <div class="text-2xl font-extrabold text-gray-900">
                            $<span x-text="precio"></span> COP / DÍA
                        </div>

                        <p class="text-sm text-gray-600 mt-1">
                            Incluye impuestos, seguro y asistencia en carretera.
                        </p>
                    </div>

                    <div class="border rounded-xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-4">Selecciona tus fechas</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Fecha de recogida
                                </label>
                                <input type="date"
                                    name="pickup_date"
                                    x-model="pickup_date"
                                    required
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-rose-500 focus:ring-rose-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Fecha de entrega
                                </label>
                                <input type="date"
                                    name="return_date"
                                    x-model="return_date"
                                    required
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-rose-500 focus:ring-rose-500">
                            </div>
                        </div>


                        <div class="mt-6 flex flex-col sm:flex-row gap-3 sm:justify-end">
                            <button type="button"
                                x-on:click="$dispatch('close')"
                                class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50">
                                Cerrar
                            </button>

                            <button type="submit"
                                class="rounded-xl bg-[#C91843] px-5 py-3 text-sm font-bold text-white hover:bg-[#B0174B]">
                                RENTAR VEHÍCULO
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function directReservaModal() {
            return {
                codveh: '',
                marca: '',
                linea: '',
                modelo: '',
                color: '',
                combustible: '',
                pasajeros: '',
                precio: '',
                precio_raw: '',
                pickup_date: '',
                return_date: '',
                mainPhoto: '',
                thumbs: [],

                init() {
                    window.addEventListener('seleccionar-vehiculo-directo', (event) => {
                        const detail = event.detail || {};

                        this.codveh = detail.codveh ?? '';
                        this.marca = detail.marca ?? '';
                        this.linea = detail.linea ?? '';
                        this.modelo = detail.modelo ?? '';
                        this.color = detail.color ?? '';
                        this.combustible = detail.combustible ?? '';
                        this.pasajeros = detail.pasajeros ?? '';
                        this.precio = detail.precio ?? '';
                        this.precio_raw = detail.precio_raw ?? '';
                        this.mainPhoto = detail.foto ?? '';
                        this.thumbs = Array.isArray(detail.thumbs) ? detail.thumbs : [];
                        this.pickup_date = '';
                        this.return_date = '';
                    });
                }
            }
        }
    </script>
</x-modal>