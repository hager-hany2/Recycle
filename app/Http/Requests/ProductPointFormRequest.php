<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductPointFormRequest extends FormRequest
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
            // "user_id" => 'required',
            "name" =>'required',
            "point" =>'filled',
            "image_url" => 'required',


        ];
    }
    public function attributes(){
        return[
            // 'user_id'=>__('keywords.user_id'),
            'name'=>__('keywords.name'),
            'image_url'=>__('keywords.image_url_product'),
            'point'=>__('keywords.point'),

        ];
    }
    public function messages()
    {
        return[
            // 'user_id.required'=>__('keywords.error_msg_user_id'),
            'image_url.required'=>__('keywords.error_msg_image_url'),
            'name'=>__('keywords.error_msg_name'),
            'point'=>__('keywords.error_msg_point')
        ];

    }
}
