<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class ImageProxyController extends Controller
{
    /**
     * Proxy external images to bypass CORS issues
     * Usage: /proxy-image?url=https://example.com/image.png
     */
    public function proxy()
    {
        $url = request()->query('url');

        if (!$url) {
            return response()->json(['error' => 'URL parameter is required'], 400);
        }

        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid URL'], 400);
        }

        // Only allow specific domains to prevent abuse
        $allowedDomains = [
            'imgur.com',
            'i.imgur.com',
            'img.vietqr.io',
            'pbs.twimg.com',
            'cdn.freebiesupply.com',
        ];

        $urlHost = parse_url($url, PHP_URL_HOST);
        $isAllowed = false;

        foreach ($allowedDomains as $domain) {
            if (strpos($urlHost, $domain) !== false) {
                $isAllowed = true;
                break;
            }
        }

        if (!$isAllowed) {
            return response()->json(['error' => 'Domain not allowed'], 403);
        }

        try {
            $response = Http::timeout(10)->get($url);

            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to fetch image'], 404);
            }

            $contentType = $response->header('Content-Type') ?? 'image/jpeg';

            return response($response->body())
                ->header('Content-Type', $contentType)
                ->header('Cache-Control', 'public, max-age=86400')
                ->header('Access-Control-Allow-Origin', '*');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching image: ' . $e->getMessage()], 500);
        }
    }
}
