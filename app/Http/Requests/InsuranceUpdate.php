<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceUpdate extends FormRequest
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
            'insurance_id' => 'required|exists:insurances,id',
            'auth_date' => 'nullable',
            'group_name' => 'nullable',
            'member_id' => 'nullable',
            'authorization_no' => 'nullable',
            'state' => 'nullable',
            'ins_phone' => 'nullable',
            'policy_holder_dob' => 'nullable|date',
            'age' => 'nullable',
        ];
    }
}
