<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIe_dataRequest extends FormRequest
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
            'org_name' => 'nullable',
            'org_logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2024',
            'bin_no' => 'nullable',
            'tin_no' => 'nullable',
            'name' => 'nullable',
            'fax_telephone' => 'nullable',
            'phone_primary' => 'nullable',
            'phone_secondary' => 'nullable',
            'whatsapp' => 'nullable',
            'email_primary' => 'nullable',
            'email_secondary' => 'nullable',
            'house_distric' => 'nullable',
            'address' => 'nullable',
            'commission_percentage' => 'nullable',
            'post' => 'nullable',
        ];
    }
}
