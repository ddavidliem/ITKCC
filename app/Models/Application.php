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
        'status',
        'feedback'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->with('pengalaman', 'sertifikasi');
    }

    public function loker()
    {
        return $this->belongsTo(Loker::class)->with('employer');
    }
}
