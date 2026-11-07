<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Throwable;

final class YoutubeMetricsService
{
    private const YT_DLP_BINARY = 'yt-dlp';
    private const VIDEO_ID_PATTERN = '/^[A-Za-z0-9_-]{11}$/';

    public function getViewCount(string $input): array
    {
        $video = $this->normalizeVideo($input);
        if (!$video) {
            return ['success' => false, 'http_status' => 422, 'error' => 'Provide a valid YouTube video URL or ID.'];
        }

        try {
            $process = new Process([
                self::YT_DLP_BINARY,
                '--dump-single-json',
                '--skip-download',
                '--no-playlist',
                '--quiet',
                '--no-warnings',
                $video['url'],
            ]);
            $process->setTimeout(45);
            $process->run();

            $info = json_decode($process->getOutput(), true);
            if (!$process->isSuccessful() || !is_array($info)) {
                $error = trim($process->getErrorOutput());
                return [
                    'success' => false,
                    'http_status' => 502,
                    'error' => $error !== '' ? mb_substr($error, 0, 300) : 'Could not retrieve YouTube video metadata.',
                ];
            }

            if (!is_numeric($info['view_count'] ?? null)) {
                return ['success' => false, 'http_status' => 502, 'error' => 'YouTube did not provide a public view count.'];
            }

            return [
                'success' => true,
                'video_id' => $video['id'],
                'title' => $info['title'] ?? null,
                'view_count' => (int) $info['view_count'],
            ];
        } catch (Throwable $exception) {
            report($exception);
            return ['success' => false, 'http_status' => 502, 'error' => 'Could not run yt-dlp. Make sure it is installed and on PATH.'];
        }
    }

    private function normalizeVideo(string $input): ?array
    {
        $input = trim($input);
        if (preg_match(self::VIDEO_ID_PATTERN, $input)) {
            return ['id' => $input, 'url' => 'https://www.youtube.com/watch?v=' . $input];
        }

        $host = strtolower((string) parse_url($input, PHP_URL_HOST));
        if ($host !== 'youtu.be' && $host !== 'youtube.com' && !str_ends_with($host, '.youtube.com')) {
            return null;
        }

        if ($host === 'youtu.be') {
            $videoId = explode('/', trim((string) parse_url($input, PHP_URL_PATH), '/'))[0] ?? '';
        } else {
            parse_str((string) parse_url($input, PHP_URL_QUERY), $query);
            $videoId = $query['v'] ?? '';
            if ($videoId === '' && preg_match('~^/(?:shorts|embed|live)/([A-Za-z0-9_-]{11})(?:/|$)~', (string) parse_url($input, PHP_URL_PATH), $match)) {
                $videoId = $match[1];
            }
        }

        if (!is_string($videoId) || !preg_match(self::VIDEO_ID_PATTERN, $videoId)) {
            return null;
        }

        return ['id' => $videoId, 'url' => 'https://www.youtube.com/watch?v=' . $videoId];
    }
}
