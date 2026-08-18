<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * CSRF Token verification.
 * Loại trừ: webhook routes, API routes có bearer token.
 */
class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'webhook/*',
        'api/*',
    ];
}
