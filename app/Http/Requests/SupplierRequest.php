<?php

namespace App\Http\Requests;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'name' => 'required',
            'email' =>  ['required', 'string', 'email','unique:supplier_profile,email'],
            'phone' => ['required', 'numeric'],
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'business_name' => 'required',
            'service_description' => 'required',
            'service_id' => 'required',
            'event_id' => 'required',
            'location' => 'required',
            'price_range' => 'required',
            // 'account_holder_name' => 'required',
            // 'account_number' => 'required',
            // 'ifsc' => 'required',
            // 'bank_name' => 'required',
            // 'bank_address' => 'required',
            // 'iban' => 'required',
            // 'sortcode' => 'required',
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
            'name.required' => 'The Name field is required.',
            'email.required' => 'The Email field is required.',
            'phone.required' => 'The Phone field is required.',
            'password.required' => 'The Password field is required.',
            'password_confirmation.required' => 'The Password confirmation field is required.',
            'image.required' => 'The Image field is required.',
            'image.mimes'=>' The Image must be a file of type: jpeg, jpg, png, gif.',
            'business_name.required' => 'The Business Name field is required.',
            'service_description.required' => 'The  Service description field is required.',
            'service_id.required' => 'The Type of service field is required.',
            'event_id.required' => 'The  Type of Event field is required.',
            'location.required' => 'The  Location field is required.',
            'price_range.required' => 'The  Price range field is required.',
            'account_holder_name.required' => 'The  Account Holder Name field is required.',
            'account_number.required' => 'The  Account Number field is required.',
            'ifsc.required' => 'The  IFSC field is required.',
            'bank_name.required' => 'The  Bank Name field is required.',
            'bank_address.required' => 'The Bank Address field is required.',
            'iban.required' => 'The  IBAN field is required.',
            'sortcode.required' => 'The Sort code field is required.',
       ];
    }
}
