<?php

namespace App\Http\Requests\SecurityRequest;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'ip_address' => 'required',
            'user_login' => 'required|unique:device',
            'version_virus' => 'required',
            'member_id' => 'required|unique:device',
        ];
    }

    public function messages()
    {
        return [
            'member_id.required' => 'The member name has already been taken.',
        ];
    }
}
