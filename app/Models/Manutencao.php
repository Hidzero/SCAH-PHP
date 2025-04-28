<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manutencao extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        // isso faz com que mesmo Retiradas soft-deleted sejam retornadas
        return $this->belongsTo(Retirada::class)
                    ->withTrashed();
    }

}