<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TiposDocVehiculoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_doc_vehiculo')->insert([
            ['nom' => 'Tarjeta de propiedad', 'des' => 'Identificación legal del vehículo y propietario, autorizando su circulación.'],
            ['nom' => 'SOAT ', 'des' => 'Seguro obligatorio contra accidentes de transito'],
            ['nom' => 'Técnico-Mecánica ', 'des' => 'Certificado de Revisión Técnico-Mecánica y de Gases']
        ]);
    }
}