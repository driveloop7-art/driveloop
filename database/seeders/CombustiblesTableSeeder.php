<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CombustiblesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('combustibles')->insert([
            ['des' => 'Gasolina'],
            ['des' => 'Diésel (ACPM)'],
            ['des' => 'Gas'],
            ['des' => 'Eléctrico'],
            ['des' => 'Híbrido'],
            ['des' => 'Hidrógeno'],
            ['des' => 'Otro']
        ]);
    }
}