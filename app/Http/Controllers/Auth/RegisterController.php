<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class RegisterController extends Controller
{


    public function index(UserFormRequest $request)
    {
        $lang = $request->header('lang', 'en');
        $translate = new GoogleTranslate($lang);

        // Validate incoming request data
        $data = $request->validated();

        // Check for duplicate email or phone
        $existingUser = User::where('email', $data['email'])->orWhere('phone', $data['phone'])->first();
        if ($existingUser) {
            $error = $existingUser->email === $data['email']
                ? 'Email already exists'
                : 'Phone already exists';
            return response()->json(['error' => $translate->translate($error)], 409);
        }

        // Upload image if provided
        $imagePath = $this->upload($request);
        $data['image_url_profile'] = $imagePath ?? asset('images/default-profile.jpg');

        // Hash password (use model mutator for consistency)
        $data['password'] = bcrypt($data['password']);

        // Create the new user
        $user = User::create($data);

        if ($user) {
            // Generate an API token
            $token = $user->createToken('YourAppName')->plainTextToken;

            return response()->json([
                'message' => $translate->translate('Registration successful!'),
                'user' => $user,
                'token' => $token,
            ], 201);
        }

        return response()->json([
            'error' => $translate->translate('Registration failed'),
        ], 500);
    }

    /**
     * Handle file upload.
     *
     * @param Request $request
     * @return string|null
     */
    private function upload(Request $request): ?string
    {
        if ($request->hasFile('image_url_profile') && $request->file('image_url_profile')->isValid()) {
            $file = $request->file('image_url_profile');
            return $file->store('profiles', 'public');
        }
        return null;
    }

}
