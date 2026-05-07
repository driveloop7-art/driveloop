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
                        Métodos de pago
                    </h1>
                    <p class="text-gray-500 mt-2 text-sm">
                        Complete toda la información para completar el proceso de renta del vehículo.
                    </p>
                </div>

                <div class="grid lg:grid-cols-[1fr_360px] gap-8 items-start">

                    {{-- ===== IZQUIERDA: MÉTODOS ===== --}}
                    <div class="space-y-3">

                        {{-- TARJETA --}}
                        <div id="block-card" onclick="selectMethod('card')"
                            class="method-card selected rounded-xl border border-gray-200 bg-white shadow-sm cursor-pointer transition-all duration-200">
                            <div class="flex items-center gap-4 px-5 py-4">
                                <div class="flex items-center flex-shrink-0 gap-1.5">
                                    <div class="relative w-9 h-6 flex-shrink-0">
                                        <div class="w-6 h-6 rounded-full bg-red-600 absolute left-0 top-0"></div>
                                        <div class="w-6 h-6 rounded-full bg-orange-400 absolute left-3 top-0 opacity-90"></div>
                                    </div>
                                    <span class="text-blue-800 font-extrabold italic text-sm tracking-tighter ml-1">VISA</span>
                                </div>
                                <div class="flex-1 min-w-0 text-left">
                                    <p class="font-bold text-gray-900 text-sm leading-tight">Tarjetas de crédito o débito</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Paga con tarjeta de crédito Visa o Mastercard.</p>
                                </div>
                                <div class="radio-ring w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center flex-shrink-0 transition-all">
                                    <div class="radio-dot w-2.5 h-2.5 rounded-full bg-red-500 opacity-0 transition-opacity"></div>
                                </div>
                            </div>

                            <div id="panel-card" class="px-5 pb-5 space-y-3" onclick="event.stopPropagation()">
                                <input
                                    id="card-numero"
                                    name="card_numero"
                                    form="form-pago"
                                    type="text"
                                    inputmode="numeric"
                                    maxlength="19"
                                    placeholder="Número de la tarjeta"
                                    class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"
                                />

                                <input
                                    id="card-nombre"
                                    name="card_nombre"
                                    form="form-pago"
                                    type="text"
                                    placeholder="Nombre del titular"
                                    class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"
                                />

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <input
                                            id="card-expiry"
                                            name="card_expiry"
                                            form="form-pago"
                                            type="text"
                                            inputmode="numeric"
                                            maxlength="5"
                                            placeholder="MM/AA"
                                            class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"
                                        />
                                    </div>
                                    <div>
                                        <input
                                            id="card-cvv"
                                            name="card_cvv"
                                            form="form-pago"
                                            type="password"
                                            inputmode="numeric"
                                            maxlength="4"
                                            placeholder="CVV"
                                            class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"
                                        />
                                    </div>
                                </div>

                                <input
                                    id="card-documento"
                                    form="form-pago"
                                    type="text"
                                    inputmode="numeric"
                                    placeholder="Documento del titular"
                                    class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"
                                />
                            </div>
                        </div>

                        {{-- TRANSFERENCIA --}}
                        <div id="block-transfer" onclick="selectMethod('transfer')"
                            class="method-card rounded-xl border border-gray-200 bg-white shadow-sm cursor-pointer transition-all duration-200">
                            <div class="flex items-center gap-4 px-5 py-4">
                                <div class="w-9 h-9 rounded-full bg-indigo-700 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-[9px] font-bold leading-none">PSE</span>
                                </div>
                                <div class="flex-1 min-w-0 text-left">
                                    <p class="font-bold text-gray-900 text-sm leading-tight">Transferencia Bancaria</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Paga mediante transferencias bancarias locales.</p>
                                </div>
                                <div class="radio-ring w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center flex-shrink-0 transition-all">
                                    <div class="radio-dot w-2.5 h-2.5 rounded-full bg-red-500 opacity-0 transition-opacity"></div>
                                </div>
                            </div>

                            <div id="panel-transfer" class="hidden px-5 pb-5 space-y-3" onclick="event.stopPropagation()">
                                <div class="bg-gray-50 border border-red-100 rounded-lg p-4 text-sm text-gray-600 space-y-1.5">
                                    <p><span class="font-semibold text-gray-800">Banco:</span> Bancolombia</p>
                                    <p><span class="font-semibold text-gray-800">Cuenta:</span> 123-456789-00 (Corriente)</p>
                                    <p><span class="font-semibold text-gray-800">NIT:</span> 900.123.456-7</p>
                                    <p><span class="font-semibold text-gray-800">Titular:</span> DriveLoop SAS</p>
                                </div>

                                <input
                                    id="transfer-comprobante"
                                    name="transfer_comprobante"
                                    form="form-pago"
                                    type="text"
                                    inputmode="numeric"
                                    placeholder="Número o referencia de comprobante"
                                    class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"
                                />
                            </div>
                        </div>

                        {{-- NEQUI --}}
                        <div id="block-nequi" onclick="selectMethod('nequi')"
                            class="method-card rounded-xl border border-gray-200 bg-white shadow-sm cursor-pointer transition-all duration-200">
                            <div class="flex items-center gap-4 px-5 py-4">
                                <div class="w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <span class="text-purple-700 font-black text-[10px] leading-none italic">'Nequi</span>
                                </div>
                                <div class="flex-1 min-w-0 text-left">
                                    <p class="font-bold text-gray-900 text-sm leading-tight">Nequi</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Pagar con fondos del monedero Nequi.</p>
                                </div>
                                <div class="radio-ring w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center flex-shrink-0 transition-all">
                                    <div class="radio-dot w-2.5 h-2.5 rounded-full bg-red-500 opacity-0 transition-opacity"></div>
                                </div>
                            </div>

                            <div id="panel-nequi" class="hidden px-5 pb-5 space-y-3" onclick="event.stopPropagation()">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <input
                                            id="nequi-nombre"
                                            form="form-pago"
                                            type="text"
                                            placeholder="Nombre"
                                            class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"
                                        />
                                    </div>
                                    <div>
                                        <input
                                            id="nequi-apellido"
                                            form="form-pago"
                                            type="text"
                                            placeholder="Apellido"
                                            class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"
                                        />
                                    </div>
                                </div>

                                <input
                                    id="nequi-telefono"
                                    name="nequi_telefono"
                                    form="form-pago"
                                    type="text"
                                    inputmode="numeric"
                                    maxlength="10"
                                    placeholder="Número de celular"
                                    class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"
                                />

                                <div id="qr-nequi" class="hidden mt-4 text-center">
                                    <p class="text-sm text-gray-600 mb-2">Escanea el código QR para abrir la app de Nequi</p>
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=nequi://"
                                        alt="QR para abrir Nequi" class="mx-auto" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===== DERECHA: RESUMEN ===== --}}
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">

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
                                <input type="hidden" name="provider" value="{{ config('payments.default', 'simulated') }}">
                                <input type="hidden" name="metodo_pago" id="metodo_pago" value="card">

                                <button type="submit"
                                    class="w-full rounded-xl bg-[#C91843] py-3 text-white font-bold hover:bg-[#981B39] transition">
                                    Pagar ahora
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .method-card.selected {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 1px #ef4444;
        }

        .method-card.selected .radio-ring {
            border-color: #ef4444;
        }

        .method-card.selected .radio-dot {
            opacity: 1 !important;
        }
    </style>

    <script>
        let selectedKey = 'card';

        function selectMethod(key) {
            const methods = ['card', 'transfer', 'nequi'];

            methods.forEach(k => {
                const panel = document.getElementById('panel-' + k);
                const block = document.getElementById('block-' + k);

                if (k === key) {
                    panel.classList.remove('hidden');
                    block.classList.add('selected');
                } else {
                    panel.classList.add('hidden');
                    block.classList.remove('selected');
                }
            });

            selectedKey = key;
            document.getElementById('metodo_pago').value = key;

            const qrNequi = document.getElementById('qr-nequi');
            if (key === 'nequi') {
                qrNequi.classList.remove('hidden');
            } else {
                qrNequi.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            selectMethod('card');
        });
    </script>

</x-page>