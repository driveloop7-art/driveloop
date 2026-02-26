<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->foreign(['codtic'], 'scores_tickets_fk')->references(['cod'])->on('tickets')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['idques'], 'scores_questions_fk')->references(['id'])->on('questions')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->dropForeign('scores_tickets_fk');
            $table->dropForeign('scores_questions_fk');
        });
    }
};
