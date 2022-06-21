<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffersRequest extends FormRequest
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
            'type_id' => 'required',
            'description' => 'required|max:255',
            'prix' => 'required|numeric|min:0',
            //'Frequency' => 'required|numeric|min:0|max:3',
            'titre' => 'required|max:255',
            'startDate' => 'required',
            'endDate' => 'required',
            'image' => 'required',
            'discount' => 'required|numeric|max:100',
            'startTime' => 'required'
        ];
    }

    /**
     * Custom message for validation
     * @return array
     */
    public function messages()
    {
        return [
            //'hotel_id.required' => 'Hotel is required required',
            'image.required' => 'Image is required',
            'description.required' => 'Description required',
            'prix.required' => 'Price is required',
            //'Frequency.required' => 'Frequency is required',
            'endDate.required' => 'End Date is required',
            'startDate.required' => 'Start Date is required',
            'titre.required' => 'Title is required',
            'discount.required' => 'Discount is required',
            'type_id.required' => 'Type is required',
            'startTime.required' => 'Start Time is required'
        ];
    }
}
