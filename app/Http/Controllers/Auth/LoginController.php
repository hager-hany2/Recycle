<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormlogin;
use App\Services\TranslationGoogle;

class LoginController extends Controller
{
    /**
     * Handle user login.
     *
     * @param UserFormlogin $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserFormlogin $request)
    {
        // Set default language to 'en' if 'lang' header is not provided
        $lang = $request->header('lang', 'en');

        // Initialize the translation service
        $translate = new TranslationGoogle($lang);

        // Validate user input using the custom form request
        $credentials = $request->validated();

        // __('')

        // Attempt to authenticate the user
        if (auth()->attempt($credentials)) {
            $user = auth()->user(); // Get authenticated user details

            return response()->json([
                'message' => $translate->translate('Login successful'),
                'user' => $user // Optionally include user data in the response
            ]);
        }

        // Return an error if authentication fails
        return response()->json([
            'error' => $translate->translate('Email or password is incorrect')
        ], 405);
    }
}
