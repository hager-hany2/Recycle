<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use App\traits\upload_image;
use Illuminate\Http\Request;
use App\Models\Images;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    use upload_image;
    public function Register(UserFormRequest $request)
    {
            // make request to validate data
        $lang = $request->header('lang', 'en');
        $translate = new GoogleTranslate($lang);
//        dd($lang); //test lang
        $data=$request->validated();
        //if Duplicate email
        if ($existingUser = User::where('email', $request->email)->orWhere('phone', $request->phone)->first())
            return response()->json(['error' => $existingUser->email === $request->email
                ? $translate->translate('already has been email')
                : $translate->translate('already has been phone')],
                $existingUser->email === $request->email ? 401 : 403);
        //upload image
        $imagePath = $this->upload($request);
         $imagePath ?
            response()->json(['image_url' => $imagePath], 200) :
            response()->json(['image_url' => asset('images/96fe121-5dfa-43f4-98b5-db50019738a7.jpg')], 200);
        //$data['password'] =bcrypt($data['password']);
        //hashed password improve this (add function in model)because in edit profile repeat the best not repeat
        $user=User::query()->create($data);//create new user in database in PhpMyAdmin
//        dd($user);
        // إنشاء توكن جديد للمستخدم
        $token =$user->createToken('YourAppName')->plainTextToken;
//        dd($token);
//        dd($image);
        if ($user) {
            return response()->json([
                'message' => $translate->translate('Registration successful!'),
            ], 201); // رمز الاستجابة 201

        } else {
            // استخدام json_encode مع JSON_UNESCAPED_UNICODE
            return response()->json([
                'error' => json_encode($translate->translate('Registration failed'), JSON_UNESCAPED_UNICODE)
            ], 403); // رمز الاستجابة 403
        }


    }
}
