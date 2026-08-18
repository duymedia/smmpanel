@extends('clients.theme-4.layouts.app')
@section('title', 'Settings')

@section('content')
<div class="content flex-column-fluid" id="kt_content">
    @include('clients.theme-4.layouts.toolbar', ['title' => 'Settings', 'langKey' => 'account.title'])
    <div class="post" id="kt_post">

        {{-- Information --}}
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title fw-bold" data-lang="account.information">Information</div>
            </div>
            <div class="card-body">
                <div class="row g-5">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" data-lang="account.email">Email</label>
                            <div class="input-group input-group-solid">
                                <input type="text" id="ipt-email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                                <span class="input-group-text"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" data-lang="account.phone">Phone number</label>
                            <input type="text" id="ipt-phone" class="form-control form-control-solid"
                                value="{{ auth()->user()->phone ?? '' }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" data-lang="account.current_password">Current password</label>
                            <input type="password" id="ipt-current-pass" class="form-control form-control-solid">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" data-lang="account.new_password">New password</label>
                            <input type="password" id="ipt-new-pass" class="form-control form-control-solid">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" data-lang="account.confirm_password">Confirm password</label>
                            <input type="password" id="ipt-confirm-pass" class="form-control form-control-solid">
                        </div>
                        <button type="button" id="btn-change-password" class="btn btn-primary"
                            onclick="_settings.on.click.changePassword()" data-lang="button::Update">Update</button>
                    </div>
                </div>
                <div class="alert mt-4 d-none" id="alert-info"></div>
            </div>
        </div>

        {{-- Security --}}
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title fw-bold" data-lang="account.security">Security</div>
            </div>
            <div class="card-body">
                <div class="row g-5">
                    <div class="col-md-6">
                        @if(auth()->user()->two_factor_enabled)
                            <button type="button" class="btn btn-danger" data-lang="account.disable_2fa"
                                data-bs-toggle="modal" data-bs-target="#modal-2fa">Disable 2FA Google Authentication</button>
                        @else
                            <button type="button" class="btn btn-primary" data-lang="Enable 2FA Google Authentication"
                                data-bs-toggle="modal" data-bs-target="#modal-2fa">Enable 2FA Google Authentication</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Settings --}}
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title fw-bold" data-lang="account.settings">Settings</div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="sl-language" class="form-label" data-lang="account.language">Language</label>
                    <select id="sl-language" class="form-select form-select-solid">
                        @foreach ($data['languages'] as $lang)
                            <option value="{{ $lang['code'] }}"
                                data-content="<span class='rounded-1 fi fi-{{ langToFlag($lang['code']) }} fs-4 me-1'></span> {{ $lang['name'] }}"
                                {{ ($data['lang'] ?? 'en') === $lang['code'] ? 'selected' : '' }}>
                                {{ $lang['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sl-currency" class="form-label" data-lang="account.currency">Currency</label>
                    <select id="sl-currency" class="form-select form-select-solid">
                        @foreach ($data['currencies'] as $cur)
                            <option value="{{ $cur->code }}"
                                data-symbol="{{ $cur->symbol }}"
                                data-name="{{ $cur->name }}"
                                data-rate="{{ $cur->exchange_rate ?? 1 }}"
                                data-content="<span class='badge badge-primary me-1'>{{ $cur->code }}</span> <span class='text-muted'>{{ number_format($cur->exchange_rate ?? 1, 2) }}</span> ({{ $cur->name }})"
                                {{ ($data['user_currency'] ?? 'USD') === $cur->code ? 'selected' : '' }}>
                                {{ $cur->code }} - {{ $cur->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sl-appearance" class="form-label" data-lang="account.appearance">Appearance</label>
                    <select id="sl-appearance" class="form-select form-select-solid">
                        <option value="light" data-lang="account.light">Light</option>
                        <option value="dark" data-lang="account.dark">Dark</option>
                    </select>
                </div>
                <div class="">
                    <label for="sl-timezone" class="form-label" data-lang="account.timezone">Timezone</label>
                    <select id="sl-timezone" class="form-select form-select-solid">
                        @foreach ($data['timezones'] as $tz)
                            <option value="{{ $tz['timezone'] ?? $tz }}"
                                {{ ($data['timezone'] ?? '0') == ($tz['timezone'] ?? $tz) ? 'selected' : '' }}>
                                {{ $tz['label'] ?? $tz }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Sign-in history --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title fw-bold" data-lang="account.signin_history">Sign-in history</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-7 gy-3 gs-5 mb-0">
                        <thead class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                            <tr>
                                <th data-lang="account.time">Time</th>
                                <th>IP</th>
                                <th data-lang="account.device">User Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['login_history'] as $log)
                                <tr>
                                    <td class="text-nowrap text-muted fs-7">{{ $log['time'] }}</td>
                                    <td class="fw-semibold ls-1">{{ $log['ip'] }}</td>
                                    <td class="fs-7 text-gray-600 wrap">{{ $log['ua'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-5" data-lang="common.no_data">No data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- 2FA Modal --}}
        <div class="modal fade" id="modal-2fa" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header flex-stack">
                        <h3 data-lang="">Google Authentication Setting</h3>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body scroll-y">
                        @if(!auth()->user()->two_factor_enabled)
                        {{-- Enable 2FA flow --}}
                        <div>
                            <div class="text-gray-500 fw-bold fs-6 mb-5" data-lang="Get Google Authenticator On Your Phone">Get Google Authenticator On Your Phone</div>
                            <a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en">
                                <img class="w-150px" src="{{ asset('images/google-play-badge.png') }}">
                            </a>
                            <a target="_blank" href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8">
                                <img class="w-150px" src="{{ asset('images/app-store-badge.png') }}">
                            </a>
                            <div class="text-gray-500 fw-bold fs-6 mt-5" data-lang=", scan the QR code. It will generate a 6 digit code for you to enter below.">, scan the QR code. It will generate a 6 digit code for you to enter below.</div>
                            <div class="pt-5 mb-5 text-center">
                                <div id="2fa-qr-loading" class="text-muted fs-7">Loading QR code...</div>
                                <img id="2fa-qr-img" src="" class="mw-150px d-none twofa-qr">
                            </div>
                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-10 p-6">
                                <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
                                        <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
                                        <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
                                    </svg>
                                </span>
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-bold">
                                        <div class="fs-6 text-gray-700">
                                            <span data-lang="If you having trouble using the QR code, select manual entry on your app, and enter your username and the code:">If you having trouble using the QR code, select manual entry on your app, and enter your username and the code:</span>
                                            <span class="fw-bolder text-dark pt-2 twofa-secret" id="2fa-secret-text"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form data-kt-element="apps-form" class="form" action="#">
                                <div class="mb-3">
                                    <div class="input-group input-group-solid">
                                        <input type="text" id="ipt-2fa-code" class="form-control form-control-solid"
                                            placeholder="Enter authentication code" maxlength="6" data-lang="Enter authentication code">
                                        <button type="button" id="btn-enable-2fa" class="btn btn-primary"
                                            onclick="_settings.on.click.enable2FA()" data-lang="button::Enable">Enable</button>
                                    </div>
                                </div>
                            </form>
                            <div class="alert d-none" id="alert-2fa-enable"></div>
                        </div>
                        @else
                        {{-- Disable 2FA flow --}}
                        <div>
                            <div class="text-gray-500 fw-bold fs-6 mb-4">
                                Enter the 6-digit code from your Google Authenticator app to disable 2FA.
                            </div>
                            <div class="mb-3">
                                <div class="input-group input-group-solid">
                                    <input type="text" id="ipt-2fa-code" class="form-control form-control-solid"
                                        placeholder="Enter authentication code" maxlength="6">
                                    <button type="button" id="btn-disable-2fa" class="btn btn-danger"
                                        onclick="_settings.on.click.disable2FA()">Disable</button>
                                </div>
                            </div>
                            <div class="alert d-none" id="alert-2fa-disable"></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    function showAlert(type, msg) {
        var el = document.getElementById('alert-info');
        if (!el) return;
        el.className = 'alert mt-4 alert-' + type;
        el.textContent = msg;
        el.classList.remove('d-none');
    }

    window._settings = window._settings || { on: { click: {} } };

    _settings.on.click.changePassword = function() {
        var btn         = document.getElementById('btn-change-password');
        var email       = document.getElementById('ipt-email').value.trim();
        var currentPass = document.getElementById('ipt-current-pass').value;
        var newPass     = document.getElementById('ipt-new-pass').value;
        var confirmPass = document.getElementById('ipt-confirm-pass').value;
        var origEmail   = '{{ auth()->user()->email }}';

        var emailChanged = email && email !== origEmail;
        var passChanged  = newPass.length > 0;

        // Validate BEFORE showing loader
        if (!emailChanged && !passChanged) return;

        // Show loader first, then disable button
        showFullScreenLoader('Updating...', 'body');
        if (btn) btn.disabled = true;

        var tasks = [];

        if (emailChanged) {
            tasks.push(fetch('{{ route("clients.settings.update-email") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ email: email })
            }).then(r => r.json()));
        }

        if (passChanged) {
            tasks.push(fetch('{{ route("clients.settings.update-password") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ current_password: currentPass, password: newPass, password_confirmation: confirmPass })
            }).then(r => r.json()));
        }

        Promise.all(tasks).then(function(results) {
            var allOk = results.every(r => r.success);
            var msgs  = results.map(r => r.message).filter(Boolean).join(' | ');
            // Hide loader before showing result
            hideFullScreenLoader();
            showAlert(allOk ? 'success' : 'danger', msgs || (allOk ? 'Updated successfully.' : 'An error occurred.'));
            if (allOk && passChanged) {
                document.getElementById('ipt-current-pass').value = '';
                document.getElementById('ipt-new-pass').value = '';
                document.getElementById('ipt-confirm-pass').value = '';
            }
        }).catch(function() {
            hideFullScreenLoader();
            showAlert('danger', 'Network error.');
        }).finally(function() {
            if (btn) btn.disabled = false;
        });
    };

    _settings.on.click.disable2FA = function() {
        var code = document.getElementById('ipt-2fa-code').value.trim();
        var alertEl = document.getElementById('alert-2fa-disable');
        function show(type, msg) { alertEl.className = 'alert alert-' + type; alertEl.textContent = msg; alertEl.classList.remove('d-none'); }
        fetch('{{ route("clients.settings.2fa-disable") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ code: code })
        }).then(r => r.json()).then(function(res) {
            if (res.success) location.reload();
            else show('danger', res.message || 'Error.');
        }).catch(function() { show('danger', 'Network error.'); });
    };

    _settings.on.click.enable2FA = function() {
        var code = document.getElementById('ipt-2fa-code').value.trim();
        var alertEl = document.getElementById('alert-2fa-enable');
        function show(type, msg) { alertEl.className = 'alert alert-' + type; alertEl.textContent = msg; alertEl.classList.remove('d-none'); }
        fetch('{{ route("clients.settings.2fa-approve") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ code: code })
        }).then(r => r.json()).then(function(res) {
            if (res.success) location.reload();
            else show('danger', res.message || 'Error.');
        }).catch(function() { show('danger', 'Network error.'); });
    };

    @if(!auth()->user()->two_factor_enabled)
    // Load QR code when enable modal opens
    document.getElementById('modal-2fa').addEventListener('show.bs.modal', function() {
        var qrImg     = document.getElementById('2fa-qr-img');
        var qrLoading = document.getElementById('2fa-qr-loading');
        var secretEl  = document.getElementById('2fa-secret-text');
        if (qrImg && !qrImg.classList.contains('d-none')) return; // already loaded
        fetch('{{ route("clients.settings.2fa-setup") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({})
        }).then(r => r.json()).then(function(res) {
            if (res.success) {
                if (qrImg)     { qrImg.src = res.qr_url; qrImg.classList.remove('d-none'); }
                if (qrLoading) { qrLoading.classList.add('d-none'); }
                if (secretEl)  { secretEl.textContent = res.secret; }
            }
        });
    });
    @endif

    // Select2 for Settings card
    document.addEventListener('DOMContentLoaded', function() {
        var s2 = {
            escapeMarkup: function(m) { return m; },
            templateResult: function(o) {
                if (!o.element) return o.text;
                var c = o.element.getAttribute('data-content');
                return c ? c : o.text;
            },
            templateSelection: function(o) {
                if (!o.element) return o.text;
                var c = o.element.getAttribute('data-content');
                return c ? c : o.text;
            },
            width: '100%'
        };

        $('#sl-language').select2(s2).on('change', function() {
            var lang = $(this).val();
            // Update HTML attributes immediately
            document.documentElement.lang = lang;
            document.documentElement.setAttribute('data-lang', lang);
            // Update cookies
            document.cookie = 'data-lang=' + lang + ';path=/;max-age=2592000;SameSite=Lax';
            localStorage.setItem('data-lang', lang);

            showFullScreenLoader('Loading...', 'body');
            fetch('{{ route("clients.settings.update-language") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ lang: lang })
            }).then(r => r.json()).then(function(res) {
                if (res.success) {
                    // Clear cached lang from sessionStorage
                    sessionStorage.removeItem('lang_' + lang);
                    location.reload();
                }
            });
        });

        $('#sl-currency').select2(s2).on('change', function() {
            var opt = $(this).find(':selected');
            var code = $(this).val();
            var symbol = opt.data('symbol');
            var name = opt.data('name');
            var rate = opt.data('rate') || 1;

            showFullScreenLoader('Loading...', 'body');
            fetch('{{ route("clients.settings.update-currency") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ currency_code: code, currency_symbol: symbol, currency_name: name })
            }).then(r => r.json()).then(function(res) { if (res.success) location.reload(); });
        });

        $('#sl-appearance').select2({ minimumResultsForSearch: -1, width: '100%' });

        // Set select value from localStorage on load
        var savedTheme = localStorage.getItem('theme') || 'light';
        $('#sl-appearance').val(savedTheme).trigger('change.select2');

        $('#sl-appearance').on('change', function() {
            var theme = $(this).val();
            // Update all theme-related attributes on <html>
            document.documentElement.setAttribute('data-bs-theme', theme);
            document.documentElement.setAttribute('data-bs-theme-mode', theme);
            document.documentElement.setAttribute('data-theme', theme);
            // Persist in localStorage and cookie
            localStorage.setItem('theme', theme);
            document.cookie = 'data-bs-theme=' + theme + ';path=/;max-age=2592000;SameSite=Lax';
        });

        $('#sl-timezone').select2({ width: '100%' }).on('change', function() {
            fetch('{{ route("clients.settings.update-timezone") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ timezone: $(this).val() })
            }).then(r => r.json()).then(function(res) { if (res.success) location.reload(); });
        });
    });
})();
</script>
@endpush
