<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('paymentForm', () => ({
            metodo_pago: null,
            init() {
                console.log('Payment form initialized');
                // Watch for changes to metodo_pago
                this.$watch('metodo_pago', value => {
                    console.log('Payment method changed to:', value);
                });
            },
            validateForm() {
                console.log('Validating form, current payment method:', this.metodo_pago);

                if (!this.metodo_pago) {
                    alert('Por favor, seleccione un método de pago.');
                    return;
                }

                let fields = [];
                if (this.metodo_pago === 'card') {
                    fields = [{
                            name: 'card_number',
                            label: 'Número de la tarjeta'
                        },
                        {
                            name: 'card_holder',
                            label: 'Nombre del titular'
                        },
                        {
                            name: 'card_expiry',
                            label: 'Vencimiento'
                        },
                        {
                            name: 'card_cvv',
                            label: 'Código de seguridad (CVV)'
                        },
                        {
                            name: 'card_doc',
                            label: 'Documento del titular'
                        }
                    ];
                } else if (this.metodo_pago === 'pse') {
                    fields = [{
                            name: 'pse_name',
                            label: 'Nombre'
                        },
                        {
                            name: 'pse_lastname',
                            label: 'Apellido'
                        },
                        {
                            name: 'pse_doc',
                            label: 'Documento del titular'
                        },
                        {
                            name: 'pse_phone',
                            label: 'Número celular'
                        },
                        {
                            name: 'pse_bank',
                            label: 'Banco'
                        }
                    ];
                } else if (this.metodo_pago === 'nequi') {
                    fields = [{
                            name: 'nequi_name',
                            label: 'Nombre'
                        },
                        {
                            name: 'nequi_lastname',
                            label: 'Apellido'
                        },
                        {
                            name: 'nequi_phone',
                            label: 'Número de teléfono'
                        }
                    ];
                }

                for (let field of fields) {
                    let input = document.querySelector(`[name='${field.name}']`);
                    if (input && !input.value.trim()) {
                        console.log('Validation failed for field:', field.name);
                        alert(`El campo '${field.label}' es obligatorio.`);
                        input.focus();
                        return;
                    }
                }

                console.log('Validation passed, submitting form');
                // If all valid, submit the form via the native DOM element
                this.$el.submit();
            }
        }));
    });
</script>