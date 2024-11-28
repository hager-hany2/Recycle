<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileFormRequest;
use App\Http\Requests\UserFormRequest;
use App\Services\TranslationGoogle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function __construct()
    {
        // تطبيق Middleware auth للتأكد من أن المستخدم مسجل الدخول
        $this->middleware('auth');
    }
    public function show(string $id,Request $request)
    {
        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function
        $user = User::find($id);

        return response()->json([
            'message' => $translator->translate('the data has displayed successfully'),
            "username" => $translator->translate($user["username"]), // ترجمة اسم المستخدم
            'email' => $user['email'],
            'image_url_profile' => $user['image_url_profile'],
            'phone' => $user['phone'],
            'password'=>$user['password'],
            "role" => $translator->translate($user["role"]), // ترجمة النوع
            "category_user" => $translator->translate($user["category_user"]), // ترجمة النوع
            'price'=> $translator->translate($user["price"]),
            'point'=> $translator->translate($user["point"]),

        ], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileFormRequest $request, string $id)
    {
        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function
        $user = User::find($id);
        if(!$user){

            return response()->json([
                'message' => $translator->translate('the user is not found'),
            ], 201);
        }
        $user->update($request->validated());
        return response()->json([
            'message' => $translator->translate('updated successfully'),
        ], 201);
    }
    public function edit($request)
    {
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function
        $user = auth()->user(); // جلب بيانات المستخدم الحالي
        return response()->json([
            'message' => $translator->translate('the user is not found'),
            "username" => $translator->translate($user["username"]), // ترجمة اسم المستخدم
            'email' => $user['email'],
            'phone' => $user['phone'],
            'password'=>$user['password'],
            "role" => $translator->translate($user["role"]), // ترجمة النوع
            "category_user" => $translator->translate($user["category_user"]), // ترجمة النوع
            'price'=> $translator->translate($user["price"]),
            'point'=> $translator->translate($user["point"]),
        ], 200); // إعادة البيانات بصيغة JSON
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
