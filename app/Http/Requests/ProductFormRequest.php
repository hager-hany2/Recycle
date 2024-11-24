<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
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
            'product_name' => 'required|string',
            'product_description' => 'required',
            'price_product'=>'required',
            'point_product'=>'required',
            'category_name'=>'required',
            'image_url'=>'required',
            'QuantityType'=>'required',
        ];
    }
    public function attributes(){
        return[
            'product_name'=>__('keywords.product_name'),
            'product_description'=>__('keywords.product_description'),
            'category_name'=>__('keywords.category_name'),
            'image_url'=>__('keywords.image_url_product'),
            'QuantityType'=>__('keywords.QuantityType'),

        ];
    }
    public function messages()
    {
        return[
            'product_name.required'=>__('keywords.error_msg_product_name'),
            'product_description.required'=>__('keywords.error_msg_product_description'),//يضع الرساله في حاله ظهور ايرور ونحطها في(keyword  ar en)
            'category_name.required'=>__('keywords.error_msg_category_name'),
            'image_url.required'=>__('keywords.error_msg_image_url_product'),
            'QuantityType'=>__('keywords.error_msg_QuantityType')
        ];

    }
}
