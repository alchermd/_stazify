<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterStudent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_type' => [
                'required',
                Rule::in([1]),
            ],
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'age' => 'required|numeric|min:15',
            'address' => 'required|min:5',
            'avatar' => 'nullable|file|mimes:jpeg,png',
            'about' => 'min:5',
            'contact_number' => 'required|regex:/^\d{9}$/',
            'school' => 'min:2',
            'course_id' => 'required|exists:courses,id',
            'resume' => 'nullable|file|mimes:pdf',
        ];
    }
}
