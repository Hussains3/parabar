<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIe_dataRequest extends FormRequest
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
            'bin_no' => 'nullable',
            'name' => 'required|unique:ie_datas,name',
            'ie' => 'nullable',
            'owners_name' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2024',
            'destination' => 'nullable',
            'office_address' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable',
            'house' => 'nullable',
            'note' => 'nullable'
        ];
    }
}
