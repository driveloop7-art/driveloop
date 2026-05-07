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
        $this->insertUsers();
        for ($i = 0; $i < 10; $i++) {
            $vehiculoId = $this->insertVehiculo();
            $this->insertFotoVehiculoTest($vehiculoId, $i);
            $this->insertTicket($vehiculoId);
        }

        for ($i = 0; $i < 10; $i++) {
            $userId = $this->insertUserFake();
            $vehiculoId = $this->insertVehiculo($userId);
            $this->insertFotoVehiculoTest($vehiculoId, $i);
            $this->insertTicket($vehiculoId, $userId);
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
        $name = $this->randomFirstName();
        $user = User::create([
            'nom' => $name,
            'ape' => $this->randomLastName(),
            'email' => $this->randomEmail($name),
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
            'col' => $this->randomColor(),
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
            'ase' => 'Seguros ' . $this->randomCompany(),
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
            'asu' => $this->randomSentence(5),
            'des' => $this->randomText(100),
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

    private function randomFirstName(): string
    {
        $names = ['Juan', 'Carlos', 'Luis', 'Andrés', 'Miguel', 'Pedro', 'Jorge', 'David', 'Santiago', 'Mateo', 'Camilo', 'Alejandro', 'Diego', 'Fernando', 'Gabriel', 'Ignacio', 'Javier', 'Kevin', 'Leonardo', 'Manuel'];
        return $names[array_rand($names)];
    }

    private function randomLastName(): string
    {
        $lastNames = ['García', 'Rodríguez', 'Martínez', 'López', 'Hernández', 'Gómez', 'Pérez', 'Díaz', 'Sánchez', 'Torres', 'Ramírez', 'Flores', 'Rivera', 'Reyes', 'Mendoza'];
        return $lastNames[array_rand($lastNames)];
    }

    private function randomEmail(string $name): string
    {
        return strtolower($name) . rand(100, 999) . '@mail.com';
    }

    private function randomColor(): string
    {
        $colors = ['Rojo', 'Azul', 'Negro', 'Blanco', 'Gris', 'Verde', 'Plateado', 'Naranja', 'Amarillo', 'Morado', 'Marrón', 'Turquesa', 'Beige', 'Dorado'];
        return $colors[array_rand($colors)];
    }

    private function randomCompany(): string
    {
        $companies = ['Bolívar', 'Sura', 'Mapfre', 'Allianz', 'AXA', 'Colpatria'];
        return $companies[array_rand($companies)];
    }

    private function randomSentence(int $words = 5): string
    {
        $pool = ['sistema', 'vehículo', 'reserva', 'usuario', 'error', 'soporte', 'plataforma', 'servicio', 'contrato', 'poliza', 'combustible', 'gasolina', 'diesel', 'gas'];
        shuffle($pool);
        return ucfirst(implode(' ', array_slice($pool, 0, $words)));
    }

    private function randomText(int $length = 100): string
    {
        return substr(str_repeat('Texto de prueba ', 10), 0, $length);
    }
}
