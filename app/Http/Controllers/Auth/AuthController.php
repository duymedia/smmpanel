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
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ─── Show Pages ───

    public function showInstall()
    {
        return view('clients.install');
    }

    public function showLogin()
    {
        if (Auth::check())
            return redirect(Auth::user()->role === 'admin' ? '/admin' : '/new');
        return $this->authView('signin');
    }

    public function showRegister(Request $request)
    {
        if (Auth::check())
            return redirect(Auth::user()->role === 'admin' ? '/admin' : '/new');
        if ($request->query('ref'))
            session(['ref_code' => $request->query('ref')]);
        return $this->authView('signup');
    }

    public function showForgotPassword()
    {
        if (Auth::check())
            return redirect(Auth::user()->role === 'admin' ? '/admin' : '/new');
        return $this->authView('forgot-password', ['config' => Config::first()]);
    }

    public function show2FA()
    {
        if (Auth::check())
            return redirect(Auth::user()->role === 'admin' ? '/admin' : '/new');
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

        Auth::login($user, $request->has('remember'));

        // 2FA
        if ($user->hasTwoFactorEnabled()) {
            Auth::logout();
            session(['2fa_pending_user_id' => $user->id, '2fa_remember' => $request->has('remember')]);
            return $this->ok($request, 'Xác thực 2FA', route('2fa.show'));
        }

        $this->logLogin($request, $user);
        return $this->ok($request, 'Đăng nhập thành công!', $user->role === 'admin' ? '/admin' : '/new');
    }

    // ─── 2FA Verify ───

    public function verify2FA(Request $request)
    {
        $userId = session('2fa_pending_user_id');
        if (!$userId)
            return redirect()->route('login')->with('error', 'Phiên đăng nhập đã hết hạn.');

        $request->validate(['code' => 'required|string']);
        $user = User::find($userId);
        $google2fa = new \PragmaRX\Google2FA\Google2FA();

        if (!$user || !$google2fa->verifyKey($user->two_factor_secret, $request->code)) {
            return back()->with('error', 'Mã xác thực không đúng.');
        }

        Auth::login($user, session('2fa_remember', false));
        session()->forget(['2fa_pending_user_id', '2fa_remember']);
        $this->logLogin($request, $user);

        return redirect()->intended($user->role === 'admin' ? '/admin' : '/new')->with('success', 'Đăng nhập thành công!');
    }

    // ─── Register ───

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users|regex:/^[a-z0-9_]{3,}$/',
            'email' => 'required|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
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
            'password' => Hash::make($request->password),
            'api_key' => Str::random(32),
            'transfer_code' => Str::random(8),
            'referral_code' => Str::random(8),
            'role' => 'member',
            'level' => 'retail',
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

        Auth::login($user, true);
        return redirect()->route('clients.new')->with('success', 'Tạo tài khoản thành công!');
    }

    // ─── Forgot Password ───

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        return back()->with('status', 'Nếu email tồn tại, chúng tôi đã gửi link đặt lại mật khẩu.');
    }

    // ─── Install ───

    public function install(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|min:2',
            'username' => 'required|string|max:255|unique:users|regex:/^[a-z0-9_]{3,}$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $domain = getDomain();

        DB::transaction(function () use ($data, $domain) {
            $admin = User::create([
                'name' => trim($data['name']),
                'username' => strtolower(trim($data['username'])),
                'email' => strtolower(trim($data['email'])),
                'password' => Hash::make($data['password']),
                'api_key' => Str::random(32),
                'referral_code' => Str::random(8),
                'role' => 'admin',
                'level' => 'distributor',
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
                'domain_main' => $domain,
                'default_currency' => 'USD',
                'default_lang' => 'en',
                'default_interface' => 'default',
                'status' => true,
            ]);
        });

        return redirect()->route('login');
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
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_SSL_VERIFYPEER => false]);
        $payload = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (!$payload || isset($payload['error']) || ($payload['aud'] ?? '') !== $config->google_oauth_client_id) {
            return response()->json(['success' => false, 'message' => 'Token không hợp lệ.'], 401);
        }

        $email = $payload['email'] ?? null;
        if (!$email)
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
                'role' => 'member',
                'level' => 'retail',
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

        Auth::login($user, true);
        return response()->json(['success' => true, 'message' => 'Đăng nhập thành công', 'redirect' => $user->role === 'admin' ? '/admin' : '/new']);
    }

    // ─── Private Helpers ───

    private function authView(string $page, array $data = [])
    {
        $config = Config::first();
        $theme = $config ? ($config->default_login ?? 'default') : 'default';
        $view = "clients.theme-{$theme}.auth.{$page}";
        return view(view()->exists($view) ? $view : "clients.theme-default.auth.{$page}", $data);
    }

    private function ok(Request $request, string $msg, string $redirect)
    {
        if ($request->expectsJson())
            return response()->json(['success' => true, 'message' => $msg, 'redirect' => $redirect]);
        return redirect()->intended($redirect)->with('success', $msg);
    }

    private function fail(Request $request, string $msg)
    {
        if ($request->expectsJson())
            return response()->json(['success' => false, 'message' => $msg], 422);
        return back()->with('error', $msg)->withInput();
    }

    private function logLogin(Request $request, User $user): void
    {
        ActivityLog::create([
            'user_id' => $user->id,
            'type' => 'login',
            'activity' => json_encode(['ip_address' => $request->ip(), 'user_agent' => $request->userAgent()]),
            'domain' => getDomain(),
        ]);
    }
}
