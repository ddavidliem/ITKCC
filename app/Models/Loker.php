<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin;
use App\Models\User;
use App\Models\Employer;

class Loker extends Model
{
    use UUID;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama_pekerjaan',
        'jenis_pekerjaan',
        'tipe_pekerjaan',
        'deskripsi_pekerjaan',
        'lokasi_pekerjaan',
        'poster',
        'status',
        'suspend_note',
        'deadline',
        'employer_id',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function scopeAccessibleBy($query, $user)
    {
        if ($user->isAdmin()) {
            return $query->withTrashed();
        }

        if ($user instanceof User) {
            return $query->where('user_id', $user->id);
        } elseif ($user instanceof Employer) {
            return $query->where('employer_id', $user->id);
        }
    }


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
