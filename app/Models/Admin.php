<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject

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

    public static function isAdmin($username)
    {
        return self::where('username', $username)->exists();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
