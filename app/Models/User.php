<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMaster()
    {
        return $this->role === 'master';
    }
}
