<?php

namespace App\Http\Requests;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
            'email' =>  ['required', 'string', 'email'],
            'password' => 'confirmed',
            'phone' => ['required', 'numeric'],
            'image' => ['mimes:jpeg,jpg,png,gif'],
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
            'image.required' => 'The Image field is required.',
            'image.mimes'=>' The Image field is required and must be a file of type: jpeg, jpg, png, gif.',
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
