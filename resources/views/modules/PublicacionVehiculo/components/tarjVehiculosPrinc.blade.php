<section class="relative py-20 min-h-screen bg-center bg-no-repeat "
    style="background-image: url('{{ asset('img/fondo-carrusel.jpg.jpeg') }}'); background-size: cover;">

    <div class="absolute inset-0 bg-black/70"></div>

    <div class="relative max-w-7xl mx-auto px-6">

        <div class="mt-20 md:mt-32 mb-10 text-center md:text-left">
            <h2 class="text-white text-5xl font-bold">Autos destacados</h2>
            <p class="text-gray-300 mt-2 text-lg">
                Alquila fácil, rápido y seguro, elige el que más te guste.
            </p>
        </div>

        <div class="swiper mySwiper mt-20 md:mt-32 mb-10">
            <div class="swiper-wrapper">

                @foreach ($vehiculos as $vehiculo)
                    @php
                        $fotos = $vehiculo->fotos_vehiculos ?? collect();
                        $fotoPrincipal = $fotos->first();
                        $fotoUrl = $fotoPrincipal ? $fotoPrincipal->url : asset('img/no-image.jpg');
                        $miniaturas = $fotos->take(3)->map(fn($f) => $f->url)->values()->toArray();
                        $precio = number_format((float) ($vehiculo->prerent ?? 0), 0, ',', '.');
                    @endphp

                    <div class="swiper-slide">
                        <article class="overflow-hidden rounded-2xl bg-white shadow-sm w-full max-w-xs mx-auto">

                            <div class="h-44 w-full bg-gray-100">
                                <img src="{{ $fotoUrl }}"
                                    alt="Foto vehículo"
                                    class="h-full w-full object-cover block"
                                    loading="lazy">
                            </div>

                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-y-2 text-sm">

                                    <div class="flex items-baseline gap-1">
                                        <span class="font-bold">Marca:</span>
                                        <span class=" uppercase">
                                            {{ $vehiculo->marca?->des ?? '---' }}
                                        </span>
                                    </div>

                                    <div class="flex items-baseline justify-end gap-1 text-right">
                                        <span class="font-bold ">Modelo:</span>
                                        <span>
                                            {{ $vehiculo->mod ?? '---' }}
                                        </span>
                                    </div>

                                    <div class="flex items-baseline gap-1">
                                        <span class="font-bold ">Línea:</span>
                                        <span>
                                            {{ $vehiculo->linea?->des ?? '---' }}
                                        </span>
                                    </div>

                                    <div class="felx items-baseline justify-end gap-1 text-right">
                                        <span class="font-bold">Color:</span>
                                        <span>
                                            {{ $vehiculo->col ?? '---' }}
                                        </span>
                                    </div>

                                </div>
                            </div>

                            <div class="grid grid-cols-2">
                                <div class="rounded-bl-2xl bg-slate-900 px-4 py-3 text-center text-sm font-extrabold text-white">
                                    ${{ $precio }} / DÍA
                                </div>

                                @auth
                                    <button type="button"
                                        class="btn-open-reserva rounded-br-2xl bg-[#C91843] px-4 py-3 text-center text-sm font-extrabold text-white hover:bg-[#B0174B]"
                                        data-codveh="{{ $vehiculo->cod }}"
                                        data-marca="{{ $vehiculo->marca?->des }}"
                                        data-linea="{{ $vehiculo->linea?->des }}"
                                        data-modelo="{{ $vehiculo->mod }}"
                                        data-color="{{ $vehiculo->col }}"
                                        data-combustible="{{ $vehiculo->combustible?->des }}"
                                        data-pasajeros="{{ $vehiculo->pas }}"
                                        data-precio="{{ $precio }}"
                                        data-precio_raw="{{ (float) ($vehiculo->prerent ?? 0) }}"
                                        data-foto="{{ $fotoUrl }}"
                                        data-thumbs='@json($miniaturas)'>
                                        RENTAR
                                    </button>
                                @else
                                    <a href="{{ route('vehiculo.rentar.directo', $vehiculo->cod) }}"
                                        class="rounded-br-2xl bg-[#C91843] px-4 py-3 text-center text-sm font-extrabold text-white hover:bg-[#B0174B]">
                                        RENTAR
                                    </a>
                                @endauth
                            </div>

                        </article>
                    </div>
                @endforeach

            </div>

         <!--   <div class="swiper-button-next custom-arrow"></div>
            <div class="swiper-button-prev custom-arrow"></div>    -->
            <div class="swiper-pagination mt-10"></div>
        </div>

    </div>
</section>

@auth
    @include('modules.BusquedaReserva.partials.modals.reserva-directa-car')
@endauth

<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (typeof Swiper !== 'undefined') {
           new Swiper(".mySwiper", {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                grabCursor: true,

                autoplay: {
                    delay: 1000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },

                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },

                    navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },

                mousewheel: {
                    forceToAxis: true,
                },

                breakpoints: {
                    640: {
                        slidesPerView: 1,
                    },

                    768: {
                        slidesPerView: 2,
                    },

                    1024: {
                        slidesPerView: 3,
                    },

                    1280: {
                        slidesPerView: 4,
                    },
                },
            });
        }

        function abrirModalReservaDesdeBoton(btn) {
            if (!btn) return;

            const data = {
                codveh: btn.dataset.codveh,
                marca: btn.dataset.marca,
                linea: btn.dataset.linea,
                modelo: btn.dataset.modelo,
                color: btn.dataset.color,
                combustible: btn.dataset.combustible,
                pasajeros: btn.dataset.pasajeros,
                precio: btn.dataset.precio,
                precio_raw: btn.dataset.precio_raw,
                foto: btn.dataset.foto,
                thumbs: JSON.parse(btn.dataset.thumbs || '[]')
            };

            window.dispatchEvent(new CustomEvent('seleccionar-vehiculo-directo', {
                detail: data
            }));

            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'reserva-directa-car'
            }));
        }

        document.querySelectorAll('.btn-open-reserva').forEach(btn => {
            btn.addEventListener('click', function () {
                abrirModalReservaDesdeBoton(this);
            });
        });

        @if(session('abrir_reserva_directa'))
            setTimeout(function () {
                const btnAuto = document.querySelector(
                    '.btn-open-reserva[data-codveh="{{ session('abrir_reserva_directa') }}"]'
                );

                abrirModalReservaDesdeBoton(btnAuto);
            }, 800);
        @endif
    });
</script>