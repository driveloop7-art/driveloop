<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TiposDocUsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_doc_usuario')->insert([
            ['id' => 1, 'nom' => 'Cédula de Ciudadanía', 'des' => 'Documento de identidad colombiano'],
            ['id' => 2, 'nom' => 'Licencia de Conducir', 'des' => 'Licencia de conducir colombiana'],
            ['id' => 3, 'nom' => 'Pasaporte', 'des' => 'Pasaporte colombiano'],
            ['id' => 4, 'nom' => 'Otro', 'des' => 'Otro documento de identidad']
        ]);
    }
}