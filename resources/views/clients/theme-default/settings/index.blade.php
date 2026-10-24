@extends('clients.theme-default.layouts.app')
@section('title', 'Settings')

@section('content')
<div class="content flex-column-fluid" id="kt_content">
    @include('clients.theme-default.layouts.toolbar', ['title' => 'Settings', 'langKey' => 'Settings'])
    <div class="post" id="kt_post">

        {{-- Information --}}
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title fw-bold" data-lang="Information">Information</div>
            </div>
            <div class="card-body">
                <div class="row g-5">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" data-lang="Email">Email</label>
                            <div class="input-group input-group-solid">
                                <input type="email" id="ipt-email" class="form-control" value="{{ auth()->user()->email }}">
                                <span class="input-group-text"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" data-lang="Phone">Phone number</label>
                            <input type="text" id="ipt-phone" class="form-control form-control-solid"
                                value="{{ auth()->user()->phone ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" data-lang="Current password">Current password</label>
                            <input type="password" id="ipt-current-pass" class="form-control form-control-solid">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" data-lang="New password">New password</label>
                            <input type="password" id="ipt-new-pass" class="form-control form-control-solid">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" data-lang="Confirm password">Confirm password</label>
                            <input type="password" id="ipt-confirm-pass" class="form-control form-control-solid">
                        </div>
                        <button type="button" id="btn-change-password" class="btn btn-primary"
                            onclick="_settings.on.click.changePassword()" data-lang="Update">Update</button>
                    </div>
                </div>
                <div class="alert mt-4 d-none" id="alert-info"></div>
            </div>
        </div>

        {{-- Security --}}
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title fw-bold" data-lang="Security">Security</div>
            </div>
            <div class="card-body">
                <div class="row g-5">
                    <div class="col-md-6">
                        @if(auth()->user()->two_factor_enabled)
                            <button type="button" class="btn btn-danger" data-lang="Disable 2FA Google Authentication"
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
                <div class="card-title fw-bold" data-lang="Settings">Settings</div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="sl-language" class="form-label" data-lang="Language">Language</label>
                    <select id="sl-language" name="language" class="form-select form-select-solid"
                        data-update-url="{{ route('clients.settings.update-language') }}">
                        @foreach ($data['languages'] as $lang)
                            <option value="{{ $lang['code'] }}" data-lang=""
                                data-language-id="{{ $lang['id'] }}"
                                data-icon="{{ $lang['flag_class'] }}"
                                data-flag-code="{{ $lang['flag_code'] }}"
                                data-flag-url="{{ $lang['flag_url'] }}"
                                data-name="{{ $lang['name'] }}"
                                data-content="<span class='rounded-1 {{ $lang['flag_class'] }} fs-4 me-1' style='background-image:url({{ $lang['flag_url'] }}) !important'></span> {{ $lang['name'] }}"
                                {{ ($data['lang'] ?? 'en') === $lang['code'] ? 'selected' : '' }}>
                                {{ $lang['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sl-currency" class="form-label" data-lang="Currency">Currency</label>
                    <select id="sl-currency" name="currency" class="form-select form-select-solid"
                        data-update-url="{{ route('clients.settings.update-currency') }}">
                        @foreach ($data['currencies'] as $cur)
                            @php
                                $isUserCurrency = strtoupper((string) ($data['user_currency'] ?? 'USD')) === strtoupper((string) $cur->code);
                                $convertedBalance = (float) ($uiData['balance']['amount'] ?? auth()->user()->balance ?? 0)
                                    * (float) ($cur->exchange_rate ?? 1);
                                $formattedOptionBalance = strtoupper((string) $cur->code) === 'VND'
                                    ? number_format(round($convertedBalance), 0, '.', ',')
                                    : number_format($convertedBalance, 2, '.', ',');
                            @endphp
                            <option value="{{ $cur->code }}" data-lang=""
                                data-code="{{ $cur->code }}"
                                data-symbol="{{ $cur->symbol }}"
                                data-symbol-position="{{ $cur->symbol_position }}"
                                data-name="{{ $cur->name }}"
                                data-rate="{{ $cur->exchange_rate ?? 1 }}"
                                data-content="<span class='badge badge-primary'>{{ $cur->code }}</span> {{ $isUserCurrency ? $formattedOptionBalance : round($cur->exchange_rate ?? 1, 3) }} ({{ $cur->name }})"
                                {{ ($data['user_currency'] ?? 'USD') === $cur->code ? 'selected' : '' }}>
                                {{ $cur->code }} ({{ $cur->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sl-appearance" class="form-label" data-lang="Appearance">Appearance</label>
                    <select id="sl-appearance" class="form-select form-select-solid">
                        <option value="light" data-lang="Light">Light</option>
                        <option value="dark" data-lang="Dark">Dark</option>
                    </select>
                </div>
                <div class="">
                    <label for="sl-timezone" class="form-label" data-lang="Timezone">Timezone</label>
                    <select id="sl-timezone" class="form-select form-select-solid"
                        data-update-url="{{ route('clients.settings.update-timezone') }}">
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
                <div class="card-title fw-bold" data-lang="Sign-in history">Sign-in history</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-7 gy-3 gs-5 mb-0">
                        <thead class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                            <tr>
                                <th data-lang="Time">Time</th>
                                <th>IP</th>
                                <th data-lang="Device">User Agent</th>
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
                                    <td colspan="3" class="text-center text-muted py-5">No data</td>
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
                        <h3 data-lang="Google Authentication Setting">Google Authentication Setting</h3>
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
                            <div class="text-gray-500 fw-bold fs-6 mb-5" data-lang="Google Authentication Setting 1">Get Google Authenticator On Your Phone</div>
                            <a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en">
                                <img class="w-150px" src="{{ asset('images/google-play-badge.png') }}">
                            </a>
                            <a target="_blank" href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8">
                                <img class="w-150px" src="{{ asset('images/app-store-badge.png') }}">
                            </a>
                            <div class="text-gray-500 fw-bold fs-6 mt-5" data-lang="Google Authentication Setting 2">, scan the QR code. It will generate a 6 digit code for you to enter below.</div>
                            <div class="pt-5 mb-5 text-center">
                                <img src="{{ $data['two_factor']['qr'] }}" class="mw-200px twofa-qr"
                                    width="200" height="200" alt="Google Authenticator QR code">
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
                                            <span data-lang="Google Authentication Setting 3">If you having trouble using the QR code, select manual entry on your app, and enter your username and the code:</span>
                                            <span class="fw-bolder text-dark pt-2 twofa-secret">{{ $data['two_factor']['secret'] }}</span>
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
                                            onclick="_settings.on.click.enable2FA()" data-lang="Enable">Enable</button>
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
                                        onclick="_settings.on.click.disable2FA()" data-lang="Disable">Disable</button>
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
<script>_settings.init();</script>
@endpush

