<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso - DriveLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-lg text-center">
        <div class="mb-6 text-green-500">
            <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">¡Gracias por tu compra!</h1>
        <p class="text-gray-600 mb-8">Tu pago ha sido procesado exitosamente.</p>

        @if(isset($reserva_id))
        <button onclick="confirmarYDescargar('{{ $reserva_id }}')"
            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 mb-4 block text-center">
            Confirmar y Descargar Contrato
        </button>
        @endif

        <a href="/" class="w-full border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-3 px-6 rounded-xl transition duration-200 block text-center">
            Volver al Inicio
        </a>
    </div>

    <script>
        async function confirmarYDescargar(reservaId) {
            try {
                // 1. Fetch previo para confirmar la reserva
                const response = await fetch(`/contrato/confirmar/${reservaId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    console.log('Reserva confirmada');
                } else {
                    console.error('Error al confirmar reserva');
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                // 2. Abrir el PDF en una pestaña nueva (siempre intentamos descargar)
                window.open('/contrato/descargar/' + reservaId, '_blank');
            }
        }
    </script>
</body>

</html>