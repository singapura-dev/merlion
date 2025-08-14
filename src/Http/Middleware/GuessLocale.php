<?php

namespace Merlion\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuessLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($locale = $request->input('lang', $request->input('locale'))) {
            app()->setLocale($locale);
        } elseif (auth()->check() && !empty(auth()->user()->language)) {
            app()->setLocale(auth()->user()->language);
        } elseif ($lang = session('locale')) {
            app()->setLocale($lang);
        } elseif ($request->hasHeader('Accept-Language')) {
            app()->setLocale($request->getPreferredLanguage());
        }
        return $next($request);
    }
}
