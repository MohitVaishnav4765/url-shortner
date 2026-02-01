<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $fillable = [
        'name'
    ];


    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function urls(){
        return $this->hasMany(ShortUrl::class);
    }
}
