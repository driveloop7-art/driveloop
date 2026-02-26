<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questions')->insert([
            ['id' => 1, 'question' => '¿Cómo calificaría su satisfacción general con la resolución de este ticket?', 'is_active' => true],
            ['id' => 2, 'question' => '¿Qué tan satisfecho está con el tiempo de respuesta y resolución?', 'is_active' => true],
            ['id' => 3, 'question' => '¿La comunicación por parte del personal de soporte fue clara y oportuna?', 'is_active' => true],
            ['id' => 4, 'question' => '¿El técnico demostró el conocimiento necesario para resolver su solicitud?', 'is_active' => true],
            ['id' => 5, 'question' => '¿Qué tan fácil fue el proceso de reporte y seguimiento de su ticket?', 'is_active' => true],
        ]);
    }
}