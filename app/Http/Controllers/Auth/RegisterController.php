<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class RegisterController extends Controller
{


    public function index(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users',
                'phone' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            // Prepare user data with default settings
            $data = $validatedData;
            $data['role'] = 'user';
            $data['category_user'] = 'home';

            // Set language for translations, default to English
            $lang = $request->header('lang', 'en');
            $translate = new GoogleTranslate($lang);

            // Upload image if provided, otherwise use default
            $data['image_url_profile'] = $this->upload($request) ?? 'images/default-profile.jpg';

            // Hash password securely
            $data['password'] = bcrypt($data['password']);

            // Create the user
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
                'role' => $data['role'],
                'category_user' => $data['category_user'],
                'image_url_profile' => $data['image_url_profile'],
            ]);

            // Generate an API token
            $token = $user->createToken($user->id, ['*'], now()->addWeek());
            $expiresAt = Carbon::parse($token->accessToken->expires_at)->toDateTimeString();
            return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'updated_at' => $user->updated_at,
                'token' => $token->plainTextToken,
                'token_expires_at' => $expiresAt,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            // Handle validation exceptions
            return response()->json([
                'error' => $validationException->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle general exceptions
            $lang = $request->header('lang', 'en');
            $translate = new GoogleTranslate($lang);

            return response()->json([
                'error' => $translate->translate('Registration failed. Please try again later.'),
                'details' => env('APP_DEBUG') ? $e->getMessage() : null,
            ], 500);
        }
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
