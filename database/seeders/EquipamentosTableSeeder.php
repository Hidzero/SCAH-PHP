<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipamento;

class EquipamentosTableSeeder extends Seeder
{
    public function run()
    {
        $equipos = [
            ['nome' => 'Gerador Elétrico', 'tipo' => 'Elétrico'],
            ['nome' => 'Compressores de Ar',   'tipo' => 'Pneumático'],
            ['nome' => 'Bomba d’Água',         'tipo' => 'Hidráulico'],
            ['nome' => 'Andaime Metálico',     'tipo' => 'Estrutural'],
        ];

        foreach ($equipos as $e) {
            Equipamento::create($e);
        }
    }
}
