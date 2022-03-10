<?php

namespace App\Http\Requests\SecurityRequest;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'required|unique:work_room|min:6|max:255',
            'location' => 'required|min:6|max:255',
        ];
    }
}
