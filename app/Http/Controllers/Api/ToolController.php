<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FacebookToolService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ToolController extends Controller
{
    public function __construct(private readonly FacebookToolService $facebook)
    {
    }

    public function uid(Request $request): JsonResponse
    {
        $url = trim((string) $request->query('url', ''));
        if ($url === '') {
            return response()->json(['error' => 'URL is required'], 422);
        }

        $id = $this->facebook->uid($url);

        return $id
            ? response()->json(['id' => $id])
            : response()->json(['error' => 'Không thể lấy UID từ link này.'], 404);
    }

    public function getFollowers(Request $request): JsonResponse
    {
        $input = trim((string) $request->input('user_id', ''));
        if ($input === '') {
            return response()->json(['error' => 'user_id or link is required'], 422);
        }

        $result = $this->facebook->followers($input);

        return $result['success']
            ? response()->json($result)
            : response()->json(['error' => $result['error']], 500);
    }
}
