<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'be_number',
        'fees',
        'type',
        'status',
        'agent_id',
        'date'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

}
