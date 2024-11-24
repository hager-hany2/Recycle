<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;//Allow login and validate
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // validate data
            //1 hager@gmail.com
            //2 hager@gmail.com not correct because unique هيدور في id
            //required مطلوب لازم يكتبه
            'username'=>'required',
            'email'=>'required|email|unique:users,id',
            'phone'=>'required|unique:users,id',
            'password'=>'required',
            'type'=>'required',
            'category_user' =>'required' ,
            // استخدمي 'sometimes' بدل 'filled' للتحقق من وجود الحقل فقط إذا كان موجودًا
            'price'=>'filled|numeric',
            'point'=>'filled|numeric',
            'Gender'=>'required',

//            'image_url_profile'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            //'address'=>'sometimes|filled'
        ];

    }

    public function attributes(){
        return[
            'username'=>__('keywords.username'),
            'email'=>__('keywords.email'),
            'password'=>__('keywords.password'),
            'phone'=>__('keywords.phone'),
            'type'=>__('keywords.type'),
            'category_user'=>__('keywords.category_user'),
            'Gender'=>__('keywords.Gender')
        ];
    }
    public function messages()
    {
        return[
            'type.required'=>__('keywords.error_msg_type'),
            'username.required'=>__('keywords.error_msg_username'),//يضع الرساله في حاله ظهور ايرور ونحطها في(keyword  ar en)
            'email.required'=>__('keywords.error_msg_email'),
            'password.required'=>__('keywords.error_msg_password'),
            'phone.required'=>__('keywords.error_msg_phone'),
            'category_user'=>__('keywords.error_msg_category_user'),
            'Gender'=>__('keywords.error_msg_Gender')
        ];

    }
}
