<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->string('provider')->nullable()->after('fecha_pago');
            $table->string('external_payment_id')->nullable()->after('provider');
            $table->string('external_reference')->nullable()->after('external_payment_id');
            $table->string('status_detail')->nullable()->after('external_reference');
            $table->json('webhook_payload')->nullable()->after('detalle');
            $table->timestamp('approved_at')->nullable()->after('webhook_payload');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn([
                'provider',
                'external_payment_id',
                'external_reference',
                'status_detail',
                'webhook_payload',
                'approved_at',
            ]);
        });
    }
};
