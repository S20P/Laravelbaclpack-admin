<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class Supplier_servicesUpdateRequest extends FormRequest
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
            'business_name' => 'required',
            'service_description' => 'required',
            'price_range' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'business_name.required' => 'The Business Name field is required.',
            'service_description.required' => 'The  Service description field is required.',
            'price_range.required' => 'The  Price range field is required.',
       ];
    }
}
