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
use App\Models\MER\Vehiculo;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatosPruebaSeeder extends Seeder
{
    public function run(): void
    {
        self::insertUsers();
        for ($i = 0; $i < 10; $i++) {
            $vehiculoId = self::insertVehiculo();
            self::insertFotoVehiculoTest($vehiculoId, $i);
            self::insertTicket($vehiculoId);
        }

        for ($i = 0; $i < 10; $i++) {
            $userId = self::insertUserFake();
            $vehiculoId = self::insertVehiculo($userId);
            self::insertFotoVehiculoTest($vehiculoId, $i);
            self::insertTicket($vehiculoId, $userId);
        }


    }

    private function insertUsers()
    {
        DB::table('users')->insert([
            [
                'id' => 2,
                'nom' => 'Soporte',
                'ape' => 'Soporte',
                'email' => 'soporte@driveloop.com',
                'password' => Hash::make('password'),
                'fecreg' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10)
            ],
            [
                'id' => 3,
                'nom' => 'Usuario',
                'ape' => 'Usuario',
                'email' => 'usuario@driveloop.com',
                'password' => Hash::make('password'),
                'fecreg' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10)
            ]
        ]);
        self::insertRol(2, 3);
        self::insertRol(3, 1);
    }

    private function insertUserFake(): int
    {
        $user = User::create([
            'nom' => fake()->firstName(),
            'ape' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'fecreg' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        self::insertRol($user->id, rand(1, 3));
        return $user->id;
    }

    private function insertRol(int $idUser, int $roleId): void
    {
        DB::table('model_has_roles')->insert([
            [
                'role_id' => $roleId,
                'model_type' => User::class,
                'model_id' => $idUser,
            ]
        ]);
    }

    private function insertVehiculo(int $userId = 3): int
    {
        return Vehiculo::create([
            'user_id' => $userId,
            'vin' => Str::upper(Str::random(12)),
            'mod' => rand(2010, 2025),
            'col' => fake()->colorName(),
            'pas' => rand(2, 4),
            'cil' => rand(1000, 2000),
            'codpol' => self::codPolizaVehiculo(),
            'codmar' => Marca::inRandomOrder()->first()->cod,
            'codlin' => Linea::inRandomOrder()->first()->cod,
            'codcla' => Clase::inRandomOrder()->first()->cod,
            'codcom' => Combustible::inRandomOrder()->first()->cod,
            'codciu' => Ciudad::inRandomOrder()->first()->cod,
            'prerent' => rand(100000, 200000),
            'disp' => rand(0, 1)
        ])->cod;
    }

    private function codPolizaVehiculo(): int
    {
        return PolizaVehiculo::create([
            'ase' => 'Seguros ' . fake()->company(),
            'fini' => Carbon::now()->subYear(),
            'ffin' => Carbon::now()->addYear(),
        ])->cod;
    }

    private function insertFotoVehiculoTest(int $vehiculoId, int $i): void
    {
        FotoVehiculo::create([
            'nom' => 'Frontal',
            'ruta' => self::photos[$i],
            'dim' => '800x600',
            'mim' => 'image/jpg',
            'pes' => 1024,
            'codveh' => $vehiculoId,
        ]);
    }

    private function codReserva(int $vehiculoId, int $userId = 3): int
    {
        return Reserva::create([
            'fecrea' => Carbon::now()->subDays(10),
            'fecini' => Carbon::now()->subDays(5),
            'fecfin' => Carbon::now()->subDays(1),
            'val' => rand(100000, 200000),
            'idusu' => $userId,
            'codveh' => $vehiculoId,
            'codestres' => rand(1, 3),
        ])->cod;
    }

    private function insertTicket(int $vehiculoId, int $userId = 3): void
    {
        Ticket::create([
            'cod' => Str::upper(Str::random(10)),
            'codres' => self::codReserva($vehiculoId, $userId),
            'codesttic' => '1',
            'asu' => fake()->sentence(5),
            'des' => fake()->text(100),
            'feccre' => now(),
            'idusu' => $userId,
        ]);
    }

    private const photos = [
        'https://www.auto-data.net/images/f56/Alfa-Romeo-159.jpg',
        'https://www.auto-data.net/images/f64/Volkswagen-Up.jpg',
        'https://www.auto-data.net/images/f127/Volvo-XC60-II.jpg',
        'https://www.auto-data.net/images/f69/Voyah-Free-facelift-2023.jpg',
        'https://www.auto-data.net/images/f116/W-Motors-Fenyr-SuperSport.jpg',
        'https://www.auto-data.net/images/f56/WEY-80-Long.jpg',
        'https://www.auto-data.net/images/f25/wey-vv5.jpg',
        'https://www.auto-data.net/images/f99/WEY-X-Concept.jpg',
        'https://www.auto-data.net/images/f127/XPENG-G6.jpg',
        'https://www.auto-data.net/images/f80/Zenvo-TSR-S.jpg',
    ];
}
