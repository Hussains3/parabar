<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ie_data extends Model
{
    use HasFactory;


    protected $fillable = [
        'org_name',
        'org_logo',
        'bin_no',
        'tin_no',
        'name',
        'fax_telephone',
        'phone_primary',
        'phone_secondary',
        'whatsapp',
        'email_primary',
        'email_secondary',
        'house_distric',
        'address',
        'post',
    ];


    //Define relationship with File_data model
    public function file_datas()
    {
        return $this->hasMany(File_data::class, 'ie_data_id');
    }
}
