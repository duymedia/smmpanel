<?php

namespace App\Http\Middleware;

use App\Models\Config;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Client
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $site = Config::query()->where('domain', $request->getHost())->first();
            if (!$site) {
                return $request->routeIs('install') ? $next($request) : redirect()->route('install');
            }

            $request->attributes->set('site_config', $site);
            $ready = (int) $site->status === 1 && $site->user_id;

            if ($request->routeIs('install')) {
                return redirect($ready ? '/' : route('login'));
            }

            if ($ready) {
                return $next($request);
            }

            $bypass = $request->routeIs('login', 'signup', 'install')
                || $request->is('admin', 'admin/*', 'api/*', 'maintenance');

            if ((int) $site->status === 0 && !$bypass) {
                $theme = $site->default_interface ?: 'default';
                return response()->view("clients.theme-{$theme}.maintenance", ['config' => $site], 503);
            }

            return $next($request);
        } catch (\Throwable) {
            return redirect()->route('install');
        }
    }
}
