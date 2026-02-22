<?php

namespace Database\Seeders;

use App\Models\MER\User;
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
            ['role_id' => 2, 'model_type' => User::class, 'model_id' => 1],
            ['role_id' => 3, 'model_type' => User::class, 'model_id' => 2],
        ]);
    }
}
