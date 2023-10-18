<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Sertifikasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UUID;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use function PHPSTORM_META\map;

class User extends Authenticatable implements MustVerifyEmail
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
        'nama_lengkap',
        'alamat_email',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'kota',
        'kode_pos',
        'nomor_telepon',
        'kewarganegaraan',
        'status_perkawinan',
        'agama',
        'pendidikan_tertinggi',
        'nim',
        'ipk',
        'program_studi',
        'disabilitas',
        'resume',
        'profile',
        'status',
        'email_verification',
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

    public function pendidikans(): HasMany
    {
        return $this->hasMany(Pendidikan::class);
    }

    public function pengalaman(): HasMany
    {
        return $this->hasMany(pengalaman::class);
    }

    public function sertifikat(): HasMany
    {
        return $this->hasMany(Sertifikasi::class);
    }

    public function appointment(): HasMany
    {
        return $this->hasMany(appointment::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
