<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->user()?->lang
            ?? $request->session()->get('language')
            ?? $request->attributes->get('site_config')?->default_lang;

        if ($locale) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
