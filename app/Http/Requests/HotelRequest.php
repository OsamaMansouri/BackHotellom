<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
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
            /* 'user_id' => 'required', */
            'name' => 'required',
            'country'  => 'required',
            'city'     => 'required',
            'address'      => 'required',
            'status'      => 'required',
            'ice'      => 'numeric',
            'idf'      => 'numeric',
            'rc'      => 'numeric',
            'rib'      => 'numeric'
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
            'user_id.required' => 'user is required',
            'name.required' => 'name is required',
            'country.required'  => 'country is required',
            'city.required'     => 'city is required',
            'address.required'      => 'address is required',
            'status.required'      => 'status is required',
            'ice.numeric'      => 'ICE must be a number',
            'if.numeric'      => 'I-F must be a number',
            'rc.numeric'      => 'R-C must be a number',
            'rib.numeric'      => 'RIB must be a number'
        ];
    }
}
