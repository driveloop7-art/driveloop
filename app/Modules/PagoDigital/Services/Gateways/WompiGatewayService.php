<?php

namespace App\Modules\PagoDigital\Services\Gateways;

use Illuminate\Support\Str;

class WompiGatewayService implements PaymentGatewayInterface
{
    public function createPayment(array $data): array
    {
        // BASE TEMPORAL:
        // Aquí luego puedes generar la referencia, la firma de integridad
        // y redirigir a Widget/Web Checkout de Wompi.

        return [
            'status' => 'pending',
            'reference' => 'WOMPI-' . strtoupper(Str::random(10)),
            'external_payment_id' => null,
            'external_reference' => $data['reserva_id'],
            'status_detail' => 'awaiting_wompi_confirmation',
            'message' => 'Pago enviado a Wompi. Pendiente de confirmación.',
        ];
    }
}