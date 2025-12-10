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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cod')->nullable()->unique();
            $table->string('nom', 80);
            $table->string('ape', 80);
            $table->string('email')->unique();
            $table->string('tel', 30)->nullable();
            $table->date('fecnac')->nullable();
            $table->string('lic', 30)->nullable();
            $table->dateTime('fecreg')->useCurrent();
            $table->string('numcue', 34)->nullable();
            $table->unsignedTinyInteger('codrol')->index('codrol')->default(1);
            $table->unsignedBigInteger('numdir')->nullable()->index('numdir');
            $table->unsignedInteger('codciu')->nullable()->index('codciu');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
