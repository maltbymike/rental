<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
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
          'description' => ['min:3', 'string', 'nullable'],
          'featured.*' => ['integer', 'nullable'],
          'image' => ['image', 'nullable'],
          'inactive' => ['boolean'],
          'name' => ['required', 'min:3', 'max:255', 'string'],
          'parent_id' => ['exists:product_categories,id', 'nullable'],
          'por_id' => ['integer', 'nullable'],
          'slug' => ['string', 'nullable'],
        ];
    }
}
