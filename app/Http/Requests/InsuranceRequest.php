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
