<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            //'hotel_id' => 'required',
            'name' => 'required|max:255',
            'type_id'  => 'required',
            'color'  => 'required|max:255',
            'pdf_file'  => 'required',
            'menu'  => 'required|max:255',
            'startTime'     => 'required',
            'size'     => 'required',
            'endTime'      => 'required',
            'description'      => 'required',
            'sequence'      => 'required',
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
            //'hotel_id.required' => 'hotel is required',
            'name.required'  =>  'name is required',
            'type_id.required'  => 'type is required',
            'color.required'  => 'color is required',
            'pdf_file.required'  => 'pdf is required',
            'menu.required'  => 'menu is required',
            'startTime.required'     => 'startTime is required',
            'endTime.required'      => 'endTime is required',
            'description.required'      => 'description is required',
            'sequence.required' => 'Sequence is required',
            'size.required' => 'Size is required'
        ];
    }
}
