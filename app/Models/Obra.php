<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'cliente',
        'endereco',
        'inicio_obra',
        'fim_obra',
    ];
}
