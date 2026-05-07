<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

public function up(): void {

if (!Schema::hasColumn('resenas', 'puntuacion')) {
Schema::table('resenas', function (Blueprint $table) {
$table->tinyInteger('puntuacion')->unsigned()->default(5)->after('codres');
});
}

if (!Schema::hasColumn('resenas', 'respuesta_propietario')) {
Schema::table('resenas', function (Blueprint $table) {
$table->string('respuesta_propietario', 500)->nullable()->after('des');
});
}

if (!Schema::hasColumn('resenas', 'estado')) {
Schema::table('resenas', function (Blueprint $table) {
$table->enum('estado', ['visible', 'reportada', 'oculta'])->default('visible')->after('respuesta_propietario');
});
}

}

public function down(): void {
Schema::table('resenas', function (Blueprint $table) {
if (Schema::hasColumn('resenas', 'puntuacion')) { $table->dropColumn('puntuacion'); }
if (Schema::hasColumn('resenas', 'respuesta_propietario')) { $table->dropColumn('respuesta_propietario'); }
if (Schema::hasColumn('resenas', 'estado')) { $table->dropColumn('estado'); }
});
}

};