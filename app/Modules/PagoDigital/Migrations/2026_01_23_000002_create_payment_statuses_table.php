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
        Schema::create('payment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., 'pending', 'approved', 'rejected'
            $table->string('label'); // e.g., 'Pendiente', 'Aprobado', 'Rechazado'
            $table->timestamps();
        });

        // Insert default values
        DB::table('payment_statuses')->insert([
            ['name' => 'pendiente', 'label' => 'Pendiente', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'aceptado', 'label' => 'Aprobado', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'rechazado', 'label' => 'Rechazado', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'fallido', 'label' => 'Fallido', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_statuses');
    }
};
