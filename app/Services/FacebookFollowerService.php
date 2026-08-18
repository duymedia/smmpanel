<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookFollowerService
{
    private string $apiUrl = 'https://smmzone.vn/api/facebook/get-followers';
    private string $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MTAwLCJlbWFpbCI6ImR1eWJ1bnR2QGdtYWlsLmNvbSIsInJvbGUiOiJ1c2VyIiwibmFtZSI6ImR1eW1lZGlhIiwiaWF0IjoxNzc4ODE5Mzg0LCJleHAiOjE3Nzk0MjQxODR9.E4gfn-NJqsbCAg4b9M7jEpuYy_owTeSO1Gyvur7Iefo';

    /**
     * Lấy followers_count từ Facebook user_id
     *
     * @param string $userId Facebook User ID
     * @return array ['success' => bool, 'followers_count' => int|null, 'error' => string|null]
     */
    public function getFollowersCount(string $userId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ])
            ->timeout(30)
            ->post($this->apiUrl, [
                'user_id' => $userId,
            ]);

            if ($response->failed()) {
                Log::error('FacebookFollowerService: API request failed', [
                    'user_id' => $userId,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'followers_count' => null,
                    'error' => 'API request failed with status: ' . $response->status(),
                ];
            }

            $data = $response->json();

            // Trích xuất followers_count từ response
            $followersCount = $data['followers_count'] ?? $data['data']['followers_count'] ?? null;

            return [
                'success' => true,
                'followers_count' => $followersCount !== null ? (int) $followersCount : null,
                'raw_response' => $data,
            ];

        } catch (\Exception $e) {
            Log::error('FacebookFollowerService: Exception', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'followers_count' => null,
                'error' => $e->getMessage(),
            ];
        }
    }
}
