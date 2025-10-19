<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bank_account_id',
        'txn_number',
        'amount',
        'type',
        'note',
        'transaction_date',
    ];


    

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}

