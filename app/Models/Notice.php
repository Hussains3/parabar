<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notice extends Model
{
    use HasFactory;

    // Define the fillable attributes
    protected $fillable = [
        'title',
        'file_link',
        'publish_date',
        'archive_date',
        'status',
    ];

    // Accessor to format the publish_date
    public function getPublishDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-y');
    }

    // Accessor to format the archive_date
    public function getArchiveDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-y');
    }
}
