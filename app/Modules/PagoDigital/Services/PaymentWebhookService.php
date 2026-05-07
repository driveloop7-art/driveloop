<?php

namespace App\Modules\PagoDigital\Services;

use App\Models\MER\Pago;
use Illuminate\Support\Facades\Log;

class PaymentWebhookService
{
    public function handle(string $provider, array $payload): array
    {
        Log::info('Webhook recibido', [
            'provider' => $provider,
            'payload' => $payload,
        ]);

        $reference = $payload['reference']
            ?? $payload['data']['reference']
            ?? $payload['external_reference']
            ?? null;

        if (!$reference) {
            return [
                'ok' => true,
                'message' => 'Webhook recibido sin referencia interna.',
            ];
        }

        $pago = Pago::where('referencia', $reference)
            ->orWhere('external_reference', $reference)
            ->first();

        if (!$pago) {
            return [
                'ok' => true,
                'message' => 'No se encontró pago asociado a la referencia.',
            ];
        }

        $statusRecibido = $payload['status']
            ?? $payload['data']['status']
            ?? 'pending';

        $estadoNormalizado = $this->normalizarEstado($statusRecibido);

        $pago->estado = $estadoNormalizado;
        $pago->webhook_payload = $payload;

        if ($estadoNormalizado === 'aprobado') {
            $pago->approved_at = now();
        }

        $pago->save();

        return [
            'ok' => true,
            'message' => 'Webhook procesado correctamente.',
        ];
    }

    private function normalizarEstado(?string $estado): string
    {
        $estado = strtolower(trim((string) $estado));

        return match ($estado) {
            'approved', 'aprobado' => 'aprobado',
            'pending', 'pendiente' => 'pendiente',
            'rejected', 'rechazado', 'failed', 'fallido' => 'rechazado',
            default => 'pendiente',
        };
    }
}