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
