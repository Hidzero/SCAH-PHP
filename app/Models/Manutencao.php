<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manutencao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'manutencoes';

    protected $fillable = [
        'retirada_id',
        'data_retorno',
        'precisa_manutencao',
        'status',
        'descricao',
        'peca_solicitada',
    ];

    protected $casts = [
        'precisa_manutencao' => 'boolean',
        'data_retorno'        => 'date',
        'peca_solicitada'     => 'boolean',
    ];

    public function retirada()
    {
        return $this->belongsTo(Retirada::class)->withTrashed();
    }
}
