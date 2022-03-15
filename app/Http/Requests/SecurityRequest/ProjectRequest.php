<?php

namespace App\Http\Requests\SecurityRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
            'name' => 'required|unique:project|min:6|max:255',
            'time_start' => 'required',
            'time_completed' => 'required',
            'company_id' => 'required',
            'work_room_id' => 'required',
        ];

        // Handle when update not unique
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $data = $this->route()->parameter('project');
            $rules = [
                'name' => 'required|min:6|max:255',
                Rule::unique('project')->ignore($data),
            ];
        }

        return $rules;
    }
}
