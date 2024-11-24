<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_name' => 'required|string|unique:categories',
            'category_description' => 'required',
             'image_url'=>'required'
        ];
    }
    public function attributes(){
        return[
            'category_name'=>__('keywords.category_name'),
            'category_description'=>__('keywords.category_description'),
            'image_url'=>__('keywords.image_url'),
        ];
    }
    public function messages()
    {
        return[
            'category_name.required'=>__('keywords.error_msg_category_name'),
            'category_description.required'=>__('keywords.error_msg_category_description'),//يضع الرساله في حاله ظهور ايرور ونحطها في(keyword  ar en)
            'image_url.required'=>__('keywords.error_msg_image_url'),
        ];

    }

}
