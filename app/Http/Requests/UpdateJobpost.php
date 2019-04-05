<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateJobpost extends FormRequest
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
            'title' => 'required|min:2',
            'description' => 'required|min:2',
            'qualifications' => 'required|min:2',
            'required_skills' => 'required|min:2',
            'deadline_month' => 'required|between:1,12',
            'deadline_day' => 'required|between:1,31',
            'deadline_year' => 'required|gte:' . Carbon::now()->year . '|lte:' . Carbon::now()->addYears(3)->year,
        ];
    }
}
