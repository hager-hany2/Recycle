<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\TranslationGoogle;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle user login.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            // Set default language to 'en' if 'lang' header is not provided
            $lang = $request->header('lang', 'en');
            $translator = new TranslationGoogle($lang);

            // Validate user input
            $validatedData = $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:6',
            ]);

            // Attempt authentication
            if (!Auth::attempt($validatedData)) {
                return response()->json([
                    'error' => $translator->translate('Invalid email or password.'),
                ], 401);
            }

            $user = Auth::user();

            // Create a personal access token for the user
            $token = $user->createToken($user->id, ['*'], now()->addWeek());

            $expiresAt = Carbon::parse($token->accessToken->expires_at)->toDateTimeString();


            return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'avatar' => asset('/avatars/' . $user->image_url),
                'updated_at' => $user->updated_at,
                'token' => $token->plainTextToken,
                'token_expires_at' => $expiresAt,

            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => $translator->translate('Validation error.'),
                'details' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => $translator->translate('An unexpected error occurred.'),
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle user logout.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'error' => 'User is not authenticated.',
                ], 401);
            }

            // If logout from all devices is requested
            if ($request->boolean('allDevice')) {
                $user->tokens()->delete();

                return response()->json([
                    'message' => 'Logged out from all devices successfully.',
                ], 200);
            }

            // Logout from the current device
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logged out successfully.',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred during logout.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
