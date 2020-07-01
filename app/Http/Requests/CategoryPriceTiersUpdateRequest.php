<?php

namespace App\Http\Requests;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryPriceTiersUpdateRequest extends FormRequest
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
            'event_id' => ['required','unique:category_price_tiers,event_id,'.$this->id],
            'low_price_range' => 'required',
            'medium_price_range' => 'required',
            'high_price_range' => 'required',
        ];
    }

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
