<?php

namespace App\Http\Requests\SecurityRequest;

use Illuminate\Foundation\Http\FormRequest;

class TrainingRoomRequest extends FormRequest
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
            'training_id' => 'required',
            'member_id' => 'required',
            'date_start' => 'required',
            'date_completed' => 'required',
            'result' => 'required',
            'note' => 'required',
        ];
    }
}
