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
            ['des' => 'AMAZONAS'],
            ['des' => 'ANTIOQUIA'],
            ['des' => 'ARAUCA'],
            ['des' => 'ATLANTICO'],
            ['des' => 'BOGOTA'],
            ['des' => 'BOLIVAR'],
            ['des' => 'BOYACA'],
            ['des' => 'CALDAS'],
            ['des' => 'CAQUETA'],
            ['des' => 'CASANARE'],
            ['des' => 'CAUCA'],
            ['des' => 'CESAR'],
            ['des' => 'CHOCO'],
            ['des' => 'CORDOBA'],
            ['des' => 'CUNDINAMARCA'],
            ['des' => 'GUAINIA'],
            ['des' => 'GUAVIARE'],
            ['des' => 'HUILA'],
            ['des' => 'LA GUAJIRA'],
            ['des' => 'MAGDALENA'],
            ['des' => 'META'],
            ['des' => 'NARIÑO'],
            ['des' => 'NORTE DE SANTANDER'],
            ['des' => 'PUTUMAYO'],
            ['des' => 'QUINDIO'],
            ['des' => 'RISARALDA'],
            ['des' => 'SAN ANDRES'],
            ['des' => 'SANTANDER'],
            ['des' => 'SUCRE'],
            ['des' => 'TOLIMA'],
            ['des' => 'VALLE DEL CAUCA'],
            ['des' => 'VAUPES'],
            ['des' => 'VICHADA']
        ]);
    }
}