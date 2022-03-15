<?php

namespace App\Http\Requests\SecurityRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CabinetRequest extends FormRequest
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
            'name' => 'required',
            'work_room_id' => 'required|unique:carbinet',
            'member_id' => 'required|unique:carbinet',
        ];

        // Handle when update not unique
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $data = $this->route()->parameter('carbinet');
            $rules = [
                'work_room_id' => 'required',
                'member_id' => 'required',
                Rule::unique('carbinet')->ignore($data),
            ];
        }

        return $rules;
    }
}
