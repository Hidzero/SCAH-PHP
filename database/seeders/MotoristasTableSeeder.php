<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Motorista;
use Carbon\Carbon;

class MotoristasTableSeeder extends Seeder
{
    public function run()
    {
        $drivers = [
            [
                'nome'           => 'João Silva',
                'cnh'            => 'BR1234567',
                'validade_cnh'   => Carbon::parse('2026-05-20'),
                'data_nascimento'=> Carbon::parse('1985-07-12'),
                'endereco'       => 'Rua das Flores, 50 – Cidade A',
                'telefone'       => '(11) 91234-5678',
                'email'          => 'joao.silva@example.com',
            ],
            [
                'nome'           => 'Maria Souza',
                'cnh'            => 'BR7654321',
                'validade_cnh'   => Carbon::parse('2025-11-30'),
                'data_nascimento'=> Carbon::parse('1990-02-25'),
                'endereco'       => 'Av. Central, 200 – Cidade B',
                'telefone'       => '(21) 92345-6789',
                'email'          => 'maria.souza@example.com',
            ],
            [
                'nome'           => 'Carlos Pereira',
                'cnh'            => 'BR1122334',
                'validade_cnh'   => Carbon::parse('2027-01-15'),
                'data_nascimento'=> Carbon::parse('1978-09-05'),
                'endereco'       => 'Trav. dos Operários, 123 – Cidade C',
                'telefone'       => '(31) 93456-7890',
                'email'          => 'carlos.pereira@example.com',
            ],
        ];

        foreach ($drivers as $d) {
            Motorista::create($d);
        }
    }
}
