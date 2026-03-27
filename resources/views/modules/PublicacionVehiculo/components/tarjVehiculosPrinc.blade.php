<section class="relative py-20 bg-center bg-no-repeat"
    style="
        background-image: url('{{ asset('img/fondo-carrusel.jpg.jpeg') }}');
        background-size: 100%;">

    
    <div class="absolute inset-0 bg-black/70"></div>

    <!-- Contenido encima del overlay -->
    <div class="relative max-w-7xl mx-auto px-6">

        <!-- Título como la imagen -->
        <div class="mb-10">
            <h2 class="text-white text-4xl font-bold">Autos destacados</h2>
            <p class="text-gray-300 mt-2 text-sm">
                Alquila fácil, rápido y seguro, elige el que más te guste.
            </p>
        </div>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">

                @foreach ($vehiculos as $vehiculo)
                    @php
                        $ruta = $vehiculo->fotos_vehiculos->first()?->ruta;

                        if (!$ruta) {
                            $fotoUrl = asset('img/no-image.jpg');
                        } elseif (str_starts_with($ruta, 'http')) {
                            $fotoUrl = $ruta;
                        } else {
                            $ruta = ltrim($ruta, '/');
                            if (!str_starts_with($ruta, 'vehiculos/')) {
                                $ruta = 'vehiculos/' . $ruta;
                            }
                            $fotoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($ruta);
                        }

                        $precio = number_format((float) ($vehiculo->prerent ?? 0), 0, ',', '.');
                    @endphp

                    <div class="swiper-slide">
                        <article class="overflow-hidden rounded-2xl bg-white shadow-sm w-full max-w-xs mx-auto">

                            <!-- Imagen (sin “borde raro”) -->
                            <div class="h-44 w-full bg-gray-100">
                                <img src="{{ $fotoUrl }}" alt="Foto vehículo"
                                    class="h-full w-full object-cover block" loading="lazy" />
                            </div>

                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-x-10 gap-y-2 text-sm">
                                    <div class="flex items-baseline gap-2">
                                        <span class="font-bold text-gray-900">Marca:</span>
                                        <span class="text-gray-700 uppercase">{{ $vehiculo->marca?->des ?? '---' }}</span>
                                    </div>

                                    <div class="flex items-baseline justify-end gap-2 text-right">
                                        <span class="font-bold text-gray-900">Modelo:</span>
                                        <span class="text-gray-700">{{ $vehiculo->mod ?? '---' }}</span>
                                    </div>

                                    <div class="flex items-baseline gap-2">
                                        <span class="font-bold text-gray-900">Línea:</span>
                                        <span class="text-gray-700">{{ $vehiculo->linea?->des ?? '---' }}</span>
                                    </div>

                                    <div class="flex items-baseline justify-end gap-2 text-right">
                                        <span class="font-bold text-gray-900">Color:</span>
                                        <span class="text-gray-700">{{ $vehiculo->col ?? '---' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2">
                                <div class="rounded-bl-2xl bg-slate-900 px-4 py-3 text-center text-sm font-extrabold text-white">
                                    ${{ $precio }} / DÍA
                                </div>

                                <a href="#"
                                    class="rounded-br-2xl bg-[#C91843] px-4 py-3 text-center text-sm font-extrabold text-white transition hover:bg-[#B0174B]">
                                    RENTAR
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach

            </div>

            <div class="swiper-button-next custom-arrow"></div>
            <div class="swiper-button-prev custom-arrow"></div>
            <div class="swiper-pagination mt-10"></div>
        </div>

    </div>
</section>

<script>
    const swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,

        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

        breakpoints: {
            640: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            },
            1280: {
                slidesPerView: 4
            },
        },
    });
</script>
