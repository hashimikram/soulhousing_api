<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'nullable|string|max:255|unique:user_details,user_name',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'gender' => 'nullable|in:Male,Female,Other',
            'date_of_birth' => 'nullable|date',
            'city' => 'nullable',
            'country' => 'nullable',
            'user_type' => 'required|in:provider,nurse,maintenance,operation',
        ];
    }
}
