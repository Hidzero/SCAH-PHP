<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retirada extends Model
{
    use HasFactory;

    protected $fillable = [
        'ferramenta_id',
        'responsavel_id',
        'previsao_retorno',
        'uso_interno',
        'obra_id',
        'deleted_at',
    ];

    protected $dates = ['deleted_at'];
    
    // Relação com a ferramenta
    public function ferramenta()
    {
        return $this->belongsTo(Ferramenta::class);
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class,'responsavel_id');
    }

    // Relação com a obra (caso tenha sido retirada para uma obra)
    public function obra()
    {
        return $this->belongsTo(Obra::class);
    }
}
