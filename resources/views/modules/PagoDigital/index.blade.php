<x-page>

    @php
        $dias_reserva = $reserva->fecini->diffInDays($reserva->fecfin) + 1;
        $precio_unitario = $monto / $dias_reserva;
    @endphp

    {{-- Fondo blanco --}}
    <div class="relative min-h-screen py-12 bg-white">
        <div>

            <div class="relative z-10 max-w-6xl mx-auto px-6">
                {{-- TÍTULO --}}
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900" style="font-family: 'Segoe UI', sans-serif;">Métodos de
                        pago</h1>
                    <p class="text-gray-500 mt-2 text-sm">Complete toda la información para completar el proceso de renta
                        del vehículo.</p>
                </div>

                <div class="grid lg:grid-cols-[1fr_360px] gap-8 items-start">

                    {{-- ===== IZQUIERDA: MÉTODOS ===== --}}
                    <div class="space-y-3">

                        {{-- ── 1) TARJETA ── --}}
                        <div id="block-card" onclick="selectMethod('card')"
                            class="method-card rounded-xl border border-gray-200 bg-white shadow-sm cursor-pointer transition-all duration-200">
                            <div class="flex items-center gap-4 px-5 py-4">
                                {{-- Mastercard + VISA --}}
                                <div class="flex items-center flex-shrink-0 gap-1.5">
                                    <div class="relative w-9 h-6 flex-shrink-0">
                                        <div class="w-6 h-6 rounded-full bg-red-600 absolute left-0 top-0"></div>
                                        <div
                                            class="w-6 h-6 rounded-full bg-orange-400 absolute left-3 top-0 opacity-90">
                                        </div>
                                    </div>
                                    <span
                                        class="text-blue-800 font-extrabold italic text-sm tracking-tighter ml-1">VISA</span>
                                </div>
                                <div class="flex-1 min-w-0 text-left">
                                    <p class="font-bold text-gray-900 text-sm leading-tight">Tarjetas de crédito o
                                        débito</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Paga con tarjeta de crédito Visa o
                                        Mastercard.</p>
                                </div>
                                <div
                                    class="radio-ring w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center flex-shrink-0 transition-all">
                                    <div
                                        class="radio-dot w-2.5 h-2.5 rounded-full bg-red-500 opacity-0 transition-opacity">
                                    </div>
                                </div>
                            </div>

                            {{-- Formulario tarjeta --}}
                            <div id="panel-card" class="hidden px-5 pb-5 space-y-3" onclick="event.stopPropagation()">
                                <input id="card-numero" type="text" inputmode="numeric" maxlength="19"
                                    placeholder="Número de la tarjeta"
                                    class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white" />
                                <p id="err-card-numero" class="text-red-500 text-xs -mt-1 hidden">Solo se permiten
                                    números.</p>

                                <input id="card-nombre" type="text" placeholder="Nombre del titular"
                                    class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white" />
                                <p id="err-card-nombre" class="text-red-500 text-xs -mt-1 hidden">Solo se permiten
                                    letras.</p>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <input id="card-expiry" type="text" inputmode="numeric" maxlength="5"
                                            placeholder="Vencimiento"
                                            class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white" />
                                        <p id="err-card-expiry" class="text-red-500 text-xs mt-1 hidden">Formato MM/AA.
                                        </p>
                                    </div>
                                    <div>
                                        <input id="card-cvv" type="text" inputmode="numeric" maxlength="4"
                                            placeholder="Código de seguridad (CVV)"
                                            class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white" />
                                        <p id="err-card-cvv" class="text-red-500 text-xs mt-1 hidden">3-4 dígitos.</p>
                                    </div>
                                </div>

                                <input id="card-documento" type="text" inputmode="numeric"
                                    placeholder="Documento del titular"
                                    class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white" />
                                <p id="err-card-documento" class="text-red-500 text-xs -mt-1 hidden">Solo se permiten
                                    números.</p>

                                <div class="pt-1">
                                    <p class="text-xs text-gray-500 mb-2">¿Quieres guardar este método de pago para
                                        alquileres futuros?</p>
                                    <div class="flex gap-5">
                                        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                            <input type="radio" name="save-card" value="si"
                                                class="accent-red-500 w-4 h-4" /> Sí
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                            <input type="radio" name="save-card" value="no"
                                                class="accent-red-500 w-4 h-4" checked /> No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── 2) TRANSFERENCIA ── --}}
                        <div id="block-transfer" onclick="selectMethod('transfer')"
                            class="method-card rounded-xl border border-gray-200 bg-white shadow-sm cursor-pointer transition-all duration-200">
                            <div class="flex items-center gap-4 px-5 py-4">
                                <div
                                    class="w-9 h-9 rounded-full bg-indigo-700 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-[9px] font-bold leading-none">PSE</span>
                                </div>
                                <div class="flex-1 min-w-0 text-left">
                                    <p class="font-bold text-gray-900 text-sm leading-tight">Transferencia Bancaria</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Paga mediante transferencias bancarias
                                        locales.</p>
                                </div>
                                <div
                                    class="radio-ring w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center flex-shrink-0 transition-all">
                                    <div
                                        class="radio-dot w-2.5 h-2.5 rounded-full bg-red-500 opacity-0 transition-opacity">
                                    </div>
                                </div>
                            </div>

                            <div id="panel-transfer" class="hidden px-5 pb-5 space-y-3"
                                onclick="event.stopPropagation()">
                                <div
                                    class="bg-gray-50 border border-red-100 rounded-lg p-4 text-sm text-gray-600 space-y-1.5">
                                    <p><span class="font-semibold text-gray-800">Banco:</span> Bancolombia</p>
                                    <p><span class="font-semibold text-gray-800">Cuenta:</span> 123-456789-00
                                        (Corriente)</p>
                                    <p><span class="font-semibold text-gray-800">NIT:</span> 900.123.456-7</p>
                                    <p><span class="font-semibold text-gray-800">Titular:</span> DriveLoop SAS</p>
                                </div>
                                <input id="transfer-comprobante" type="text" inputmode="numeric"
                                    placeholder="Número de comprobante"
                                    class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white" />
                                <p id="err-transfer-comprobante" class="text-red-500 text-xs -mt-1 hidden">Solo se
                                    permiten números.</p>

                                <div class="pt-1">
                                    <p class="text-xs text-gray-500 mb-2">¿Quieres guardar este método de pago para
                                        alquileres futuros?</p>
                                    <div class="flex gap-5">
                                        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                            <input type="radio" name="save-transfer" value="si"
                                                class="accent-red-500 w-4 h-4" /> Sí
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                            <input type="radio" name="save-transfer" value="no"
                                                class="accent-red-500 w-4 h-4" checked /> No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── 3) NEQUI ── --}}
                        <div id="block-nequi" onclick="selectMethod('nequi')"
                            class="method-card rounded-xl border border-gray-200 bg-white shadow-sm cursor-pointer transition-all duration-200">
                            <div class="flex items-center gap-4 px-5 py-4">
                                <div
                                    class="w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <span
                                        class="text-purple-700 font-black text-[10px] leading-none italic">'Nequi</span>
                                </div>
                                <div class="flex-1 min-w-0 text-left">
                                    <p class="font-bold text-gray-900 text-sm leading-tight">Nequi</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Pagar con fondos del monedero Nequi.</p>
                                </div>
                                <div
                                    class="radio-ring w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center flex-shrink-0 transition-all">
                                    <div
                                        class="radio-dot w-2.5 h-2.5 rounded-full bg-red-500 opacity-0 transition-opacity">
                                    </div>
                                </div>
                            </div>

                            <div id="panel-nequi" class="hidden px-5 pb-5 space-y-3"
                                onclick="event.stopPropagation()">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <input id="nequi-nombre" type="text" placeholder="Nombre"
                                            class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white" />
                                        <p id="err-nequi-nombre" class="text-red-500 text-xs mt-1 hidden">Solo letras.
                                        </p>
                                    </div>
                                    <div>
                                        <input id="nequi-apellido" type="text" placeholder="Apellido"
                                            class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white" />
                                        <p id="err-nequi-apellido" class="text-red-500 text-xs mt-1 hidden">Solo
                                            letras.</p>
                                    </div>
                                </div>
                                <input id="nequi-telefono" type="text" inputmode="numeric" maxlength="10"
                                    placeholder="Numero de telefono"
                                    class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white" />
                                <p id="err-nequi-telefono" class="text-red-500 text-xs -mt-1 hidden">10 dígitos
                                    requeridos.</p>

                                <div class="pt-1">
                                    <p class="text-xs text-gray-500 mb-2">¿Quieres guardar este método de pago para
                                        alquileres futuros?</p>
                                    <div class="flex gap-5">
                                        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                            <input type="radio" name="save-nequi" value="si"
                                                class="accent-red-500 w-4 h-4" /> Sí
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                            <input type="radio" name="save-nequi" value="no"
                                                class="accent-red-500 w-4 h-4" checked /> No
                                        </label>
                                    </div>
                                </div>

                                {{-- CÓDIGO QR PARA NEQUI --}}
                                <div id="qr-nequi" class="hidden mt-4 text-center">
                                    <p class="text-sm text-gray-600 mb-2">Escanea el código QR para abrir la app de
                                        Nequi</p>
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=nequi://"
                                        alt="QR para abrir Nequi" class="mx-auto" />
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- ===== FIN IZQUIERDA ===== --}}


                    {{-- ===== DERECHA: RESUMEN ===== --}}
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">

                        {{-- FECHAS --}}
                        <div class="px-5 pt-5 pb-4 grid grid-cols-2 gap-3 border-b border-gray-100">
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Fecha y
                                    hora de recogida</p>
                                <p class="font-semibold text-gray-800 text-sm mt-1">
                                    {{ $reserva->fecini->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-400">{{ $reserva->fecini->format('g:i a') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Fecha y
                                    hora de entrega</p>
                                <p class="font-semibold text-gray-800 text-sm mt-1">
                                    {{ $reserva->fecfin->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-400">{{ $reserva->fecfin->format('g:i a') }}</p>
                            </div>
                        </div>

                        {{-- PREGUNTA DÍAS ALQUILER --}}
                        <div class="px-5 py-4 border-b border-gray-100">
                            <label for="dias-alquiler" class="block text-sm font-semibold text-gray-700 mb-2">¿Cuántos
                                días va a alquilar el vehículo?</label>
                            <input id="dias-alquiler" type="text" inputmode="numeric"
                                placeholder="Número de días"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white" />
                            <p id="err-dias-alquiler" class="text-red-500 text-xs mt-1 hidden">Solo se permiten
                                números.</p>
                        </div>

                        {{-- IMAGEN --}}
                        <div class="px-5 pt-5">
                            @php
                                $foto = $reserva->vehiculo->fotos->first();
                                $rutaImagen = $foto
                                    ? asset($foto->ruta)
                                    : 'https://placehold.co/600x280/ef4444/ffffff?text=' .
                                        urlencode(
                                            ($reserva->vehiculo->marca->des ?? '') . ' ' . ($reserva->vehiculo->linea->des ?? ''),
                                        );
                            @endphp
                            <img src="{{ $rutaImagen }}" class="w-full rounded-xl object-cover aspect-[2.14/1]"
                                alt="Vehículo" />
                        </div>


                        {{-- INFO --}}
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






                        {{-- BADGES --}}
                        <div class="px-5 py-3 flex items-center gap-3 text-xs text-gray-500 border-t border-gray-100">
                            <span class="flex items-center gap-1">👤 {{ $reserva->vehiculo->pas }} Personas</span>
                            <span class="text-gray-200">|</span>
                            <span class="flex items-center gap-1">⭐ 4.8 / 5 (41 reseñas)</span>
                        </div>

                        {{-- PRECIO --}}
                        <div class="px-5 py-4 border-t border-gray-100">
                            <p class="text-3xl font-bold text-gray-900">
                                ${{ number_format($precio_unitario, 0, ',', '.') }}
                                <span class="text-base font-normal text-gray-400">Precio diario</span>
                            </p>
                        </div>

                        {{-- VALOR TOTAL --}}
                        <div class="px-5 py-4 border-t border-gray-100">
                            <p class="text-2xl font-bold text-gray-900" id="valor-total">
                                $0
                                <span class="text-base font-normal text-gray-400">Precio total</span>
                            </p>
                        </div>

                        {{-- BOTÓN --}}
                        <div class="px-5 pb-5">
                            <button id="btn-continuar" onclick="procesarPago()"
                                class="block w-full text-center border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-bold py-3.5 rounded-xl tracking-widest uppercase text-sm transition-all duration-200">
                                Continuar
                            </button>
                        </div>

                    </div>
                    {{-- ===== FIN DERECHA ===== --}}

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

            .btn-loading {
                opacity: 0.5;
                cursor: not-allowed;
            }

            /* Overlays */
            .overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.4);
                backdrop-filter: blur(4px);
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1.5rem;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }
            .overlay.active {
                opacity: 1;
                pointer-events: auto;
            }

            /* Spinner Animation */
            @keyframes spin-fast {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .animate-spin-custom {
                animation: spin-fast 1s linear infinite;
            }

            /* Circular Progress */
            .progress-ring__circle {
                transition: stroke-dashoffset 0.35s;
                transform: rotate(-90deg);
                transform-origin: 50% 50%;
            }
        </style>

        {{-- ── OVERLAY: VERIFICACIÓN ── --}}
        <div id="overlay-verification" class="overlay">
            <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl transform transition-all">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Verificación de pago</h2>
                
                <div class="relative w-32 h-32 mx-auto mb-6">
                    <svg class="w-full h-full">
                        <circle class="text-gray-100" stroke-width="8" stroke="currentColor" fill="transparent" r="58" cx="64" cy="64"/>
                        <circle id="progress-bar" class="text-red-500 progress-ring__circle" stroke-width="8" stroke-dasharray="364.4" stroke-dashoffset="364.4" stroke-linecap="round" stroke="currentColor" fill="transparent" r="58" cx="64" cy="64"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span id="progress-text" class="text-xl font-bold text-gray-700">0%</span>
                    </div>
                </div>

                <p class="text-gray-500 font-medium">Su pago se verificará dentro de poco</p>
            </div>
        </div>

        {{-- ── OVERLAY: ÉXITO ── --}}
        <div id="overlay-success" class="overlay {{ $pago ? 'active' : '' }}">
            <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl relative overflow-hidden border border-gray-100">
                
                {{-- HEADER ROJO (ESTILO TICKET) --}}
                <div class="bg-[#c2183e] px-8 py-5 flex items-center justify-between relative overflow-hidden">
                    <h2 class="text-3xl font-black text-white tracking-widest uppercase">Detalle de Pago</h2>
                    <span class="text-white/50 font-bold hidden sm:block">DriveLoop</span>
                    {{-- Decoración --}}
                    <div class="absolute -right-6 top-1/2 -translate-y-1/2 w-12 h-24 bg-white/10 rotate-12"></div>
                </div>

                <div class="p-8">
                    {{-- CUADRO DE DATOS (ESTILO TICKET) --}}
                    <div class="border border-[#f0c2cc] rounded-3xl p-8 mb-8 bg-white">
                        <div class="grid grid-cols-2 gap-x-12 gap-y-8">
                            
                            {{-- CÓDIGO --}}
                            <div>
                                <label class="block text-[11px] font-bold text-[#b0b3b8] uppercase tracking-wider mb-1.5">Código de pago</label>
                                <span class="block text-lg font-black text-gray-900">#{{ str_pad($pago->id ?? 0, 7, '0', STR_PAD_LEFT) }}</span>
                            </div>

                            {{-- FECHA --}}
                            <div>
                                <label class="block text-[11px] font-bold text-[#b0b3b8] uppercase tracking-wider mb-1.5">Fecha de pago</label>
                                <span class="block text-lg font-bold text-gray-800">{{ $pago ? $pago->created_at->format('D, d M Y H:i:s') : now()->format('D, d M Y H:i:s') }}</span>
                            </div>

                            {{-- MÉTODO --}}
                            <div>
                                <label class="block text-[11px] font-bold text-[#b0b3b8] uppercase tracking-wider mb-1.5">Método de pago</label>
                                <span class="block text-lg font-bold text-gray-800 capitalize">{{ $pago->metodo_pago ?? 'N/A' }}</span>
                            </div>

                            {{-- ESTADO --}}
                            <div>
                                <label class="block text-[11px] font-bold text-[#b0b3b8] uppercase tracking-wider mb-1.5">Estado</label>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-black uppercase tracking-tight inline-block">Aceptado</span>
                            </div>

                        </div>

                        <div class="mt-10">
                            <label class="block text-[11px] font-bold text-[#b0b3b8] uppercase tracking-wider mb-3">Descripción / Vehículo</label>
                            <div class="bg-[#f8f9fa] rounded-2xl p-6 border border-gray-100">
                                <div class="flex items-start gap-5">
                                    <img src="{{ $rutaImagen }}" class="w-24 h-16 rounded-xl object-cover shadow-sm border border-white" alt="Auto">
                                    <div>
                                        <p class="text-base font-black text-gray-900 leading-tight mb-1">{{ $marcaNombre }} {{ $lineaNombre }}</p>
                                        <p class="text-sm text-gray-500 font-medium">Modelo {{ $reserva->vehiculo->mod ?? '' }} • Ubicación: {{ $ciudadNombre }}</p>
                                        <p class="text-[11px] text-red-500 font-bold mt-2 uppercase tracking-wide">Pago Total: ${{ number_format($pago->monto ?? 0, 0, ',', '.') }} COP</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BOTONES ACCIÓN --}}
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                        <a id="btn-ver-pdf" href="{{ $pago ? route('pago.digital.invoice', ['id' => $pago->id]) : '#' }}" target="_blank"
                            class="w-full sm:w-1/2 py-4 bg-[#c2183e] hover:bg-[#a01433] text-white font-black rounded-2xl transition-all shadow-lg shadow-red-100 tracking-widest uppercase text-sm flex items-center justify-center gap-2 group">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Ver PDF
                        </a>

                        <button onclick="window.location.href='/'" 
                            class="w-full sm:w-1/2 py-4 border-2 border-[#c2183e] text-[#c2183e] hover:bg-gray-50 font-black rounded-2xl transition-all tracking-widest uppercase text-sm">
                            Finalizar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let selectedKey = null;

            /* ─── SELECCIÓN DE MÉTODO ──────────────────────────────── */
            function selectMethod(key) {
                const methods = ['card', 'transfer', 'nequi'];
                methods.forEach(k => {
                    const panel = document.getElementById('panel-' + k);
                    const block = document.getElementById('block-' + k);
                    if (k === key) {
                        const isOpen = !panel.classList.contains('hidden');
                        if (isOpen) {
                            panel.classList.add('hidden');
                            block.classList.remove('selected');
                            selectedKey = null;
                        } else {
                            panel.classList.remove('hidden');
                            block.classList.add('selected');
                            selectedKey = key;
                        }
                    } else {
                        panel.classList.add('hidden');
                        block.classList.remove('selected');
                    }
                });

                // Mostrar QR solo para Nequi
                if (selectedKey === 'nequi') {
                    document.getElementById('qr-nequi').classList.remove('hidden');
                } else {
                    document.getElementById('qr-nequi').classList.add('hidden');
                }
            }

            /* ─── CONTINUAR ───────────────────────────────────────── */
            async function procesarPago() {
                if (!selectedKey) {
                    alert('Selecciona un método de pago para continuar.');
                    return;
                }

                const btn = document.getElementById('btn-continuar');
                const detalles = {};

                // Recolectar datos según el método
                if (selectedKey === 'card') {
                    detalles.numero = document.getElementById('card-numero').value;
                    detalles.nombre = document.getElementById('card-nombre').value;
                    detalles.vencimiento = document.getElementById('card-expiry').value;
                    detalles.documento = document.getElementById('card-documento').value;
                    if (!detalles.numero || !detalles.nombre || detalles.numero.length < 15) {
                        alert('Por favor completa los datos de la tarjeta correctamente.');
                        return;
                    }
                } else if (selectedKey === 'transfer') {
                    detalles.comprobante = document.getElementById('transfer-comprobante').value;
                    if (!detalles.comprobante) {
                        alert('Por favor ingresa el número de comprobante.');
                        return;
                    }
                } else if (selectedKey === 'nequi') {
                    detalles.nombre = document.getElementById('nequi-nombre').value;
                    detalles.apellido = document.getElementById('nequi-apellido').value;
                    detalles.telefono = document.getElementById('nequi-telefono').value;
                    if (!detalles.nombre || !detalles.telefono || detalles.telefono.length < 10) {
                        alert('Por favor completa los datos de Nequi correctamente.');
                        return;
                    }
                }

                btn.disabled = true;
                btn.classList.add('btn-loading');
                btn.innerText = 'PROCESANDO...';

                // Calcular monto final basado en los días ingresados
                const dias = parseInt(document.getElementById('dias-alquiler').value) || 0;
                const precioUnitario = {{ $precio_unitario }};
                const montoFinal = dias * precioUnitario;

                try {
                    const response = await fetch("{{ route('pago.digital.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            reserva_id: "{{ $reserva_id }}",
                            metodo_pago: selectedKey,
                            monto: montoFinal,
                            detalles: detalles
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Mostrar overlay de verificación
                        document.getElementById('overlay-verification').classList.add('active');
                        
                        // Animación simulada de progreso
                        const progressBar = document.getElementById('progress-bar');
                        const progressText = document.getElementById('progress-text');
                        const total = 364.4; // Circunferencia del círculo
                        let p = 0;

                        const interval = setInterval(() => {
                            p += Math.floor(Math.random() * 15) + 5;
                            if (p > 100) p = 100;
                            
                            const offset = total - (p / 100) * total;
                            progressBar.style.strokeDashoffset = offset;
                            progressText.innerText = p + '%';

                            if (p === 100) {
                                clearInterval(interval);
                                setTimeout(() => {
                                    // Guardar el enlace de PDF antes de recargar
                                    window.location.href = "{{ route('pago.digital', ['reserva_id' => $reserva_id]) }}?success=1";
                                }, 500);
                            }
                        }, 200);

                    } else {
                        alert('Error al guardar: ' + result.message);
                        btn.disabled = false;
                        btn.classList.remove('btn-loading');
                        btn.innerText = 'CONTINUAR';
                    }
                } catch (error) {
                    console.error(error);
                    alert('Ocurrió un error al procesar el pago.');
                    btn.disabled = false;
                    btn.classList.remove('btn-loading');
                    btn.innerText = 'CONTINUAR';
                }
            }

            /* ─── HELPERS ─────────────────────────────────────────── */
            function setError(id, show) {
                const el = document.getElementById('err-' + id);
                if (el) el.classList.toggle('hidden', !show);
            }

            function blockInvalid(e, regex) {
                if (!regex.test(String.fromCharCode(e.which || e.keyCode))) e.preventDefault();
            }

            function soloNumeros(id, max) {
                const el = document.getElementById(id);
                el.addEventListener('keypress', e => blockInvalid(e, /[0-9]/));
                el.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').substring(0, max || 999);
                });
            }

            function soloLetras(id) {
                const el = document.getElementById(id);
                el.addEventListener('keypress', e => blockInvalid(e, /[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/));
                el.addEventListener('input', function() {
                    this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/g, '');
                });
            }

            /* ─── APLICAR VALIDACIONES ────────────────────────────── */
            soloNumeros('card-numero', 16);
            document.getElementById('card-numero').addEventListener('input', function() {
                let raw = this.value.replace(/\D/g, '').substring(0, 16);
                this.value = raw.match(/.{1,4}/g)?.join(' ') ?? raw;
            });
            soloLetras('card-nombre');
            soloNumeros('card-expiry', 4);
            document.getElementById('card-expiry').addEventListener('input', function() {
                let raw = this.value.replace(/\D/g, '').substring(0, 4);
                if (raw.length >= 3) raw = raw.slice(0, 2) + '/' + raw.slice(2);
                this.value = raw;
            });
            soloNumeros('card-cvv', 4);
            soloNumeros('card-documento');
            soloNumeros('transfer-comprobante');
            soloLetras('nequi-nombre');
            soloLetras('nequi-apellido');
            soloNumeros('nequi-telefono', 10);
            soloNumeros('dias-alquiler');

            /* ─── CALCULAR VALOR TOTAL ───────────────────────────── */
            function calcularTotal() {
                const dias = parseInt(document.getElementById('dias-alquiler').value) || 0;
                const precioUnitario = {{ $precio_unitario }};
                const total = dias * precioUnitario;
                document.getElementById('valor-total').innerHTML = '$' + total.toLocaleString('es-CO') +
                    ' <span class="text-base font-normal text-gray-400">Precio total</span>';
            }

            document.getElementById('dias-alquiler').addEventListener('input', calcularTotal);
        </script>

</x-page>
