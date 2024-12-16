<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\Concerns\Has;
use Stichoza\GoogleTranslate\GoogleTranslate;

class RegisterController extends Controller
{


    public function index(Request $request)
    {
        try {



            //username Validation
            $username = $request->username;




            $validatedData = $request->validate([
                'username' => 'required|string|max:255|min:3|unique:users|regex:/^\\S+$/',
                'email' => 'required|email|max:255|unique:users',
                'phone' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);


            $data = $validatedData;
            $data['role'] = 'user';
            $data['category_user'] = 'home';
            // Random Number 1 to 100
            $number = rand(1, 100);
            $data['image_url'] = $number . '.png';
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);
            $token = $user->createToken($user->id, ['*'], now()->addWeek());
            $expiresAt = Carbon::parse($token->accessToken->expires_at)->toDateTimeString();

            return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'token' => $token->plainTextToken,
                'token_expires_at' => $expiresAt,
                'avatar' => url(asset('/avatars/' . $user->image_url)),
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registration failed.'], 500);
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
