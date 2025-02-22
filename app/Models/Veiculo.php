<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;

    protected $table = 'veiculos'; // Nome da tabela

    protected $fillable = [
        'nome',
        'tipo',
        'modelo',
        'marca',
        'placa',
        'km_atual',
    ];
}
