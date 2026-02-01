<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    public $fillable = [
        'company_id',
        'user_id',
        'original_url',
        'short_code',
        'hits'
    ];
}
