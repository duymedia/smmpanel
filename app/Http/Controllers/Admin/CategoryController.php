<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Platform;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // ──────────────────────────────────────────────────────────────────────────
    //  PAGE
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * GET /admin/categories — render the category management page.
     */
    public function index()
    {
        $domain = getDomain();

        $platforms = Platform::where('domain', $domain)
            ->orderBy('position')
            ->get();

        $categories = Category::with('platform')
            ->withCount('services')
            ->where('domain', $domain)
            ->orderBy('position')
            ->get();

        $categoriesByPlatform = $categories->groupBy('platform_id');

        // Build $plat_cat: each platform with its sorted categories
        $plat_cat = $platforms->map(function (Platform $platform) use ($categoriesByPlatform) {
            $image  = $platform->image ?? '';
            $sorted = $categoriesByPlatform->get($platform->id, collect())
                          ->sortBy('position')->values();

            // is_url = true  → dùng <img src="...">
            // is_url = false → dùng <i class="..."> (icon class)
            $isUrl = $image !== '' && filter_var($image, FILTER_VALIDATE_URL) !== false;

            return [
                'id'            => $platform->id,
                'name'          => $platform->name,
                'image'         => $image,
                'is_url'        => $isUrl,   // true = link ảnh, false = class icon
                'position'      => $platform->position ?? 0,
                'status'        => $platform->status,
                'categories'    => $sorted,
                'category_count'=> $sorted->count(),
            ];
        })->sortBy('position')->values();

        $languages = \App\Models\Language::where('domain', $domain)
            ->where('code', '!=', 'en')
            ->orderBy('code')
            ->get();

        return view('admin.category.index', compact('plat_cat', 'platforms', 'categories', 'languages'));
    }

    // ──────────────────────────────────────────────────────────────────────────
    //  CATEGORY AJAX ACTIONS  (called from _categories in admin.js)
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Category-add
     * Payload: { platform, name, name_translated, display, status }
     */
    public function add(Request $request): JsonResponse
    {
        $data = $request->input('data', []);

        $platformId      = $data['platform']        ?? null;
        $name            = trim($data['name']        ?? '');
        $nameTranslated  = $data['name_translated']  ?? [];
        $display         = isset($data['display'])   ? (int) $data['display'] : 0;
        $status          = isset($data['status'])    ? (bool) $data['status'] : true;

        if (!$platformId || $name === '') {
            return response()->json(['error' => 'Platform and name are required']);
        }

        $platform = Platform::where('id', $platformId)->where('domain', getDomain())->first();
        if (!$platform) {
            return response()->json(['error' => 'Platform not found']);
        }

        // Build the JSON name field: en + translated languages
        $nameJson = array_merge(['en' => $name], array_filter((array) $nameTranslated, fn($v) => $v !== ''));

        $nextPosition = Category::where('platform_id', $platformId)
            ->where('domain', getDomain())
            ->max('position') + 1;

        Category::create([
            'platform_id' => $platformId,
            'name'        => $nameJson,
            'image'       => $platform->image,
            'display'     => $display,
            'status'      => $status,
            'position'    => $nextPosition,
            'domain'      => getDomain(),
        ]);

        return response()->json(['success' => adminMessage('add')]);
    }

    /**
     * Category-update
     * Payload: { id, platform, name, name_translated, display, status }
     */
    public function update(Request $request): JsonResponse
    {
        $data = $request->input('data', []);

        $id             = $data['id']               ?? null;
        $platformId     = $data['platform']          ?? null;
        $name           = trim($data['name']         ?? '');
        $nameTranslated = $data['name_translated']   ?? [];
        $display        = isset($data['display'])    ? (int) $data['display'] : 0;
        $status         = isset($data['status'])     ? (bool) $data['status'] : false;

        $category = Category::where('id', $id)->where('domain', getDomain())->first();
        if (!$category) {
            return response()->json(['error' => 'Category not found']);
        }

        if ($name === '') {
            return response()->json(['error' => 'Name is required']);
        }

        $nameJson = array_merge(['en' => $name], array_filter((array) $nameTranslated, fn($v) => $v !== ''));

        $category->update([
            'platform_id' => $platformId ?? $category->platform_id,
            'name'        => $nameJson,
            'display'     => $display,
            'status'      => $status,
        ]);

        return response()->json(['success' => adminMessage('update')]);
    }

    /**
     * Category-updateStatus
     * Payload: { id, status }
     */
    public function updateStatus(Request $request): JsonResponse
    {
        $data     = $request->input('data', []);
        $id       = $data['id']     ?? null;
        $status   = isset($data['status']) ? (bool) $data['status'] : false;

        $category = Category::where('id', $id)->where('domain', getDomain())->first();
        if (!$category) {
            return response()->json(['error' => 'Category not found']);
        }

        $category->update(['status' => $status]);

        return response()->json(['success' => adminMessage('update')]);
    }

    /**
     * Category-sort
     * Payload: { dataSort: [id1, id2, ...] }  (Sortable.js toArray order)
     */
    public function sort(Request $request): JsonResponse
    {
        $data     = $request->input('data', []);
        $dataSort = $data['dataSort'] ?? [];

        if (empty($dataSort)) {
            return response()->json(['error' => 'No data']);
        }

        foreach ($dataSort as $position => $id) {
            Category::where('id', $id)
                ->where('domain', getDomain())
                ->update(['position' => $position + 1]);
        }

        return response()->json(['success' => adminMessage('update')]);
    }

    /**
     * Category-syncFor1dg  (sync categories to child panel 1dg.me)
     */
    public function syncFor1dg(Request $request): JsonResponse
    {
        try {
            $categories = Category::where('domain', getDomain())
                ->where('status', true)
                ->orderBy('position')
                ->get();

            // TODO: implement actual sync logic with 1dg child panel
            // For now return count as confirmation
            return response()->json(['success' => adminMessage('sync'), 'count' => $categories->count()]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Category syncFor1dg failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Sync failed: ' . $e->getMessage()]);
        }
    }

    // ──────────────────────────────────────────────────────────────────────────
    //  PLATFORM AJAX ACTIONS  (called from _categories in admin.js)
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Platform-add
     * Payload: { name, icon }
     */
    public function addPlatform(Request $request): JsonResponse
    {
        $data = $request->input('data', []);
        $name = trim($data['name'] ?? '');
        $icon = trim($data['icon'] ?? '');

        if ($name === '') {
            return response()->json(['error' => 'Platform name is required']);
        }

        $nextPosition = Platform::where('domain', getDomain())->max('position') + 1;

        Platform::create([
            'name'     => $name,
            'image'    => $icon ?: null,
            'position' => $nextPosition,
            'status'   => true,
            'domain'   => getDomain(),
        ]);

        return response()->json(['success' => adminMessage('add')]);
    }

    /**
     * Platform-update
     * Payload: { id, name, icon }
     */
    public function updatePlatform(Request $request): JsonResponse
    {
        $data = $request->input('data', []);
        $id   = $data['id']   ?? null;
        $name = trim($data['name'] ?? '');
        $icon = trim($data['icon'] ?? '');

        if ($name === '') {
            return response()->json(['error' => 'Platform name is required']);
        }

        $platform = Platform::where('id', $id)->where('domain', getDomain())->first();
        if (!$platform) {
            return response()->json(['error' => 'Platform not found']);
        }

        $platform->update([
            'name'  => $name,
            'image' => $icon ?: $platform->image,
        ]);

        return response()->json(['success' => adminMessage('update')]);
    }

    /**
     * Platform-sort
     * Payload: { dataSort: [id1, id2, ...] }
     */
    public function sortPlatform(Request $request): JsonResponse
    {
        $data     = $request->input('data', []);
        $dataSort = $data['dataSort'] ?? [];

        if (empty($dataSort)) {
            return response()->json(['error' => 'No data']);
        }

        foreach ($dataSort as $position => $id) {
            Platform::where('id', $id)
                ->where('domain', getDomain())
                ->update(['position' => $position + 1]);
        }

        return response()->json(['success' => adminMessage('update')]);
    }
}
