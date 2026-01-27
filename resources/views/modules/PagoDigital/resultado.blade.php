<x-page>
    <div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gray-50">
        <div class="max-w-2xl w-full bg-white rounded-lg shadow-lg p-12">

            <div x-data="{ 
                estado: '{{ $pago->estado_pago }}',
                showResult: false,
                init() {
                    setTimeout(() => {
                        this.showResult = true;
                    }, 4000);
                }
            }">

                {{-- Loading Screen --}}
                <div class="flex flex-col items-center justify-center text-center"
                    x-show="!showResult"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">

                    <h2 class="text-2xl font-semibold text-gray-700 mb-8">Verificación de pago</h2>

                    {{-- Loading Spinner --}}
                    <div class="relative w-32 h-32 mb-6">
                        <svg class="animate-spin" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#ef4444" stroke-width="6"
                                stroke-dasharray="70 200" stroke-linecap="round" />
                        </svg>
                    </div>

                    <p class="text-sm text-gray-500">
                        Su pago se verificará dentro de poco
                    </p>
                </div>

                {{-- Result Screen --}}
                <div class="flex flex-col items-center justify-center text-center"
                    x-show="showResult"
                    style="display: none;"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100">

                    @if($pago->estado_pago === 'aceptado')
                    <h2 class="text-2xl font-semibold text-green-600 mb-8">Pago exitoso</h2>

                    {{-- Success Checkmark Animation --}}
                    <div class="relative w-32 h-32 mb-6">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            {{-- Circle --}}
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#10b981" stroke-width="6"
                                class="animate-draw-circle" />

                            {{-- Checkmark --}}
                            <path d="M 30 50 L 45 65 L 70 35" fill="none" stroke="#10b981" stroke-width="6"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="animate-draw-check" />
                        </svg>
                    </div>

                    <p class="text-base text-gray-600 mb-8">
                        Su pago ha sido procesado exitosamente
                    </p>
                    @else
                    <h2 class="text-2xl font-semibold text-red-600 mb-8">Pago rechazado</h2>

                    {{-- Error X Animation --}}
                    <div class="relative w-32 h-32 mb-6">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            {{-- Circle --}}
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#ef4444" stroke-width="6"
                                class="animate-draw-circle" />

                            {{-- X Mark --}}
                            <path d="M 35 35 L 65 65 M 65 35 L 35 65" fill="none" stroke="#ef4444" stroke-width="6"
                                stroke-linecap="round"
                                class="animate-draw-check" />
                        </svg>
                    </div>

                    <p class="text-base text-gray-600 mb-8">
                        El pago fue rechazado. Por favor, intente nuevamente.
                    </p>
                    @endif

                    {{-- Transaction Details --}}
                    <div class="w-full mt-4 p-6 bg-gray-50 rounded-lg text-left">
                        <h3 class="text-sm font-semibold text-gray-700 mb-4">Detalles de la transacción</h3>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>ID Transacción:</span>
                                <span class="font-mono font-semibold">#{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Método de pago:</span>
                                <span class="capitalize">{{ $pago->metodo_pago }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Monto:</span>
                                <span class="font-semibold">${{ number_format($pago->monto, 0, ',', '.') }} Pesos Colombianos (COP)</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Estado:</span>
                                <span class="font-semibold {{ $pago->estado_pago === 'aceptado' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $pago->estado_pago === 'aceptado' ? 'Transacción Aceptada' : 'Transacción Rechazada' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="w-full mt-8">
                        @if($pago->estado_pago === 'aceptado')
                        <a href="{{ route('pago.digital') }}"
                            class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-6 rounded-lg transition-colors text-center">
                            Finalizar
                        </a>
                        @else
                        <a href="{{ route('pago.digital') }}"
                            class="block w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-4 px-6 rounded-lg transition-colors text-center">
                            Intentar nuevamente
                        </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        @keyframes draw-circle {
            from {
                stroke-dasharray: 0 283;
            }

            to {
                stroke-dasharray: 283 283;
            }
        }

        @keyframes draw-check {
            from {
                stroke-dasharray: 0 100;
            }

            to {
                stroke-dasharray: 100 100;
            }
        }

        .animate-draw-circle {
            animation: draw-circle 0.6s ease-out forwards;
        }

        .animate-draw-check {
            animation: draw-check 0.4s ease-out 0.6s forwards;
            stroke-dasharray: 0 100;
        }
    </style>
</x-page>