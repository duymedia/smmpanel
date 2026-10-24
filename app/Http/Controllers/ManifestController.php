<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

final class ManifestController extends Controller
{
    private const DEFAULT_ICONS = ['logo_square.png', 'logo.png'];

    public function __invoke(): JsonResponse
    {
        $config = Config::where('domain', getDomain())->first() ?? Config::first();
        $name = trim((string) ($config?->title ?: config('app.name', 'Panel')));

        return response()->json([
            'id' => '/',
            'name' => $name,
            'short_name' => Str::limit($name, 30, ''),
            'description' => trim((string) ($config?->description ?: $name)),
            'lang' => str_replace('_', '-', (string) ($config?->default_lang ?: app()->getLocale())),
            'start_url' => '/',
            'scope' => '/',
            'display' => 'standalone',
            'orientation' => 'portrait',
            'icons' => $this->icons($config),
        ], headers: [
            'Content-Type' => 'application/manifest+json; charset=UTF-8',
            'Cache-Control' => 'no-cache, must-revalidate',
        ], options: JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private function icons(?Config $config): array
    {
        foreach ([$config?->logo_square, $config?->logo, ...self::DEFAULT_ICONS] as $file) {
            $file = basename((string) $file);
            if ($file !== '' && is_file(public_path("assets/media/{$file}"))) {
                return [[
                    'src' => asset("assets/media/{$file}"),
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'any maskable',
                ]];
            }
        }

        return [];
    }
}
