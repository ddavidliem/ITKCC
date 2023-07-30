<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employer extends Authenticatable
{
    use UUID;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'nama_perusahaan',
        'alamat',
        'provinsi',
        'kota',
        'kode_pos',
        'website',
        'nama_lengkap',
        'jabatan',
        'nomor_telepon',
        'alamat_email',
        'logo_perusahaan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function loker(): HasMany
    {
        return $this->hasMany(Loker::class);
    }
}
