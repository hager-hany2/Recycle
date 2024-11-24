<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormlogin;
use App\Http\Resources\UserResource;

use App\Services\TranslationGoogle;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    // start login
    public function Login(UserFormlogin $request)//make form UserFormlogin write validate data
    {
        $lang = $request->header('lang', 'en');// في حاله عدم تحقق الشرط تكون اللغة en
//        dd($lang);
        $translate = new TranslationGoogle($lang);//يستخدم لترجمة الجمل المطلوبة
//        dd($translate);
        $data=$request->validated();
//        dd($data);

        if (auth()->attempt($data)){//تقوم بتشفير كلمة المرور وتقوم بالتحقق من البيانات ال بتمر عليها
            $data=auth()->user();// تساعد للوصول الي البيانات  تفوم بالعمل إذا كان مسجل دخول المستخدم
//            dd($data);
            return response()->json([
                'message' => $translate->translate('Login successful')]);

        }else{
            return response()->json([
            'error' => $translate->translate('email or password not correct')],405);

        }

    }

}
//end login
