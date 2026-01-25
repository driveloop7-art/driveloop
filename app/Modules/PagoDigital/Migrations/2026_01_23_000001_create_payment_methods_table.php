<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., 'card', 'pse', 'nequi'
            $table->string('label'); // e.g., 'Tarjeta de Crédito', 'PSE', 'Nequi'
            $table->timestamps();
        });

        // Insert default values
        DB::table('payment_methods')->insert([
            ['name' => 'card', 'label' => 'Tarjeta de Crédito/Débito', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'pse', 'label' => 'Transferencia Bancaria (PSE)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'nequi', 'label' => 'Nequi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
