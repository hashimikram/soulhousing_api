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
            'insurance_name'=>'required',
            'policy_no'=>'required',
            'subscriber'=>'required',
            'subscriber_relation'   => 'required',
            'insurance_type' => 'required|in:1,2,3',
        ];
    }
}
