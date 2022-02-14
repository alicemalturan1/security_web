<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityLog extends Model
{
    use HasFactory;
    protected $table='community';
    protected static function booted()
    {
        static::created(function ($cml) {
            return $cml;
        });
    }
}
