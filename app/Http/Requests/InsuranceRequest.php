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
            'plan_name' => 'required|string|max:255',
            'effective_date' => 'required|date',
            'effective_date_end' => 'required|date|after_or_equal:effective_date',
            'policy_number' => 'required|string|max:255',
            'group_number' => 'required|string|max:255',
            'subscriber_employee' => 'required|string|max:255',
            'se_address' => 'required|string|max:255',
            'se_address_2' => 'nullable|string|max:255',
            'se_city' => 'required|string|max:255',
            'se_state' => 'required|string|max:255',
            'se_zip_code' => 'required|string|max:255',
            'se_country' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'subscriber' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:Male,Female,Other',
            's_s' => 'nullable|string|max:255',
            'subscriber_address' => 'required|string',
            'subscriber_address2' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'subscriber_phone' => 'nullable|string|max:255',
            'co_pay' => 'required|string|max:255',
            'accept_assignment' => 'required|string|max:255',
            'secondary_medicare_type' => 'nullable|string',
        ];
    }
}
