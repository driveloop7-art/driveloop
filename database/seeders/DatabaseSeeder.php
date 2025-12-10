<?php

namespace Database\Seeders;

use App\Models\MER\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesTableSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesTableSeeder::class);
        
        // User::factory(10)->create();

        User::factory()->create([
            'email' => 'test@example.com',
        ]);
    }
}
