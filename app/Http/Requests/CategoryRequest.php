<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'hotel_id' => 'required',
            'name'  =>  'required|max:255',
            'icon'  =>  'required',
            'startTime'     => 'required',
            'endTime'      => 'required',
            'Sequence' => 'required'
        ];
    }


    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'hotel_id.required' => 'hotel is required',
            'name.required'  =>  'name is required',
            'icon.required'  =>  'icon is required',
            'startTime.required'     => 'Start time is required',
            'endTime.required'      => 'End time is required',
            'Sequence.required' => 'Sequence is required'
        ];
    }
}
