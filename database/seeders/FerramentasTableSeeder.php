<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ferramenta;

class FerramentasTableSeeder extends Seeder
{
    public function run()
    {
        $tools = [
            ['nome' => 'Enxada',       'descricao' => 'Enxada para escavação',        'numero_serie' => 'ENX-001'],
            ['nome' => 'Marreta',      'descricao' => 'Marreta 5kg',                  'numero_serie' => 'MAR-005'],
            ['nome' => 'Martelo',      'descricao' => 'Martelo de carpinteiro',       'numero_serie' => 'MAR-010'],
            ['nome' => 'Chave de fenda','descricao'=> 'Chave de fenda Philips #2',   'numero_serie' => 'CDF-002'],
            ['nome' => 'Serra manual', 'descricao' => 'Serra manual para madeira',    'numero_serie' => 'SM-015'],
        ];

        foreach ($tools as $t) {
            Ferramenta::create($t);
        }
    }
}
