<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosReservaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estados_reserva')->insert([
            ['des' => 'Pendiente a iniciar'],
            ['des' => 'En Proceso'],
            ['des' => 'Finalizada'],
        ]);
    }
}
