document.addEventListener('DOMContentLoaded', () => {
    // Elementos DOM
    const btns = document.querySelectorAll('.payment-method-btn');
    const sections = document.querySelectorAll('.payment-form-section');
    const inputMetodoPago = document.getElementById('metodo_pago');
    const inputProvider = document.getElementById('payment_provider');

    // 1. Selector de Pestañas
    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            btns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            sections.forEach(s => s.classList.add('hidden'));

            const method = btn.dataset.method;
            const provider = btn.dataset.provider;

            inputMetodoPago.value = method;
            inputProvider.value = provider;

            if (method === 'card') {
                document.getElementById('form-card').classList.remove('hidden');
            } else if (method === 'nequi') {
                document.getElementById('form-nequi').classList.remove('hidden');
            }
            hideError();
        });
    });

    // Trigger click en Tarjetas por defecto
    const defaultBtn = document.querySelector('.payment-method-btn[data-method="card"]');
    if (defaultBtn) defaultBtn.click();

    // 2. Sincronización e inputs de Tarjeta
    const numInput = document.getElementById('card_numero');
    const inputVisa = document.getElementById('input-visa-logo');
    const inputMaster = document.getElementById('input-mastercard-logo');

    if (numInput) {
        numInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 16) value = value.slice(0, 16);

            let formatted = value.match(/.{1,4}/g)?.join(' ') || '';
            e.target.value = formatted;

            // Resaltar logos de marca
            if (value.startsWith('4')) {
                inputVisa.style.opacity = '1';
                inputMaster.style.opacity = '0.1';
            } else if (value.startsWith('5')) {
                inputVisa.style.opacity = '0.1';
                inputMaster.style.opacity = '1';
            } else {
                inputVisa.style.opacity = '0.25';
                inputMaster.style.opacity = '0.25';
            }
        });
    }

    const nameInput = document.getElementById('card_nombre');
    if (nameInput) {
        nameInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/[^A-Za-z\s]/g, '').toUpperCase();
            e.target.value = value;
        });
    }

    const expiryInput = document.getElementById('card_expiry');
    if (expiryInput) {
        expiryInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) value = value.slice(0, 4);

            if (value.length > 2) {
                value = value.slice(0, 2) + '/' + value.slice(2);
            }
            e.target.value = value;
        });
    }

    const cvvInput = document.getElementById('card_cvv');
    if (cvvInput) {
        cvvInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 3) value = value.slice(0, 3);
            e.target.value = value;
        });
    }

    // 3. Validaciones de envío de formulario
    const form = document.getElementById('form-pago');
    const errorBox = document.getElementById('payment-error-box');
    const errorMessage = document.getElementById('payment-error-message');

    function showError(msg) {
        errorMessage.textContent = msg;
        errorBox.classList.remove('hidden');
        errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function hideError() {
        errorBox.classList.add('hidden');
    }

    // Validador Luhn
    function luhnCheck(num) {
        let sum = 0;
        let numDigits = num.length;
        let parity = numDigits % 2;
        for (let i = 0; i < numDigits; i++) {
            let digit = parseInt(num.charAt(i), 10);
            if (i % 2 === parity) {
                digit *= 2;
                if (digit > 9) digit -= 9;
            }
            sum += digit;
        }
        return (sum % 10 === 0);
    }

    form.addEventListener('submit', (e) => {
        hideError();

        const activeMethod = inputMetodoPago.value;

        if (activeMethod === 'card') {
            const rawNum = numInput.value.replace(/\s+/g, '');
            const nameVal = nameInput.value.trim();
            const expVal = expiryInput.value.trim();
            const cvvVal = cvvInput.value.trim();

            if (!rawNum || !nameVal || !expVal || !cvvVal) {
                e.preventDefault();
                showError('Por favor, completa todos los campos de la tarjeta.');
                return;
            }

            if (rawNum.length !== 16) {
                e.preventDefault();
                showError('El número de tarjeta debe tener exactamente 16 dígitos.');
                return;
            }

            if (!luhnCheck(rawNum)) {
                e.preventDefault();
                showError('El número de tarjeta no es válido.');
                return;
            }

            if (!/^\d{2}\/\d{2}$/.test(expVal)) {
                e.preventDefault();
                showError('El formato de vencimiento debe ser MM/AA.');
                return;
            }

            const parts = expVal.split('/');
            const month = parseInt(parts[0], 10);
            const year = parseInt(parts[1], 10);

            if (month < 1 || month > 12) {
                e.preventDefault();
                showError('El mes de vencimiento debe estar entre 01 y 12.');
                return;
            }

            const now = new Date();
            const currentYear = now.getFullYear() % 100;
            const currentMonth = now.getMonth() + 1;

            if (year < currentYear || (year === currentYear && month < currentMonth)) {
                e.preventDefault();
                showError('La tarjeta de crédito se encuentra vencida.');
                return;
            }

            if (cvvVal.length !== 3) {
                e.preventDefault();
                showError('El código CVV debe tener exactamente 3 dígitos.');
                return;
            }

            // Validar contra las 10 tarjetas permitidas del equipo (coincidencia de todos los campos)
            const devCards = [
                { num: '4556528154470678', name: 'SEBASTIAN MANCILLA', exp: '12/30', cvv: '123' },
                { num: '4556978441587943', name: 'SANDINO MOLINETT', exp: '08/29', cvv: '456' },
                { num: '4556418784186771', name: 'JEFFERSON PUPIALES', exp: '10/28', cvv: '789' },
                { num: '4556438294617933', name: 'JEINS ZAPATA', exp: '04/31', cvv: '111' },
                { num: '4556579272210850', name: 'RUBEN DARIO PAZ', exp: '06/27', cvv: '222' },
                { num: '5223767193761214', name: 'EDGAR SALAMANCA', exp: '05/29', cvv: '333' },
                { num: '5223319768269635', name: 'JUAN ESTEBAN VELEZ', exp: '11/30', cvv: '444' },
                { num: '5223552080997414', name: 'JOHAN PIEDRAHITA', exp: '09/28', cvv: '555' },
                { num: '5223573343124224', name: 'EVANNY VALLECILLA', exp: '02/31', cvv: '666' },
                { num: '5223337239995349', name: 'NICOLAS GUTIERREZ', exp: '07/27', cvv: '777' }
            ];

            const matchedCard = devCards.find(c => c.num === rawNum);

            if (!matchedCard ||
                matchedCard.name !== nameVal.trim().toUpperCase() ||
                matchedCard.exp !== expVal.trim() ||
                matchedCard.cvv !== cvvVal.trim()) {
                e.preventDefault();
                showError('Transacción rechazada. Fondos insuficientes o tarjeta no autorizada.');
                return;
            }
        } else if (activeMethod === 'nequi') {
            const telInput = document.getElementById('nequi_telefono');
            const telVal = telInput.value.replace(/\s+/g, '');

            if (!telVal) {
                e.preventDefault();
                showError('Por favor, ingresa tu número celular de Nequi.');
                return;
            }
            if (telVal.length !== 10 || !/^3\d{9}$/.test(telVal)) {
                e.preventDefault();
                showError('El número celular Nequi debe tener 10 dígitos y empezar con 3.');
                return;
            }
        }

        // Si las validaciones fueron exitosas, se previene el envío natural para simular la transacción segura
        e.preventDefault();

        const modal = document.getElementById('processing-modal');
        const card = document.getElementById('processing-modal-card');
        const stepText = document.getElementById('processing-step-title');
        const progressBar = document.getElementById('processing-bar');

        if (modal && card && stepText && progressBar) {
            // Mostrar contenedor del modal
            modal.classList.remove('hidden');

            // Pequeño retardo para disparar transiciones de CSS (escala y opacidad)
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 50);

            // Pasos del procesamiento bancario simulado
            const steps = [
                { text: 'CONECTANDO CON LA ENTIDAD FINANCIERA...', progress: 25, time: 1000 },
                { text: 'VERIFICANDO CREDENCIALES DE PAGO...', progress: 50, time: 1200 },
                { text: 'PROCESANDO TRANSACCIÓN SEGURA...', progress: 75, time: 1200 },
                { text: 'GENERANDO RESERVA...', progress: 100, time: 800 }
            ];

            let currentStep = 0;

            function runSteps() {
                if (currentStep < steps.length) {
                    const step = steps[currentStep];
                    stepText.textContent = step.text;
                    progressBar.style.width = `${step.progress}%`;
                    currentStep++;
                    setTimeout(runSteps, step.time);
                } else {
                    // Envío programático real (no gatilla el addEventListener de nuevo)
                    form.submit();
                }
            }

            runSteps();
        } else {
            // Fallback directo por seguridad si los elementos no se encuentran
            form.submit();
        }
    });
});
