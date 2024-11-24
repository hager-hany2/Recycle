<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileFormRequest extends FormRequest
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
            // validate data
            //1 hager@gmail.com
            //2 hager@gmail.com not correct because unique هيدور في id
            //required مطلوب لازم يكتبه
            'username'=>'string|min:2',
            'email'=>'unique:users,id|email',
            'phone'=>'required|unique:users,id',
//            'password'=>'required',
//            'type'=>'required',
            'category_user' =>'filled' ,// استخدمي 'sometimes' بدل 'filled' للتحقق من وجود الحقل فقط إذا كان موجودًا
//            'category_user'=>'filled',//request مينفعش يجي فاضي لكن لو مبعتهاش عادي pass
            'price'=>'filled|numeric',
            'point'=>'filled|numeric',
//            'image_url_profile'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            //'address'=>'sometimes|filled'
        ];
    }
}
