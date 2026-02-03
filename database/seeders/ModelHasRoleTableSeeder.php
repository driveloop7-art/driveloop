<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ModelHasRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('model_has_roles')->insert([
            ['role_id' => 2, 'model_type' => 'App\Models\MER\User', 'model_id' => 1],
        ]);
    }
}
