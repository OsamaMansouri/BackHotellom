<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingsRequest extends FormRequest
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
            'logo'  =>  'required|mimes:jpeg,jpg,png,gif|max:5000',
            'licence_days'  =>  'required'
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
            'logo.required'  =>  'logo is required',
            'licence_days.required'  =>  'licence_days is required'
        ];
    }
}
