<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiToken
{
    public function handle(Request $request, Closure $next, ?string $requiredRole = null): Response
    {
        $token = $request->bearerToken()
            ?: $request->header('X-API-Key')
            ?: $request->input('api_key')
            ?: $request->input('key');

        if (!is_string($token) || $token === '') {
            return response()->json(['error' => 'API token is required'], 401);
        }

        $user = User::query()
            ->where(['api_key' => $token, 'is_active' => true, 'domain' => getDomain()])
            ->when($requiredRole === 'admin', fn ($query) => $query->whereRole(User::ROLE_ADMIN))
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid API token'], 401);
        }

        $request->attributes->set('api_user', $user);
        $request->setUserResolver(fn() => $user);

        return $next($request);
    }
}
