<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Sertifikasi;
use App\Models\Application;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UUID;
use Illuminate\Contracts\Auth\MustVerifyEmail;


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
        'google_id',
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


    public function pengalaman(): HasMany
    {
        return $this->hasMany(pengalaman::class);
    }

    public function sertifikat(): HasMany
    {
        return $this->hasMany(sertifikasi::class);
    }

    public function pendidikan(): HasMany
    {
        return $this->hasMany(pendidikan::class);
    }

    public function appointment(): HasMany
    {
        return $this->hasMany(appointment::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(application::class);
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            $user->applications()->delete();
            $user->appointment()->delete();
            $user->sertifikat()->delete();
            $user->pengalaman()->delete();
        });
    }
}
