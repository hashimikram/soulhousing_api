<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicationRequest extends FormRequest
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
            'prescribe_date'=>'required|date',
            'days_supply'=>'required',
            'refills'=>'required',
            'dispense'=>'required',
            'dispense_unit'=>'required',
            'primary_diagnosis'=>'required',
            'secondary_diagnosis'=>'required',
            'patient_directions'=>'required',
        ];
    }
}
