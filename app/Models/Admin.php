<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use UUID;
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'username',
        'password',
        'alamat_email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
