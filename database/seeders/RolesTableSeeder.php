<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'des' => 'Usuario'
        ]);
        DB::table('roles')->insert([
            'des' => 'Administrador'
        ]);
    }
}