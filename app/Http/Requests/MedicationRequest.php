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
            'title' => 'required',
            'strength' => 'nullable',
            'begin_date' => 'required|date',
            'end_date' => 'nullable|date',
            'referred_by' => 'nullable',
            'dosage_unit' => 'required',
            'dose' => 'required',
        ];
    }
}
