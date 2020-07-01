<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class Supplier_servicesRequest extends FormRequest
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
            'supplier_id'=> 'required',
            'business_name' => 'required',
            'service_description' => 'required',
            'service_id' => 'required',
            'event_id' => 'required',
            'location' => 'required',
            'price_range' => 'required',
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
            'supplier_id.required'=>'The Supplier Name field is required.',
            'business_name.required' => 'The Business Name field is required.',
            'service_description.required' => 'The  Service description field is required.',
            'service_id.required' => 'The Type of service field is required.',
            'event_id.required' => 'The  Type of Event field is required.',
            'location.required' => 'The  Location field is required.',
            'price_range.required' => 'The  Price range field is required.',
       ];
    }
}
