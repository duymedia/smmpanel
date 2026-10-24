<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Affiliate;
use App\Models\Config;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as PasswordBroker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    public function legacyRequest(Request $request)
    {
        $payload = $request->input('data', []);
        if (is_array($payload)) {
            $request->merge($payload);
        }

        $request->headers->set('Accept', 'application/json');
        $action = (string) $request->input('action');
        $language = $this->requestLanguage($request);

        // t.html/landing.js sends login data in the legacy `data` envelope.
        // Keep the controller as the compatibility boundary; no changes to
        // the existing template or JavaScript are required.
        if ($action === 'Account-signin') {
            $request->merge([
                'username' => trim((string) $request->input('username', '')),
                'password' => (string) $request->input('password', ''),
            ]);
        }

        try {
            if ($action === 'Account-signup') {
                $request->merge([
                    'name' => $request->input('name', $request->input('username')),
                    'password_confirmation' => $request->input('password_confirmation', $request->input('confpass')),
                    'agree_terms' => $request->input('agree_terms', true),
                ]);
            }

            $response = match ($action) {
                'Account-signin' => $this->login($request),
                'Account-signup' => $this->register($request),
                'Account-resetPassword', 'Account-resendVerifyEmail' => $this->sendResetLink($request),
                'Account-checkGGAuth' => $this->verify2FA($request),
                default => null,
            };

            if (!$response) {
                return response()->json(['error' => "Unsupported auth action: {$action}"], 404);
            }

            $data = $response->getData(true);
            if (!($data['success'] ?? false)) {
                $message = (string) ($data['message'] ?? 'Yêu cầu không thành công');
                $localized = $this->localizeAuthMessage($message, $language);

                return response()->json([
                    'error' => $localized,
                    'language' => $localized,
                ]);
            }

            $localized = $this->localizeAuthMessage((string) ($data['message'] ?? ''), $language);

            $response = match ($action) {
                'Account-signin' => [
                    'success' => $localized,
                    'language' => $localized,
                    // landing.js builds the URL as `${location.origin}/${rd}`.
                    // Return a relative segment so `/admin` does not become
                    // `//admin` on localhost.
                    'rd' => ltrim(parse_url((string) $data['redirect'], PHP_URL_PATH) ?: (string) $data['redirect'], '/'),
                ],
                'Account-checkGGAuth' => [
                    'success' => $localized,
                    'language' => $localized,
                    // auth.js assigns `rd` directly to window.location.
                    'rd' => $data['redirect'] ?? route('login'),
                ],
                'Account-signup' => [
                    'success' => $localized,
                    'language' => $localized,
                    'redirect' => $data['redirect'],
                ],
                default => ['success' => $localized, 'language' => $localized],
            };

            return response()->json($response);
        } catch (ValidationException $e) {
            if (in_array($action, ['Account-signin', 'Account-signup'], true)) {
                return response()->json($this->legacyValidationError($e, $language));
            }

            $message = $this->localizeAuthMessage($e->validator->errors()->first(), $language);
            return response()->json([
                'error' => $message,
                'language' => $message,
            ]);
        } catch (\Throwable $e) {
            report($e);
            $message = in_array($action, ['Account-resetPassword', 'Account-resendVerifyEmail'], true)
                ? 'Password reset is temporarily unavailable. Please try again later.'
                : 'Authentication request failed. Please try again later.';

            return response()->json([
                'error' => $message,
                'language' => $message,
            ], 500);
        }
    }

    private function requestLanguage(Request $request): string
    {
        $language = strtolower((string) ($request->input('lang') ?: app()->getLocale() ?: 'en'));
        return str_starts_with($language, 'vi') ? 'vi' : 'en';
    }

    private function localizeAuthMessage(string $message, string $language): string
    {
        $messages = [
            'Tài khoản không tồn tại' => ['en' => 'Account does not exist', 'vi' => 'Tài khoản không tồn tại'],
            'Tài khoản của bạn đã bị khóa' => ['en' => 'Your account has been locked', 'vi' => 'Tài khoản của bạn đã bị khóa'],
            'Tài khoản hoặc mật khẩu không đúng' => ['en' => 'Incorrect username or password', 'vi' => 'Tài khoản hoặc mật khẩu không đúng'],
            'Đăng nhập thành công!' => ['en' => 'Sign in successfully', 'vi' => 'Đăng nhập thành công!'],
            'Xác thực 2FA' => ['en' => 'Two-factor authentication required', 'vi' => 'Vui lòng xác thực 2FA'],
            'Mã xác thực không đúng.' => ['en' => 'The verification code is incorrect.', 'vi' => 'Mã xác thực không đúng.'],
            'Tạo tài khoản thành công!' => ['en' => 'Account created successfully!', 'vi' => 'Tạo tài khoản thành công!'],
            'Vui lòng nhập tên đăng nhập' => ['en' => 'Please enter your username', 'vi' => 'Vui lòng nhập tên đăng nhập'],
            'Vui lòng nhập mật khẩu' => ['en' => 'Please enter your password', 'vi' => 'Vui lòng nhập mật khẩu'],
            'Vui lòng đồng ý với các điều khoản sử dụng' => ['en' => 'You must agree to the terms and conditions', 'vi' => 'Vui lòng đồng ý với các điều khoản sử dụng'],
        ];

        return $messages[$message][$language] ?? $message;
    }

    private function legacyValidationError(ValidationException $e, string $language): array
    {
        $failed = $e->validator->failed();
        $field = array_key_first($failed);
        $rule = $field ? array_key_first($failed[$field]) : null;

        if ($rule === 'Required') {
            return [
                'error' => $language === 'vi' ? 'Xin hãy nhập đầy đủ thông tin' : 'All fields cannot be blank',
                'language' => $language === 'vi' ? 'Xin hãy nhập đầy đủ thông tin' : 'All fields cannot be blank',
            ];
        }

        $messages = match (strtolower("{$field}.{$rule}")) {
            'username.regex' => ['Username format is invalid', 'Tên đăng nhập chỉ gồm chữ thường, số và dấu gạch dưới'],
            'username.unique' => ['Username already exists', 'Tên đăng nhập này đã tồn tại'],
            'email.email' => ['Email address is invalid', 'Địa chỉ email không hợp lệ'],
            'email.unique' => ['Email already exists', 'Email này đã được đăng ký'],
            'password.confirmed' => ['Password confirmation does not match', 'Mật khẩu xác nhận không khớp'],
            'password.min' => ['Password must be at least 8 characters', 'Mật khẩu phải có ít nhất 8 ký tự'],
            default => ['The submitted data is invalid', $e->validator->errors()->first()],
        };

        $message = $language === 'vi' ? $messages[1] : $messages[0];
        return ['error' => $message, 'language' => $message];
    }

    // ─── Show Pages ───

    public function showInstall()
    {
        $isChild = isChildPanel();
        $parent = $isChild ? childPanelParent() : null;

        return view('auth.install', [
            'isChild' => $isChild,
            'parentDomain' => $parent?->domain,
        ]);
    }

    public function showLogin()
    {
        $user = Auth::user();
        if ($user)
            return redirect($user instanceof User && $user->isAdmin() ? '/admin' : '/new');
        return $this->authView('signin');
    }

    public function redirectGoogle()
    {
        $config = Config::where('domain', getDomain())->first();
        if (!$config?->google_oauth_status || !$config->google_oauth_client_id || !$config->google_oauth_client_secret) {
            return redirect()->route('login')->with('error', 'Google OAuth chưa được cấu hình.');
        }

        $state = Str::random(40);
        session(['google_oauth_state' => $state]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
            'client_id' => $config->google_oauth_client_id,
            'redirect_uri' => route('login.google.callback'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'access_type' => 'online',
            'prompt' => 'select_account',
        ]));
    }

    public function callbackGoogle(Request $request)
    {
        if ($request->filled('error')) {
            return redirect()->route('login')->with('error', 'Bạn đã hủy đăng nhập bằng Google.');
        }

        $state = (string) session('google_oauth_state');
        if (!$request->filled('code') || $state === '' || !hash_equals($state, (string) $request->query('state'))) {
            return redirect()->route('login')->with('error', 'Phiên đăng nhập Google không hợp lệ.');
        }
        session()->forget('google_oauth_state');

        $config = Config::where('domain', getDomain())->first();
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_POSTFIELDS => http_build_query([
                'code' => $request->code,
                'client_id' => $config->google_oauth_client_id,
                'client_secret' => $config->google_oauth_client_secret,
                'redirect_uri' => route('login.google.callback'),
                'grant_type' => 'authorization_code',
            ]),
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
        ]);
        $tokenResponse = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);
        $tokens = is_string($tokenResponse) ? json_decode($tokenResponse, true) : null;

        if ($curlError || !is_array($tokens) || empty($tokens['id_token'])) {
            return redirect()->route('login')->with('error', 'Không thể xác thực tài khoản Google.');
        }

        $result = $this->loginGoogle(Request::create('/api/oauth_google', 'POST', [
            'id_token' => $tokens['id_token'],
        ]));
        $data = $result->getData(true);

        return ($data['success'] ?? false)
            ? redirect($data['redirect'] ?? '/new')
            : redirect()->route('login')->with('error', $data['message'] ?? 'Đăng nhập Google thất bại.');
    }

    public function showRegister(Request $request)
    {
        $user = Auth::user();
        if ($user)
            return redirect($user instanceof User && $user->isAdmin() ? '/admin' : '/new');
        if ($request->query('ref'))
            session(['ref_code' => $request->query('ref')]);
        return $this->authView('signup');
    }

    public function showForgotPassword()
    {
        $user = Auth::user();
        if ($user)
            return redirect($user instanceof User && $user->isAdmin() ? '/admin' : '/new');
        return $this->authView('forgot-password');
    }

    public function show2FA()
    {
        $user = Auth::user();
        if ($user)
            return redirect($user instanceof User && $user->isAdmin() ? '/admin' : '/new');
        if (!session('2fa_pending_user_id'))
            return redirect()->route('login');
        return $this->authView('2fa');
    }

    // ─── Login ───

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|max:255',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        $domain = getDomain();

        $user = User::where(function ($q) use ($request) {
            $q->where('username', $request->username)->orWhere('email', $request->username);
        })->where('domain', $domain)->first();

        if (!$user)
            return $this->fail($request, 'Tài khoản không tồn tại');
        if (!$user->is_active)
            return $this->fail($request, 'Tài khoản của bạn đã bị khóa');
        if (!Hash::check($request->password, $user->password))
            return $this->fail($request, 'Tài khoản hoặc mật khẩu không đúng');

        // 2FA
        if ($user->hasTwoFactorEnabled()) {
            session(['2fa_pending_user_id' => $user->id]);
            return $this->ok($request, 'Xác thực 2FA', route('2fa.show'));
        }

        Auth::login($user, false);
        $request->session()->regenerate();
        $this->logLogin($request, $user);
        return $this->ok($request, 'Đăng nhập thành công!', $user->isAdmin() ? '/admin' : '/new');
    }

    // ─── 2FA Verify ───

    public function verify2FA(Request $request)
    {
        $userId = session('2fa_pending_user_id');
        if (!$userId) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phiên đăng nhập đã hết hạn.',
                    'redirect' => route('login'),
                ], 419);
            }
            return redirect()->route('login')->with('error', 'Phiên đăng nhập đã hết hạn.');
        }

        $request->validate(['code' => 'required|string']);
        $user = User::find($userId);
        $google2fa = new \PragmaRX\Google2FA\Google2FA();

        if (!$user || !$google2fa->verifyKey($user->two_factor_secret, $request->code)) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Mã xác thực không đúng.'], 422);
            }
            return back()->with('error', 'Mã xác thực không đúng.');
        }

        Auth::login($user, false);
        $request->session()->regenerate();
        session()->forget('2fa_pending_user_id');
        $this->logLogin($request, $user);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đăng nhập thành công!',
                'redirect' => $user->isAdmin() ? '/admin' : '/new',
            ]);
        }

        return redirect()->intended($user->isAdmin() ? '/admin' : '/new')->with('success', 'Đăng nhập thành công!');
    }

    // ─── Register ───

    public function register(Request $request)
    {
        $request->merge([
            'name' => $request->input('name', $request->input('username')),
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users|regex:/^[a-z0-9_]{3,}$/',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|string|max:30',
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
            'agree_terms' => 'required|accepted',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'username.unique' => 'Tên đăng nhập này đã tồn tại',
            'username.regex' => 'Chỉ chứa chữ thường, số và gạch dưới (tối thiểu 3 ký tự)',
            'email.unique' => 'Email này đã được đăng ký',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            'agree_terms.required' => 'Vui lòng đồng ý với điều khoản sử dụng',
        ]);

        $domain = getDomain();
        $cf = Config::where('domain', $domain)->first();
        $refCode = $request->query('ref') ?? session('ref_code');
        $referrer = $refCode ? User::where('referral_code', $refCode)->where('domain', $domain)->first() : null;

        $user = User::create([
            'name' => trim($request->name),
            'username' => strtolower(trim($request->username)),
            'email' => strtolower(trim($request->email)),
            'phone' => $request->filled('phone') ? trim($request->phone) : null,
            'password' => Hash::make($request->password),
            'api_key' => Str::random(32),
            // Leave transfer code empty until the user enables/uses transfers.
            // `null` is required because the database column is UNIQUE; an empty
            // string would allow only one normally registered account.
            'transfer_code' => null,
            'referral_code' => Str::random(8),
            'role' => User::ROLE_RETAIL,
            'lang' => $cf->default_lang ?? 'en',
            'currency' => $cf->default_currency ?? 'USD',
            'timezone' => $cf->timezone ?? 0,
            'balance' => 0.0,
            'spent' => 0.0,
            'is_active' => true,
            'domain' => $domain,
        ]);

        if ($referrer && $referrer->id !== $user->id) {
            Affiliate::create([
                'referrer_id' => $referrer->id,
                'referred_id' => $user->id,
                'referral_code' => $refCode,
                'commission_rate' => 0,
                'total_earned' => 0,
                'total_orders' => 0,
                'orders_count' => 0,
                'status' => 'active',
                'domain' => $domain,
            ]);
            session()->forget('ref_code');
        }

        Auth::login($user, false);
        $request->session()->regenerate();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Tạo tài khoản thành công!',
                'redirect' => route('clients.new'),
            ], 201);
        }

        return redirect()->route('clients.new')->with('success', 'Tạo tài khoản thành công!');
    }

    // ─── Forgot Password ───

    public function sendResetLink(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email']);
        $status = PasswordBroker::sendResetLink($credentials);

        if ($status !== PasswordBroker::RESET_LINK_SENT) {
            $message = __($status);

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }

            return back()->withErrors(['email' => $message])->withInput();
        }

        $message = __($status);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('status', $message);
    }

    public function showResetPassword(Request $request, string $token)
    {
        return $this->authView('reset-password', [
            'token' => $token,
            'email' => (string) $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $credentials = $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = PasswordBroker::reset($credentials, function (User $user, string $password) {
            $user->forceFill(['password' => Hash::make($password)]);
            $user->setRememberToken(Str::random(60));
            $user->save();
        });

        if ($status !== PasswordBroker::PASSWORD_RESET) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => __($status)], 422);
            }

            return back()->withErrors(['email' => __($status)])->withInput($request->only('email'));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __($status),
                'redirect' => route('login'),
            ]);
        }

        return redirect()->route('login')->with('success', __($status));
    }

    // ─── Install ───

    public function install(Request $request)
    {
        $isChild = isChildPanel();
        $parent = $isChild ? childPanelParent() : null;

        $rules = [
            'name' => 'required|string|max:255|min:2',
            'username' => 'required|string|max:255|unique:users|regex:/^[a-z0-9_]{3,}$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
        $messages = [];

        if ($isChild) {
            $rules['api_key'] = [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($parent) {
                    if (!$parent || $value !== $parent->api_key) {
                        $fail('API Key không hợp lệ hoặc không khớp với trang chính.');
                    }
                },
            ];
            $messages['api_key.required'] = 'Vui lòng nhập API Key từ trang chính.';
        }

        try {
            $data = $request->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                    'message' => $e->validator->errors()->first(),
                ], 422);
            }
            throw $e;
        }

        $domain = getDomain();

        try {
            DB::transaction(function () use ($data, $domain, $isChild, $parent) {
                $admin = User::create([
                    'name' => trim($data['name']),
                    'username' => strtolower(trim($data['username'])),
                    'email' => strtolower(trim($data['email'])),
                    'password' => Hash::make($data['password']),
                    'api_key' => Str::random(32),
                    'referral_code' => Str::random(8),
                    'role' => User::ROLE_ADMIN,
                    'timezone' => 14400,
                    'lang' => 'en',
                    'currency' => 'USD',
                    'is_active' => true,
                    'balance' => 0.0,
                    'spent' => 0.0,
                    'domain' => $domain,
                ]);

                Config::create([
                    'user_id' => $admin->id,
                    'title' => 'SMM Panel',
                    'description' => 'SMM Panel',
                    'timezone' => 14400,
                    'domain' => $domain,
                    'domain_main' => $isChild && $parent ? $parent->domain : $domain,
                    'default_currency' => 'USD',
                    'default_lang' => 'en',
                    'default_interface' => 'default',
                    'status' => true,
                ]);
            });
        } catch (\Throwable $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }
            throw $e;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('install.done'),
                'redirect' => route('login'),
            ]);
        }

        return redirect()->route('login')->with('success', __('install.done'));
    }

    // ─── Google Login ───

    public function loginGoogle(Request $request)
    {
        $request->validate(['id_token' => 'required|string']);

        $domain = getDomain();
        $config = Config::where('domain', $domain)->first();

        if (!$config || !$config->google_oauth_status || !$config->google_oauth_client_id) {
            return response()->json(['success' => false, 'message' => 'Google OAuth chưa được kích hoạt.'], 403);
        }

        $ch = curl_init('https://oauth2.googleapis.com/tokeninfo?id_token=' . $request->id_token);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
        ]);
        $tokenResponse = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);
        $payload = is_string($tokenResponse) ? json_decode($tokenResponse, true) : null;

        if ($curlError || !$payload || isset($payload['error']) || ($payload['aud'] ?? '') !== $config->google_oauth_client_id
            || ($payload['iss'] ?? '') !== 'https://accounts.google.com') {
            return response()->json(['success' => false, 'message' => 'Token không hợp lệ.'], 401);
        }

        $email = $payload['email'] ?? null;
        if (!$email || (($payload['email_verified'] ?? 'false') !== 'true' && ($payload['email_verified'] ?? false) !== true))
            return response()->json(['success' => false, 'message' => 'Không lấy được email.'], 400);

        $user = User::where('email', $email)->where('domain', $domain)->first();

        if (!$user) {
            $base = Str::slug($payload['given_name'] ?? explode('@', $email)[0], '');
            $username = $base;
            $i = 1;
            while (User::where('username', $username)->where('domain', $domain)->exists()) {
                $username = $base . $i++;
            }

            $user = User::create([
                'name' => $payload['name'] ?? $email,
                'username' => $username,
                'email' => $email,
                'password' => Hash::make(Str::random(32)),
                'api_key' => Str::random(32),
                'referral_code' => Str::random(8),
                'role' => User::ROLE_RETAIL,
                'lang' => $config->default_lang ?? 'en',
                'currency' => $config->default_currency ?? 'USD',
                'timezone' => $config->timezone ?? 0,
                'balance' => 0.0,
                'spent' => 0.0,
                'is_active' => true,
                'domain' => $domain,
            ]);
        }

        if (!$user->is_active)
            return response()->json(['success' => false, 'message' => 'Tài khoản đã bị khóa.'], 403);

        if ($user->hasTwoFactorEnabled()) {
            session([
                '2fa_pending_user_id' => $user->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Vui lòng xác thực 2FA.',
                'redirect' => route('2fa.show'),
            ]);
        }

        Auth::login($user, false);
        request()->session()->regenerate();
        return response()->json(['success' => true, 'message' => 'Đăng nhập thành công', 'redirect' => $user->isAdmin() ? '/admin' : '/new']);
    }

    // ─── Private Helpers ───

    protected function authView(string $page, array $data = [])
    {
        $config = Config::where('domain', getDomain())->first() ?? Config::first();
        $theme = $config->default_login ?? 'default';
        $authTheme = view()->exists("auth.theme-{$theme}.{$page}") ? $theme : 'default';
        $view = "auth.theme-{$authTheme}.{$page}";
        $html = view(view()->exists($view) ? $view : "clients.theme-{$authTheme}.auth.{$page}", array_merge([
            'config' => $config,
            'settings' => $config?->toArray() ?? [],
        ], $data))->render();
        $html = $this->applyAuthCustomization($html, $theme, $page, $authTheme);

        return response($html)->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }

    private function applyAuthCustomization(string $html, string $theme, string $page, string $authTheme): string
    {
        $path = 'themes/' . sha1(getDomain()) . '/signin.json';
        if (!Storage::disk('local')->exists($path)) {
            return $html;
        }

        $stored = json_decode(Storage::disk('local')->get($path), true);
        $themeData = is_array($stored) && is_array($stored[(string) $theme] ?? null)
            ? $stored[(string) $theme]
            : [];
        $customize = is_array($themeData['pages'][$page] ?? null)
            ? $themeData['pages'][$page]
            : ($page === 'signin' && !isset($themeData['pages']) ? $themeData : []);
        if (!$customize) {
            return $html;
        }

        $json = json_encode(
            $customize,
            JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        );
        $script = '<script>document.addEventListener("DOMContentLoaded",function(){'
            . 'const d=' . $json . ';'
            . 'const has=(key)=>Object.prototype.hasOwnProperty.call(d,key);'
            . 'if(has("background")){document.body.style.backgroundImage=d.background?"url("+JSON.stringify(d.background)+")":"";document.body.style.backgroundSize="cover";document.body.style.backgroundPosition="center";}'
            . 'const image=document.querySelector(".cmz-background1,img.background1,.block-signin-text img,.block-signin__content img,[data-auth-theme-image]");'
            . 'const imageContainer=image?null:document.querySelector(".block-signin-text,.block-signin__content,.bgi-size-cover,.auth-hero");'
            . 'const customImage=d.background1||d.image||"";'
            . 'if(image&&customImage)image.src=customImage;'
            . 'if(imageContainer&&customImage){imageContainer.style.backgroundImage="url("+JSON.stringify(customImage)+")";imageContainer.style.backgroundSize="cover";imageContainer.style.backgroundPosition="center";}'
            . 'const title=document.querySelector(".block-signin-text__block-text-title h1,.block-signin__title,h1");'
            . 'const description=document.querySelector(".block-signin__description,.block-signin-text__block-text-description,h1 + p,.auth-description");'
            . 'const normalizeText=value=>String(value||"").replace(/\\s+/g," ").trim();'
            . 'const customTitle=normalizeText(d.title);'
            . 'const customDescription=normalizeText(d.description);'
            . 'if(title&&customTitle&&normalizeText(title.textContent)!==customTitle)title.textContent=d.title;'
            . 'if(description&&customDescription&&normalizeText(description.textContent)!==customDescription)description.textContent=d.description;'
            . 'if(d.styles){if(d.styles.background_color)document.body.style.backgroundColor=d.styles.background_color;if(d.styles.text_color)document.body.style.color=d.styles.text_color;'
            . ($authTheme === '6'
                ? 'if(d.styles.accent_color)document.documentElement.style.setProperty("--signin-accent",d.styles.accent_color);'
                : 'if(d.styles.accent_color){document.documentElement.style.setProperty("--signin-accent",d.styles.accent_color);const s=document.createElement("style");s.textContent=".btn-primary,button[type=submit],input[type=submit]{background-color:"+d.styles.accent_color+"!important;border-color:"+d.styles.accent_color+"!important}";document.head.appendChild(s);}')
            . 'if(d.styles.font_family)document.body.style.fontFamily=d.styles.font_family;}'
            . 'if(d.seo_title)document.title=d.seo_title;'
            . 'if(d.seo_description){let meta=document.querySelector("meta[name=description]");if(!meta){meta=document.createElement("meta");meta.name="description";document.head.appendChild(meta);}meta.content=d.seo_description;}'
            . 'if(Array.isArray(d.layout)){const elements={title:title,description:description,image:image,form:document.querySelector("form")};const selected=d.layout.map(k=>elements[k]).filter(Boolean);const parent=selected[0]&&selected.every(e=>e.parentElement===selected[0].parentElement)?selected[0].parentElement:null;if(parent)selected.forEach(e=>parent.appendChild(e));}'
            . '});</script>';

        return preg_replace('/<\/body>/i', $script . '</body>', $html, 1) ?? $html . $script;
    }

    protected function ok(Request $request, string $msg, string $redirect)
    {
        if ($request->expectsJson())
            return response()->json(['success' => true, 'message' => $msg, 'redirect' => $redirect]);
        return redirect()->intended($redirect)->with('success', $msg);
    }

    protected function fail(Request $request, string $msg)
    {
        if ($request->expectsJson())
            return response()->json(['success' => false, 'message' => $msg], 422);
        return back()->with('error', $msg)->withInput();
    }

    protected function logLogin(Request $request, User $user): void
    {
        ActivityLog::create([
            'user_id' => $user->id,
            'type' => 'login',
            'activity' => json_encode(['ip_address' => $request->ip(), 'user_agent' => $request->userAgent()]),
            'domain' => getDomain(),
        ]);
    }
}
