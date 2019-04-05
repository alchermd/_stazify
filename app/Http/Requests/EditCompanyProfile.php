<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCompanyProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isCompany() && $this->user()->id === (int) $this->route('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => 'required|min:2',
            'address' => 'required|min:5',
            'avatar' => 'nullable|file|mimes:jpeg,png',
            'contact_number' => 'required|regex:/^\d{9}$/',
            'about' => 'nullable|min:5',
            'website' => 'nullable|url',
            'industry_id' => 'required|exists:industries,id',
        ];
    }
}
