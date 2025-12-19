<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ClasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clases')->insert([
            ['des' => 'Automóvil'],
            ['des' => 'Campero'],
            ['des' => 'Camioneta']
        ]);
    }
}