<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomepageCarouselRequest extends FormRequest
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
          'image' => ['image', 'required'],
          'title' => ['string', 'nullable'],
          'caption' => ['string', 'nullable'],
          'button_text' => ['string', 'nullable'],
          'link_to' => ['string', 'nullable'],
          'inactive' => ['boolean']
        ];
    }
}
