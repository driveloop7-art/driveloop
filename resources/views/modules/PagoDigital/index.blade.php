<x-page>
    <div class="max-w-7xl mx-auto px-2 py-2">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Métodos de pago</h1>
            <p class="text-gray-500 text-sm">Confirma los detalles de tu pago y prepárate para la carretera. Selecciona el método que
                mejor se adapte a ti.</p>
        </div>

        <style>
            /* Hack to override toggle component hardcoded styles without modifying the component file */
            #payment-toggles .bg-gray-50 {
                background-color: white !important;
                border: 1px solid #e5e7eb;
                transition: all 0.2s;
            }

            /* Target the active item wrapper using :has selector (supported in modern browsers) */
            #payment-toggles .bg-gray-50:has(.is-active-marker) {
                border-color: #ef4444 !important;
                /* dl color */
                box-shadow: 0 0 0 1px #ef4444 !important;
            }

            /* Hide the default '+' identifier from the component */
            #payment-toggles button>span.text-dl {
                display: none !important;
            }

            /* Make the title span take full width to allow internal flex justify-between to work */
            #payment-toggles button>span:first-child {
                width: 100%;
            }
        </style>




        <!--------------------------------------------- CUADRO CONTENEDOR DE INFORMACION------------------------------------------------- -->

        <div class="flex justify-center w-full">
            {{-- Left Column: Payment Methods --}}

            {{-- Right Column: Summary --}}
            <x-card class="text-center p-8 max-w-md">
                {{-- Dates --}}
                <div class="w-full flex justify-between border-b border-gray-100 pb-4 mb-6">
                    <div class="text-left border-r border-gray-100 pr-4 w-1/2">
                        <span class="block text-[10px] text-gray-400 uppercase tracking-wide">Fecha y hora de
                            recogida</span>
                        <div class="flex items-center text-xs text-gray-600 font-medium mt-1">
                            <span>24/12/2025</span>
                            <span class="mx-2 text-gray-300">|</span>
                            <span>6:00 pm</span>
                        </div>
                    </div>
                    <div class="text-left pl-4 w-1/2">
                        <span class="block text-[10px] text-gray-400 uppercase tracking-wide">Fecha y hora de
                            entrega</span>
                        <div class="flex items-center text-xs text-gray-600 font-medium mt-1">
                            <span>27/12/2025</span>
                            <span class="mx-2 text-gray-300">|</span>
                            <span>6:00 pm</span>
                        </div>
                    </div>
                </div>

                {{-- Car Image (Placeholder) --}}
                <div class="mb-6 relative w-full h-40 flex items-center justify-center">
                    <img src="https://placehold.co/600x400/red/white?text=Toyota+RAV4" alt="Toyota RAV4"
                        class="max-h-full object-contain">
                </div>

                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Toyota</h2>
                <p class="text-gray-500 font-light text-lg mb-2">RAV4 Híbrida 2022</p>

                <p class="text-[10px] text-gray-400 mb-6">Incluye impuestos, seguro y asistencia en carretera.</p>

                {{-- Specs --}}
                <div class="flex items-center gap-4 text-xs text-gray-500 mb-6 justify-center">
                    <span class="flex items-center gap-1"><span class="text-dl">📍</span> Cali</span>
                    <span class="border-l border-gray-300 h-3"></span>
                    <span class="flex items-center gap-1">👤 5 Personas</span>
                    <span class="border-l border-gray-300 h-3"></span>
                    <span class="flex items-center gap-1">⭐ 4.8 / 5 (41 reseñas)</span>
                </div>

                <div class="text-2xl font-bold text-gray-900 mb-8">
                    $150.000 COP/día
                </div>

                <div class="w-full">
                    <x-button type="tertiary"
                        class="w-full !border-dl !text-dl hover:!bg-dl hover:!text-white uppercase font-bold py-3">
                        CONTINUAR
                    </x-button>
                </div>

            </x-card>
        </div>
    </div>
</x-page>