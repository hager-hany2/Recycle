<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class callbackFormRequest extends FormRequest
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
            'Amount_paid' => 'required|numeric',
            'transaction_id'=>'required',
            'status'=>'required'
        ];

    }
    public function attributes(){
        return[
            'Amount_paid'=>__('keywords.Amount_paid'),
            'transaction_id'=>__('keywords.transaction_id'),
            'status'=>__('keywords.status'),
        ];
    }
    public function messages()
    {
        return[
            'Amount_paid.required'=>__('keywords.error_msg_Amount_paid'),
            'transaction_id.required'=>__('keywords.error_msg_transaction_id'),//يضع الرساله في حاله ظهور ايرور ونحطها في(keyword  ar en)
            'status.required'=>__('keywords.error_msg_status'),
        ];

    }
}
