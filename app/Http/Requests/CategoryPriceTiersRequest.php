<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class CategoryPriceTiersRequest extends FormRequest
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
            'event_id' => ['required','unique:category_price_tiers,event_id'],
            'low_price_range' => 'required',
            'medium_price_range' => 'required',
            'high_price_range' => 'required',
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
            'event_id.required' => 'The Type of Service field is required.',
            'event_id.unique' => 'The Type of Service has already been taken.',
            'low_price_range.required' => 'The Low price range field is required.',
            'medium_price_range.required' => 'The Medium price range field is required.',
            'high_price_range.required' => 'The High price range field is required.',
       ];
    }
}
