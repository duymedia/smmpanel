<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

final class FacebookToolService
{
    // Try alolike first.  This endpoint may return HTTP 200 with
    // {"status": false}, which must be treated as a failed lookup so that
    // the fallback endpoint is attempted.
    private const UID_ENDPOINT = 'https://alolike.vn/api/v1/tools/get-uidv3';
    private const FALLBACK_UID_ENDPOINT = 'https://id.traodoisub.com/api.php';

    public function __construct(private readonly FacebookFollowerService $followers)
    {
    }

    public function uid(string $url): ?string
    {
        $url = trim($url);

        if ($url === '') {
            return null;
        }

        return $this->requestUid(self::UID_ENDPOINT, ['link' => $url])
            ?? $this->requestUid(self::FALLBACK_UID_ENDPOINT, ['link' => $url]);
    }

    public function followers(string $input): array
    {
        $input = trim($input);
        $userId = $this->isLink($input) ? $this->uid($this->facebookUrl($input)) : $input;

        if (!$userId) {
            return ['success' => false, 'error' => 'Không thể lấy UID từ link này.'];
        }

        $result = $this->followers->getFollowersCount($userId);

        return $result['success']
            ? ['success' => true, 'user_id' => $userId, 'followers_count' => $result['followers_count']]
            : ['success' => false, 'error' => $result['error'] ?? 'Không thể lấy số người theo dõi.'];
    }

    private function isLink(string $input): bool
    {
        return !ctype_digit($input);
    }

    private function facebookUrl(string $input): string
    {
        return preg_match('#^https?://#i', $input)
            ? $input
            : 'https://www.facebook.com/' . ltrim($input, '/');
    }

    private function requestUid(string $url, array $data = []): ?string
    {
        try {
            // The first provider is GET; the fallback provider expects POST.
            $response = $url === self::UID_ENDPOINT
                ? Http::acceptJson()->connectTimeout(5)->timeout(10)->get($url, $data)
                : Http::acceptJson()->connectTimeout(5)->timeout(10)->post($url, $data);

            if (!$response->successful()) {
                return null;
            }

            $payload = $response->json();
            if (!is_array($payload) || ($payload['status'] ?? true) === false) {
                return null;
            }

            // Providers do not all use the same key (id, uid, or data.id).
            $id = data_get($payload, 'id')
                ?? data_get($payload, 'uid')
                ?? data_get($payload, 'data.id')
                ?? data_get($payload, 'data.uid');

            return is_scalar($id) && (string) $id !== '' ? (string) $id : null;
        } catch (\Throwable) {
            return null;
        }
    }
}
