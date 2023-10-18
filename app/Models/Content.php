<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Content extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        'category',
        'status',
        'image',
        'title',
        'body',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
