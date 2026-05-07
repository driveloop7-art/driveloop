<?php

namespace App\Modules\PagoDigital\Services\Gateways;

use Illuminate\Support\Str;

class MercadoPagoGatewayService implements PaymentGatewayInterface
{
    public function createPayment(array $data): array
    {
        // BASE TEMPORAL:
        // Aquí después conectarás el SDK oficial de Mercado Pago.
        // Por ahora devolvemos pending para no romper el flujo.

        return [
            'status' => 'pending',
            'reference' => 'MP-' . strtoupper(Str::random(10)),
            'external_payment_id' => null,
            'external_reference' => $data['reserva_id'],
            'status_detail' => 'awaiting_mercadopago_confirmation',
            'message' => 'Pago enviado a Mercado Pago. Pendiente de confirmación.',
        ];
    }
}