<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterCompany extends FormRequest
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
                Rule::in([2]),
            ],
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
            'company_name' => 'required|min:2|unique:users',
            'address' => 'required|min:5',
            'avatar' => 'nullable|file|mimes:jpeg,png',
            'contact_number' => 'required|regex:/^\d{9}$/',
            'about' => 'required|min:5',
            'website' => 'nullable|url',
            'industry_id' => 'required|exists:industries,id',
        ];
    }
}
