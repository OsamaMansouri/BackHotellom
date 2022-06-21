<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LicenceRequest extends FormRequest
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
            'startDate'     => 'required',
            'endDate'      => 'required'
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
            'startDate.required'     => 'Start date is required',
            'endDate.required'      => 'End date is required'
        ];
    }
}
