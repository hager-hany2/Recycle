<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentFormRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',  // التحقق من وجود المستخدم
            'order_id' => 'required|exists:orders,order_id',  // التحقق من وجود الطلب
            'Amount_paid' => 'required|numeric|min:1',  // التحقق من المبلغ
            'status' => 'required|in:pending,cancel,complete',
            'transaction_id'=>'required',
            'payment_method'=>'required',
            'phone'=>'required',
        ];
    }
    public function attributes(){
        return[
            'user_id'=>__('keywords.user_id'),
            'order_id'=>__('keywords.order_id'),
            'status'=>__('keywords.status'),
            'Amount_paid'=>__('keywords.Amount_paid'),
            'transaction_id'=>__('keywords.transaction_id'),
            'payment_method'=>__('keywords.payment_method'),
        ];
    }
    public function messages()
    {
        return[
            'user_id.required'=>__('keywords.error_msg_user_id'),
            'order_id.required'=>__('keywords.error_msg_order_id'),
            'status.required'=>__('keywords.error_msg_status'),
            'Amount_paid.required'=>__('keywords.error_msg_Amount_paid'),
            'transaction_id.required'=>__('keywords.error_msg_transaction_id'),//يضع الرساله في حاله ظهور ايرور ونحطها في(keyword  ar en)
            'payment_method.required'=>__('keywords.error_msg_payment_method'),
        ];

    }
}
