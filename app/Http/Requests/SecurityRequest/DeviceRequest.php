<?php

namespace App\Http\Requests\SecurityRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeviceRequest extends FormRequest
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
            'ip_address' => 'required',
            'user_login' => 'required|unique:device',
            'version_virus' => 'required',
            'member_id' => 'required|unique:device',
        ];

        // Handle when update not unique
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $data = $this->route()->parameter('device');
            $rules = [
                'user_login' => 'required|max:255',
                'member_id' => 'required',
                Rule::unique('device')->ignore($data),
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'member_id.required' => 'The member name has already been taken.',
        ];
    }
}
