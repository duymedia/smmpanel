<?php

namespace App\Http\Middleware;

use App\Models\Config;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class ClientThemePreview
{
    public function handle(Request $request, Closure $next): Response
    {
        $preview = $request->session()->get('client_theme_preview');
        $user = $request->user();
        $site = $request->attributes->get('site_config');

        if (
            $user &&
            (int) $user->role === User::ROLE_ADMIN &&
            $site instanceof Config &&
            is_array($preview)
        ) {
            $activeTheme = (string) ($site->default_interface ?? 'default');
            $activeTheme = $activeTheme === '1' ? 'default' : $activeTheme;
            $expectedRoot = storage_path(
                'framework/views/client-theme-preview/' . hash('sha256', $request->session()->getId())
            );

            if (
                ($preview['theme'] ?? null) === $activeTheme &&
                ($preview['root'] ?? null) === $expectedRoot &&
                File::isDirectory($expectedRoot)
            ) {
                view()->getFinder()->prependLocation($expectedRoot);
            }
        }

        return $next($request);
    }
}
