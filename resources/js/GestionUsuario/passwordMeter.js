// Función para validar nombres y apellidos
function validarTexto(texto) {
    if (!texto || texto.trim().length === 0) {
        return "Este campo es obligatorio.";
    }
    if (texto.trim().length < 2) {
        return "Debe tener al menos 2 caracteres.";
    }
    // Regex para solo letras (incluye acentos y ñ) y espacios
    const regexLetras = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
    if (!regexLetras.test(texto)) {
        return "Solo se permiten letras y espacios.";
    }
    return null; // Retorna null si no hay errores (es válido)
}

export default function () {
    return {
        nombre: '',
        apellido: '',
        email: '',
        password: '',
        password_confirmation: '',
        conditions: {
            length: false,
            uppercase: false,
            number: false,
            special: false,
        },
        strength: 'none',
        errors: {
            nombre: null,
            apellido: null,
        },
        checkNombre() {
            this.errors.nombre = validarTexto(this.nombre);
        },
        checkApellido() {
            this.errors.apellido = validarTexto(this.apellido);
        },

        checkPassword() {
            this.conditions.length = this.password.length >= 8;
            this.conditions.uppercase = /[A-Z]/.test(this.password);
            this.conditions.number = /[0-9]/.test(this.password);
            this.conditions.special = /[!@#\$%\^&\*\(\),\.?":\{\}\|<>\-_\+=\/\\\[\]~;']/.test(this.password);

            let metCount = Object.values(this.conditions).filter(Boolean).length;

            if (this.password.length === 0) {
                this.strength = 'none';
            } else if (metCount <= 2) {
                this.strength = 'low';
            } else if (metCount === 3) {
                this.strength = 'medium';
            } else if (metCount === 4) {
                this.strength = 'high';
            }
        },

        get allConditionsMet() {
            const nombreValido = this.errors.nombre === null;
            const apellidoValido = this.errors.apellido === null;
            const passwordValida = this.conditions.length && this.conditions.uppercase && this.conditions.number && this.conditions.special;
            return nombreValido && apellidoValido && passwordValida;
        },

        async submitForm(e) {
            // 1. Detenemos el envío automático para poder hacer verificaciones (incluso asíncronas)
            e.preventDefault();

            // 2. Si las condiciones de la contraseña no se cumplen, no hacemos nada
            if (!this.allConditionsMet) {
                return;
            }

            if (validarTexto(this.nombre) != null) {
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'nombre-invalido-modal' }));
                return;
            }
            if (validarTexto(this.apellido) != null) {
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'apellido-invalido-modal' }));
                return;
            }
            // 3. Verificamos que las contraseñas coincidan
            if (this.password !== this.password_confirmation) {
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'password-mismatch-modal' }));
                return;
            }

            // 4. Verificamos si el correo existe mediante la ruta en Laravel
            try {
                const tokenElement = document.querySelector('meta[name="csrf-token"]');
                const token = tokenElement ? tokenElement.getAttribute('content') : '';

                const response = await fetch('/api/check-email', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ email: this.email })
                });

                // Si la ruta existe y devuelve JSON, lo leemos
                if (response.ok) {
                    const data = await response.json();

                    // Si el servidor responde: { "exists": true }
                    if (data.exists) {
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'email-exists-modal' }));
                        return; // Detenemos aquí, el formulario no se envía
                    }
                }

                // Si llegamos hasta aquí, todo está perfecto. Enviamos el formulario "manualmente"
                e.target.submit();

            } catch (error) {
                // Si la ruta no existe todavía o hay error de red, igual enviamos el formulario por precaución
                console.error("Error validando el correo:", error);
                e.target.submit();
            }
        }
    };
}
