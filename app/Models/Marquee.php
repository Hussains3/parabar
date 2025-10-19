<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marquee extends Model
{
    protected $fillable = [
        'content',
        'active',
        'order'
    ];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer'
    ];
}
