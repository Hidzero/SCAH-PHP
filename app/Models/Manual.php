<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manual extends Model
{
    use SoftDeletes;

    protected $table = 'manuais';
    
    protected $fillable = ['original_name', 'file_path', 'user_id'];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
