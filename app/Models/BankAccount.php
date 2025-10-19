<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;


    protected $fillable = [
        'bank_id',
        'cascade',
        'account_number',
        'account_holder_name',
        'balance'
    ];
    protected $with = ['bank'];


    /**
     * Get the user that owns the BankAccount
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank() {
        return $this->belongsTo(Bank::class);
    }


    public function transactions()
    {
        return $this->hasMany(BankTransaction::class);
    }
}
