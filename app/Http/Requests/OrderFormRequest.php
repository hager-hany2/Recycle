<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderFormRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',  // تأكد من وجود المستخدم
            'product_id' =>'required|exists:products,product_id',
            'address' => 'required|string',
            'phone' => 'required|string',
            'status' => 'required|in:pending,cancel,complete',
            'total_price' => 'required|numeric',
            'quantity' => 'required|integer',
        ];
    }
    public function attributes(){
        return[
            'user_id'=>__('keywords.user_id'),
            'product_id'=>__('keywords.product_id'),
            'address'=>__('keywords.address'),
            'phone'=>__('keywords.phone'),
            'status'=>__('keywords.status'),
            'total_price'=>__('keywords.total_price'),
            'quantity'=>__('keywords.quantity'),
        ];
    }
    public function messages()
    {
        return[
            'user_id.required'=>__('keywords.error_msg_user_id'),
            'product_id.required'=>__('keywords.error_msg_product_id'),//يضع الرساله في حاله ظهور ايرور ونحطها في(keyword  ar en)
            'address.required'=>__('keywords.error_msg_address'),
            'phone.required'=>__('keywords.error_msg_phone'),
            'status.required'=>__('keywords.error_msg_status'),//يضع الرساله في حاله ظهور ايرور ونحطها في(keyword  ar en)
            'total_price.required'=>__('keywords.error_msg_total_price'),
            'quantity.required'=>__('keywords.error_msg_quantity'),
        ];

    }
}
