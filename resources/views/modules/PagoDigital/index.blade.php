<x-page>

{{-- Fondo blanco --}}
<div class="relative min-h-screen py-12 bg-white">
    <div>

    <div class="relative z-10 max-w-5xl mx-auto px-6">

        {{-- TÍTULO --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900" style="font-family: 'Segoe UI', sans-serif;">Métodos de pago</h1>
            <p class="text-gray-500 mt-2 text-sm">Complete toda la información para completar el proceso de renta del vehículo.</p>
        </div>

        <div class="grid lg:grid-cols-[1fr_360px] gap-8 items-start">

            {{-- ===== IZQUIERDA: MÉTODOS ===== --}}
            <div class="space-y-3">

                {{-- ── 1) TARJETA ── --}}
                <div id="block-card"
                     onclick="selectMethod('card')"
                     class="method-card rounded-xl border border-gray-200 bg-white shadow-sm cursor-pointer transition-all duration-200">
                    <div class="flex items-center gap-4 px-5 py-4">
                        {{-- Mastercard + VISA --}}
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

                    {{-- Formulario tarjeta --}}
                    <div id="panel-card" class="hidden px-5 pb-5 space-y-3" onclick="event.stopPropagation()">
                        <input id="card-numero" type="text" inputmode="numeric" maxlength="19"
                               placeholder="Número de la tarjeta"
                               class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"/>
                        <p id="err-card-numero" class="text-red-500 text-xs -mt-1 hidden">Solo se permiten números.</p>

                        <input id="card-nombre" type="text"
                               placeholder="Nombre del titular"
                               class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"/>
                        <p id="err-card-nombre" class="text-red-500 text-xs -mt-1 hidden">Solo se permiten letras.</p>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <input id="card-expiry" type="text" inputmode="numeric" maxlength="5"
                                       placeholder="Vencimiento"
                                       class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"/>
                                <p id="err-card-expiry" class="text-red-500 text-xs mt-1 hidden">Formato MM/AA.</p>
                            </div>
                            <div>
                                <input id="card-cvv" type="text" inputmode="numeric" maxlength="4"
                                       placeholder="Código de seguridad (CVV)"
                                       class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"/>
                                <p id="err-card-cvv" class="text-red-500 text-xs mt-1 hidden">3-4 dígitos.</p>
                            </div>
                        </div>

                        <input id="card-documento" type="text" inputmode="numeric"
                               placeholder="Documento del titular"
                               class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"/>
                        <p id="err-card-documento" class="text-red-500 text-xs -mt-1 hidden">Solo se permiten números.</p>

                        <div class="pt-1">
                            <p class="text-xs text-gray-500 mb-2">¿Quieres guardar este método de pago para alquileres futuros?</p>
                            <div class="flex gap-5">
                                <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                    <input type="radio" name="save-card" value="si" class="accent-red-500 w-4 h-4"/> Sí
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                    <input type="radio" name="save-card" value="no" class="accent-red-500 w-4 h-4" checked/> No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── 2) TRANSFERENCIA ── --}}
                <div id="block-transfer"
                     onclick="selectMethod('transfer')"
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
                        <input id="transfer-comprobante" type="text" inputmode="numeric"
                               placeholder="Número de comprobante"
                               class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"/>
                        <p id="err-transfer-comprobante" class="text-red-500 text-xs -mt-1 hidden">Solo se permiten números.</p>

                        <div class="pt-1">
                            <p class="text-xs text-gray-500 mb-2">¿Quieres guardar este método de pago para alquileres futuros?</p>
                            <div class="flex gap-5">
                                <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                    <input type="radio" name="save-transfer" value="si" class="accent-red-500 w-4 h-4"/> Sí
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                    <input type="radio" name="save-transfer" value="no" class="accent-red-500 w-4 h-4" checked/> No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── 3) NEQUI ── --}}
                <div id="block-nequi"
                     onclick="selectMethod('nequi')"
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
                                <input id="nequi-nombre" type="text" placeholder="Nombre"
                                       class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"/>
                                <p id="err-nequi-nombre" class="text-red-500 text-xs mt-1 hidden">Solo letras.</p>
                            </div>
                            <div>
                                <input id="nequi-apellido" type="text" placeholder="Apellido"
                                       class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"/>
                                <p id="err-nequi-apellido" class="text-red-500 text-xs mt-1 hidden">Solo letras.</p>
                            </div>
                        </div>
                        <input id="nequi-telefono" type="text" inputmode="numeric" maxlength="10"
                               placeholder="Numero de telefono"
                               class="field-input w-full border border-red-300 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-500 bg-white"/>
                        <p id="err-nequi-telefono" class="text-red-500 text-xs -mt-1 hidden">10 dígitos requeridos.</p>

                        <div class="pt-1">
                            <p class="text-xs text-gray-500 mb-2">¿Quieres guardar este método de pago para alquileres futuros?</p>
                            <div class="flex gap-5">
                                <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                    <input type="radio" name="save-nequi" value="si" class="accent-red-500 w-4 h-4"/> Sí
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                    <input type="radio" name="save-nequi" value="no" class="accent-red-500 w-4 h-4" checked/> No
                                </label>
                            </div>
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
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Fecha y hora de recogida</p>
                        <p class="font-semibold text-gray-800 text-sm mt-1">{{ $reserva->fecini->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-400">{{ $reserva->fecini->format('g:i a') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Fecha y hora de entrega</p>
                        <p class="font-semibold text-gray-800 text-sm mt-1">{{ $reserva->fecfin->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-400">{{ $reserva->fecfin->format('g:i a') }}</p>
                    </div>
                </div>

                {{-- IMAGEN --}}
                <div class="px-5 pt-5">
                    @php
                        $foto = $reserva->vehiculo->fotos->first();
                        $rutaImagen = $foto ? asset($foto->ruta) : 'https://placehold.co/600x280/ef4444/ffffff?text=' . urlencode($reserva->vehiculo->marca->nom . ' ' . $reserva->vehiculo->linea->nom);
                    @endphp
                    <img src="{{ $rutaImagen }}"
                         class="w-full rounded-xl object-cover aspect-[2.14/1]" alt="Vehículo"/>
                </div>

                {{-- INFO --}}
                <div class="px-5 pt-4 pb-2">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $reserva->vehiculo->marca->nom }}</h2>
                    <p class="text-gray-400 text-sm">{{ $reserva->vehiculo->linea->nom }} {{ $reserva->vehiculo->mod }}</p>
                    <p class="text-xs text-gray-400 mt-1">Incluye impuestos, seguro y asistencia en carretera.</p>
                </div>

                {{-- BADGES --}}
                <div class="px-5 py-3 flex items-center gap-3 text-xs text-gray-500 border-t border-gray-100">
                    <span class="flex items-center gap-1">📍 {{ $reserva->vehiculo->ciudad->nom }}</span>
                    <span class="text-gray-200">|</span>
                    <span class="flex items-center gap-1">👤 {{ $reserva->vehiculo->pas }} Personas</span>
                    <span class="text-gray-200">|</span>
                    <span class="flex items-center gap-1">⭐ 4.8 / 5 (41 reseñas)</span>
                </div>

                {{-- PRECIO --}}
                <div class="px-5 py-4 border-t border-gray-100">
                    <p class="text-3xl font-bold text-gray-900">
                        ${{ number_format($monto, 0, ',', '.') }}
                        <span class="text-base font-normal text-gray-400">COP Total</span>
                    </p>
                </div>

                {{-- BOTÓN --}}
                <div class="px-5 pb-5">
                    <button
                        id="btn-continuar"
                        onclick="procesarPago()"
                        class="block w-full text-center border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-bold py-3.5 rounded-xl tracking-widest uppercase text-sm transition-all duration-200"
                    >
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
</style>

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
                    monto: "{{ $monto }}",
                    detalles: detalles
                })
            });

            const result = await response.json();

            if (result.success) {
                alert('¡Excelente! Información guardada. Procediendo al pago...');
                window.location.href = "{{ route('checkout', ['monto' => $monto]) }}?reserva_id={{ $reserva_id }}";
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
        el.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').substring(0, max || 999);
        });
    }
    function soloLetras(id) {
        const el = document.getElementById(id);
        el.addEventListener('keypress', e => blockInvalid(e, /[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/));
        el.addEventListener('input', function () {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/g, '');
        });
    }

    /* ─── APLICAR VALIDACIONES ────────────────────────────── */
    soloNumeros('card-numero', 16);
    document.getElementById('card-numero').addEventListener('input', function () {
        let raw = this.value.replace(/\D/g, '').substring(0, 16);
        this.value = raw.match(/.{1,4}/g)?.join(' ') ?? raw;
    });
    soloLetras('card-nombre');
    soloNumeros('card-expiry', 4);
    document.getElementById('card-expiry').addEventListener('input', function () {
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
</script>

</x-page>