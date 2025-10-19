<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvisoryCommittee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'photo',
        'order',
        'active',
        'type',
        'message',
        'email',
        'phone',
        'officename',
        'officeaddress'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
}
