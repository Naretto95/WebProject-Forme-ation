<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingFormRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255',
            'diploma' => 'required|string|max:255',
            'cost' => 'required|numeric|between:0,999.99',
            'date' => 'required|date',
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
            'Ncoord' => 'required|numeric|between:-99.9999,99.9999',
            'Ecoord' => 'required|numeric|between:-99.9999,99.9999',
            'region' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'funding' => 'required|string|max:1000',
            'prospect' => 'required|string|max:1000',
            'captcha' => 'required|captcha',
        ];
    }

        /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
