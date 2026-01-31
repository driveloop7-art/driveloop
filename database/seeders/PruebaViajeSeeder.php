<?php

namespace Database\Seeders;

use App\Models\MER\EstadoReserva;
use App\Models\MER\Vehiculo;
use App\Models\MER\FotoVehiculo;
use App\Models\MER\User;
use App\Models\MER\PolizaVehiculo;
use App\Models\MER\Marca;
use App\Models\MER\Linea;
use App\Models\MER\Clase;
use App\Models\MER\Combustible;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class PruebaViajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Obtener Usuario (el primero o crear uno)
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'cod' => 12345, // Asignamos un cod para la relación
            ]);
        } elseif (!$user->cod) {
            // Si el usuario existe pero no tiene cod, se lo asignamos
            $user->update(['cod' => 12345]);
        }

        // 2. Crear Poliza
        $poliza = PolizaVehiculo::create([
            'ase' => 'Seguros Bolivar',
            'fini' => Carbon::now()->subYear(),
            'ffin' => Carbon::now()->addYear(),
        ]);

        // 3. Obtener Referencias (asumiendo que los seeders bases ya corrieron)
        $marca = Marca::where('des', 'TOYOTA')->first();
        if (!$marca) {
             $marca = Marca::create(['des' => 'TOYOTA']);
        }
        
        $linea = Linea::where('des', 'COROLLA')->first();
        if (!$linea) {
             $linea = Linea::create(['des' => 'COROLLA', 'codmar' => $marca->cod]);
        }

        $clase = Clase::first();
        if (!$clase) {
             $clase = Clase::create(['nom' => 'Automovil']);
        }
        
        $combustible = Combustible::first();
        if (!$combustible) {
             $combustible = Combustible::create(['nom' => 'Gasolina']);
        }

        // 4. Crear Vehiculo
        // Obtener la primera ciudad disponible
        $ciudad = DB::table('ciudades')->first();
        $codciu = $ciudad ? $ciudad->cod : 1;
        
        $vehiculoId = DB::table('vehiculos')->insertGetId([
            'user_id' => $user->id,                                                          
            'vin' => 'JDKS93849JD93',
            'mod' => 2022,
            'col' => 'Rojo',
            'pas' => 5,
            'cil' => 2000,
            'codpol' => $poliza->cod,
            'codmar' => $marca->cod,
            'codlin' => $linea->cod,
            'codcla' => $clase->cod,
            'codcom' => $combustible->cod,
            'codciu' => $codciu, // Código de ciudad
            'prerent' => 150000, // Precio de renta por día                                                          
        ]);

        // 5. Crear Foto Vehiculo
        FotoVehiculo::create([
            'nom' => 'Frontal',
            'ruta' => 'https://platform.crd.co/assets/templates/images/main/cars/05.png', // Imagen de prueba
            'dim' => '800x600',
            'mim' => 'image/png',
            'pes' => 1024,
            'codveh' => $vehiculoId,
        ]);

        // 6. Crear Reserva Finalizada
        $user->reservas()->create([
            'fecrea' => Carbon::now()->subDays(10),
            'fecini' => Carbon::now()->subDays(5),
            'fecfin' => Carbon::now()->subDays(1),
            'val' => 150000,
            'codveh' => $vehiculoId,
            'codestres' => 3, // Finalizada
        ]);

        $this->command->info('Viaje de prueba creado exitosamente para el usuario: ' . $user->email);
    }
}
