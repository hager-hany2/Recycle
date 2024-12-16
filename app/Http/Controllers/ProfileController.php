<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileFormRequest;
use App\Services\TranslationGoogle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function show(Request $request)
    {
        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function
        $user = Auth::user(); // جلب بيانات المستخدم الحالي

        return response()->json([
            'message' => $translator->translate('the data has displayed successfully'),
            "user" => $user,
            "avatar" => asset('/avatars/'.$user->image_url),
            "name" => $user["name"] ??  $user["username"], // ترجمة اسم المستخدم
            "username" => $translator->translate($user["username"]), // ترجمة اسم المستخدم
            'email' => $user['email'],
            'image_url_profile' => asset('/avatars/'.$user->image_url),
            'phone' => $user['phone'],
            "role" => $translator->translate($user["role"]), // ترجمة النوع
            "category_user" => $translator->translate($user["category_user"]), // ترجمة النوع
            'price' => $translator->translate($user["price"]),
            'point' => $translator->translate($user["point"]),
            "created_at" => $user["created_at"],
            "gender" => $user["Gender"],

        ], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        $user = \App\Models\User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json([
                'message' => $translator->translate('The user is not found')
            ], 404); // 404 Not Found
        }

        // Validate the request data
        $validated = $request->validate([
<<<<<<< HEAD
            'username' => 'required|string|regex:/^[A-Za-z0-9]+$/|max:255|unique:users,username,' . $id, // Unique username validation
            'email' => 'required|email|unique:users,email,' . $id, // Unique email validation
            'password' => 'nullable|string|min:8',
=======
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
>>>>>>> 0300525f4a97b5eec70b92647ce911221f0f9110
        ]);

        // Update user details
        $user->username = $validated['username'];
        $user->email = $validated['email'];

        // Update password only if provided
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        // Save the updated user
        $user->save();

        return response()->json([
            'message' => $translator->translate('Updated successfully'),
            'user' => $user
        ], 200); // 200 OK
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
