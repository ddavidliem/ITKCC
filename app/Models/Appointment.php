<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use UUID;
    use HasFactory;

    protected $fillable = [
        'date_time',
        'user_id',
        'topik',
        'jenis_konseling',
        'tempat_konseling',
        'jumlah_peserta',
        'google_meet',
        'status',
        'feedback',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->with('pengalaman', 'sertifikat');
    }
}
