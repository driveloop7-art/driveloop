<?php

namespace Database\Seeders;

use App\Models\MER\Reserva;
use App\Models\MER\FotoVehiculo;
use App\Models\MER\User;
use App\Models\MER\PolizaVehiculo;
use App\Models\MER\Marca;
use App\Models\MER\Linea;
use App\Models\MER\Clase;
use App\Models\MER\Combustible;
use App\Models\MER\Ciudad;
use App\Models\MER\Ticket;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatosPruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 3; $i < 11; $i++) {

            $poliza = PolizaVehiculo::create([
                'ase' => 'Seguros ' . fake()->company(),
                'fini' => Carbon::now()->subYear(),
                'ffin' => Carbon::now()->addYear(),
            ]);

            $marca = Marca::first();
            $linea = Linea::first();
            $clase = Clase::first();
            $combustible = Combustible::first();
            $ciudad = Ciudad::first();

            $vehiculoId = DB::table('vehiculos')->insertGetId([
                'user_id' => $i,
                'vin' => Str::upper(Str::random(12)),
                'mod' => rand(2010, 2025),
                'col' => fake()->colorName(),
                'pas' => rand(2, 4),
                'cil' => rand(1000, 2000),
                'codpol' => $poliza->cod,
                'codmar' => $marca->cod,
                'codlin' => $linea->cod,
                'codcla' => $clase->cod,
                'codcom' => $combustible->cod,
                'codciu' => $ciudad->cod, // Código de ciudad
                'prerent' => rand(100000, 200000), // Precio de renta por día
                'disp' => rand(0, 1)
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

            $reserva = Reserva::create([
                'fecrea' => Carbon::now()->subDays(10),
                'fecini' => Carbon::now()->subDays(5),
                'fecfin' => Carbon::now()->subDays(1),
                'val' => rand(100000, 200000),
                'idusu' => $i,
                'codveh' => $vehiculoId,
                'codestres' => rand(1, 3), // Finalizada
            ]);

            Ticket::create([
                'cod' => Str::upper(Str::random(10)),
                'codres' => $reserva->cod,
                'codesttic' => '1',
                'asu' => fake()->sentence(5),
                'des' => fake()->text(100),
                'feccre' => now(),
                'idusu' => $i,
            ]);

            DB::table('model_has_roles')->insert([
                'role_id' => $i < 6 ? 3 : 1,
                'model_type' => User::class,
                'model_id' => $i,
            ]);
        }
    }
}
