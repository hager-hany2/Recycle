<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Component\HttpFoundation\Response;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('lang', 'en');// في حاله عدم تحقق الشرط تكون اللغة en
        $translate = new GoogleTranslate($lang);//يستخدم لترجمة الجمل المطلوبة
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        return response()->json([
            'message' =>$translate->translate( 'You must be logged in to access this resource')
        ], 403);

    }
}
