<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDischargedPatientsRequest extends FormRequest
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
            'provider_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:patients,id',
            'admission_id' => 'required|exists:admission_discharges,id',
            'date_of_discharge' => 'nullable|date',
            'acknowledgment_of_discharge' => 'nullable|string',
            'release_of_liability' => 'nullable|string',
            'acknowledgment-of-receipt-of-belongings-and-medication' => 'nullable|string',
            'belongings' => 'nullable|string',
            'medications' => 'nullable|string',
            'patient_signature' => 'nullable|string',
            'staff_witness_signature' => 'nullable|string',
            'patient_signature_date' => 'nullable|date',
            'staff_signature_date' => 'nullable|date',
        ];
    }
}
