<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FacebookMetricsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ToolController extends Controller
{
    public function __construct(private readonly FacebookMetricsService $facebook)
    {
    }

    public function getFacebookMetric(Request $request): JsonResponse
    {
        $type = trim((string) $request->input('type', 'facebook-followers'));
        $input = trim((string) ($request->input('user_id') ?: $request->input('link') ?: $request->input('url', '')));
        if ($input === '') {
            $field = $type === 'facebook-followers' ? 'user_id' : 'link';
            return response()->json(['success' => false, 'error' => "Provide {$field} or user_id."], 422);
        }

        $result = $this->facebook->getMetricCount($input, $type);
        $status = $result['success'] ? 200 : ($result['http_status'] ?? 502);
        unset($result['http_status']);

        $result['type'] = $type;

        return response()->json($result, $status);
    }
}
