<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnh',
        'validade_cnh',
        'data_nascimento',
        'endereco',
        'telefone',
        'email',
    ];
}
