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
        'payments' => 'array',
        'total_paid' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'be_number',
        'manifest_number',
        'package',
        'file_date',
        'lc_no',
        'lc_value',
        'lc_bank',
        'bill_no',
        'actual_coat_fee',
        'bill_coat_fee',
        'actual_asso_be_entry_fee',
        'bill_asso_be_entry_fee',
        'actual_cargo_branch_aro',
        'bill_cargo_branch_aro',
        'actual_cargo_branch_ro',
        'bill_cargo_branch_ro',
        'actual_cargo_branch_ac',
        'bill_cargo_branch_ac',
        'actual_manifest_dept',
        'bill_manifest_dept',
        'actual_fourtytwo_shed_aro',
        'bill_fourtytwo_shed_aro',
        'actual_examination_normal',
        'actual_examination_irm',
        'actual_examination_goinda',
        'bill_examination_normal',
        'bill_examination_irm',
        'bill_examination_goinda',
        'actual_assessement_aro',
        'actual_assessement_ro',
        'actual_assessement_ac',
        'actual_assessement_dc',
        'actual_assessement_jc',
        'actual_assessement_adc',
        'actual_assessement_commissionar',
        'bill_assessement_aro',
        'bill_assessement_ro',
        'bill_assessement_ac',
        'bill_assessement_dc',
        'bill_assessement_jc',
        'bill_assessement_adc',
        'bill_assessement_commissionar',
        'actual_special_assessment',
        'bill_special_assessment',
        'actual_other_fee',
        'bill_other_fee',
        'total_actual_fee',
        'total_bill_fee',
        'ie_data_id',
        'total_paid',
        'payments',
        'balance',
    ];

    // Accessor: Converts Y-m-d to d/m/Y when retrieving lodgement_date
    public function getFileDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    // Mutator: Converts d/m/Y to Y-m-d before saving lodgement_date
    public function setFileDateAttribute($value)
    {
        $this->attributes['file_date'] = $value ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null;
    }


    public function ie_data()
    {
        return $this->belongsTo(Ie_data::class, 'ie_data_id');
    }
}
