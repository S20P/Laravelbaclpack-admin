<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class HowItWorkUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
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
             'heading' => 'required|min:5',
             'content' => 'required|min:5',
             'slide_number' => 'integer|min:0',
             'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'heading.required' => 'The Heading field is required.',
            'content.required' => 'The Content Description field is required.',
            'image.required' => 'The Image field is required.',
            'image.mimes'=>' The Image must be a file of type: jpeg, jpg, png, gif.',
        ];
    }
}
