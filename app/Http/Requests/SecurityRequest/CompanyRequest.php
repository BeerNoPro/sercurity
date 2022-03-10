<?php

namespace App\Http\Requests\SecurityRequest;

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
        return [
            'name' => 'bail|required|unique:company|min:6|max:255',
            'address' => 'bail|required|min:6|max:255',
            'email' => 'bail|required|email|unique:company|max:255',
            'phone' => 'bail|required|max:11',
            'date_incorporation' => 'bail|required'
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'name.required' => 'Required custom demo.',
    //         'address.required'  => 'Required custom demo.',
    //         'email.required'  => 'Required custom demo.',
    //         'phone.required'  => 'The phone field is required.',
    //         'date_incorporation.required'  => 'The date field is required.',
    //     ];
    // }

    // public function getData()
    // {
    //     $data = $this->only(['name','address','email','phone','date_incorporation']);
    //     return $data;
    // }
}
