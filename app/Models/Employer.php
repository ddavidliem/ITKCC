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
        'logo_perusahaan',
        'bidang_perusahaan',
        'tahun_berdiri',
        'kantor_pusat',
        'deskripsi_perusahaan',
        'nama_lengkap',
        'jabatan',
        'nomor_telepon',
        'alamat_email',
        'email_verification',
        'google_id'
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

    protected static function booted()
    {
        static::deleting(function ($employer) {
            $employer->loker->each(function ($loker) {
                $loker->applicants->each(function ($applicant) {
                    $applicant->delete();
                });
                $loker->delete();
            });
        });
    }
}
