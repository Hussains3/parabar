<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;  // Allow updates
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'be_number' => 'required|string',
            'type' => 'required|in:IM,EX',
            'status' => 'required|in:Paid,Unpaid',
            'fees' => 'required|numeric|min:0',
            'agent_id' => 'nullable|exists:agents,id'
        ];
    }
}
