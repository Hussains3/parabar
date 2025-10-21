<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFile_dataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'be_number' => 'nullable|unique:file_datas,be_number',
            'manifest_number' => 'nullable|string|max:255',
            'package' => 'nullable|string|max:255',
            'file_date' => 'nullable|string|date_format:d/m/Y',
            'lc_no' => 'nullable|string|max:255',
            'lc_value' => 'nullable|string|max:255',
            'lc_bank' => 'nullable|string|max:255',
            'bill_no' => 'nullable|string|max:255',
            'actual_coat_fee' => 'nullable|integer|min:0',
            'bill_coat_fee' => 'nullable|integer|min:0',
            'actual_asso_be_entry_fee' => 'nullable|integer|min:0',
            'bill_asso_be_entry_fee' => 'nullable|integer|min:0',
            'actual_cargo_branch_aro' => 'nullable|integer|min:0',
            'bill_cargo_branch_aro' => 'nullable|integer|min:0',
            'actual_cargo_branch_ro' => 'nullable|integer|min:0',
            'bill_cargo_branch_ro' => 'nullable|integer|min:0',
            'actual_cargo_branch_ac' => 'nullable|integer|min:0',
            'bill_cargo_branch_ac' => 'nullable|integer|min:0',
            'actual_manifest_dept' => 'nullable|integer|min:0',
            'bill_manifest_dept' => 'nullable|integer|min:0',
            'actual_fourtytwo_shed_aro' => 'nullable|integer|min:0',
            'bill_fourtytwo_shed_aro' => 'nullable|integer|min:0',
            'actual_examination_normal' => 'nullable|integer|min:0',
            'actual_examination_irm' => 'nullable|integer|min:0',
            'actual_examination_goinda' => 'nullable|integer|min:0',
            'bill_examination_normal' => 'nullable|integer|min:0',
            'bill_examination_irm' => 'nullable|integer|min:0',
            'bill_examination_goinda' => 'nullable|integer|min:0',
            'actual_assessement_aro' => 'nullable|integer|min:0',
            'actual_assessement_ro' => 'nullable|integer|min:0',
            'actual_assessement_ac' => 'nullable|integer|min:0',
            'actual_assessement_dc' => 'nullable|integer|min:0',
            'actual_assessement_jc' => 'nullable|integer|min:0',
            'actual_assessement_adc' => 'nullable|integer|min:0',
            'actual_assessement_commissionar' => 'nullable|integer|min:0',
            'bill_assessement_aro' => 'nullable|integer|min:0',
            'bill_assessement_ro' => 'nullable|integer|min:0',
            'bill_assessement_ac' => 'nullable|integer|min:0',
            'bill_assessement_dc' => 'nullable|integer|min:0',
            'accual_total' => 'nullable|numeric|min:0',
            'ie_data_id' => 'required|numeric',
        ];
    }
}
