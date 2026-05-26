<?php

namespace App\Modules\PagoDigital\Services\Gateways;

use Illuminate\Support\Str;

class SimulatedGatewayService implements PaymentGatewayInterface
{
    public function createPayment(array $data): array
    {
        $estadoPago = 'aprobado';
        $esTarjetaNoValida = false;

        switch ($data['metodo_pago']) {
            case 'card':
                $cardNum = preg_replace('/\D/', '', $data['card_numero'] ?? '');
                $cardName = strtoupper(trim($data['card_nombre'] ?? ''));
                $cardExpiry = trim($data['card_expiry'] ?? '');
                $cardCvv = trim($data['card_cvv'] ?? '');

                $validCards = [
                    ['num' => '4556528154470678', 'name' => 'SEBASTIAN MANCILLA', 'exp' => '12/30', 'cvv' => '123'],
                    ['num' => '4556978441587943', 'name' => 'SANDINO MOLINETT', 'exp' => '08/29', 'cvv' => '456'],
                    ['num' => '4556418784186771', 'name' => 'JEFFERSON PUPIALES', 'exp' => '10/28', 'cvv' => '789'],
                    ['num' => '4556438294617933', 'name' => 'JEINS ZAPATA', 'exp' => '04/31', 'cvv' => '111'],
                    ['num' => '4556579272210850', 'name' => 'RUBEN DARIO PAZ', 'exp' => '06/27', 'cvv' => '222'],
                    ['num' => '5223767193761214', 'name' => 'EDGAR SALAMANCA', 'exp' => '05/29', 'cvv' => '333'],
                    ['num' => '5223319768269635', 'name' => 'JUAN ESTEBAN VELEZ', 'exp' => '11/30', 'cvv' => '444'],
                    ['num' => '5223552080997414', 'name' => 'JOHAN PIEDRAHITA', 'exp' => '09/28', 'cvv' => '555'],
                    ['num' => '5223573343124224', 'name' => 'EVANNY VALLECILLA', 'exp' => '02/31', 'cvv' => '666'],
                    ['num' => '5223337239995349', 'name' => 'NICOLAS GUTIERREZ', 'exp' => '07/27', 'cvv' => '777']
                ];

                $matched = false;
                foreach ($validCards as $card) {
                    if ($card['num'] === $cardNum && 
                        $card['name'] === $cardName && 
                        $card['exp'] === $cardExpiry && 
                        $card['cvv'] === $cardCvv) {
                        $matched = true;
                        break;
                    }
                }

                if ($matched) {
                    $estadoPago = 'aprobado';
                } else {
                    $estadoPago = 'rechazado';
                    $esTarjetaNoValida = true;
                }
                break;

            case 'transfer':
                $estadoPago = 'pendiente';
                break;

            case 'nequi':
                $telefono = preg_replace('/\D/', '', $data['nequi_telefono'] ?? '');

                if ($telefono === '') {
                    $estadoPago = 'rechazado';
                } else {
                    $ultimoDigito = (int) substr($telefono, -1);
                    $estadoPago = ($ultimoDigito % 2 === 0) ? 'aprobado' : 'rechazado';
                }
                break;

            default:
                $estadoPago = 'rechazado';
                break;
        }

        return [
            'status' => $estadoPago,
            'reference' => 'TXN-' . strtoupper(Str::random(12)),
            'external_payment_id' => 'PAY-' . strtoupper(Str::random(12)),
            'external_reference' => $data['reserva_id'],
            'status_detail' => $estadoPago === 'aprobado' ? 'aprobado_exitoso' : ($esTarjetaNoValida ? 'fondos_insuficientes' : 'procesado'),
            'message' => match ($estadoPago) {
                'aprobado' => 'Transacción aprobada exitosamente.',
                'pendiente' => 'Transacción en proceso de verificación por la entidad financiera.',
                'rechazado' => $esTarjetaNoValida 
                    ? 'Transacción rechazada. Fondos insuficientes o tarjeta no autorizada.'
                    : 'Transacción rechazada por la entidad financiera.',
                default => 'Resultado de transacción procesado.',
            },
        ];
    }
}