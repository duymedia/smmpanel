@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="content flex-row-fluid" id="kt_content">
    @include('admin.settings.partials.header')

    <div class="d-flex flex-wrap flex-stack mb-6">
        <h3 class="fw-bold my-2" data-lang="Security">Bảo mật</h3>
        <div class="d-flex flex-wrap my-2">
            <button type="button" class="btn btn-primary btn-sm" data-lang="button::Update"
                onclick="_settings.on.click.updateSecurity(document.querySelector('.cb-enable-website-maintenance').checked, document.querySelector('.cb-enable-signup').checked, document.querySelector('.cb-enable-gcaptcha').checked, document.querySelector('.cb-multiple-login-status').checked, document.querySelector('.ipt-gcaptcha-site-key').value.trim(), document.querySelector('.ipt-secret-site-key').value.trim())">
                Cập nhật
            </button>
        </div>
    </div>

    <div class="row g-6">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-body">
            <div class="mb-5">
                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                    <input class="form-check-input cb-enable-website-maintenance" type="checkbox"
                        {{ ($config->status ?? true) ? '' : 'checked' }}>
                    <label class="form-check-label" data-lang="Maintenance mode">Bảo trì website</label>
                </div>
            </div>

            <div class="mb-5">
                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                    <input class="form-check-input cb-enable-signup" type="checkbox"
                        {{ ($config->enable_signup ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" data-lang="Allow to sign up">Cho phép đăng ký</label>
                </div>
            </div>

            <div class="mb-5">
                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                    <input class="form-check-input cb-multiple-login-status" type="checkbox"
                        {{ ($config->multiple_login_status ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" data-lang="Multiple session login for the same account">
                        Cho phép một tài khoản đăng nhập trên nhiều thiết bị
                    </label>
                </div>
            </div>

            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                <input class="form-check-input cb-enable-gcaptcha" type="checkbox"
                    {{ ($config->gcaptcha_status ?? false) ? 'checked' : '' }}
                    onchange="document.querySelector('.row-gcaptcha').style.display = this.checked ? '' : 'none'">
                <label class="form-check-label" data-lang="Google reCAPTCHA">Google reCAPTCHA</label>
            </div>

            <div class="row mt-5 row-gcaptcha" style="{{ ($config->gcaptcha_status ?? false) ? '' : 'display: none;' }}">
                <div class="col-lg-6">
                    <label class="required form-label" data-lang="Site key">Site key</label>
                    <input type="text" class="form-control form-control-solid ipt-gcaptcha-site-key"
                        value="{{ $config->gcaptcha_site_key ?? '' }}" placeholder="6LcWxxxxxxx">
                </div>
                <div class="col-lg-6">
                    <label class="required form-label" data-lang="Secret key">Secret key</label>
                    <input type="text" class="form-control form-control-solid ipt-secret-site-key"
                        value="{{ $config->gcaptcha_secret_key ?? '' }}" placeholder="6LcW2xxxxxxx">
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap flex-stack my-6">
        <h3 class="fw-bold my-2" data-lang="IP Blocking">Chặn IP</h3>
        <div class="d-flex flex-wrap my-2">
            <button type="button" class="btn btn-danger btn-sm" data-lang="button::Clear"
                onclick="_settings.on.click.unlockIP()">
                Xóa
            </button>
        </div>
    </div>

    <div class="row g-6">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle table-row-dashed fs-7 gy-2 table-ip-blocking">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th data-lang="IP Address">Địa chỉ IP</th>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (($blockedIps ?? []) as $ip)
                            <tr>
                                <td>{{ $ip }}</td>
                                <td class="text-end">
                                    <a href="javascript:;" onclick="_settings.on.click.unlockIP(@js($ip))"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        aria-label="Unlock" data-bs-original-title="Unlock">
                                        <i class="fa-solid fa-xmark fs-4 text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-6" data-lang="No blocked IPs">
                                    Chưa có IP nào bị chặn
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>$(document).ready(function () { _settings.init(); });</script>
@endpush
@endsection
