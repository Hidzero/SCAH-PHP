<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Veiculo;

class VeiculosTableSeeder extends Seeder
{
    public function run()
    {
        $vehicles = [
            [
                'nome' => 'Caminhão Basculante',
                'tipo' => 'Caminhão',
                'modelo' => 'Ford F-350',
                'marca' => 'Ford',
                'placa' => 'ABC1D23',
                'km_atual' => 12000,
                'em_uso' => false
            ],
            [
                'nome' => 'Carro de Apoio',
                'tipo' => 'Carro',
                'modelo' => 'Fiat Uno',
                'marca' => 'Fiat',
                'placa' => 'XYZ9W87',
                'km_atual' => 45000,
                'em_uso' => false
            ],
            [
                'nome' => 'Caminhão Painel',
                'tipo' => 'Caminhão',
                'modelo' => 'Mercedes Actros',
                'marca' => 'Mercedes',
                'placa' => 'MNO4P56',
                'km_atual' => 8000,
                'em_uso' => false
            ],
        ];

        foreach ($vehicles as $v) {
            Veiculo::create($v);
        }
    }
}
