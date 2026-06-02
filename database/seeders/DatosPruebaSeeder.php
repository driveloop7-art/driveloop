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
            $vehiculoId = $this->insertVehiculo($i);
            $this->insertFotoVehiculoTest($vehiculoId, $i);
            $this->insertDocsVehiculoTest($vehiculoId);
        }
            
        // $this->insertTicketTest($vehiculoId);
        $this->insertDocumentUsuario();
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
            ],
            [
                'id' => 4,
                'nom' => 'Arrendador',
                'ape' => 'Arrendador',
                'email' => 'arrendador@driveloop.com',
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
        self::insertRol(4, 1);
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

    private function insertVehiculo(int $i): int
    {
        return Vehiculo::create([
            'user_id' => 4,
            'vin' => Str::upper(Str::random(12)),
            'mod' => rand(2020, 2025),
            'col' => $this->color($i),
            'pas' => 4,
            'cil' => $this->cilindrada($i),
            'codpol' => self::codPolizaVehiculo(),
            'codmar' => $this->marca($i),
            'codlin' => $this->linea($i),
            'codcla' => $this->clase($i),
            'codcom' => 1,
            'codciu' => Ciudad::inRandomOrder()->first()->cod,
            'prerent' => rand(300000, 500000),
            'disp' => 1
        ])->cod;
    }

    private function cilindrada(int $i): int
    {
        $cilindradas = [1600, 2000, 1800, 1500, 2500, 2200, 2000, 2400, 1400, 1600];
        return $cilindradas[$i];
    }

    private function marca(int $i): int
    {
        $marcas = ['Chevrolet', 'Mazda', 'Toyota', 'Ford', 'Renault', 'Nissan', 'Hyundai', 'Kia', 'Volkswagen', 'Honda'];
        $marcasCod = [1,6,25,54,8,15,208,5,9,21];
        return $marcasCod[$i];
    }

    private function linea(int $i): int
    {
        $lineas = ['Onix', 'CX-5', 'Corolla', 'Fiesta', 'Duster', 'Sentra', 'Tucson', 'Sportage', 'Golf', 'Civic'];
        $lineaCod = [1002, 6003, 25001, 54001, 8004, 15003, 208003, 5004, 9001, 21001];
        return $lineaCod[$i];
    }

    private function clase(int $i): int
    {
        $clases = ['Automóvil', 'Camioneta', 'Automóvil', 'Automóvil', 'Camioneta', 'Automóvil', 'Camioneta', 'Camioneta', 'Automóvil', 'Automóvil'];
        $claseCod = [1, 3, 1, 1, 3, 1, 3, 3, 1, 1];
        return $claseCod[$i];
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

    private function insertDocsVehiculoTest(int $vehiculoId): void
    {
        $placa = Str::upper(Str::random(3)) . rand(100, 999);
        DB::table('documentos_vehiculo')->insert([
            [
                'idtipdocveh' => 1,
                'numdoc' => $placa,
                'empexp' => '',
                'descdoc' => 'https://example.com/tarjeta_propiedad.jpg',
                'codveh' => $vehiculoId,
                'estado' => 'APROBADO',
                'mensaje_rechazo' => null,
            ],
            [
                'idtipdocveh' => 2,
                'numdoc' => $placa,
                'empexp' => '',
                'descdoc' => 'https://example.com/soat.jpg',
                'codveh' => $vehiculoId,
                'estado' => 'APROBADO',
                'mensaje_rechazo' => null,
            ],
            [
                'idtipdocveh' => 3,
                'numdoc' => $placa,
                'empexp' => '',
                'descdoc' => 'https://example.com/tecnomecanica.jpg',
                'codveh' => $vehiculoId,
                'estado' => 'APROBADO',
                'mensaje_rechazo' => null,
            ],
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

    private function insertTicketTest(int $vehiculoId, int $userId = 3): void
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

        DB::table('pagos')->insert([
            'codres' => Reserva::latest('cod')->first()->cod,
            'idusu' => $userId,
            'referencia'=> 'SIM-ZADSRZP3QO',
            'metodo' => 'card',
            'monto' => rand(100000, 200000),
            'estado' => 'aprobado',
            'moneda' => 'COP',
            'fecha_pago' => now(),
            'detalle' => '{"reserva_temporal":"TMP-20260524145024-10","codveh":"10","pickup_date":"2026-05-24","return_date":"2026-05-25","gateway_response":{"status":"aprobado","reference":"SIM-ZADSRZP3QO","external_payment_id":null,"external_reference":"TMP-20260524145024-10","status_detail":"transaccion_simulada","message":"Pago aprobado en simulaci\u00f3n."}}',
        ]);
    }

    private function insertDocumentUsuario(): void
    {
        for ($i=1; $i < 5; $i++) { 
            DB::table('documentos_usuario')->insert([
                [
                    'idtipdocusu' => 1,
                    'num' => '123456789',
                    'codusu' => $i,
                    'url_anverso' => 'https://example.com/documento_anverso.jpg',
                    'url_reverso' => 'https://example.com/documento_reverso.jpg',
                    'estado' => 'APROBADO',
                    'mensaje_rechazo' => null,
                ],
                [
                    'idtipdocusu' => 2,
                    'num' => '987654321',
                    'codusu' => $i,
                    'url_anverso' => 'https://example.com/soat_anverso.jpg',
                    'url_reverso' => null,
                    'estado' => 'APROBADO',
                    'mensaje_rechazo' => null,
                ],
            ]);            
        }
    }


    private const photos = [
        'https://www.elcarrocolombiano.com/wp-content/webp-express/webp-images/uploads/2025/08/20250826-CHEVROLET-ONIX-Y-TRACKER-2026-ANUNCIO-PARA-COLOMBIA-ACTUALIZACION-01.jpg.webp',
        'https://alciautosmazda.com/wp-content/uploads/2019/09/mazda-cx5-lateral-frente.jpg',
        'https://autoamerica.com.co/wp-content/uploads/2021/05/COROLLA-SEDAN-EXT-1-1024x819.jpg.avif',
        'https://pluralidadz.com/wp-content/uploads/2024/04/Ford-Fiesta-2018.-Foto-TuCarro-696x406.webp',
        'https://autosdeprimera.com/wp-content/uploads/2024/05/renault-duster-iconic-turbo-4x4-colombia-frente.jpg',
        'https://www.elcarrocolombiano.com/wp-content/webp-express/webp-images/uploads/2020/07/20200729-NISSAN-SENTRA-2021-VIDEO-RESENA-COMENTARIOS-TEST-DRIVE-CAMPANA-01.jpg.webp',
        'https://www.elcarrocolombiano.com/wp-content/webp-express/webp-images/uploads/2022/07/20220722-HYUNDAI-TUCSON-NX4-2023-COLOMBIA-PRECIOS-VERSIONES-CARACTERISTICAS-NOVEDADES-01.jpg.webp',
        'https://fuelcarmagazine.com/wp-content/uploads/2022/09/Kia-Sportage-GT-Line-Colombia-696x365.jpg',
        'https://www.elcarrocolombiano.com/wp-content/webp-express/webp-images/uploads/2020/11/2022_Golf_R_European_model_shown-Large-12436.jpg.webp',
        'https://www.elcarrocolombiano.com/wp-content/webp-express/webp-images/uploads/2019/11/20191116-HONDA-CIVIC-2020-COLOMBIA-PRECIO-CARACTERISTICAS-06.jpg.webp',
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

    private function color(int $i): string
    {
        $colors = ['Vinotinto', 'Rojo', 'Blanco', 'Gris', 'Gris Ceniza', 'Vinotinto', 'Gris Oscuro', 'Gris', 'Azul', 'Gris Oscuro'];
        return $colors[$i];
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
