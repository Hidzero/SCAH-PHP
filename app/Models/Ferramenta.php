<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Ferramenta extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nome',
        'descricao',
        'numero_serie',
        'em_uso',
    ];

    protected $casts = [
      'em_uso' => 'boolean',
    ];
}
