<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $apiKey = $user?->api_key;
        $userId = $user?->id;

        return view('admin.api.index', compact('apiKey', 'userId'));
    }

    /**
     * API v2 documentation page. Kept as a dedicated view because it ships
     * its own documentation layout and assets.
     */
    public function v2()
    {
        return view('admin.api.v2');
    }

    public function changeKey(Request $request)
    {
        $data = $request->validate([
            'id' => ['sometimes', 'integer'],
            'status' => ['sometimes', 'boolean'],
        ]);
        $user = auth()->user();
        abort_unless($user instanceof User, 401);

        $target = User::query()
            ->where('domain', getDomain())
            ->findOrFail((int) ($data['id'] ?? $user->id));

        $newKey = null;
        if ((bool) ($data['status'] ?? true)) {
            do {
                $newKey = Str::random(32);
            } while (User::where('api_key', $newKey)->exists());
        }

        $target->update(['api_key' => $newKey]);

        return response()->json(['success' => $newKey ?: '?']);
    }
}
