<?php

namespace Database\Seeders;

use App\Models\MER\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(UserTableSeeder::class);
        User::factory(8)->create(); //Provisional
        User::factory()->create([
            'email' => 'test@example.com',
        ]);
        $this->call(RolesTableSeeder::class);
        $this->call(EstadosTicketTableSeeder::class);
        $this->call(EstadosReservaTableSeeder::class);
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
        $this->call(ModelHasRoleTableSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(QuestionsTableSeeder::class);

        $this->call(DatosPruebaSeeder::class); //Provisional
    }
}
