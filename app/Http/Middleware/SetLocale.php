<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected array $supportedLocales = ['rw', 'en', 'fr'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale');

        if (!$locale && Auth::check()) {
            $locale = Auth::user()->locale;
        }

        if (!$locale || !in_array($locale, $this->supportedLocales)) {
            $locale = 'rw';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
