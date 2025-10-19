<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ain_no',
        'name',
        'bangla_name',
        'license_no',
        'license_issue_date',
        'membership_no',
        'agency_logo',
        'owners_name',
        'owners_gender',
        'owner_photo',
        'owners_designation',
        'office_address',
        'phone',
        'email',
        'house',
        'parmanent_address',
        'note',
        'member_fee_amount',
        'welfare_fund_amount',
        'last_fee_paid_date',
        'member_fee_paid_till_date',
        'welfare_fund_paid_till_date'
    ];

    protected $casts = [
        'last_fee_paid_date' => 'date',
        'member_fee_paid_till_date' => 'date',
        'welfare_fund_paid_till_date' => 'date'
    ];

    public function donations() {
        return $this->hasMany(Donation::class)->orderBy('id', 'desc');
    }
    public function custom_files() {
        return $this->hasMany(CustomFile::class)->orderBy('id', 'desc');
    }

}
