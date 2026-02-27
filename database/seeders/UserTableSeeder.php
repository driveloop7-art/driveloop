<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'nom' => 'Administrador',
                'ape' => 'Administrador',
                'email' => 'administrador@driveloop.com',
                'password' => Hash::make('password'),
                'fecreg' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10)
            ]
        ]);
    }
}
