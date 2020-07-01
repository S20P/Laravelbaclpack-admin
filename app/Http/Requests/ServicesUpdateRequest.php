<?php

namespace App\Http\Requests;
use App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;

class ServicesUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
      
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric',
            // 'image' => 'required|mimes:jpeg,jpg,png,gif',
            // 'image_hover' => 'required|mimes:jpeg,jpg,png,gif',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price field is numeric.',
//            'location_id.required' => 'The location field is required.',
            'image.required' => 'The image field is required.',
            'image_hover.required' => 'The image field is required.',

        ];
    }
}
