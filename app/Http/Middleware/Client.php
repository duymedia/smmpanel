<?php

namespace App\Http\Middleware;

use App\Models\Config;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Client
{
    public function handle(Request $request, Closure $next): Response
    {
        $site = Config::where('domain', getDomain())->first();

        // Chưa có config → chỉ cho vào install
        if (!$site) {
            return $request->routeIs('install', 'install.store') ? $next($request) : redirect()->route('install');
        }

        // Site active + đã setup → chặn install
        if ($request->routeIs('install', 'install.store') && $site->status && $site->user_id) {
            return redirect('/');
        }

        // Site không active → logout user + chỉ cho vào install
        if (!$site->status) {
            if (Auth::check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
            return $request->routeIs('install', 'install.store') ? $next($request) : redirect()->route('install');
        }

        // Share tenant cho middleware/controller phía sau
        $request->attributes->set('site_config', $site);

        return $next($request);
    }
}
