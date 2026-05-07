<?php

namespace App\Modules\PagoDigital\Services\Gateways;

interface PaymentGatewayInterface
{
    public function createPayment(array $data): array;
}