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
            'insurance_id' => 'required',
            'group_name' => 'required',
            'policy_no' => 'required',
            'policy_holder' => 'required',
            'ins_phone' => 'required',
            'policy' => 'required',
            'age' => 'nullable',
            'policy_holder_dob' => 'nullable|date',
            'zip_code' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'address' => 'nullable',
        ];
    }
}
