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
        $this->call(EstadosTicketTableSeeder::class);
        $this->call(PrioridadesTicketTableSeeder::class);
        $this->call(ClasesTableSeeder::class);
        $this->call(CombustiblesTableSeeder::class);
        $this->call(MarcasTableSeeder::class);
        $this->call(LineasTableSeeder::class);
        $this->call(TiposDocVehiculoTableSeeder::class);
        $this->call(AccesoriosTableSeeder::class);
        $this->call(DepartamentosTableSeeder::class);
        $this->call(CiudadesTableSeeder::class);
        $this->call(TiposDocUsuarioTableSeeder::class);

        // User::factory(10)->create();

        User::factory()->create([
            'email' => 'test@example.com',
        ]);
    }
}
