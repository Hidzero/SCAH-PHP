<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manutencao extends Model
{
    use HasFactory;

    protected $table = 'manutencoes';

    protected $fillable = [
        'retirada_id',
        'data_retorno',
        'data_conserto',
        'descricao',
        'status'
    ];

    /**
     * Relação com a Retirada associada
     */
    public function retirada()
    {
        return $this->belongsTo(Retirada::class);
    }
}