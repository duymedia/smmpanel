<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $site = $request->attributes->get('site_config');

        if ($user->role !== 'admin' || ($site && (int) $site->user_id !== $user->id)) {
            abort(403);
        }

        return $next($request);
    }
}
