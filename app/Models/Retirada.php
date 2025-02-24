<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retirada extends Model
{
    use HasFactory;

    protected $fillable = [
        'ferramenta_id',
        'descricao',
        'numero_serie',
        'responsavel',
        'previsao_retorno',
        'uso_interno',
        'obra_id',
    ];

    // Relação com a ferramenta
    public function ferramenta()
    {
        return $this->belongsTo(Ferramenta::class);
    }

    // Relação com a obra (caso tenha sido retirada para uma obra)
    public function obra()
    {
        return $this->belongsTo(Obra::class);
    }
}
