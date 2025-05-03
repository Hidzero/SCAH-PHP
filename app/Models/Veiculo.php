<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veiculo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'veiculos'; // Nome da tabela

    protected $fillable = [
        'nome',
        'tipo',
        'modelo',
        'marca',
        'placa',
        'km_atual',
        'em_uso'
    ];
}
