<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EstadosTicketTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estados_ticket')->insert([
            'des' => 'Abierto'
        ]);
        DB::table('estados_ticket')->insert([
            'des' => 'En proceso'
        ]);
        DB::table('estados_ticket')->insert([
            'des' => 'Cerrado'
        ]);
    }
}