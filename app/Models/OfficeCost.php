<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficeCost extends Model
{
    use HasFactory;


    protected $fillable = [
        'cost_category_id',
        'cost_date',
        'amount',
        'description',
        'attachment_path',
        'notes',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'cost_date' => 'date',
        'amount' => 'decimal:2'
    ];

    /**
     * Get the category that owns the cost.
     */
    public function category()
    {
        return $this->belongsTo(CostCategory::class, 'cost_category_id');
    }

    /**
     * Get the user who created the cost.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the cost.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
