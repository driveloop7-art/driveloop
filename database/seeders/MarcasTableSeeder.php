<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MarcasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marcas')->insert([
            ['cod' => '1', 'des' => 'CHEVROLET'],
            ['cod' => '2', 'des' => 'DAEWOO'],
            ['cod' => '3', 'des' => 'FIAT'],
            ['cod' => '5', 'des' => 'KIA'],
            ['cod' => '6', 'des' => 'MAZDA'],
            ['cod' => '8', 'des' => 'RENAULT'],
            ['cod' => '9', 'des' => 'VOLKSWAGEN'],
            ['cod' => '10', 'des' => 'DODGE'],
            ['cod' => '15', 'des' => 'NISSAN'],
            ['cod' => '16', 'des' => 'PEUGEOT'],
            ['cod' => '17', 'des' => 'SUBARU'],
            ['cod' => '21', 'des' => 'HONDA'],
            ['cod' => '23', 'des' => 'MITSUBISHI'],
            ['cod' => '25', 'des' => 'TOYOTA'],
            ['cod' => '26', 'des' => 'VOLVO'],
            ['cod' => '28', 'des' => 'BMW'],
            ['cod' => '30', 'des' => 'MERCEDES BENZ'],
            ['cod' => '33', 'des' => 'JAGUAR'],
            ['cod' => '40', 'des' => 'SKODA'],
            ['cod' => '41', 'des' => 'CITROEN'],
            ['cod' => '48', 'des' => 'OPEL'],
            ['cod' => '49', 'des' => 'ISUZU'],
            ['cod' => '50', 'des' => 'JEEP'],
            ['cod' => '51', 'des' => 'LAND ROVER'],
            ['cod' => '52', 'des' => 'SUZUKI'],
            ['cod' => '53', 'des' => 'CHRYSLER'],
            ['cod' => '54', 'des' => 'FORD'],
            ['cod' => '57', 'des' => 'KAWASAKI'],
            ['cod' => '62', 'des' => 'INTERNATIONAL'],
            ['cod' => '64', 'des' => 'MACK'],
            ['cod' => '67', 'des' => 'KENWORTH'],
            ['cod' => '68', 'des' => 'IVECO'],
            ['cod' => '76', 'des' => 'HINO'],
            ['cod' => '91', 'des' => 'GMC'],
            ['cod' => '139', 'des' => 'AUDI'],
            ['cod' => '142', 'des' => 'ASTON MARTIN'],
            ['cod' => '150', 'des' => 'BENTLEY'],
            ['cod' => '169', 'des' => 'FREIGHTLINER'],
            ['cod' => '190', 'des' => 'MAN'],
            ['cod' => '208', 'des' => 'HYUNDAI'],
            ['cod' => '210', 'des' => 'LEXUS'],
            ['cod' => '214', 'des' => 'PORSCHE'],
            ['cod' => '216', 'des' => 'SCANIA'],
            ['cod' => '217', 'des' => 'SSANGYONG'],
            ['cod' => '221', 'des' => 'PIAGGIO'],
            ['cod' => '226', 'des' => 'HUMMER'],
            ['cod' => '234', 'des' => 'DUCATI'],
            ['cod' => '235', 'des' => 'MG'],
            ['cod' => '241', 'des' => 'INFINITI'],
            ['cod' => '252', 'des' => 'MAHINDRA']
        ]);
    }
}