<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'categories.*' => ['integer', 'exists:product_categories,id'],
          'por_category' => ['integer', 'nullable'],
          'description' => ['min:3', 'string', 'nullable'],
          'header' => ['string', 'nullable'],
          'hide_on_website' => ['boolean'],
          'images.*' => ['image', 'nullable'],
          'inactive' => ['boolean'],
          'manufacturer' => ['string', 'nullable'],
          'model' => ['string', 'nullable'],
          'name' => ['required', 'min:3', 'max:255', 'string'],
          'part_number' => ['string', 'nullable'],
          'por_id' => ['integer', 'nullable'],
          'product_key' => ['required', 'string'],
          'rates.*.period' => ['numeric', 'nullable'],
          'rates.*.rate' => ['numeric', 'required_with:rates.*.time', 'nullable'],
          'rates.*.time' => ['numeric', 'required_with:rates.*.rate', 'nullable'],
          'quantity' => ['numeric', 'nullable'],
          'slug' => ['string', 'nullable'],
          'type' => ['required', 'size:1'],
          'weight' => ['numeric', 'nullable']
        ];
    }
}
