<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Middleware tối ưu response: security headers, cache control, HTML minify.
 */
class OptimizeResponse
{
    private const SECURITY_HEADERS = [
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options' => 'SAMEORIGIN',
        'X-XSS-Protection' => '1; mode=block',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Bỏ qua file/stream responses
        if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            return $response;
        }

        // Chỉ xử lý response OK hoặc redirect
        if (!$response->isSuccessful() && !$response->isRedirection()) {
            return $response;
        }

        // Security headers
        foreach (self::SECURITY_HEADERS as $key => $value) {
            $response->headers->set($key, $value);
        }

        // Cache control
        if ($request->isMethod('GET') && !$request->expectsJson()) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
        }

        // Minify HTML
        $contentType = $response->headers->get('Content-Type', '');
        if (str_contains($contentType, 'text/html') && !$request->expectsJson()) {
            $content = $response->getContent();
            if ($content && strlen($content) > 500) {
                $response->setContent($this->minifyHtml($content));
            }
        }

        return $response;
    }

    private function minifyHtml(string $html): string
    {
        // Bảo vệ <pre>, <textarea>, <script>, <style>
        $preserved = [];
        $html = preg_replace_callback(
            '/<(pre|textarea|script|style)\b[^>]*>.*?<\/\1>/is',
            function ($match) use (&$preserved) {
                $key = '<!--P' . count($preserved) . '-->';
                $preserved[$key] = $match[0];
                return $key;
            },
            $html
        );

        // Xóa comments, gộp whitespace
        $html = preg_replace('/<!--(?!\[|P\d).*?-->/s', '', $html);
        $html = preg_replace('/>\s+</', '> <', $html);
        $html = preg_replace('/\s{2,}/', ' ', $html);

        // Khôi phục nội dung đã bảo vệ
        return trim(str_replace(array_keys($preserved), array_values($preserved), $html));
    }
}
