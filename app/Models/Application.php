<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    use UUID;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loker_id',
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
        'status',
        'feedback'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->with('pengalaman', 'sertifikat');
    }

    public function loker()
    {
        return $this->belongsTo(Loker::class)->with('employer');
    }
}
