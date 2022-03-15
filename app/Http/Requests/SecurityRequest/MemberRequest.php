<?php

namespace App\Http\Requests\SecurityRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
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
            'name' => 'required|unique:member|min:4|max:255',
            'email' => 'required|email|unique:member|max:255',
            'address' => 'required|min:4|max:255',
            'phone_number' => 'required|max:11',
            'work_position' => 'required|min:2|max:255',
            'date_join_company' => 'required',
            'company_id' => 'required',
        ];

        // Handle when update not unique
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $data = $this->route()->parameter('member');
            $rules = [
                'name' => 'required|min:4|max:255',
                'email' => 'required|email|max:255',
                Rule::unique('member')->ignore($data),
            ];
        }

        return $rules;
    }
}
