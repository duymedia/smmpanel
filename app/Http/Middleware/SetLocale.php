<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware set ngôn ngữ theo user hoặc config site.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ưu tiên: user lang > site config lang > default
        if (Auth::check() && Auth::user()->lang) {
            App::setLocale(Auth::user()->lang);
        } else {
            $site = $request->attributes->get('site_config');
            if ($site && $site->default_lang) {
                App::setLocale($site->default_lang);
            }
        }

        return $next($request);
    }
}
