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

        // Let the admin root reach its redirect to /admin/orders; the target
        // page still passes the normal child-panel access check.
        $isAdminRoot = trim($request->path(), '/') === 'admin';
        if (!$isAdminRoot && isChildPanel() && ! panelCanAccess($request->path())) {
            abort(403);
        }

        return $next($request);
    }
}
