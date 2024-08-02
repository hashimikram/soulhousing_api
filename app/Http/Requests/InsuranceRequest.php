<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'group_name' => 'nullable',
            'policy_no' => 'nullable',
            'policy_holder' => 'nullable',
            'ins_phone' => 'nullable',
            'policy' => 'nullable',
            'age' => 'nullable',
            'policy_holder_dob' => 'nullable|date',
            'zip_code' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'address' => 'nullable',
        ];
    }
}
