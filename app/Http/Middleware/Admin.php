<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $user = $request->user()) {
            return redirect()->route('login');
        }

        abort_unless((int) $user->role === User::ROLE_ADMIN, 403);

        if (isChildPanel() && ! panelCanAccess($request->path())) {
            abort(403, 'This page is not available for the child panel.');
        }

        return $next($request);
    }
}
