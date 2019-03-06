<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
          'type' => ['required', 'size:1'],
          'name' => ['required', 'min:3', 'max:255', 'string'],
          'description' => ['min:3', 'string', 'nullable'],
          'product_key' => ['required', 'unique:products', 'string'],
          'part_number' => ['string', 'nullable'],
          'por_id' => ['integer', 'unique:products', 'nullable'],
          'header' => ['string', 'nullable'],
          'quantity' => ['numeric', 'nullable'],
          'slug' => ['string', 'unique:products', 'nullable'],
          'model' => ['string', 'nullable'],
          'inactive' => ['boolean'],
          'hide_on_website' => ['boolean'],
          'categories.*' => ['integer', 'exists:product_categories,id'],
          'rates.*.time' => ['numeric', 'required_with:rates.*.rate', 'nullable'],
          'rates.*.period' => ['required_with:rates.*.time', 'numeric'],
          'rates.*.rate' => ['numeric', 'required_with:rates.*.time', 'nullable'],
          'manufacturer' => ['string', 'nullable']
        ];
    }
}
