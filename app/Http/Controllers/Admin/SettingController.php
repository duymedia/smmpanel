<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Language;
use App\Models\Currency;
use App\Models\PaymentMethod;
use App\Models\Service;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Render a landing-page theme for the legacy iframe editor in admin.js.
     */
    public function loadHTML(Request $request)
    {
        $theme = (string) $request->input('theme', '');

        if ($theme !== 'default' && !preg_match('/^\d+$/', $theme)) {
            return response()->json(['error' => 'Theme không hợp lệ.'], 422);
        }

        $viewName = $theme === 'default'
            ? 'landing-page.default'
            : 'landing-page.lang-' . $theme;
        if (!view()->exists($viewName)) {
            return response()->json(['error' => 'Không tìm thấy landing theme.'], 404);
        }

        $customPath = $this->landingCustomizationPath($theme);
        if (Storage::disk('local')->exists($customPath)) {
            return response()->json([
                'success' => Storage::disk('local')->get($customPath),
                'custom' => true,
                'default' => false,
            ]);
        }

        try {
            return response()->json([
                'success' => view($viewName)->render(),
                'custom' => false,
                'default' => true,
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'error' => 'Không thể tải landing theme: ' . $exception->getMessage(),
            ], 500);
        }
    }

    public function saveHTML(Request $request)
    {
        $theme = (string) $request->input('theme', '');
        $html = $request->input('html');

        if (($theme !== 'default' && !preg_match('/^\d+$/', $theme))) {
            return response()->json(['error' => 'Theme không hợp lệ.'], 422);
        }

        if (!is_string($html) || trim($html) === '' || strlen($html) > 5 * 1024 * 1024) {
            return response()->json(['error' => 'Nội dung HTML không hợp lệ.'], 422);
        }

        if (!preg_match('/<html\b/i', $html)) {
            return response()->json(['error' => 'Nội dung phải chứa thẻ HTML.'], 422);
        }

        $viewName = $theme === 'default' ? 'landing-page.default' : 'landing-page.lang-' . $theme;
        if (!view()->exists($viewName)) {
            return response()->json(['error' => 'Không tìm thấy landing theme.'], 404);
        }

        Storage::disk('local')->put($this->landingCustomizationPath($theme), $html);

        return response()->json(['success' => 'Đã lưu giao diện.']);
    }

    public function defaultHTML(Request $request)
    {
        $theme = (string) $request->input('theme', '');

        if ($theme !== 'default' && !preg_match('/^\d+$/', $theme)) {
            return response()->json(['error' => 'Theme không hợp lệ.'], 422);
        }

        $viewName = $theme === 'default' ? 'landing-page.default' : 'landing-page.lang-' . $theme;
        if (!view()->exists($viewName)) {
            return response()->json(['error' => 'Không tìm thấy landing theme.'], 404);
        }

        $disk = Storage::disk('local');
        $customPath = $this->landingCustomizationPath($theme);

        try {
            if ($disk->exists($customPath) && !$disk->delete($customPath)) {
                return response()->json(['error' => 'Không thể khôi phục giao diện mặc định.'], 500);
            }
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['error' => 'Không thể khôi phục giao diện mặc định.'], 500);
        }

        return response()->json([
            'success' => 'Đã khôi phục giao diện mặc định.',
            'custom' => false,
            'default' => true,
        ]);
    }

    public function landingEditor(string $theme)
    {
        $viewName = $theme === 'default' ? 'landing-page.default' : 'landing-page.lang-' . $theme;
        if (($theme !== 'default' && !preg_match('/^\d+$/', $theme)) || !view()->exists($viewName)) {
            abort(404);
        }

        $path = $this->landingCustomizationPath($theme);
        $defaultHtml = view($viewName)->render();
        $html = Storage::disk('local')->exists($path)
            ? Storage::disk('local')->get($path)
            : $defaultHtml;
        $landingPages = collect(glob(resource_path('views/landing-page/*.blade.php')) ?: [])
            ->map(function ($file) {
                $name = pathinfo($file, PATHINFO_FILENAME);
                if ($name === 'default') {
                    return ['id' => 'default', 'label' => 'Default'];
                }

                return preg_match('/^lang-(\d+)$/', $name, $match)
                    ? ['id' => $match[1], 'label' => 'Page ' . $match[1]]
                    : null;
            })
            ->filter()
            ->sortBy(fn ($page) => $page['id'] === 'default' ? -1 : (int) $page['id'])
            ->values();

        return view('admin.settings.landing-editor', compact('theme', 'html', 'landingPages'));
    }

    public function clientThemeEditor(Request $request, string $theme)
    {
        if (!in_array($theme, ['default', '4', '6'], true)) {
            abort(404);
        }

        $config = Config::where('domain', getDomain())->first() ?? Config::first();
        $activeTheme = (string) ($config?->default_interface ?? 'default');
        if ($activeTheme === '1') {
            $activeTheme = 'default';
        }
        if ($activeTheme !== $theme) {
            abort(404);
        }

        $directory = resource_path('views/clients/theme-' . $theme);
        if (!\Illuminate\Support\Facades\File::isDirectory($directory)) {
            abort(404);
        }

        $files = collect(\Illuminate\Support\Facades\File::allFiles($directory))
            ->map(fn ($file) => str_replace('\\', '/', substr($file->getPathname(), strlen($directory) + 1)))
            ->filter(fn ($file) => str_ends_with($file, '.blade.php'))
            ->sort()
            ->values();
        if ($files->isEmpty()) {
            abort(404);
        }

        $originalRoot = storage_path('app/client-theme-originals/' . sha1(getDomain()) . '/' . $theme);
        foreach ($files as $file) {
            $originalPath = $originalRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
            if (!\Illuminate\Support\Facades\File::exists($originalPath)) {
                $currentPath = $directory . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
                \Illuminate\Support\Facades\File::ensureDirectoryExists(dirname($originalPath));
                \Illuminate\Support\Facades\File::copy($currentPath, $originalPath);
            }
        }

        $selectedFile = str_replace('\\', '/', (string) $request->query('file', 'new.blade.php'));
        if (!$files->contains($selectedFile)) {
            $folderIndex = trim($selectedFile, '/') . '/index.blade.php';
            $rootFile = trim($selectedFile, '/') . '.blade.php';
            $selectedFile = $files->contains($folderIndex)
                ? $folderIndex
                : ($files->contains($rootFile) ? $rootFile : $files->first());
        }

        $sourcePath = $directory . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $selectedFile);
        $source = \Illuminate\Support\Facades\File::get($sourcePath);
        $fileGroups = $files->groupBy(
            fn ($file) => str_contains($file, '/') ? explode('/', $file, 2)[0] : ''
        );

        return view('admin.settings.client-theme-editor', compact(
            'theme',
            'files',
            'fileGroups',
            'selectedFile',
            'source'
        ));
    }

    public function previewClientThemeSource(Request $request, string $theme)
    {
        if (!in_array($theme, ['default', '4', '6'], true)) {
            return response()->json(['error' => 'Giao diện người dùng không hợp lệ.'], 422);
        }

        $config = Config::where('domain', getDomain())->first() ?? Config::first();
        $activeTheme = (string) ($config?->default_interface ?? 'default');
        if ($activeTheme === '1') {
            $activeTheme = 'default';
        }
        if ($activeTheme !== $theme) {
            return response()->json(['error' => 'Chỉ có thể xem trước giao diện người dùng đang áp dụng.'], 403);
        }

        $validated = $request->validate([
            'file' => 'required|string|max:255',
            'source' => 'required|string|max:2097152',
        ]);
        $directory = resource_path('views/clients/theme-' . $theme);
        $files = collect(\Illuminate\Support\Facades\File::allFiles($directory))
            ->map(fn ($file) => str_replace('\\', '/', substr($file->getPathname(), strlen($directory) + 1)))
            ->filter(fn ($file) => str_ends_with($file, '.blade.php'));
        $selectedFile = str_replace('\\', '/', $validated['file']);
        if (!$files->contains($selectedFile)) {
            return response()->json(['error' => 'Tệp giao diện không hợp lệ.'], 422);
        }

        $previewRoot = storage_path(
            'framework/views/client-theme-preview/' . hash('sha256', $request->session()->getId())
        );
        $previewRelativePath = 'clients' . DIRECTORY_SEPARATOR
            . 'theme-' . $theme . DIRECTORY_SEPARATOR
            . str_replace('/', DIRECTORY_SEPARATOR, $selectedFile);

        try {
            $previewFiles = [$previewRoot . DIRECTORY_SEPARATOR . $previewRelativePath];
            if ($theme === 'default' && \Illuminate\Support\Facades\File::isDirectory(
                resource_path('views/clients/theme-1')
            )) {
                $previewFiles[] = $previewRoot . DIRECTORY_SEPARATOR . 'clients' . DIRECTORY_SEPARATOR
                    . 'theme-1' . DIRECTORY_SEPARATOR
                    . str_replace('/', DIRECTORY_SEPARATOR, $selectedFile);
            }

            foreach ($previewFiles as $previewFile) {
                \Illuminate\Support\Facades\File::ensureDirectoryExists(dirname($previewFile));
                \Illuminate\Support\Facades\File::put($previewFile, $validated['source']);
            }

            $request->session()->put('client_theme_preview', [
                'theme' => $theme,
                'root' => $previewRoot,
                'file' => $selectedFile,
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['error' => 'Không thể cập nhật bản xem trước.'], 500);
        }

        return response()->json(['success' => true]);
    }

    public function saveClientThemeSource(Request $request, string $theme)
    {
        if (!in_array($theme, ['default', '4', '6'], true)) {
            return response()->json(['error' => 'Giao diện người dùng không hợp lệ.'], 422);
        }

        $config = Config::where('domain', getDomain())->first() ?? Config::first();
        $activeTheme = (string) ($config?->default_interface ?? 'default');
        if ($activeTheme === '1') {
            $activeTheme = 'default';
        }
        if ($activeTheme !== $theme) {
            return response()->json(['error' => 'Chỉ có thể chỉnh sửa giao diện người dùng đang áp dụng.'], 403);
        }

        $directory = resource_path('views/clients/theme-' . $theme);
        if (!\Illuminate\Support\Facades\File::isDirectory($directory)) {
            return response()->json(['error' => 'Không tìm thấy thư mục giao diện.'], 404);
        }

        $validated = $request->validate([
            'file' => 'required|string|max:255',
            'source' => 'required|string|max:2097152',
        ]);
        $files = collect(\Illuminate\Support\Facades\File::allFiles($directory))
            ->map(fn ($file) => str_replace('\\', '/', substr($file->getPathname(), strlen($directory) + 1)))
            ->filter(fn ($file) => str_ends_with($file, '.blade.php'));
        $selectedFile = str_replace('\\', '/', $validated['file']);
        if (!$files->contains($selectedFile)) {
            return response()->json(['error' => 'Tệp giao diện không hợp lệ.'], 422);
        }

        $sourcePath = $directory . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $selectedFile);
        try {
            \Illuminate\Support\Facades\File::put($sourcePath, $validated['source']);
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            $preview = $request->session()->get('client_theme_preview');
            if (($preview['theme'] ?? null) === $theme) {
                \Illuminate\Support\Facades\File::deleteDirectory($preview['root']);
                if ($selectedFile === 'account/edit.blade.php') {
                    $request->session()->put('client_theme_preview', [
                        'theme' => $theme,
                        'root' => $preview['root'],
                        'file' => $selectedFile,
                    ]);
                } else {
                    $request->session()->forget('client_theme_preview');
                }
            }
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['error' => 'Không thể lưu source giao diện.'], 500);
        }

        return response()->json(['success' => 'Đã lưu source giao diện.', 'file' => $selectedFile]);
    }

    public function resetClientThemeSource(Request $request, string $theme)
    {
        if (!in_array($theme, ['default', '4', '6'], true)) {
            return response()->json(['error' => 'Giao diện người dùng không hợp lệ.'], 422);
        }

        $config = Config::where('domain', getDomain())->first() ?? Config::first();
        $activeTheme = (string) ($config?->default_interface ?? 'default');
        if ($activeTheme === '1') {
            $activeTheme = 'default';
        }
        if ($activeTheme !== $theme) {
            return response()->json(['error' => 'Chỉ có thể khôi phục giao diện người dùng đang áp dụng.'], 403);
        }

        $directory = resource_path('views/clients/theme-' . $theme);
        $originalRoot = storage_path('app/client-theme-originals/' . sha1(getDomain()) . '/' . $theme);
        if (!\Illuminate\Support\Facades\File::isDirectory($directory)
            || !\Illuminate\Support\Facades\File::isDirectory($originalRoot)) {
            return response()->json(['error' => 'Chưa có bản gốc để khôi phục giao diện.'], 404);
        }

        try {
            foreach (\Illuminate\Support\Facades\File::allFiles($originalRoot) as $originalFile) {
                if (!str_ends_with($originalFile->getFilename(), '.blade.php')) {
                    continue;
                }
                $relativePath = str_replace('\\', '/', substr(
                    $originalFile->getPathname(),
                    strlen($originalRoot) + 1
                ));
                $targetPath = $directory . DIRECTORY_SEPARATOR
                    . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
                \Illuminate\Support\Facades\File::ensureDirectoryExists(dirname($targetPath));
                \Illuminate\Support\Facades\File::copy($originalFile->getPathname(), $targetPath);
            }

            $preview = $request->session()->get('client_theme_preview');
            $expectedPreviewRoot = storage_path(
                'framework/views/client-theme-preview/' . hash('sha256', $request->session()->getId())
            );
            if (($preview['root'] ?? null) === $expectedPreviewRoot) {
                \Illuminate\Support\Facades\File::deleteDirectory($expectedPreviewRoot);
            }
            $request->session()->forget('client_theme_preview');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['error' => 'Không thể khôi phục giao diện gốc.'], 500);
        }

        return response()->json(['success' => 'Đã khôi phục giao diện về bản gốc.']);
    }

    public function uploadLandingImage(Request $request)
    {
        $theme = (string) $request->input('theme', '');
        $viewName = $theme === 'default' ? 'landing-page.default' : 'landing-page.lang-' . $theme;
        if (($theme !== 'default' && !preg_match('/^\d+$/', $theme)) || !view()->exists($viewName)) {
            return response()->json(['error' => 'Landing theme không hợp lệ.'], 422);
        }

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp,avif|max:5120',
        ]);
        $image = $validated['image'];
        $filename = 'landing-' . $theme . '-' . Str::uuid() . '.' . $image->extension();
        $directory = public_path('images/landing/uploads');

        \Illuminate\Support\Facades\File::ensureDirectoryExists($directory);
        $image->move($directory, $filename);

        return response()->json(['url' => asset('images/landing/uploads/' . $filename)]);
    }

    private function landingCustomizationPath(string $theme): string
    {
        return 'themes/' . sha1(getDomain()) . '/landing-' . $theme . '.html';
    }

    /**
     * Dedicated WordPress-like editor for a sign-in theme.
     * Theme values may be numeric IDs or text slugs such as "default".
     */
    public function themeEditor(string $default_login)
    {
        if (!preg_match('/^[A-Za-z0-9_-]+$/', $default_login)) {
            abort(404);
        }

        $page = 'signin';
        $viewName = $this->authPageViewName($default_login, $page);
        if (!$viewName) {
            abort(404, 'Không tìm thấy giao diện đăng nhập.');
        }

        $config = Config::where('domain', getDomain())->first() ?? Config::first() ?? new Config();
        $settings = $config->toArray();
        $settings['site_name'] = $settings['title'] ?? config('app.name');
        $html = $this->renderAuthPage($viewName, $config, $settings, $page);
        $customize = $this->authPageCustomization($default_login, $page);

        $languageData = [];
        $languagePath = public_path('assets/client/language.js');
        if (is_file($languagePath)) {
            $languageSource = file_get_contents($languagePath);
            if (preg_match('/var\s+LANGUAGE\s*=\s*(\{.*\})\s*;\s*$/s', $languageSource, $match)) {
                $languageData = json_decode($match[1], true) ?: [];
            }
        }

        return view('admin.settings.theme-editor', [
            'theme' => $default_login,
            'page' => $page,
            'pages' => $this->authPages(),
            'customize' => $customize,
            'previewHtml' => $this->injectSignInEditor($html, $default_login, $customize),
            'languages' => Language::where('domain', getDomain())->where('status', true)->orderBy('name')->get(['code', 'name', 'flag']),
        ]);
    }

    public function loadSignInHTML(Request $request)
    {
        $theme = (string) $request->input('theme', '');

        if (!preg_match('/^[A-Za-z0-9_-]+$/', $theme)) {
            return response()->json(['error' => 'Theme đăng nhập không hợp lệ.'], 422);
        }

        $page = (string) $request->input('page', 'signin');
        $viewName = $this->authPageViewName($theme, $page);
        if (!$viewName) {
            return response()->json(['error' => 'Không tìm thấy trang xác thực trong theme này.'], 404);
        }

        $config = Config::where('domain', getDomain())->first() ?? Config::first() ?? new Config();
        $settings = $config->toArray();
        $settings['site_name'] = $settings['title'] ?? config('app.name');
        $customize = $this->authPageCustomization($theme, $page);

        try {
            $html = $this->renderAuthPage($viewName, $config, $settings, $page);
            $html = $this->injectSignInEditor($html, $theme, $customize);

            return response()->json([
                'success' => $html,
                'customize' => $this->signInCustomizations()[$theme] ?? [],
                'page_customize' => $customize,
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'error' => 'Không thể tải theme đăng nhập: ' . $exception->getMessage(),
            ], 500);
        }
    }

    public function saveSignInHTML(Request $request)
    {
        $theme = (string) $request->input('theme', '');
        $page = (string) $request->input('page', 'signin');
        $customize = $request->input('customize');
        if (is_string($customize)) {
            $customize = json_decode($customize, true);
        }

        if ($request->hasFile('image') && is_array($customize)) {
            // The editor preview uses a temporary blob: URL; replace it with
            // the permanent Laravel asset URL after the uploaded file is saved.
            $customize['background1'] = null;
            $customize['image'] = null;
        }

        if (!preg_match('/^[A-Za-z0-9_-]+$/', $theme) || !$this->isAuthPage($page)) {
            return response()->json(['error' => 'Theme đăng nhập không hợp lệ.'], 422);
        }

        if (!$this->authPageViewName($theme, $page)) {
            return response()->json(['error' => 'Không tìm thấy trang xác thực trong theme này.'], 404);
        }

        $validator = Validator::make(['customize' => $customize], [
            'customize' => 'required|array',
            'customize.background' => 'nullable|url|max:2048',
            'customize.image' => 'nullable|url|max:2048',
            'customize.background1' => 'nullable|url|max:2048',
            'customize.title' => 'nullable|string|max:500',
            'customize.description' => 'nullable|string|max:2000',
            'customize.seo_title' => 'nullable|string|max:255',
            'customize.seo_description' => 'nullable|string|max:500',
            'customize.styles' => 'nullable|array',
            'customize.styles.background_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'customize.styles.text_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'customize.styles.accent_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'customize.styles.font_family' => 'nullable|string|in:Inter,Arial,Georgia,Roboto,system-ui',
            'customize.layout' => 'nullable|array',
            'customize.layout.*' => 'string|in:title,description,image,form',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $validatedCustomize = $validator->validated()['customize'];
        $uploadedImagePath = null;
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imageValidator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp,avif|max:5120',
            ]);
            if ($imageValidator->fails()) {
                return response()->json(['error' => $imageValidator->errors()->first()], 422);
            }

            $image = $request->file('image');
            $relativePath = 'images/auth/' . Str::uuid() . '.' . $image->extension();
            $absolutePath = public_path($relativePath);
            \Illuminate\Support\Facades\File::ensureDirectoryExists(dirname($absolutePath));
            $image->move(dirname($absolutePath), basename($absolutePath));
            $uploadedImagePath = $absolutePath;
            $imageUrl = asset($relativePath);
            $validatedCustomize['background1'] = $imageUrl;
            $validatedCustomize['image'] = $imageUrl;
        }

        $disk = Storage::disk('local');
        $allCustomizations = $this->signInCustomizations();
        $themeCustomizations = $allCustomizations[$theme] ?? [];
        if (isset($themeCustomizations['pages']) && is_array($themeCustomizations['pages'])) {
            $pages = $themeCustomizations['pages'];
        } else {
            $pages = is_array($themeCustomizations) && $themeCustomizations !== []
                ? ['signin' => $themeCustomizations]
                : [];
        }
        $previousImage = (string) ($pages[$page]['background1'] ?? $pages[$page]['image'] ?? '');
        $pages[$page] = array_intersect_key(
            $validatedCustomize,
            array_flip(['background', 'image', 'background1', 'title', 'description', 'seo_title', 'seo_description', 'styles', 'layout'])
        );
        $allCustomizations[$theme] = ['pages' => $pages];

        try {
            $saved = $disk->put(
                $this->signInCustomizationPath(),
                json_encode($allCustomizations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
            );
        } catch (\Throwable $exception) {
            report($exception);
            $saved = false;
        }
        if (!$saved) {
            if ($uploadedImagePath && is_file($uploadedImagePath)) {
                \Illuminate\Support\Facades\File::delete($uploadedImagePath);
            }
            return response()->json(['error' => 'Không thể lưu tùy chỉnh giao diện.'], 500);
        }

        $newImage = (string) ($pages[$page]['background1'] ?? $pages[$page]['image'] ?? '');
        $this->deleteManagedThemeImage($previousImage, $theme, $page, $newImage);

        return response()->json([
            'success' => 'Đã lưu tùy chỉnh giao diện đăng nhập.',
            'image_url' => $imageUrl,
        ]);
    }

    public function resetSignInCustomization(Request $request)
    {
        $theme = (string) $request->input('theme', '');
        $page = (string) $request->input('page', 'signin');
        if (!preg_match('/^[A-Za-z0-9_-]+$/', $theme) || !$this->authPageViewName($theme, $page)) {
            return response()->json(['error' => 'Trang giao diện đăng nhập không hợp lệ.'], 422);
        }

        $allCustomizations = $this->signInCustomizations();
        $themeCustomizations = $allCustomizations[$theme] ?? [];
        $pages = $themeCustomizations['pages'] ?? null;
        $previousCustomization = is_array($pages)
            ? ($pages[$page] ?? [])
            : ($page === 'signin' ? $themeCustomizations : []);
        $previousImage = (string) (
            $previousCustomization['background1'] ?? $previousCustomization['image'] ?? ''
        );

        if (is_array($pages)) {
            unset($pages[$page]);
            if ($pages === []) {
                unset($allCustomizations[$theme]);
            } else {
                $allCustomizations[$theme]['pages'] = $pages;
            }
        } elseif ($page === 'signin') {
            unset($allCustomizations[$theme]);
        }

        $disk = Storage::disk('local');
        $path = $this->signInCustomizationPath();
        try {
            if ($allCustomizations === []) {
                if ($disk->exists($path) && !$disk->delete($path)) {
                    throw new \RuntimeException('Unable to remove saved sign-in customization.');
                }
            } elseif (!$disk->put(
                $path,
                json_encode($allCustomizations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
            )) {
                throw new \RuntimeException('Unable to save sign-in customization.');
            }
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['error' => 'Không thể khôi phục giao diện đăng nhập.'], 500);
        }

        $remainingCustomizations = json_encode($allCustomizations, JSON_UNESCAPED_UNICODE) ?: '';
        if ($previousImage !== '' && !str_contains($remainingCustomizations, $previousImage)) {
            $this->deleteManagedThemeImage($previousImage, $theme, $page, '');
        }

        return response()->json(['success' => 'Đã khôi phục giao diện đăng nhập về bản gốc.']);
    }

    private function signInCustomizations(): array
    {
        $disk = Storage::disk('local');
        $path = $this->signInCustomizationPath();

        if (!$disk->exists($path)) {
            return [];
        }

        $customizations = json_decode($disk->get($path), true);

        return is_array($customizations) ? $customizations : [];
    }

    private function signInCustomizationPath(): string
    {
        return 'themes/' . sha1(getDomain()) . '/signin.json';
    }

    private function signInViewName(string $theme): ?string
    {
        return $this->authPageViewName($theme, 'signin');
    }

    private function authPageViewName(string $theme, string $page): ?string
    {
        if (!$this->isAuthPage($page)) {
            return null;
        }

        foreach ([
            'auth.theme-' . $theme . '.' . $page,
            'clients.theme-' . $theme . '.auth.' . $page,
        ] as $viewName) {
            if (view()->exists($viewName)) {
                return $viewName;
            }
        }

        return null;
    }

    private function authPages(): array
    {
        return [
            'signin' => 'Đăng nhập',
            'signup' => 'Đăng ký',
            'forgot-password' => 'Quên mật khẩu',
            'reset-password' => 'Đặt lại mật khẩu',
            '2fa' => 'Xác thực 2 bước',
        ];
    }

    private function isAuthPage(string $page): bool
    {
        return array_key_exists($page, $this->authPages());
    }

    private function authPageCustomization(string $theme, string $page): array
    {
        $themeCustomization = $this->signInCustomizations()[$theme] ?? [];
        if (isset($themeCustomization['pages']) && is_array($themeCustomization['pages'])) {
            return is_array($themeCustomization['pages'][$page] ?? null)
                ? $themeCustomization['pages'][$page]
                : [];
        }

        return $page === 'signin' && is_array($themeCustomization) ? $themeCustomization : [];
    }

    private function renderAuthPage(string $viewName, Config $config, array $settings, string $page): string
    {
        $errors = new ViewErrorBag();
        $data = compact('config', 'settings', 'errors');
        if ($page === 'reset-password') {
            $data['token'] = 'preview-token';
            $data['email'] = 'preview@example.com';
        }

        return view($viewName, $data)->render();
    }

    private function deleteManagedThemeImage(string $oldUrl, string $theme, string $page, string $newUrl): void
    {
        if ($oldUrl === '' || $oldUrl === $newUrl) {
            return;
        }

        $oldPath = ltrim((string) parse_url($oldUrl, PHP_URL_PATH), '/');
        if (str_starts_with($oldPath, 'storage/')) {
            $oldPath = substr($oldPath, 8);
        }

        $domainHash = sha1(getDomain());
        $publicImagePath = null;
        $flatImagePrefix = 'images/auth/';
        $legacyImagePrefix = $flatImagePrefix . $domainHash . '/' . $theme . '/' . $page . '/';
        if (str_starts_with($oldPath, $legacyImagePrefix)) {
            $filename = substr($oldPath, strlen($legacyImagePrefix));
            if (preg_match('/^[A-Za-z0-9-]+\.(?:jpg|jpeg|png|gif|webp|avif)$/i', $filename)) {
                $publicImagePath = $legacyImagePrefix . $filename;
            }
        } elseif (str_starts_with($oldPath, $flatImagePrefix)) {
            $filename = substr($oldPath, strlen($flatImagePrefix));
            if (preg_match('/^[A-Za-z0-9-]+\.(?:jpg|jpeg|png|gif|webp|avif)$/i', $filename)) {
                $publicImagePath = $flatImagePrefix . $filename;
            }
        }

        if ($publicImagePath !== null) {
            $absolutePath = public_path($publicImagePath);
            if (is_file($absolutePath)) {
                \Illuminate\Support\Facades\File::delete($absolutePath);
            }
            return;
        }

        $legacyManagedPrefix = 'auth-themes/' . $domainHash . '/' . $theme . '/' . $page . '/';
        if (str_starts_with($oldPath, $legacyManagedPrefix)) {
            $filename = substr($oldPath, strlen($legacyManagedPrefix));
            $legacyPath = $legacyManagedPrefix . basename($filename);
            if ($filename === basename($filename) && Storage::disk('public')->exists($legacyPath)) {
                Storage::disk('public')->delete($legacyPath);
            }
        }
    }

    /**
     * admin.js expects **INIT_DATA** plus these input selectors inside the iframe:
     * .background, .background1, .title and .description.
     */
    private function injectSignInEditor(string $html, string $theme, ?array $initialCustomize = null): string
    {
        $editor = <<<'HTML'
<div id="signin-theme-values" hidden>
    <input class="background" type="hidden">
    <input class="background1" type="hidden">
    <input class="title" type="hidden">
    <input class="description" type="hidden">
</div>
<style>
    [data-signin-editable="true"] { outline: 2px dashed #0d6efd !important; outline-offset: 3px; cursor: text !important; }
    img[data-signin-image="true"] { outline: 2px dashed #ffc107 !important; outline-offset: 3px; cursor: pointer !important; }
</style>
<script>
(function () {
    const customize = **INIT_DATA**;
    // Preview only: never allow editor clicks to navigate the real site.
    document.addEventListener('click', function (event) {
        const link = event.target.closest('a, button, form');
        if (link) {
            event.preventDefault();
            event.stopPropagation();
        }
    }, true);
    document.addEventListener('submit', function (event) { event.preventDefault(); }, true);
    document.addEventListener('keydown', function (event) {
        if ((event.key === 'Enter' || event.key === ' ') && event.target.closest('a, button')) {
            event.preventDefault();
        }
    }, true);
    const data = customize && typeof customize === 'object' ? customize : {};
    const values = document.getElementById('signin-theme-values');
    const title = document.querySelector('.block-signin-text__block-text-title h1, .block-signin__title, h1');
    const description = document.querySelector('.block-signin__description, .block-signin-text__block-text-description, h1 + p');
    const image = document.querySelector('[data-auth-theme-image], .cmz-background1, img.background1, .block-signin-text img, .block-signin__content img');
    const imageContainer = image ? null : document.querySelector('.block-signin-text, .block-signin__content, .bgi-size-cover');
    const styles = data.styles && typeof data.styles === 'object' ? data.styles : {};

    values.querySelector('.background').value = data.background || '';
    values.querySelector('.background1').value = data.background1 || data.image || '';
    values.querySelector('.title').value = data.title || (title ? title.textContent.trim() : '');
    values.querySelector('.description').value = data.description || (description ? description.textContent.trim() : '');

    if (data.title && title) title.textContent = data.title;
    if (data.description && description) description.textContent = data.description;
    if (data.background) {
        document.body.style.backgroundImage = 'url("' + String(data.background).replace(/"/g, '\\"') + '")';
        document.body.style.backgroundSize = 'cover';
        document.body.style.backgroundPosition = 'center';
    }
    if (styles.background_color) document.body.style.backgroundColor = styles.background_color;
    if (styles.text_color) document.body.style.color = styles.text_color;
    if (styles.accent_color) {
        document.documentElement.style.setProperty('--signin-accent', styles.accent_color);
        const accentStyle = document.createElement('style');
        accentStyle.textContent = '.btn-primary,button[type="submit"],input[type="submit"]{background-color:' + styles.accent_color + '!important;border-color:' + styles.accent_color + '!important}';
        document.head.appendChild(accentStyle);
    }
    if (styles.font_family) document.body.style.fontFamily = styles.font_family;
    if (data.seo_title) document.title = data.seo_title;
    if (data.seo_description) {
        let metaDescription = document.querySelector('meta[name="description"]');
        if (!metaDescription) {
            metaDescription = document.createElement('meta');
            metaDescription.name = 'description';
            document.head.appendChild(metaDescription);
        }
        metaDescription.content = data.seo_description;
    }
    if (image) {
        image.dataset.signinImage = 'true';
        if (data.background1 || data.image) image.src = data.background1 || data.image;
    }
    if (imageContainer && (data.background1 || data.image)) {
        imageContainer.style.backgroundImage = 'url("' + String(data.background1 || data.image).replace(/"/g, '\\"') + '")';
        imageContainer.style.backgroundSize = 'cover';
        imageContainer.style.backgroundPosition = 'center';
    }
    [title, description].filter(Boolean).forEach(function (element) {
        element.contentEditable = 'true';
        element.dataset.signinEditable = 'true';
    });
    if (title) title.addEventListener('input', function () { values.querySelector('.title').value = title.textContent.trim(); });
    if (description) description.addEventListener('input', function () { values.querySelector('.description').value = description.textContent.trim(); });
    if (Array.isArray(data.layout)) {
        const elements = { title: title, description: description, image: image, form: document.querySelector('form') };
        const selected = data.layout.map(function (key) { return elements[key]; }).filter(Boolean);
        const parent = selected[0] && selected.every(function (element) {
            return element.parentElement === selected[0].parentElement;
        }) ? selected[0].parentElement : null;
        if (parent) selected.forEach(function (element) { parent.appendChild(element); });
    }
})();
</script>
HTML;

        if ($initialCustomize !== null) {
            $editor = str_replace(
                '**INIT_DATA**',
                json_encode($initialCustomize, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?: '{}',
                $editor
            );
        }

        if (stripos($html, '</body>') !== false) {
            return preg_replace('/<\/body>/i', $editor . '</body>', $html, 1) ?? $html;
        }

        return $html . $editor;
    }

    public function saveSetting(Request $request)
    {
        // Tương thích payload AJAX legacy từ _settings trong admin.js.
        $aliases = [
            'website_title' => 'title',
            'website_description' => 'description',
            'website_keywords' => 'keywords',
            'default_language' => 'default_lang',
            'announcement' => 'announcement_content',
            'terms' => 'terms_content',
            'landing_theme' => 'default_landingpage',
            'home_theme' => 'default_login',
            'client_theme' => 'default_interface',
            'landing_as_service_page' => 'default_landingpage',
            'style_theme' => 'default_interface',
            'smtp_user' => 'smtp_username',
            'smtp_pass' => 'smtp_password',
            'smtp_from' => 'smtp_from_name',
            'child_panel_price' => 'child_panel_cost',
            'affiliate_minpay_status' => 'affiliate_allow_withdraw',
            'affiliate_convert_status' => 'affiliate_allow_convert',
            'affiliate_convert_auto' => 'affiliate_auto_convert',
            'affiliate_convert' => 'affiliate_min_convert',
            'affiliate_minpay' => 'affiliate_min_withdraw',
            'telegram_token' => 'telegram_token_bot',
            'telegram_chat_id' => 'telegram_public_chat_id',
            'telegram_notification_add_service' => 'telegram_notify_add_service',
            'telegram_notification_update_service' => 'telegram_notify_update_service',
            'telegram_notification_new_manual_order' => 'telegram_notify_manual_order',
            'telegram_notification_new_deposit' => 'telegram_notify_deposit',
            'keep_cancel_orders_data' => 'keep_orders',
            'module_oauth_google_client_id' => 'google_oauth_client_id',
            'module_oauth_google_client_secret' => 'google_oauth_client_secret',
            'module_fake_order_id_step' => 'fake_order_step_max',
            'signup_status' => 'enable_signup',
            'allow_register' => 'enable_signup',
            'allow_multi_device_login' => 'multiple_login_status',
            'recaptcha_status' => 'gcaptcha_status',
            'recaptcha_site_key' => 'gcaptcha_site_key',
            'recaptcha_secret_key' => 'gcaptcha_secret_key',
            'css' => 'script_css',
            'header_javascript' => 'script_header',
            'footer_javascript' => 'script_footer',
            'percent_inc_service' => 'markup_retail',
            'percent_inc_service_1' => 'markup_agent',
            'percent_inc_service_2' => 'markup_distributor',
            'contact_facebook' => 'link_facebook',
            'contact_skype' => 'link_zalo',
            'contact_telegram' => 'link_telegram',
            'contact_whatsapp' => 'link_whatsapp',
            'contact_phone' => 'phone_admin',
            'contact_others' => 'other_contact',
        ];
        $data = $request->all();

        if (array_key_exists('landing_as_service_page', $data)
            && !in_array((string) $data['landing_as_service_page'], ['-1', '-2'], true)) {
            return response()->json(['error' => 'Giá trị chuyển hướng trang chủ không hợp lệ.'], 422);
        }

        foreach ($aliases as $source => $target) {
            if (array_key_exists($source, $data)) {
                $data[$target] = $data[$source];
            }
        }

        $changePriceAll = filter_var(
            $data['change_price_all'] ?? false,
            FILTER_VALIDATE_BOOLEAN
        );
        if ($changePriceAll) {
            $priceValidator = Validator::make($data, [
                'markup_retail' => 'required|numeric|min:0|max:999.99',
                'markup_agent' => 'required|numeric|min:0|max:999.99',
                'markup_distributor' => 'required|numeric|min:0|max:999.99',
            ]);
            if ($priceValidator->fails()) {
                return response()->json(['error' => $priceValidator->errors()->first()], 422);
            }
        }

        // admin.js gửi trạng thái bảo trì; configs.status lưu trạng thái website hoạt động.
        if (array_key_exists('website_maintenance', $data)) {
            $data['status'] = !filter_var($data['website_maintenance'], FILTER_VALIDATE_BOOLEAN);
        }

        if (array_key_exists('quick_chat_messages', $data) && is_string($data['quick_chat_messages'])) {
            $quickMessages = json_decode($data['quick_chat_messages'], true);
            if (!is_array($quickMessages)) {
                return response()->json(['error' => 'Dữ liệu tin nhắn nhanh không hợp lệ.'], 422);
            }
            $data['quick_chat_messages'] = array_values(array_filter(
                array_map(fn ($message) => is_string($message) ? trim($message) : $message, $quickMessages),
                fn ($message) => $message !== ''
            ));
        }

        if (array_key_exists('direct_message_chatbox', $data)) {
            $data['direct_message_chatbox'] = filter_var(
                $data['direct_message_chatbox'],
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            );
        }

        // Dropdown legacy dùng mã quốc gia (vn/us/...) để _settings.templateCountry
        // hiển thị cờ. Chuyển lại về mã ngôn ngữ (vi/en/...) trước khi lưu config.
        if (!empty($data['default_lang'])) {
            $selectedFlag = strtolower((string) $data['default_lang']);
            $language = Language::where('domain', getDomain())
                ->where('status', 1)
                ->get(['code', 'flag'])
                ->first(function (Language $language) use ($selectedFlag) {
                    return strtolower($language->code) === $selectedFlag
                        || strtolower($language->flag_code) === $selectedFlag;
                });

            if ($language) {
                $data['default_lang'] = $language->code;
            }
        }

        $supportValidator = Validator::make($data, [
            'link_facebook'          => 'sometimes|nullable|string|max:500',
            'link_zalo'              => 'sometimes|nullable|string|max:500',
            'link_telegram'          => 'sometimes|nullable|string|max:500',
            'link_whatsapp'          => 'sometimes|nullable|string|max:500',
            'phone_admin'            => 'sometimes|nullable|string|max:50',
            'other_contact'          => 'sometimes|nullable|string',
            'direct_message_chatbox' => 'sometimes|boolean',
            'quick_chat_messages'    => 'sometimes|array|max:50',
            'quick_chat_messages.*'  => 'string|max:500',
        ]);
        if ($supportValidator->fails()) {
            return response()->json(['error' => $supportValidator->errors()->first()], 422);
        }

        // Chỉ cho phép các cột đã khai báo fillable trên Config.
        // Điều này giúp toàn bộ payload Setting-* của _settings tương thích an toàn.
        $allowed = (new Config())->getFillable();
        $data = array_intersect_key($data, array_flip($allowed));

        if (!$data) {
            return response()->json(['error' => 'No supported settings provided.'], 422);
        }

        $config = Config::where('domain', getDomain())->first() ?? new Config(['domain' => getDomain()]);
        $booleanFields = [
            'show_multi_rate',
            'status',
            'enable_signup',
            'multiple_login_status',
            'gcaptcha_status',
            'enable_services',
            'service_allow_report',
            'service_require_login',
            'service_average_time',
            'require_confirm_service',
            'check_duplicate_order_status',
            'direct_message_chatbox',
            'smtp_status',
            'smtp_verify_account',
            'smtp_forget_password',
            'smtp_warning_login',
            'child_panel_status',
            'member_level_status',
            'keep_orders_status',
            'google_oauth_status',
            'fake_order_status',
            'module_coupon',
            'module_crisp_chat',
            'telegram_status',
            'google_analytics_status',
            'affiliate_auto_convert',
            'affiliate_allow_withdraw',
            'affiliate_allow_convert',
            'telegram_notify_add_service',
            'telegram_notify_update_service',
            'telegram_notify_manual_order',
            'telegram_notify_deposit',
        ];
        foreach ($data as $field => $value) {
            $config->{$field} = in_array($field, $booleanFields, true)
                ? filter_var($value, FILTER_VALIDATE_BOOLEAN)
                : ($field === 'announcement_payment_status'
                    ? (filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0)
                    : $value);
        }
        DB::transaction(function () use ($config, $changePriceAll, $data) {
            $config->save();

            if ($changePriceAll) {
                Service::where('domain', getDomain())->update([
                    'rate_retail_up' => $data['markup_retail'],
                    'rate_agent_up' => $data['markup_agent'],
                    'rate_distributor_up' => $data['markup_distributor'],
                ]);
            }
        });

        return adminSuccess();
    }

    private function showSetting($view, $extraData = [])
    {
        $config = Config::where('domain', getDomain())->first() ?? new Config();
        $config->domain = getDomain();
        $languages = Language::where('status', 1)->where('domain', getDomain())->get();
        $data = compact('config', 'languages') + $extraData;
        return view("admin.settings.$view", $data);
    }

    public function general()
    {
        $currencies = Currency::where('status', 1)->where('domain', getDomain())->orderBy('code')->get();
        return $this->showSetting('general', compact('currencies'));
    }
    public function theme()
    {
        return $this->showSetting('theme');
    }
    public function design()
    {
        return $this->showSetting('design');
    }
    public function price()
    {
        return $this->showSetting('price');
    }
    public function service()
    {
        return $this->showSetting('service');
    }
    public function product()
    {
        return $this->showSetting('product');
    }
    public function language()
    {
        return $this->showSetting('language');
    }
    public function support()
    {
        $config = Config::where('domain', getDomain())->first() ?? new Config(['domain' => getDomain()]);
        $languages = Language::where('status', 1)
            ->where('domain', getDomain())
            ->get();
        $quickMessages = $config->quick_chat_messages ?? [];

        if (is_string($quickMessages)) {
            $quickMessages = json_decode($quickMessages, true);
        }

        $quickMessages = collect(is_array($quickMessages) ? $quickMessages : [])
            ->filter(fn ($message) => is_string($message) && trim($message) !== '')
            ->map(fn ($message) => trim($message))
            ->values()
            ->all();

        return view('admin.settings.support', compact('config', 'languages', 'quickMessages'));
    }
    public function security()
    {
        $config = Config::where('domain', getDomain())->first() ?? new Config(['domain' => getDomain()]);
        $languages = Language::where('status', 1)->where('domain', getDomain())->get();
        $blockedIps = json_decode($config->blocked_ips ?? '[]', true);
        $blockedIps = is_array($blockedIps) ? array_values($blockedIps) : [];

        return view('admin.settings.security', compact('config', 'languages', 'blockedIps'));
    }
    public function smtp()
    {
        return $this->showSetting('smtp');
    }
    public function modules()
    {
        $config = Config::where('domain', getDomain())->first() ?? new Config(['domain' => getDomain()]);
        $languages = Language::where('status', 1)->where('domain', getDomain())->get();
        $defaultLevels = [
            ['name' => 'NEWBIE', 'min_deposit' => 0, 'bonus_percent' => 0],
            ['name' => 'JUNIOR', 'min_deposit' => 1000, 'bonus_percent' => 0],
            ['name' => 'ELITE', 'min_deposit' => 5000, 'bonus_percent' => 0],
            ['name' => 'FREQUENT', 'min_deposit' => 10000, 'bonus_percent' => 0],
            ['name' => 'VIP', 'min_deposit' => 20000, 'bonus_percent' => 0],
        ];
        $memberLevels = $config->member_levels;
        if (is_string($memberLevels)) {
            $memberLevels = json_decode($memberLevels, true);
        }
        $memberLevels = is_array($memberLevels) && $memberLevels ? $memberLevels : $defaultLevels;

        return view('admin.settings.modules', compact('config', 'languages', 'memberLevels'));
    }
    public function social()
    {
        return $this->showSetting('social');
    }
    public function pricing()
    {
        return $this->showSetting('pricing');
    }
    public function notifications()
    {
        return $this->showSetting('notifications');
    }
    public function email()
    {
        return $this->showSetting('email');
    }
    public function advanced()
    {
        return $this->showSetting('advanced');
    }
    public function keepOrders()
    {
        return $this->showSetting('keep-orders');
    }
    public function cloudflare()
    {
        return $this->showSetting('cloudflare');
    }

    public function currency()
    {
        $currencies = Currency::where(function ($query) {
                $query->where('domain', getDomain())->orWhereNull('domain');
            })->get()
            ->sortBy(fn($c) => $c->code === 'VND' ? '' : $c->code)
            ->values();
        return $this->showSetting('currency', ['currency_settings' => $currencies]);
    }
    private function sendResponse($success, $message, $data = [], $statusCode = 200, Request $request = null)
    {
        if ($request && $request->expectsJson()) {
            return response()->json(array_merge(['success' => $success, 'message' => $message], $data), $statusCode);
        }

        $redirect = redirect()->back();
        return $success ? $redirect->with('success', $message) : $redirect->with('error', $message);
    }

    private function updateConfig(Request $request, array $rules, array $fields, ?string $successMsg = null)
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $config = Config::where('domain', getDomain())->first() ?? new Config();
            $config->domain = getDomain();
            $config->fill($request->only($fields));
            $config->save();

            return $this->sendResponse(true, $successMsg ?? adminMessage('update'), [], 200, $request);
        } catch (\Exception $e) {
            return $this->sendResponse(false, 'Có lỗi xảy ra: ' . $e->getMessage(), [], 500, $request)->withInput();
        }
    }

    public function updateGeneral(Request $request)
    {
        return $this->updateConfig($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'keywords' => 'nullable|string|max:500',
            'default_currency' => 'nullable|string|max:10',
            'default_lang' => 'nullable|string|max:10',
            'announcement_position' => 'nullable|string|in:modal,page,page_and_modal',
            'announcement_content' => 'nullable|string',
        ], [
            'title',
            'description',
            'keywords',
            'default_currency',
            'default_lang',
            'announcement_position',
            'announcement_content'
        ]);
    }

    public function updateTerms(Request $request)
    {
        return $this->updateConfig($request, [
            'terms_content' => 'nullable|string',
        ], ['terms_content']);
    }

    public function updateTheme(Request $request)
    {
        return $this->updateConfig($request, [
            'default_theme' => 'nullable|string|in:light,dark',
            'notice_modal' => 'nullable|string|max:2000',
            'domain_main' => 'nullable|string|max:255',
            'domain' => 'nullable|string|max:1000',
            'default_landingpage' => 'nullable|string|max:50',
            'default_login' => 'nullable|string|max:50',
            'default_interface' => 'nullable|string|max:50',
        ], [
            'default_theme',
            'notice_modal',
            'domain_main',
            'domain',
            'default_landingpage',
            'default_login',
            'default_interface'
        ]);
    }

    public function updateSocial(Request $request)
    {
        return $this->updateConfig($request, [
            'link_facebook' => 'nullable|url|max:500',
            'link_telegram' => 'nullable|url|max:500',
            'link_zalo' => 'nullable|url|max:500',
            'link_whatsapp' => 'nullable|url|max:500',
        ], ['link_facebook', 'link_telegram', 'link_zalo', 'link_whatsapp']);
    }

    public function updateSupport(Request $request)
    {
        $aliases = [
            'contact_facebook' => 'link_facebook',
            'contact_skype'    => 'link_zalo',
            'contact_telegram' => 'link_telegram',
            'contact_whatsapp' => 'link_whatsapp',
            'contact_phone'    => 'phone_admin',
            'contact_others'   => 'other_contact',
        ];
        $data = $request->all();
        foreach ($aliases as $source => $target) {
            if (array_key_exists($source, $data)) {
                $data[$target] = $data[$source];
            }
        }

        if (array_key_exists('quick_chat_messages', $data) && is_string($data['quick_chat_messages'])) {
            $decodedMessages = json_decode($data['quick_chat_messages'], true);
            if (!is_array($decodedMessages)) {
                return response()->json(['error' => 'Dữ liệu tin nhắn nhanh không hợp lệ.'], 422);
            }
            $data['quick_chat_messages'] = array_values(array_filter(
                array_map(fn ($message) => is_string($message) ? trim($message) : $message, $decodedMessages),
                fn ($message) => $message !== ''
            ));
        }


        if (array_key_exists('direct_message_chatbox', $data)) {
            $data['direct_message_chatbox'] = filter_var(
                $data['direct_message_chatbox'],
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            );
        }

        $validator = Validator::make($data, [
            'link_facebook'          => 'sometimes|nullable|string|max:500',
            'link_telegram'          => 'sometimes|nullable|string|max:500',
            'link_whatsapp'          => 'sometimes|nullable|string|max:500',
            'link_zalo'              => 'sometimes|nullable|string|max:500',
            'phone_admin'            => 'sometimes|nullable|string|max:50',
            'other_contact'          => 'sometimes|nullable|string',
            'direct_message_chatbox' => 'sometimes|boolean',
            'quick_chat_messages'    => 'sometimes|array|max:50',
            'quick_chat_messages.*'  => 'string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $fields = [
            'link_facebook', 'link_telegram', 'link_whatsapp', 'link_zalo',
            'phone_admin', 'other_contact',
            'direct_message_chatbox',
            'quick_chat_messages',
        ];
        $values = array_intersect_key($validator->validated(), array_flip($fields));
        $config = Config::firstOrNew(['domain' => getDomain()]);
        $config->fill($values)->save();

        return adminSuccess();
    }

    public function updatePrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'markup_retail' => 'required|numeric|min:0|max:999.99',
            'markup_agent' => 'required|numeric|min:0|max:999.99',
            'markup_distributor' => 'required|numeric|min:0|max:999.99',
            'show_multi_rate' => 'nullable|boolean',
            'min_total_deposit_child_panel' => 'nullable|numeric|min:0',
            'min_total_deposit_reseller' => 'nullable|numeric|min:0',
            'change_price_all' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $config = Config::where('domain', getDomain())->first() ?? new Config();
            $config->domain = getDomain();
            $fieldsToUpdate = $request->only([
                'markup_retail',
                'markup_agent',
                'markup_distributor',
                'min_total_deposit_child_panel',
                'min_total_deposit_reseller',
            ]);
            $fieldsToUpdate['show_multi_rate'] = $request->boolean('show_multi_rate');

            if (!empty($fieldsToUpdate)) {
                $config->update($fieldsToUpdate);
            }

            if ($request->boolean('change_price_all')) {
                \App\Models\Service::where('domain', getDomain())->update([
                    'rate_retail_up' => $request->input('markup_retail'),
                    'rate_agent_up' => $request->input('markup_agent'),
                    'rate_distributor_up' => $request->input('markup_distributor'),
                ]);
            }

            return $this->sendResponse(true, 'Cài đặt giá bán đã được cập nhật thành công!', [], 200, $request);
        } catch (\Exception $e) {
            return $this->sendResponse(false, 'Có lỗi xảy ra: ' . $e->getMessage(), [], 500, $request)->withInput();
        }
    }

    public function updatePricing(Request $request)
    {
        return $this->updateConfig($request, [
            'markup_retail' => 'required|numeric|min:0|max:100',
            'markup_agent' => 'required|numeric|min:0|max:100',
            'markup_distributor' => 'required|numeric|min:0|max:100',
            'affiliate_percent' => 'required|numeric|min:0|max:100',
            'affiliate_min' => 'required|numeric|min:0',
            'affiliate_max' => 'required|numeric|min:0',
            'affiliate_status' => 'required|boolean',
        ], [
            'markup_retail',
            'markup_agent',
            'markup_distributor',
            'affiliate_percent',
            'affiliate_min',
            'affiliate_max',
            'affiliate_status'
        ]);
    }

    public function updateNotifications(Request $request)
    {
        return $this->updateConfig($request, [
            'telegram_bot' => 'nullable|string|max:255',
            'telegram_chat_id' => 'nullable|string|max:255',
            'telegram_status' => 'required|boolean',
            'notice_system' => 'nullable|string|max:5000',
        ], ['telegram_bot', 'telegram_chat_id', 'telegram_status', 'notice_system']);
    }

    public function updateEmail(Request $request)
    {
        return $this->updateConfig($request, [
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_from_name' => 'nullable|string|max:255',
        ], ['smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_from_name']);
    }

    public function testSmtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'smtp_host'  => 'required|string|max:255',
            'smtp_port'  => 'required|integer|min:1|max:65535',
            'smtp_user'  => 'required|string|max:255',
            'smtp_pass'  => 'required|string|max:255',
            'smtp_from'  => 'required|email|max:255',
            'test_email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $data = $validator->validated();

        try {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.scheme' => (int) $data['smtp_port'] === 465 ? 'smtps' : 'smtp',
                'mail.mailers.smtp.host' => $data['smtp_host'],
                'mail.mailers.smtp.port' => (int) $data['smtp_port'],
                'mail.mailers.smtp.username' => $data['smtp_user'],
                'mail.mailers.smtp.password' => $data['smtp_pass'],
                'mail.from.address' => $data['smtp_from'],
                'mail.from.name' => config('app.name'),
            ]);

            Mail::purge('smtp');
            Mail::mailer('smtp')->raw('SMTP connection test from ' . config('app.name'), function ($message) use ($data) {
                $message->to($data['test_email'])->subject('SMTP test');
            });

            return response()->json(['success' => 'Gửi email kiểm tra thành công!']);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Không thể gửi email: ' . $e->getMessage()], 422);
        }
    }

    public function updateAdvanced(Request $request)
    {
        return $this->updateConfig($request, [
            'script_header' => 'nullable|string',
            'script_body' => 'nullable|string',
            'script_footer' => 'nullable|string',
        ], ['script_header', 'script_body', 'script_footer']);
    }

    public function updateCustomCss(Request $request)
    {
        return $this->updateConfig($request, [
            'script_header' => 'nullable|string',
            'script_css' => 'nullable|string',
            'script_footer' => 'nullable|string',
        ], ['script_header', 'script_css', 'script_footer']);
    }

    public function enableModule(Request $request)
    {
        $aliases = [
            'create_child_panel_status' => 'child_panel_status',
            'member_level' => 'member_level_status',
            'affiliate' => 'affiliate_status',
            'keep_cancel_orders_status' => 'keep_orders_status',
            'module_oauth_google' => 'google_oauth_status',
            'module_fake_order_id' => 'fake_order_status',
        ];
        $allowed = [
            'create_child_panel_status', 'member_level', 'affiliate', 'module_coupon',
            'keep_cancel_orders_status', 'telegram_status', 'google_analytics_status',
            'module_crisp_chat', 'module_oauth_google', 'module_fake_order_id',
        ];
        $module = collect($allowed)->first(fn ($field) => $request->has($field));
        if (!$module) {
            return response()->json(['error' => 'Module không hợp lệ.'], 422);
        }

        try {
            $field = $aliases[$module] ?? $module;
            $config = Config::firstOrNew(['domain' => getDomain()]);
            $config->{$field} = filter_var($request->input($module), FILTER_VALIDATE_BOOLEAN);
            $config->save();
            return adminSuccess();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateMemberLevel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data_level' => 'required|array|max:50',
            'data_level.*.name' => 'required|string|max:100',
            'data_level.*.amount' => 'required|numeric|min:0',
            'data_level.*.percent' => 'required|numeric|min:0|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $levels = collect($validator->validated()['data_level'])->map(fn ($level) => [
            'name' => trim($level['name']),
            'min_deposit' => (float) $level['amount'],
            'bonus_percent' => (float) $level['percent'],
        ])->values()->all();

        $config = Config::firstOrNew(['domain' => getDomain()]);
        $config->member_levels = $levels;
        $config->save();

        return adminSuccess();
    }

    public function updateModuleConfig(Request $request)
    {
        $request->validate(['module' => 'required|string', 'data' => 'required|array']);
        try {
            $config = Config::where('domain', getDomain())->first() ?? new Config();
            $config->domain = getDomain();
            foreach ($request->data as $key => $value) {
                $config->{$key} = $value;
            }
            $config->save();
            return adminSuccess('update', ['message' => adminMessage('update')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateAnnouncement(Request $request)
    {
        $request->validate([
            'announcement_status' => 'nullable|boolean',
            'announcement_content' => 'nullable|string',
        ]);

        try {
            $config = Config::where('domain', getDomain())->first() ?? new Config();
            $config->domain = getDomain();

            if ($request->has('announcement_status')) {
                $config->announcement_status = $request->boolean('announcement_status') ? 1 : 0;
            }

            if ($request->has('announcement_content')) {
                $config->announcement_content = $request->input('announcement_content');
            }

            $config->save();

            return adminSuccess('update', ['message' => adminMessage('update')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    public function updateKeepOrders(Request $request)
    {
        try {
            $config = Config::where('domain', getDomain())->first() ?? new Config();
            $config->domain = getDomain();
            $text = trim((string) ($request->input('keep_orders') ?? ''));

            if (!$text) {
                $config->keep_orders = null;
                $config->save();
                return redirect()->back()->with('success', 'Cập nhật thành công!');
            }

            if (preg_match('/\[[\s\S]*\]/', $text, $m)) {
                $parsed = @json_decode($m[0], true);
                if (is_array($parsed)) {
                    $items = array_map(fn($v) => trim((string)$v), $parsed);
                    $items = array_filter($items, fn($v) => $v !== '');
                    if ($items) {
                        $config->keep_orders = json_encode(array_unique($items), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                        $config->save();
                        return redirect()->back()->with('success', 'Cập nhật thành công!');
                    }
                }
            }

            $items = preg_split('/[\n,;]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
            $items = array_map(fn($v) => trim($v), $items);
            $items = array_filter($items, fn($v) => $v !== '');

            $config->keep_orders = json_encode(array_unique($items), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: null;
            $config->save();

            return redirect()->back()->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function updateService(Request $request)
    {
        return $this->updateConfig($request, [
            'enable_services'              => 'nullable|boolean',
            'service_allow_report'         => 'nullable|boolean',
            'service_require_login'        => 'nullable|boolean',
            'service_average_time'         => 'nullable|boolean',
            'require_confirm_service'      => 'nullable|boolean',
            'check_duplicate_order_status' => 'nullable|boolean',
            'check_duplicate_order_time'   => 'nullable|integer|min:0|max:99',
        ], [
            'enable_services',
            'service_allow_report',
            'service_require_login',
            'service_average_time',
            'require_confirm_service',
            'check_duplicate_order_status',
            'check_duplicate_order_time',
        ]);
    }

    public function updateProduct(Request $request)
    {
        try {
            $config = Config::where('domain', getDomain())->first() ?? new Config();
            $config->enable_products = $request->boolean('enable_products') ? 1 : 0;
            $config->save();
            return $this->sendResponse(true, adminMessage('update'), [], 200, $request);
        } catch (\Exception $e) {
            return $this->sendResponse(false, 'Có lỗi xảy ra: ' . $e->getMessage(), [], 500, $request);
        }
    }

    public function updateSecurity(Request $request)
    {
        $request->validate([
            'status'                   => 'nullable|boolean',
            'allow_register'           => 'nullable|boolean',
            'allow_multi_device_login' => 'nullable|boolean',
            'recaptcha_status'         => 'nullable|boolean',
            'recaptcha_site_key'       => 'nullable|string|max:255',
            'recaptcha_secret_key'     => 'nullable|string|max:255',
        ]);

        try {
            $config = Config::where('domain', getDomain())->first() ?? new Config();
            $config->domain = getDomain();

            $config->status                   = $request->boolean('status');
            $config->allow_register           = $request->boolean('allow_register');
            $config->allow_multi_device_login = $request->boolean('allow_multi_device_login');
            $config->recaptcha_status         = $request->boolean('recaptcha_status');

            if ($request->filled('recaptcha_site_key')) {
                $config->recaptcha_site_key = $request->input('recaptcha_site_key');
            }
            if ($request->filled('recaptcha_secret_key')) {
                $config->recaptcha_secret_key = $request->input('recaptcha_secret_key');
            }

            $config->save();

            return adminSuccess('update', ['message' => adminMessage('update')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    public function blockIp(Request $request)
    {
        $request->validate(['ip' => 'required|ip']);

        try {
            $config = Config::where('domain', getDomain())->first() ?? new Config();
            $config->domain = getDomain();

            $ips = json_decode($config->blocked_ips ?? '[]', true) ?? [];
            $ip  = $request->input('ip');

            if (!in_array($ip, $ips)) {
                $ips[] = $ip;
                $config->blocked_ips = json_encode(array_values($ips));
                $config->save();
            }

            return response()->json(['success' => true, 'ip' => $ip]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function unblockIp(Request $request)
    {
        $ip = $request->input('ip', 0);
        if (!in_array($ip, [0, '0', null, ''], true)) {
            $request->validate(['ip' => 'ip']);
        }

        try {
            $config = Config::where('domain', getDomain())->first() ?? new Config();
            $config->domain = getDomain();

            if (in_array($ip, [0, '0', null, ''], true)) {
                // Xóa tất cả
                $config->blocked_ips = json_encode([]);
            } else {
                $ips = json_decode($config->blocked_ips ?? '[]', true) ?? [];
                $config->blocked_ips = json_encode(array_values(array_filter($ips, fn($i) => $i !== $ip)));
            }

            $config->save();

            return response()->json([
                'success' => in_array($ip, [0, '0', null, ''], true)
                    ? 'Đã xóa tất cả IP bị chặn!'
                    : 'Đã bỏ chặn IP ' . $ip . '!',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateCloudflare(Request $request)
    {
        return $this->updateConfig($request, [
            'cloudflare_email' => 'nullable|email|max:255',
            'cloudflare_global_key' => 'nullable|string|max:500',
            'cloudflare_account_id' => 'nullable|string|max:255',
            'cloudflare_token' => 'nullable|string|max:500',
            'cloudflare_ip_host' => 'nullable|ip',
        ], [
            'cloudflare_email',
            'cloudflare_global_key',
            'cloudflare_account_id',
            'cloudflare_token',
            'cloudflare_ip_host'
        ]);
    }

    /**
     * Load language data for a given country code.
     * Returns existing lang file if found, otherwise returns EN as base.
     */
    public function loadLanguageData(Request $request, string $code)
    {
        $code = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '', $code));
        $requestedCode = $code;
        $code = $this->resolveExistingLanguageCode($code);
        $langPath = resource_path("lang/{$code}.json");
        $clientLanguage = $this->clientLanguageData();
        $coreData = $clientLanguage['core']
            ?? $this->groupLanguageData($this->readJsonFile(resource_path('lang/en.json')));
        $languageData = $this->readJsonFile($langPath);
        $translatedData = $code === 'vi' && isset($clientLanguage['language'])
            ? $clientLanguage['language']
            : $this->groupLanguageData($languageData);

        $response = [
            'success' => true,
            'core' => $coreData,
            'json' => $languageData,
            $code => $translatedData,
            'exists' => file_exists($langPath),
            'language' => Language::where('domain', getDomain())->where('code', $code)->first(),
        ];
        if ($requestedCode !== $code) {
            $response[$requestedCode] = $translatedData;
        }

        return response()->json($response);
    }

    private function clientLanguageData(): array
    {
        $javascript = @file_get_contents(public_path('assets/client/language.js'));
        if ($javascript === false) {
            return [];
        }

        $start = strpos($javascript, '{');
        $end = strrpos($javascript, '}');
        if ($start === false || $end === false || $end < $start) {
            return [];
        }

        return json_decode(substr($javascript, $start, $end - $start + 1), true) ?? [];
    }

    private function readJsonFile(string $path): array
    {
        $contents = @file_get_contents($path);

        return $contents === false ? [] : (json_decode($contents, true) ?? []);
    }

    private function groupLanguageData(array $items): array
    {
        $grouped = [];
        foreach ($items as $key => $value) {
            $parts = preg_split('/\.|::/', (string) $key, 2);
            [$section, $item] = count($parts) === 2 ? $parts : ['common', $key];

            if ($section !== 'common' && !str_starts_with((string) $item, $section . '::')) {
                $item = $section . '::' . $item;
            }
            $grouped[$section][$item] = is_scalar($value)
                ? (string) $value
                : json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        return $grouped;
    }

    /**
     * Save language: write JSON file + upsert DB record.
     */
    public function createLanguage(Request $request)
    {
        $code = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '', $request->input('code')));
        $code = $this->resolveExistingLanguageCode($code);
        $name = trim((string) $request->input('name'));
        $data = $request->input('data');
        $flag = preg_replace('/\s+/', ' ', trim((string) $request->input('flag'))); // e.g. "fi fi-us"

        if ($code === '' || !is_array($data)) {
            return response()->json([
                'error' => 'Dữ liệu ngôn ngữ không hợp lệ.',
            ], 422);
        }

        // saveLanguage của admin.js cũ chỉ gửi code và json. Lấy metadata từ
        // option trong giao diện: <option value="cu" data-icon="fi fi-cu">Cuba</option>.
        $country = $this->getLanguageCountryMetadata($code);
        $existingLanguage = Language::where('domain', getDomain())->where('code', $code)->first();
        if ($name === '' || strtolower($name) === $code) {
            $name = $existingLanguage?->name
                ?? $country['name']
                ?? $code;
        }
        if (!preg_match('/^fi\s+fi-([a-z0-9-]+)$/i', $flag, $matches) || strtolower($matches[1]) !== $code) {
            $flag = $existingLanguage?->flag ?? $country['flag'] ?? 'fi fi-' . $code;
        }

        try {
            // Write JSON file
            $langPath = resource_path("lang/{$code}.json");
            file_put_contents($langPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

            // Upsert DB record
            $domain   = getDomain();
            $upsertData = ['name' => $name, 'flag' => $flag, 'status' => true];

            $language = Language::updateOrCreate(
                ['domain' => $domain, 'code' => $code],
                $upsertData
            );
            $message = adminMessage($language->wasRecentlyCreated ? 'add' : 'update');

            return response()->json([
                'success' => $message,
                'message' => $message,
                'language' => $language,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Trả metadata quốc gia từ danh sách option chuẩn của trang Settings > Language.
     * Không phụ thuộc việc admin.js legacy có gửi name/flag trong AJAX hay không.
     */
    private function getLanguageCountryMetadata(string $code): ?array
    {
        $view = resource_path('views/admin/settings/language.blade.php');
        $contents = @file_get_contents($view);
        if ($contents === false) {
            return null;
        }

        $quotedCode = preg_quote($code, '/');
        $pattern = '/<option\s+value="' . $quotedCode . '"\s+data-icon="([^"]+)">([^<]+)<\/option>/i';
        if (!preg_match($pattern, $contents, $matches)) {
            return null;
        }

        return [
            'flag' => preg_replace('/\s+/', ' ', trim($matches[1])),
            'name' => trim(html_entity_decode($matches[2], ENT_QUOTES | ENT_HTML5, 'UTF-8')),
        ];
    }

    /**
     * Delete language: remove JSON file + DB record.
     */
    public function deleteLanguage(Request $request, string $code)
    {
        $code = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '', $code));
        $code = $this->resolveExistingLanguageCode($code);

        // Prevent deleting base EN language
        if ($code === 'en') {
            return response()->json(['error' => 'Không thể xóa ngôn ngữ gốc EN!'], 403);
        }

        try {
            $domain   = getDomain();
            $language = Language::where('domain', $domain)->where('code', $code)->first();
            $name     = $language ? $language->name : $code;

            if ($language) {
                $language->delete();
            }

            $langPath = resource_path("lang/{$code}.json");
            if (file_exists($langPath)) {
                unlink($langPath);
            }

            $message = adminMessage('delete');

            return response()->json([
                'success' => $message,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Select2 legacy dùng mã quốc gia làm value để dựng class cờ fi-*.
     * Nếu đây là ngôn ngữ đã tồn tại, trả về code locale thật để đọc/ghi dữ liệu.
     */
    private function resolveExistingLanguageCode(string $value): string
    {
        if ($value === '') {
            return $value;
        }

        $language = Language::where('domain', getDomain())
            ->get(['code', 'flag'])
            ->first(function (Language $language) use ($value) {
                return strtolower($language->code) === $value
                    || strtolower($language->flag_code) === $value;
            });

        return $language?->code ?? $value;
    }

    public function uploadLogo(Request $request)
    {
        try {
            $config = Config::where('domain', getDomain())->first() ?? new Config();
            $config->domain = getDomain();
            $logoFields = ['favicon', 'logo', 'logo_square', 'logo_facebook'];
            $uploadedFiles = [];
            $errors = [];
            $fieldsToUpdate = [];
            $imageRules = [
                'favicon' => ['extensions' => ['png', 'ico']],
                'logo' => ['extensions' => ['png']],
                'logo_square' => ['extensions' => ['png']],
                'logo_facebook' => ['extensions' => ['png']],
            ];

            foreach ($logoFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    $validator = Validator::make(
                        [$field => $file],
                        [$field => 'required|file|max:5120']
                    );

                    if ($validator->fails()) {
                        $errors[$field] = $validator->errors()->first($field);
                        continue;
                    }

                    $rule = $imageRules[$field];
                    $extension = strtolower($file->extension());
                    if (!in_array($extension, $rule['extensions'], true)) {
                        $errors[$field] = sprintf('%s chỉ hỗ trợ định dạng %s.', $field, strtoupper(implode(', ', $rule['extensions'])));
                        continue;
                    }

                    try {
                        $directory = public_path('assets/media');
                        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
                            throw new \RuntimeException('Không thể tạo thư mục lưu ảnh.');
                        }

                        // admin.js cập nhật preview theo tên cố định {field}.{extension}.
                        // Lưu file tạm trước để chỉ thay thế ảnh cũ khi upload thành công.
                        $filename = $field . '.' . $extension;
                        $temporaryFilename = $field . '_' . bin2hex(random_bytes(8)) . '.tmp';
                        $file->move($directory, $temporaryFilename);

                        $targetPath = $directory . DIRECTORY_SEPARATOR . $filename;
                        if (is_file($targetPath) && !@unlink($targetPath)) {
                            @unlink($directory . DIRECTORY_SEPARATOR . $temporaryFilename);
                            throw new \RuntimeException('Không thể thay thế ảnh cũ.');
                        }
                        if (!@rename($directory . DIRECTORY_SEPARATOR . $temporaryFilename, $targetPath)) {
                            @unlink($directory . DIRECTORY_SEPARATOR . $temporaryFilename);
                            throw new \RuntimeException('Không thể lưu ảnh mới.');
                        }

                        $fieldsToUpdate[$field] = $filename;
                        $uploadedFiles[$field] = [
                            'filename' => $filename,
                            'url' => asset('assets/media/' . $filename),
                        ];
                    } catch (\Exception $e) {
                        $errors[$field] = 'Lỗi khi lưu file: ' . $e->getMessage();
                    }
                }
            }

            if (!empty($fieldsToUpdate)) {
                $config->fill($fieldsToUpdate);
                $config->save();
            }

            $message = '';
            if (!empty($uploadedFiles)) {
                $fieldNames = implode(', ', array_keys($uploadedFiles));
                $message = "Đã cập nhật thành công: $fieldNames";
            }

            if (!empty($errors)) {
                $errorMsg = implode(', ', array_values($errors));
                $message .= ($message ? '. ' : '') . "Lỗi: $errorMsg";
            }

            if (empty($uploadedFiles) && !empty($errors)) {
                return response()->json([
                    'message' => $message ?: 'Không có file nào được cập nhật',
                    'uploaded' => [],
                    'errors' => $errors
                ], 422);
            }

            return response()->json([
                'message' => $message ?: 'Cập nhật thành công',
                'uploaded' => $uploadedFiles,
                'config' => [
                    'logo_square' => $config->logo_square,
                    'logo_square_url' => $config->logo_square
                        ? asset('assets/media/' . basename($config->logo_square))
                        : null,
                ],
                'errors' => $errors
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
                'uploaded' => [],
                'errors' => ['general' => $e->getMessage()]
            ], 500);
        }
    }

    public function updateCurrency(Request $request)
    {
        try {
            if ($request->input('action') === 'fetch') {
                return $this->syncCurrencyRates();
            }

            // Payload legacy từ _settings.on.click.updateCurrency() trong admin.js.
            // currency_data[id] = { currency_rate, currency_sync }.
            if (is_array($request->input('currency_data'))) {
                $currencies = [];
                foreach ($request->input('currency_data') as $currencyId => $currencyData) {
                    $rate = str_replace(',', '', (string) ($currencyData['currency_rate'] ?? ''));
                    $currencies[$currencyId] = [
                        'sync' => (bool) ($currencyData['currency_sync'] ?? false),
                        'exchange_rate' => $rate === '' ? null : $rate,
                    ];
                }
                $request->merge(['currencies' => $currencies]);
            }

            $validated = $request->validate([
                'currencies' => 'required|array',
                'currencies.*' => 'required|array',
                'currencies.*.sync' => 'nullable|boolean',
                'currencies.*.exchange_rate' => 'nullable|numeric|min:0.00000001',
            ]);

            $updated = 0;
            $errors = [];

            foreach ($validated['currencies'] as $currencyId => $data) {
                try {
                    if (empty($currencyId)) continue;

                    $currency = Currency::whereKey($currencyId)
                        ->where(fn ($query) => $query->where('domain', getDomain())->orWhereNull('domain'))
                        ->firstOrFail();
                    $updateData = [];

                    if (isset($data['sync'])) {
                        $updateData['sync'] = (bool) $data['sync'];
                    }

                    if (isset($data['exchange_rate']) && $data['exchange_rate'] !== null) {
                        $isSynced = $data['sync'] ?? $currency->sync;
                        if (!$isSynced) {
                            $updateData['exchange_rate'] = roundExchangeRate($data['exchange_rate']);
                        }
                    }

                    if (!empty($updateData)) {
                        $currency->update($updateData);
                        $updated++;
                    }
                } catch (\Exception $e) {
                    $errors[$currencyId] = $e->getMessage();
                }
            }

            // Checkbox cuối mỗi dòng của admin.js gửi sync_payment[CODE] = RATE.
            // Đồng bộ tỷ giá vào cấu hình các phương thức thanh toán cùng currency.
            foreach ((array) $request->input('sync_payment', []) as $code => $rate) {
                if (!is_numeric($rate) || (float) $rate <= 0) {
                    continue;
                }

                $currencyCode = strtoupper((string) $code);
                PaymentMethod::where('domain', getDomain())
                    ->get()
                    ->filter(function (PaymentMethod $paymentMethod) use ($currencyCode): bool {
                        $config = $paymentMethod->parsed_config;

                        return strtoupper((string) ($paymentMethod->currency ?? $config['currency'] ?? '')) === $currencyCode
                            || strtoupper((string) ($config['currency'] ?? '')) === $currencyCode;
                    })
                    ->each(function (PaymentMethod $paymentMethod) use ($rate): void {
                        $config = $paymentMethod->parsed_config;
                        $config['rate_usd'] = roundExchangeRate($rate);
                        $paymentMethod->config = json_encode($config, JSON_UNESCAPED_UNICODE);
                        $paymentMethod->save();
                    });
            }

            $message = adminMessage('update');

            // admin.js đọc response.success trực tiếp bằng app.toastr().
            return response()->json([
                'success' => $message,
                'updated' => $updated,
                'errors' => $errors,
            ]);
        } catch (\Exception $e) {
            Log::error('Currency update error: ' . $e->getMessage());
            return response()->json(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    private function syncCurrencyRates()
    {
        try {
            $ratesData = fetchCurrencyRates();
            if (!$ratesData) {
                return response()->json(['error' => 'Không thể lấy dữ liệu tỷ giá từ API'], 500);
            }

            $currencyMetadata = getCurrencyData();
            $updated = $created = 0;

            foreach ($ratesData['conversion_rates'] as $code => $rate) {
                $currency = Currency::where('code', $code)
                    ->where(fn ($query) => $query->where('domain', getDomain())->orWhereNull('domain'))
                    ->first();
                $isUSD = $code === 'USD';

                if (!$currency) {
                    Currency::create([
                        'code' => $code,
                        'name' => $currencyMetadata['names'][$code] ?? $code,
                        'symbol' => $currencyMetadata['symbols'][$code] ?? $code,
                        'exchange_rate' => $isUSD ? 1 : roundExchangeRate($rate),
                        'status' => 1,
                        'symbol_position' => 'before',
                        'sync' => $isUSD ? 0 : 1,
                        'domain' => getDomain()
                    ]);
                    $created++;
                } else {
                    if ($isUSD) {
                        // USD luôn giữ sync = 0, exchange_rate = 1
                        $currency->update(['sync' => 0, 'exchange_rate' => 1]);
                    } elseif ($currency->sync) {
                        $currency->update(['exchange_rate' => roundExchangeRate($rate)]);
                        $updated++;
                    }
                }
            }

            return adminSuccess();
        } catch (\Exception $e) {
            Log::error('Currency fetch rates error: ' . $e->getMessage());
            return response()->json(['error' => 'Có lỗi xảy ra khi cập nhật tỷ giá: ' . $e->getMessage()], 500);
        }
    }
}
