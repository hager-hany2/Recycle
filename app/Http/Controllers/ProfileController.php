<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\TranslationGoogle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


    public function show(Request $request)
    {
        // Add translation service
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);

        // Call the TranslationGoogle service and ensure it inherits the necessary methods
        $user = Auth::user(); // Get the current authenticated user

        return response()->json([
            'message' => $translator->translate('The data has been displayed successfully'),
            "user" => $user,
            "avatar" => url(asset('/avatars/' . $user->image_url)),
            "name" => $user["name"] ??  $user["username"], // Translated user name
            "username" => $translator->translate($user["username"]), // Translated username
            'email' => $user['email'],
            'image_url_profile' => asset('/avatars/' . $user->image_url),
            'phone' => $user['phone'],
            "role" => $translator->translate($user["role"]), // Translated role
            "category_user" => $translator->translate($user["category_user"]), // Translated user category
            'price' => $translator->translate($user["price"]),
            'point' => $translator->translate($user["point"]),
            "created_at" => $user["created_at"],
            "gender" => $user["Gender"],
        ], 201);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    public function updateApi(Request $request, $id)
    {
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        $user = Auth::user();

        // Check if the user exists
        if (!$user) {
            return response()->json([
                'message' => $translator->translate('The user was not found')
            ], 404); // 404 Not Found
        }

        // Validate the request data
        $validated = $request->validate([
            'username' => 'required|string|regex:/^[A-Za-z0-9]+$/|max:255|unique:users,username,' . $id, // Unique username validation
            'email' => 'required|email|unique:users,email,' . $id, // Unique email validation
            'password' => 'nullable|string|min:8',
            'avatar' => 'integer|between:1,80', // Ensure 'avatar' is an integer within 1 to 80
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
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
