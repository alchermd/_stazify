<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditStudentProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isStudent() && $this->user()->id === (int) $this->route('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
