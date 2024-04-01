<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'type'=>'required',
            'first_name'=>'required',
            'middle_name'=>'required',
            'relationship'=>'required',
        ];
    }
}
