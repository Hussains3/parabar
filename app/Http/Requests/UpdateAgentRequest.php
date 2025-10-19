<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgentRequest extends FormRequest
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
            'ain_no' => 'required|string',
            'name' => 'required|string',
            'bangla_name' => 'nullable|string',
            'license_no' => 'nullable|string',
            'license_issue_date' => 'nullable|date',
            'membership_no' => 'nullable|string',
            'agency_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'owners_name' => 'nullable|string',
            'owners_gender' => 'nullable|in:Male,Female,Other',
            'owner_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'owners_designation' => 'nullable|string',
            'office_address' => 'nullable|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'house' => 'required|string',
            'parmanent_address' => 'nullable|string',
            'note' => 'nullable|string',
        ];
    }
}
