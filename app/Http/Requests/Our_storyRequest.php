<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class Our_storyRequest extends FormRequest
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
            'section1_subtitle' => 'required',
            'section1_title' => 'required',
            'section1_description_title' => 'required',
            'section1_description' => 'required',
            'section2_subtitle' => 'required',
            'section2_tile' => 'required',
            'section2_description_title' => 'required',
            'section2_description' => 'required',
            'section3_subtitle' => 'required',
            'sectio3_title' => 'required',
            'section3_description_title' => 'required',
            'section3_description' => 'required',
            'color1' => 'required',
            'color2' => 'required',
            'color3' => 'required',
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
            //
        ];
    }
}
