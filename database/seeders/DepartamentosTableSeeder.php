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
            ['cod' => 1, 'des' => 'AMAZONAS'],
            ['cod' => 2, 'des' => 'ANTIOQUIA'],
            ['cod' => 3, 'des' => 'ARAUCA'],
            ['cod' => 4, 'des' => 'ATLANTICO'],
            ['cod' => 5, 'des' => 'BOGOTA'],
            ['cod' => 6, 'des' => 'BOLIVAR'],
            ['cod' => 7, 'des' => 'BOYACA'],
            ['cod' => 8, 'des' => 'CALDAS'],
            ['cod' => 9, 'des' => 'CAQUETA'],
            ['cod' => 10, 'des' => 'CASANARE'],
            ['cod' => 11, 'des' => 'CAUCA'],
            ['cod' => 12, 'des' => 'CESAR'],
            ['cod' => 13, 'des' => 'CHOCO'],
            ['cod' => 14, 'des' => 'CORDOBA'],
            ['cod' => 15, 'des' => 'CUNDINAMARCA'],
            ['cod' => 16, 'des' => 'GUAINIA'],
            ['cod' => 17, 'des' => 'GUAVIARE'],
            ['cod' => 18, 'des' => 'HUILA'],
            ['cod' => 19, 'des' => 'LA GUAJIRA'],
            ['cod' => 20, 'des' => 'MAGDALENA'],
            ['cod' => 21, 'des' => 'META'],
            ['cod' => 22, 'des' => 'NARIÑO'],
            ['cod' => 23, 'des' => 'NORTE DE SANTANDER'],
            ['cod' => 24, 'des' => 'PUTUMAYO'],
            ['cod' => 25, 'des' => 'QUINDIO'],
            ['cod' => 26, 'des' => 'RISARALDA'],
            ['cod' => 27, 'des' => 'SAN ANDRES'],
            ['cod' => 28, 'des' => 'SANTANDER'],
            ['cod' => 29, 'des' => 'SUCRE'],
            ['cod' => 30, 'des' => 'TOLIMA'],
            ['cod' => 31, 'des' => 'VALLE DEL CAUCA'],
            ['cod' => 32, 'des' => 'VAUPES'],
            ['cod' => 33, 'des' => 'VICHADA'],
        ]);
    }
}