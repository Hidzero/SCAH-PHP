<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saida extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'saidas';

    protected $fillable = [
        'veiculo_id',
        'motorista_id',
        'km_atual',
        'avarias_descritas',
        'nota_retorno'
    ];

    /**
     * Relação com Veículo
     */
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    /**
     * Relação com Motorista
     */
    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }
}
