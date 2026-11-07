<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Process;
use Throwable;

final class FacebookMetricsService
{
    private const API_URL = 'https://smmzone.vn/api/facebook/get-followers';
    private const API_TOKEN = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MTAwLCJlbWFpbCI6ImR1eWJ1bnR2QGdtYWlsLmNvbSIsInJvbGUiOiJ1c2VyIiwibmFtZSI6ImR1eW1lZGlhIiwiaWF0IjoxNzkzNTk3ODI1LCJleHAiOjE3OTQyMDI2MjV9.UekpS6PxJ9d8UIskRm1UvZX7UxwY3rwcR_eyF2xT9sw';

    public function getFollowersCount(string $input, string $type = 'facebook-followers'): array
    {
        return $this->getMetricCount($input, $type);
    }

    public function getUID(string $input): array
    {
        $input = trim(html_entity_decode($input, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if ($this->isFacebookId($input)) {
            return ['success' => true, 'user_id' => $input];
        }

        $url = $this->facebookProfileUrl($input);
        if (!$url) {
            return ['success' => false, 'http_status' => 422, 'error' => 'Provide a valid Facebook profile URL or numeric ID.'];
        }

        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
        foreach (['id', 'profile_id', 'user_id'] as $key) {
            if (isset($query[$key]) && $this->isFacebookId((string) $query[$key])) {
                return ['success' => true, 'user_id' => (string) $query[$key]];
            }
        }

        $path = (string) parse_url($url, PHP_URL_PATH);
        if (preg_match('~^/(?:people/[^/]+/|pages/[^/]+/)(\d+)(?:/|$)|^/(?:profile/)?(\d+)(?:/|$)~i', $path, $match)) {
            $userId = $match[1] ?: $match[2];
            if ($this->isFacebookId($userId)) return ['success' => true, 'user_id' => $userId];
        }

        $page = $this->requestFacebookHtml($url);
        if (!$page['success']) return $page;

        $html = html_entity_decode(str_replace('\\"', '"', $page['html']), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $actorId = $this->findActorId($html, $url);
        if ($actorId !== null) return ['success' => true, 'user_id' => $actorId];

        foreach ([
            '/"(?:userID|user_id|profile_id|profileId|owner_id|actorID|actor_id)"\s*:\s*"?(\d+)"?/i',
            '/fb:\/\/profile\/(\d+)/i',
            '/profile\.php\?id=(\d+)/i',
        ] as $pattern) {
            if (preg_match_all($pattern, $html, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    if ($this->isFacebookId($match[1])) {
                        return ['success' => true, 'user_id' => $match[1]];
                    }
                }
            }
        }

        return ['success' => false, 'http_status' => 422, 'error' => 'Facebook profile HTML did not contain a recognizable user ID.'];
    }

    private function isFacebookId(string $value): bool
    {
        return ctype_digit($value) && ltrim($value, '0') !== '';
    }

    private function findActorId(string $html, string $profileUrl): ?string
    {
        $targetUrl = $this->normalizeProfileUrl($profileUrl);
        $ids = [];

        for ($offset = 0; ($key = strpos($html, '"actors"', $offset)) !== false;) {
            $start = $key + strlen('"actors"');
            while (isset($html[$start]) && ctype_space($html[$start])) $start++;
            if (($html[$start] ?? null) !== ':') { $offset = $start; continue; }
            $start++;
            while (isset($html[$start]) && ctype_space($html[$start])) $start++;

            $json = $this->jsonArrayAt($html, $start);
            if ($json === null) { $offset = $start + 1; continue; }
            $offset = $start + strlen($json);

            foreach ((array) json_decode($json, true) as $actor) {
                $id = $actor['id'] ?? null;
                if (!is_array($actor) || ($actor['__typename'] ?? null) !== 'User' || !is_scalar($id) || !$this->isFacebookId((string) $id)) continue;

                $id = (string) $id;
                $ids[$id] = $id;
                if ($targetUrl && $this->normalizeProfileUrl((string) ($actor['url'] ?? '')) === $targetUrl) return $id;
            }
        }

        return count($ids) === 1 ? reset($ids) : null;
    }

    private function normalizeProfileUrl(string $url): ?string
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $path = (string) parse_url($url, PHP_URL_PATH);
        if ($host === '' || $path === '') return null;

        $host = preg_replace('/^(?:www|m|mbasic)\\./', '', $host);
        return $host . '/' . strtolower(trim(rawurldecode($path), '/'));
    }

    private function jsonArrayAt(string $source, int $start): ?string
    {
        if (($source[$start] ?? null) !== '[') return null;

        $depth = 0;
        $quoted = $escaped = false;
        for ($i = $start, $length = strlen($source); $i < $length; $i++) {
            $char = $source[$i];
            if ($quoted) {
                if ($escaped) $escaped = false;
                elseif ($char === '\\') $escaped = true;
                elseif ($char === '"') $quoted = false;
            } elseif ($char === '"') $quoted = true;
            elseif ($char === '[') $depth++;
            elseif ($char === ']' && --$depth === 0) return substr($source, $start, $i - $start + 1);
        }

        return null;
    }

    public function getMetricCount(string $input, string $type): array
    {
        return match ($type) {
            'facebook-followers' => $this->getFollowersCountApi($input),
            'facebook-followers-no-api' => $this->getFollowersCountNoApi($input),
            'facebook-reactions-no-api' => $this->getReactionCountNoApi($input),
            default => ['success' => false, 'http_status' => 422, 'error' => 'Unsupported follower check type.'],
        };
    }

    public function getFollowersCountApi(string $userId): array
    {
        if (!ctype_digit($userId)) {
            return ['success' => false, 'http_status' => 422, 'error' => 'A numeric Facebook user_id is required.'];
        }

        try {
            $response = Http::acceptJson()
                ->withToken(self::API_TOKEN)
                ->connectTimeout(5)
                ->timeout(15)
                ->post(self::API_URL, ['user_id' => $userId]);

            if ($response->failed()) {
                return ['success' => false, 'http_status' => 502, 'error' => 'Follower provider returned HTTP ' . $response->status() . '.'];
            }

            $count = $response->json('followers_count') ?? $response->json('data.followers_count');
            if (!is_numeric($count)) {
                return ['success' => false, 'http_status' => 502, 'error' => 'Follower provider returned an invalid count.'];
            }

            return ['success' => true, 'user_id' => $userId, 'followers_count' => (int) $count];
        } catch (Throwable $exception) {
            report($exception);
            return ['success' => false, 'http_status' => 502, 'error' => 'Could not connect to the follower provider.'];
        }
    }

    public function getFollowersCountNoApi(string $input): array
    {
        $profileUrl = $this->facebookProfileUrl($input);
        if (!$profileUrl) {
            return ['success' => false, 'http_status' => 422, 'error' => 'Provide a valid Facebook profile URL or username.'];
        }

        $page = $this->requestFacebookHtml($profileUrl);
        if (!$page['success']) return $page;

        $followersCount = $this->extractFollowerCount($page['html']);
        if ($followersCount === null) {
            return ['success' => false, 'http_status' => 502, 'error' => 'Follower count was not found in Facebook profile metadata.'];
        }

        return ['success' => true, 'profile_url' => $profileUrl, 'followers_count' => $followersCount];
    }

    public function getReactionCountNoApi(string $input): array
    {
        $postUrl = $this->facebookPostUrl($input);
        if (!$postUrl) {
            return ['success' => false, 'http_status' => 422, 'error' => 'Provide a valid Facebook post URL.'];
        }

        $postId = $this->facebookPostId($postUrl);
        if (!$postId) {
            return ['success' => false, 'http_status' => 422, 'error' => 'Could not identify a post ID in the URL.'];
        }

        $page = $this->requestFacebookHtml($postUrl);
        if (!$page['success']) {
            return $page;
        }

        $html = $page['html'];
        $targetPosition = strrpos($html, '"subscription_target_id":"' . $postId . '"');
        if ($targetPosition === false) {
            return ['success' => false, 'http_status' => 502, 'error' => 'Could not find reaction data for this Facebook post.'];
        }

        $postData = substr($html, $targetPosition);
        preg_match('/"i18n_reaction_count"\s*:\s*"(\d+)"/', $postData, $totalMatch);
        $topReactionsPosition = strpos($html, '"top_reactions":', $targetPosition);
        $topReactionsStart = $topReactionsPosition === false ? false : strpos($html, '{', $topReactionsPosition);
        $topReactionsJson = $topReactionsStart === false ? null : $this->extractJsonObject($html, $topReactionsStart);
        $topReactions = $topReactionsJson ? json_decode($topReactionsJson, true) : null;

        if (!is_array($topReactions)) {
            return ['success' => false, 'http_status' => 502, 'error' => 'Could not parse reaction breakdown for this Facebook post.'];
        }

        $reactions = [];
        foreach ($topReactions['edges'] ?? [] as $edge) {
            $name = $edge['node']['localized_name'] ?? null;
            $count = $edge['reaction_count'] ?? null;
            if (is_string($name) && is_numeric($count)) {
                $reactions[] = ['localized_name' => $name, 'reaction_count' => (int) $count];
            }
        }

        $total = $totalMatch[1] ?? null;
        if (!is_numeric($total)) {
            $total = array_sum(array_column($reactions, 'reaction_count'));
        }

        return [
            'success' => true,
            'post_id' => $postId,
            'reaction_count' => (int) $total,
            'reactions' => $reactions,
        ];
    }

    private function requestFacebookHtml(string $url): array
    {
        $curlBinary = storage_path('app/private/curl-impersonate/curl-impersonate.exe');
        if (!is_file($curlBinary)) {
            return ['success' => false, 'http_status' => 500, 'error' => 'curl-impersonate binary is missing.'];
        }

        try {
            $process = new Process([
                $curlBinary,
                '--compressed',
                '--impersonate', 'chrome152',
                '--location',
                '--silent',
                '--show-error',
                '--fail-with-body',
                '--header', 'Accept-Language: en-US,en;q=0.9',
                $url,
            ], dirname($curlBinary));
            $process->setTimeout(30);
            $process->run();

            if (!$process->isSuccessful()) {
                $detail = trim($process->getErrorOutput());
                return [
                    'success' => false,
                    'http_status' => 502,
                    'error' => $detail !== '' ? mb_substr($detail, 0, 250) : 'Facebook HTML request failed.',
                ];
            }

            return ['success' => true, 'html' => $process->getOutput()];
        } catch (Throwable $exception) {
            report($exception);
            return ['success' => false, 'http_status' => 502, 'error' => 'Could not request Facebook HTML.'];
        }
    }

    private function facebookProfileUrl(string $input): ?string
    {
        $input = trim($input);
        if ($input === '') {
            return null;
        }

        if (!preg_match('#^https?://#i', $input)) {
            return 'https://www.facebook.com/' . ltrim($input, '/');
        }

        $host = strtolower((string) parse_url($input, PHP_URL_HOST));
        return $host === 'facebook.com' || str_ends_with($host, '.facebook.com') ? $input : null;
    }

    private function facebookPostUrl(string $input): ?string
    {
        $input = trim($input);
        $host = strtolower((string) parse_url($input, PHP_URL_HOST));
        return $host === 'facebook.com' || str_ends_with($host, '.facebook.com') ? $input : null;
    }

    private function facebookPostId(string $url): ?string
    {
        $path = (string) parse_url($url, PHP_URL_PATH);
        if (preg_match('~/(?:posts|videos|reel)/([0-9]+)~i', $path, $match)) {
            return $match[1];
        }

        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
        $postId = $query['story_fbid'] ?? $query['fbid'] ?? null;
        return is_scalar($postId) && ctype_digit((string) $postId) ? (string) $postId : null;
    }

    private function extractJsonObject(string $source, int $start): ?string
    {
        if (($source[$start] ?? null) !== '{') {
            return null;
        }

        $depth = 0;
        $inString = false;
        $escaped = false;
        $length = strlen($source);

        for ($index = $start; $index < $length; $index++) {
            $character = $source[$index];
            if ($inString) {
                if ($escaped) {
                    $escaped = false;
                } elseif ($character === '\\') {
                    $escaped = true;
                } elseif ($character === '"') {
                    $inString = false;
                }
                continue;
            }

            if ($character === '"') {
                $inString = true;
            } elseif ($character === '{') {
                $depth++;
            } elseif ($character === '}' && --$depth === 0) {
                return substr($source, $start, $index - $start + 1);
            }
        }

        return null;
    }

    private function extractFollowerCount(string $html): ?int
    {
        $previousLibxmlState = libxml_use_internal_errors(true);

        try {
            $document = new \DOMDocument();
            if (!$document->loadHTML($html)) {
                return null;
            }

            $xpath = new \DOMXPath($document);
            $description = trim($xpath->evaluate('string(//meta[@property="og:description"]/@content)'));
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previousLibxmlState);
        }

        return preg_match('/([\d,.]+)\s+followers\b/i', $description, $match)
            ? (int) preg_replace('/\D/', '', $match[1])
            : null;
    }
}
