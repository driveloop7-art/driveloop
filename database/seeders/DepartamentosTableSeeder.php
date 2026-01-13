<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DepartamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departamentos')->insert([
            ['des' => 'ANTIOQUIA'],
            ['des' => 'ATLANTICO'],
            ['des' => 'BOGOTA'],
            ['des' => 'BOLIVAR'],
            ['des' => 'BOYACA'],
            ['des' => 'CALDAS'],
            ['des' => 'CAQUETA'],
            ['des' => 'CAUCA'],
            ['des' => 'CESAR'],
            ['des' => 'CORDOBA'],
            ['des' => 'CUNDINAMARCA'],
            ['des' => 'CHOCO'],
            ['des' => 'HUILA'],
            ['des' => 'LA GUAJIRA'],
            ['des' => 'MAGDALENA'],
            ['des' => 'META'],
            ['des' => 'NARIÑO'],
            ['des' => 'NORTE DE SANTANDER'],
            ['des' => 'QUINDIO'],
            ['des' => 'RISARALDA'],
            ['des' => 'SANTANDER'],
            ['des' => 'SUCRE'],
            ['des' => 'TOLIMA'],
            ['des' => 'VALLE DEL CAUCA'],
            ['des' => 'ARAUCA'],
            ['des' => 'CASANARE'],
            ['des' => 'PUTUMAYO'],
            ['des' => 'SAN ANDRES'],
            ['des' => 'AMAZONAS'],
            ['des' => 'GUAINIA'],
            ['des' => 'GUAVIARE'],
            ['des' => 'VAUPES'],
            ['des' => 'VICHADA']
        ]);
    }
}