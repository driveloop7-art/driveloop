document.addEventListener('DOMContentLoaded', function () {
    const placaInput = document.getElementById('placa');
    const placaErrorBox = document.getElementById('placaError');

    if (placaInput) {
        placaInput.addEventListener('input', (e) => {
            // Convertir a mayúsculas y eliminar caracteres que no sean alfanuméricos
            let val = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (val !== e.target.value) {
                e.target.value = val;
            }

            // Validar que la placa tenga exactamente 6 caracteres alfanuméricos
            // const isValid = /^[A-Z0-9]{6}$/.test(val);
            const isValid = /^[A-Z]{3}[0-9]{3}$/.test(val);

            // Mostrar u ocultar mensaje de error
            if (placaErrorBox) {
                if (val.length > 0 && !isValid) {
                    placaErrorBox.textContent = 'La placa debe iniciar con 3 letras y terminar con 3 números.';
                    placaErrorBox.style.display = 'block';
                } else {
                    placaErrorBox.style.display = 'none';
                }
            }

            // Despachar un evento personalizado para que otras partes del código sepan si es válida
            placaInput.dispatchEvent(new CustomEvent('placaValidated', { detail: { isValid } }));
        });

        // Forzar la validación inicial en caso de que haya datos precargados
        placaInput.dispatchEvent(new Event('input'));
    }
});
