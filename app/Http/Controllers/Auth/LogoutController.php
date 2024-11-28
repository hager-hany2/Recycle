<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\TranslationGoogle;
use Illuminate\Support\Facades\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function logout(Request $request)
    {
        $lang = $request->header('lang', 'en');
        $translate = new GoogleTranslate($lang);
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'message' => $translate->translator('logout successful')]);
    }

}
