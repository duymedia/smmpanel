<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\FacebookFollowerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function uid(Request $request): JsonResponse
    {
        $url = $request->query('url', '');
        if (!$url) return response()->json(['error' => 'URL is required'], 422);

        $id = $this->curl('GET', 'https://ffb.vn/api/tool/get-id-fb?idfb=' . urlencode($url))
           ?? $this->curl('POST', 'https://id.traodoisub.com/api.php', ['link' => $url]);

        return $id
            ? response()->json(['id' => $id])
            : response()->json(['error' => 'Không thể lấy UID từ link này.'], 404);
    }

    public function getFollowers(Request $request): JsonResponse
    {
        $userId = $request->input('user_id', '');
        if (!$userId) return response()->json(['error' => 'user_id is required'], 422);

        $result = (new FacebookFollowerService())->getFollowersCount($userId);

        if (!$result['success']) {
            return response()->json(['error' => $result['error']], 500);
        }

        return response()->json(['followers_count' => $result['followers_count']]);
    }

    private function curl(string $method, string $url, array $post = []): ?string
    {
        try {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_FOLLOWLOCATION => true,
            ] + ($post ? [CURLOPT_POSTFIELDS => $post] : []));

            $res = json_decode(curl_exec($ch), true);
            curl_close($ch);
            return !empty($res['id']) ? (string) $res['id'] : null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
