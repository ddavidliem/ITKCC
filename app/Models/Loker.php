<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loker extends Model
{
    use UUID;
    use HasFactory;

    protected $fillable = [
        'nama_pekerjaan',
        'jenis_pekerjaan',
        'tipe_pekerjaan',
        'deskripsi_pekerjaan',
        'lokasi_pekerjaan',
        'poster',
        'status',
        'deadline',
        'employer_id',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];



    public function applicants()
    {
        return $this->hasMany(Application::class);
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    protected static function booted()
    {
        static::deleting(function ($loker) {
            $loker->applicants()->delete();
        });
    }
}
