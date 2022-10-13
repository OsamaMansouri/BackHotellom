<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'category_id' => 'required',
            'name' => 'required|max:255',
            //'image' => 'required',
            //'description' => 'required|max:250',
            'price' => 'required|numeric',
            'cost' => 'numeric',
            'profit' => 'numeric'
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
            'name.required'  =>  'Name is required',
            'category_id.required'  =>  'category_id is required',
            //'image.required'  =>  'Image is required',
            //'description.required'     => 'Description is required',
            'price.required' => 'Price is required'
        ];
    }
}
