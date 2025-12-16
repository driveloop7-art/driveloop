<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PrioridadesTicketTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prioridades_ticket')->insert([
            'des' => 'Normal'
        ]);
        DB::table('prioridades_ticket')->insert([
            'des' => 'Urgente'
        ]);
    }
}