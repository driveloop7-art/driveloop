<x-page>

    @php
        $dias_reserva = $reserva->fecini->diffInDays($reserva->fecfin);
        if ($dias_reserva < 1) {
            $dias_reserva = 1;
        }

        $precio_unitario = $monto / $dias_reserva;
    @endphp

    <div class="relative min-h-screen py-12 bg-white">
        <div>
            <div class="relative z-10 max-w-6xl mx-auto px-6">

                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900" style="font-family: 'Segoe UI', sans-serif;">
                        Checkout
                    </h1>
                    <p class="text-gray-500 mt-2 text-sm">
                        Revisa los detalles de tu reserva y procede al pago seguro.
                    </p>
                </div>

                <div class="grid lg:grid-cols-[1fr_360px] gap-8 items-start">

                    {{-- ===== IZQUIERDA: PAGO SEGURO ===== --}}
                    <x-card class="bg-gradient-to-br from-gray-50 to-white p-6 md:p-8 space-y-6 text-left border-0">
                        
                        {{-- Cabecera de Plataforma --}}
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center flex-shrink-0 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 leading-snug">Pasarela de Pago</h3>
                            </div>
                        </div>

                        <hr class="border-gray-100" />

                        {{-- Métodos de Pago Interactivos (Tabs) --}}
                        <div class="space-y-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider text-center md:text-left">
                                Selecciona tu método de pago:
                            </span>
                            <div class="grid grid-cols-2 gap-4" id="payment-toggles">
                                {{-- Tarjetas --}}
                                <button type="button" data-method="card" data-provider="simulated" class="payment-method-btn flex flex-col items-center justify-center p-3 rounded-xl border border-gray-200 bg-white hover:border-gray-300 transition-all duration-200 shadow-sm focus:outline-none h-20 text-center">
                                    <div class="flex items-center gap-1.5 h-8 justify-center">
                                        <img src="{{ asset('images/logo_visa.svg') }}" alt="Visa" class="h-4.5 w-auto object-contain" />
                                        <img src="{{ asset('images/logo_mastercard.svg') }}" alt="Mastercard" class="h-5 w-auto object-contain" />
                                    </div>
                                    <span class="text-xs text-gray-700 font-bold mt-1">Tarjeta de Crédito / Débito</span>
                                </button>

                                {{-- Nequi --}}
                                <button type="button" data-method="nequi" data-provider="simulated" class="payment-method-btn flex flex-col items-center justify-center p-3 rounded-xl border border-gray-200 bg-white hover:border-gray-300 transition-all duration-200 shadow-sm focus:outline-none h-20 text-center">
                                    <div class="h-8 flex items-center justify-center">
                                        <img src="{{ asset('images/nequi_logo.svg') }}" alt="Nequi" class="h-6 w-auto object-contain" />
                                    </div>
                                    <span class="text-xs text-gray-700 font-bold mt-1">Nequi</span>
                                </button>
                            </div>
                        </div>

                        <hr class="border-gray-100" />

                        {{-- Sección de Formularios Dinámicos --}}
                        <div id="payment-forms-container" class="space-y-4">
                            
                            {{-- MENSAJES DE ERROR DINÁMICOS --}}
                            <div id="payment-error-box" class="hidden p-3.5 bg-red-50 border border-red-200 rounded-xl flex items-start gap-2 text-red-800 text-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 flex-shrink-0 text-red-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                <span id="payment-error-message"></span>
                            </div>

                            {{-- FORMULARIO DE TARJETA --}}
                            <div id="form-card" class="payment-form-section space-y-4">
                                {{-- Inputs --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                                    <div class="col-span-2">
                                        <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Número de Tarjeta</label>
                                        <div class="relative">
                                            <input type="text" id="card_numero" name="card_numero" form="form-pago" autocomplete="off" maxlength="19" 
                                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all font-mono" />
                                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center gap-1 pointer-events-none">
                                                <img id="input-visa-logo" src="{{ asset('images/logo_visa.svg') }}" alt="Visa" class="h-3.5 w-auto object-contain opacity-25 transition-opacity" />
                                                <img id="input-mastercard-logo" src="{{ asset('images/logo_mastercard.svg') }}" alt="Mastercard" class="h-4 w-auto object-contain opacity-25 transition-opacity" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Nombre del Titular</label>
                                        <input type="text" id="card_nombre" name="card_nombre" form="form-pago" autocomplete="off" maxlength="120" 
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all" />
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Vencimiento</label>
                                        <input type="text" id="card_expiry" name="card_expiry" form="form-pago" autocomplete="off" maxlength="5" placeholder="MM/AA" 
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all font-mono" />
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1">CVV</label>
                                        <input type="text" id="card_cvv" name="card_cvv" form="form-pago" autocomplete="off" maxlength="3" placeholder="123" 
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all font-mono" />
                                    </div>
                                </div>
                            </div>

                            {{-- FORMULARIO DE NEQUI --}}
                            <div id="form-nequi" class="payment-form-section hidden space-y-4">
                                <div class="bg-violet-50 rounded-xl p-3.5 border border-violet-100 flex items-start gap-2.5">
                                    <img src="{{ asset('images/nequi_logo.svg') }}" alt="Nequi" class="h-5 w-auto object-contain flex-shrink-0 mt-0.5" />
                                    <p class="text-[11px] text-violet-950 leading-normal">
                                        Paga usando tu número celular Nequi de forma rápida. Recibirás una notificación para aceptar el pago en tu celular.
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Número Celular Nequi</label>
                                    <input type="text" id="nequi_telefono" name="nequi_telefono" form="form-pago" placeholder="300 123 4567" maxlength="10"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all font-mono" />
                                </div>
                            </div>


                        </div>
                    </x-card>

                    {{-- ===== DERECHA: RESUMEN ===== --}}
                    <x-card class="bg-white overflow-hidden border-0">

                        <div class="px-5 pt-5 pb-4 grid grid-cols-2 gap-3 border-b border-gray-100">
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Fecha y hora de recogida</p>
                                <p class="font-semibold text-gray-800 text-sm mt-1">
                                    {{ $reserva->fecini->format('d/m/Y') }}
                                </p>
                                <p class="text-sm text-gray-400">{{ $reserva->fecini->format('g:i a') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Fecha y hora de entrega</p>
                                <p class="font-semibold text-gray-800 text-sm mt-1">
                                    {{ $reserva->fecfin->format('d/m/Y') }}
                                </p>
                                <p class="text-sm text-gray-400">{{ $reserva->fecfin->format('g:i a') }}</p>
                            </div>
                        </div>

                        <div class="px-5 py-4 border-b border-gray-100">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Días de alquiler</label>
                            <input type="text" value="{{ $dias_reserva }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-800 bg-gray-50"
                                readonly />
                        </div>

                        <div class="px-5 pt-5">
                            @php
                                $foto = optional($reserva->vehiculo->fotos->first())->ruta;

                                if ($foto) {
                                    if (\Illuminate\Support\Str::startsWith($foto, ['http://', 'https://'])) {
                                        $rutaImagen = $foto;
                                    } else {
                                        $rutaImagen = \Illuminate\Support\Facades\Storage::disk('public')->url($foto);
                                    }
                                } else {
                                    $rutaImagen =
                                        'https://placehold.co/600x280/ef4444/ffffff?text=' .
                                        urlencode(
                                            ($reserva->vehiculo->marca->des ?? '') .
                                            ' ' .
                                            ($reserva->vehiculo->linea->des ?? ''),
                                        );
                                }
                            @endphp

                            <img src="{{ $rutaImagen }}" class="w-full rounded-xl object-cover aspect-[2.14/1]" alt="Vehículo" />
                        </div>

                        <div class="px-5 pb-4">
                            <div class="mt-2 space-y-1">
                                <p class="text-sm text-gray-700">
                                    <span class="font-semibold">Marca:</span>
                                    {{ $reserva->vehiculo->marca->des ?? 'Sin marca' }}
                                </p>

                                <p class="text-sm text-gray-700">
                                    <span class="font-semibold">Línea:</span>
                                    {{ $reserva->vehiculo->linea->des ?? 'Sin línea' }}
                                </p>

                                <p class="text-sm text-gray-700">
                                    <span class="font-semibold">Modelo:</span>
                                    {{ $reserva->vehiculo->mod ?? '' }}
                                </p>

                                <p class="text-sm text-gray-700">
                                    <span class="font-semibold">Ubicación:</span>
                                    {{ $reserva->vehiculo->ciudad->des ?? 'Sin ubicación' }}
                                </p>
                            </div>
                        </div>

                        <div class="px-5 py-3 flex items-center gap-3 text-xs text-gray-500 border-t border-gray-100">
                            <span class="flex items-center gap-1">👤 {{ $reserva->vehiculo->pas }} Personas</span>
                            <span class="text-gray-200">|</span>
                            <span class="flex items-center gap-1">⭐ 4.8 / 5 (41 reseñas)</span>
                        </div>

                        <div class="px-5 py-4 border-t border-gray-100">
                            <p class="text-3xl font-bold text-gray-900">
                                ${{ number_format($precio_unitario, 0, ',', '.') }}
                                <span class="text-base font-normal text-gray-400">Precio diario</span>
                            </p>
                        </div>

                        <div class="px-5 py-4 border-t border-gray-100">
                            <p class="text-2xl font-bold text-gray-900" id="valor-total">
                                ${{ number_format($monto, 0, ',', '.') }}
                                <span class="text-base font-normal text-gray-400">Precio total</span>
                            </p>
                        </div>

                        <div class="px-5 pb-5">
                            <form action="{{ route('checkout.pagar') }}" method="POST" id="form-pago">
                                @csrf

                                <input type="hidden" name="reserva_id" value="{{ $reserva_id }}">
                                <input type="hidden" name="codveh" value="{{ $reserva->vehiculo->cod }}">
                                <input type="hidden" name="pickup_date" value="{{ $reserva->fecini->format('Y-m-d') }}">
                                <input type="hidden" name="return_date" value="{{ $reserva->fecfin->format('Y-m-d') }}">
                                <input type="hidden" name="monto" value="{{ $monto }}">
                                <input type="hidden" name="provider" id="payment_provider" value="simulated">
                                <input type="hidden" name="metodo_pago" id="metodo_pago" value="card">

                                <x-button type="primary" id="btn-submit-pago"
                                    class="w-full flex items-center justify-center !py-2.5 !px-4 !text-xs shadow-md !tracking-wider">
                                    Pagar ahora
                                </x-button>
                            </form>
                        </div>

                    </x-card>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL DE PROCESAMIENTO DE TRANSACCIÓN ===== --}}
    <div id="processing-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-md transition-all duration-300">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full text-center shadow-2xl border border-gray-100 flex flex-col items-center justify-center space-y-6 transform scale-95 opacity-0 transition-all duration-300" id="processing-modal-card">
            
            {{-- Loader Animado Premium --}}
            <div class="relative w-24 h-24 flex items-center justify-center">
                {{-- Círculo de fondo --}}
                <div class="absolute inset-0 rounded-full border-4 border-gray-100"></div>
                {{-- Círculo animado giratorio --}}
                <div class="absolute inset-0 rounded-full border-4 border-t-red-600 border-r-red-600/30 border-b-red-600/10 border-l-red-600/0 animate-spin"></div>
                {{-- Icono de escudo de seguridad en el centro --}}
                <div class="text-red-600 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
            </div>

            {{-- Textos de Carga --}}
            <div class="space-y-2 text-center">
                <h3 class="text-xl font-bold text-gray-900" style="font-family: 'Segoe UI', sans-serif;">Procesando Pago</h3>
                <p class="text-xs text-gray-400 font-semibold tracking-wider uppercase" id="processing-step-title">Iniciando verificación...</p>
            </div>

            {{-- Barra de progreso lineal sutil --}}
            <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-red-500 to-red-600 transition-all duration-500 ease-out" id="processing-bar" style="width: 0%;"></div>
            </div>

            {{-- Candado / Seguridad --}}
            <div class="flex items-center gap-1.5 justify-center text-[10px] text-gray-400 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                    <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    {{-- SCRIPTS DE INTERACCIÓN Y VALIDACIÓN DE PAGO --}}
    @vite('resources/js/PagoDigital/checkout_validation.js')
</x-page>