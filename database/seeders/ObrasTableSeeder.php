<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obra;
use Carbon\Carbon;

class ObrasTableSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'cliente'     => 'Construtora Alpha',
                'endereco'    => 'Rua A, 123 – Centro, Cidade X',
                'inicio_obra' => Carbon::parse('2024-01-15'),
                'fim_obra'    => Carbon::parse('2024-06-30'),
            ],
            [
                'cliente'     => 'Empreendimentos Beta',
                'endereco'    => 'Av. B, 456 – Zona Sul, Cidade Y',
                'inicio_obra' => Carbon::parse('2024-03-01'),
                'fim_obra'    => Carbon::parse('2024-12-15'),
            ],
            [
                'cliente'     => 'Construtora Gama',
                'endereco'    => 'Trav. C, 789 – Bairro Z, Cidade Z',
                'inicio_obra' => Carbon::parse('2023-11-20'),
                'fim_obra'    => null,
            ],
        ];

        foreach ($projects as $p) {
            Obra::create($p);
        }
    }
}
