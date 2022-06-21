<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProlongationRequest extends FormRequest
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
            'hotel_id'      => 'required',
            'number_days'   => 'required'
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
            'hotel_id.required'     => 'Hotel is required',
            'number_days.required'  => 'Start date is required'
        ];
    }
}
