<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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



    // Accessor: Converts Y-m-d to d/m/Y when retrieving cost_date
    public function getCostDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    // Mutator: Converts d/m/Y to Y-m-d before saving cost_date
    public function setCostDateAttribute($value)
    {
        if (!$value) {
            $this->attributes['cost_date'] = null;
            return;
        }

        try {
            // First check if the value is already in Y-m-d format
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                $this->attributes['cost_date'] = $value;
            } else {
                // Try to parse as d/m/Y format
                $date = Carbon::createFromFormat('d/m/Y', $value);
                $this->attributes['cost_date'] = $date->format('Y-m-d');
            }
        } catch (\Exception $e) {
            // If parsing fails, try to parse with Carbon's automatic parsing
            try {
                $this->attributes['cost_date'] = Carbon::parse($value)->format('Y-m-d');
            } catch (\Exception $e) {
                // If all parsing attempts fail, set to null
                $this->attributes['cost_date'] = null;
            }
        }
    }


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
