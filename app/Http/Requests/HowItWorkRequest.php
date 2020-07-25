<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class HowItWorkRequest extends FormRequest
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
             'slug' => 'unique:how_does_it_works_module',
             'content' => 'required|min:5',
             'slide_number' => 'integer|min:0',
             'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'slug.required' => 'The slug field is required.',
            'slug.unique' => 'this slug already exist.Try another one.',
            'content.required' => 'The Content Description field is required.',
            'image.mimes'=>' The Image field is required and must be a file of type: jpeg, jpg, png, gif.'
        ];
    }
}
