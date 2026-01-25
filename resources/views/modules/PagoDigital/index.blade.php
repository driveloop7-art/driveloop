<x-page>
    <div class="max-w-7xl mx-20 px-2 py-2">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Métodos de pago</h1>
            <p class="text-gray-500 text-sm">Complete toda la información para completar el proceso de renta del
                vehículo.</p>
        </div>

        {{-- Display validation errors --}}
        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Se encontraron los siguientes errores:
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

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

        <form action="{{ route('pago.digital.process') }}" method="POST"
            x-data="paymentForm"
            @submit.prevent="validateForm()">
            @csrf

            <input type="hidden" name="metodo_pago" :value="metodo_pago">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                {{-- Left Column: Payment Methods --}}
                <div id="payment-toggles" class="space-y-4">
                    <x-toggle>

                        {{-- Credit/Debit Card --}}
                        <x-toggle>
                            <x-slot:title>
                                <div @click="metodo_pago = (active === $id('item') ? null : 'card')" class="w-full">
                                    {{-- Marker to detect active state in parent via CSS :has --}}
                                    <div class="is-active-marker hidden" x-show="active === $id('item')"></div>

                                    <div class="flex items-center justify-between w-full">
                                        <div class="flex items-center gap-4">
                                            <div class="flex gap-1">
                                                <div
                                                    class="h-8 w-10 bg-white border border-gray-200 rounded flex items-center justify-center px-0.5">
                                                    <img src="{{ asset('images/logo_mastercard.svg') }}"
                                                        alt="Mastercard">
                                                </div>
                                                <div
                                                    class="h-8 w-10 bg-white border border-gray-200 rounded flex items-center justify-center px-0.5">
                                                    <img src="{{ asset('images/logo_visa.svg') }}" alt="Visa">
                                                </div>
                                            </div>
                                            <div class="text-left">
                                                <span class="block font-bold text-gray-800 text-sm">Tarjetas de crédito o
                                                    débito</span>
                                                <span class="block text-xs text-gray-500 leading-tight">Paga con tarjeta
                                                    de
                                                    crédito Visa o Mastercard.</span>
                                            </div>
                                        </div>
                                        {{-- Custom Radio Button --}}
                                        <div class="w-5 h-5 rounded-full border border-gray-300 flex items-center justify-center transition-colors"
                                            :class="active === $id('item') ? 'border-dl bg-dl' : 'bg-white'">
                                            <div class="w-2 h-2 bg-white rounded-full opacity-0 transition-opacity"
                                                :class="active === $id('item') ? 'opacity-100' : ''"></div>
                                        </div>
                                    </div>
                                </div>
                            </x-slot:title>

                            {{-- Form Content --}}
                            @include('modules.PagoDigital.partials.form-card')
                        </x-toggle>

                        {{-- Transferencia Bancaria --}}
                        <x-toggle>
                            <x-slot:title>
                                <div @click="metodo_pago = (active === $id('item') ? null : 'pse')" class="w-full">
                                    <div class="is-active-marker hidden" x-show="active === $id('item')"></div>
                                    <div class="flex items-center justify-between w-full">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="h-8 w-8 bg-blue-900 rounded-full flex items-center justify-center overflow-hidden">
                                                <img src="{{ asset('images/logo_pse.png') }}" alt="PSE"
                                                    class="w-full h-full object-cover transform scale-150">
                                            </div>
                                            <div class="text-left">
                                                <span class="block font-bold text-gray-800 text-sm">Transferencia
                                                    Bancaria</span>
                                                <span class="block text-xs text-gray-500 leading-tight">Paga mediante
                                                    transferencias bancarias locales.</span>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border border-gray-300 flex items-center justify-center transition-colors"
                                            :class="active === $id('item') ? 'border-dl bg-dl' : 'bg-white'">
                                            <div class="w-2 h-2 bg-white rounded-full opacity-0 transition-opacity"
                                                :class="active === $id('item') ? 'opacity-100' : ''"></div>
                                        </div>
                                    </div>
                                </div>
                            </x-slot:title>

                            @include('modules.PagoDigital.partials.form-pse')
                        </x-toggle>

                        {{-- Nequi --}}
                        <x-toggle>
                            <x-slot:title>
                                <div @click="metodo_pago = (active === $id('item') ? null : 'nequi')" class="w-full">
                                    <div class="is-active-marker hidden" x-show="active === $id('item')"></div>
                                    <div class="flex items-center justify-between w-full">
                                        <div class="flex items-center gap-4">
                                            <div class="h-8 w-12 flex items-center justify-start">
                                                <img src="{{ asset('images/nequi_logo.svg') }}" alt="Nequi">
                                            </div>
                                            <div class="text-left">
                                                <span class="block font-bold text-gray-800 text-sm">Nequi</span>
                                                <span class="block text-xs text-gray-500 leading-tight">Pagar con fondos
                                                    del
                                                    monedero Nequi.</span>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border border-gray-300 flex items-center justify-center transition-colors"
                                            :class="active === $id('item') ? 'border-dl bg-dl' : 'bg-white'">
                                            <div class="w-2 h-2 bg-white rounded-full opacity-0 transition-opacity"
                                                :class="active === $id('item') ? 'opacity-100' : ''"></div>
                                        </div>
                                    </div>
                                </div>
                            </x-slot:title>

                            @include('modules.PagoDigital.partials.form-nequi')
                        </x-toggle>

                    </x-toggle>
                </div>


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
        </form>

    </div>

    @include('modules.PagoDigital.partials.payment-script')
</x-page>