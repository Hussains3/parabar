<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class File_data extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:H:i',
        'updated_at' => 'datetime:H:i',
        'delivered_at' => 'datetime:H:i',
    ];

    // Accessor: Converts Y-m-d to d/m/Y when retrieving lodgement_date
    public function getLodgementDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    // Mutator: Converts d/m/Y to Y-m-d before saving lodgement_date
    public function setLodgementDateAttribute($value)
    {
        $this->attributes['lodgement_date'] = $value ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null;
    }

    // Accessor: Converts Y-m-d to d/m/Y when retrieving manifest_date
    public function getManifestDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    // Mutator: Converts d/m/Y to Y-m-d before saving manifest_date
    public function setManifestDateAttribute($value)
    {
        $this->attributes['manifest_date'] = $value ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null;
    }

    // Accessor: Converts Y-m-d to d/m/Y when retrieving be_date
    public function getBeDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    // Mutator: Converts d/m/Y to Y-m-d before saving be_date
    public function setBeDateAttribute($value)
    {
        $this->attributes['be_date'] = $value ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null;
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function ie_data()
    {
        return $this->belongsTo(Ie_data::class);
    }

    public function data_users()
    {
        return $this->hasMany(Data_user::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class);
    }

    public function deliverer()
    {
        return $this->belongsTo(User::class, 'deliverer_id');
    }
}
