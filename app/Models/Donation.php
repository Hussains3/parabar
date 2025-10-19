<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'purpose', 'amount', 'agent_id', 'type', 'status'];


    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function getFormattedDateAttribute()
    {
        return $this->date ? \Carbon\Carbon::parse($this->date)->format('d-M-Y') : null;
    }


}
