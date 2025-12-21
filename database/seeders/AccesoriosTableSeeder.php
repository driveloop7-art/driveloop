<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AccesoriosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accesorios')->insert([
            ['des' => 'Aire acondicionado'],
            ['des' => 'Airbag'],
            ['des' => 'Bluetooth'],
            ['des' => 'GPS'],
            ['des' => 'Cargador USB'],
            ['des' => 'Cámara de reversa'],
            ['des' => 'Sensor de parqueo']
        ]);
    }
}