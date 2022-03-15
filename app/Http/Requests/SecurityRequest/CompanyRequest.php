<?php

namespace App\Http\Requests\SecurityRequest;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $rules = [
            'name' => 'required|min:6|max:255|unique:company',
            'address' => 'required|min:6|max:255',
            'email' => 'required|email|max:255|unique:company',
            'phone' => 'required|max:11',
            'date_incorporation' => 'required',
        ];

        // Handle when update not unique
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $company = $this->route()->parameter('company');
            $rules = [
                'name' => 'required|min:6|max:255',
                'email' => 'required|email|max:255',
                Rule::unique('company')->ignore($company),
            ];
        }

        return $rules;
    }

}
