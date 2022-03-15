<?php

namespace App\Http\Requests\SecurityRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkRoomRequest extends FormRequest
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
            'name' => 'required|unique:work_room|min:6|max:255',
            'location' => 'required|min:6|max:255',
        ];

        // Handle when update not unique
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $workRoom = $this->route()->parameter('work_room');
            $rules['name'] = [
                'required',
                'min:6',
                'max:255',
                Rule::unique('work_room')->ignore($workRoom),
            ];
        }
        
        return $rules;
    }
}
