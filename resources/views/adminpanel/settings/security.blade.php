@extends('adminpanel.layouts.app')
@section('title', 'Settings')
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        
        @include('adminpanel.settings.partials.header')
        
        <div class="d-flex flex-wrap flex-stack mb-6">
            <h3 class="fw-bold my-2" data-lang="Security">Bảo mật</h3>
            <div class="d-flex flex-wrap my-2">
                <button class="btn btn-primary btn-sm" data-lang="button::Update"
                    onclick="updateSecurity()">Cập nhật</button>
            </div>
        </div>

        <div class="row g-6">
            <div class="col-xl-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-5">
                                    <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                        <input class="form-check-input cb-enable-website-maintenance" type="checkbox"
                                            {{ ($config->status ?? true) ? '' : 'checked' }}>
                                        <label class="form-check-label" data-lang="Maintenance mode">Bảo trì website</label>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                        <input class="form-check-input cb-allow-register" type="checkbox"
                                            {{ ($config->allow_register ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" data-lang="Allow to sign up">Cho phép đăng ký</label>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                        <input class="form-check-input cb-allow-multi-device-login" type="checkbox"
                                            {{ ($config->allow_multi_device_login ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" data-lang="Multiple session login for the same account">Cho phép đăng nhập một tài khoản trên nhiều thiết bị</label>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                        <input class="form-check-input cb-recaptcha-status" type="checkbox"
                                            {{ ($config->recaptcha_status ?? false) ? 'checked' : '' }}
                                            onchange="document.querySelector('.row-gcaptcha').style.display = this.checked ? '' : 'none'">
                                        <label class="form-check-label" data-lang="Google reCAPTCHA">Google reCAPTCHA</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5 row-gcaptcha" style="{{ ($config->recaptcha_status ?? false) ? '' : 'display: none;' }}">
                            <div class="col-lg-6">
                                <div class="mb-5">
                                    <label class="required form-label" data-lang="Site key">Site key</label>
                                    <input type="text" class="form-control form-control-solid ipt-recaptcha-site-key"
                                        value="{{ $config->recaptcha_site_key ?? '' }}" placeholder="6LcWxxxxxxx">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="">
                                    <label class="required form-label" data-lang="Secret key">Secret key</label>
                                    <input type="text" class="form-control form-control-solid ipt-recaptcha-secret-key"
                                        value="{{ $config->recaptcha_secret_key ?? '' }}" placeholder="6LcW2xxxxxxx">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap flex-stack my-6">
            <h3 class="fw-bold my-2" data-lang="Blocked IP Address">Chặn IP</h3>
            <div class="d-flex flex-wrap my-2 gap-2">
                <div class="input-group input-group-sm" style="width: 260px;">
                    <input type="text" class="form-control form-control-solid ipt-new-ip"
                        data-lang="Enter IP address..." placeholder="Nhập địa chỉ IP...">
                    <button class="btn btn-primary btn-sm" data-lang="button::Add" onclick="blockIP()">Thêm</button>
                </div>
                <button class="btn btn-danger btn-sm" data-lang="button::Delete" onclick="clearAllIPs()">Xóa</button>
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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-blocked-ips">
                                    @php $blockedIps = json_decode($config->blocked_ips ?? '[]', true) ?? []; @endphp
                                    @forelse($blockedIps as $ip)
                                    <tr id="row-ip-{{ md5($ip) }}">
                                        <td>{{ $ip }}</td>
                                        <td class="text-end">
                                            <a href="javascript:;" onclick="unblockIP('{{ $ip }}')"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                aria-label="Bỏ chặn">
                                                <i class="fa-solid fa-xmark fs-4 text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr id="row-no-ip">
                                        <td colspan="2" class="text-center text-muted" data-lang="No blocked IPs">Chưa có IP nào bị chặn</td>
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

    <script>
        function updateSecurity() {
            showFullScreenLoader();
            fetch('{{ route("admin.settings.update.security") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status:                    !document.querySelector('.cb-enable-website-maintenance').checked,
                    allow_register:             document.querySelector('.cb-allow-register').checked,
                    allow_multi_device_login:   document.querySelector('.cb-allow-multi-device-login').checked,
                    recaptcha_status:           document.querySelector('.cb-recaptcha-status').checked,
                    recaptcha_site_key:         document.querySelector('.ipt-recaptcha-site-key').value.trim(),
                    recaptcha_secret_key:       document.querySelector('.ipt-recaptcha-secret-key').value.trim(),
                })
            })
            .then(r => r.json())
            .then(result => {
                hideFullScreenLoader();
                showToast(result.success ? 'Cập nhật thành công' : 'Có lỗi xảy ra khi cập nhật', result.success ? 'success' : 'error');
            })
            .catch(() => { hideFullScreenLoader(); showToast('Có lỗi xảy ra khi cập nhật', 'error'); });
        }

        function blockIP() {
            const ip = document.querySelector('.ipt-new-ip').value.trim();
            if (!ip) return showToast('Vui lòng nhập địa chỉ IP', 'warning');
            showFullScreenLoader();
            fetch('{{ route("admin.settings.security.block-ip") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ ip })
            })
            .then(r => r.json())
            .then(result => {
                hideFullScreenLoader();
                if (!result.success) return showToast(result.message ?? 'Có lỗi xảy ra', 'error');
                document.querySelector('.ipt-new-ip').value = '';
                const tbody = document.getElementById('tbody-blocked-ips');
                const noRow = document.getElementById('row-no-ip');
                if (noRow) noRow.remove();
                const key = result.ip.replace(/\./g, '_');
                if (!document.getElementById('row-ip-' + key)) {
                    tbody.insertAdjacentHTML('beforeend',
                        `<tr id="row-ip-${key}">
                            <td>${result.ip}</td>
                            <td class="text-end"><a href="javascript:;" onclick="unblockIP('${result.ip}')" data-bs-toggle="tooltip" title="Bỏ chặn"><i class="fa-solid fa-xmark fs-4 text-danger"></i></a></td>
                        </tr>`
                    );
                }
                showToast('Đã chặn IP ' + result.ip, 'success');
            })
            .catch(() => { hideFullScreenLoader(); showToast('Có lỗi xảy ra', 'error'); });
        }

        function unblockIP(ip) {
            showFullScreenLoader();
            fetch('{{ route("admin.settings.security.unblock-ip") }}', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ ip })
            })
            .then(r => r.json())
            .then(result => {
                hideFullScreenLoader();
                if (!result.success) return showToast(result.message ?? 'Có lỗi xảy ra', 'error');
                const key = ip.replace(/\./g, '_');
                const row = document.getElementById('row-ip-' + key);
                if (row) row.remove();
                if (!document.querySelector('#tbody-blocked-ips tr')) {
                    document.getElementById('tbody-blocked-ips').innerHTML =
                        '<tr id="row-no-ip"><td colspan="2" class="text-center text-muted">Chưa có IP nào bị chặn</td></tr>';
                }
                showToast('Đã bỏ chặn IP ' + ip, 'success');
            })
            .catch(() => { hideFullScreenLoader(); showToast('Có lỗi xảy ra', 'error'); });
        }

        function clearAllIPs() {
            showFullScreenLoader();
            fetch('{{ route("admin.settings.security.unblock-ip") }}', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ ip: null })
            })
            .then(r => r.json())
            .then(result => {
                hideFullScreenLoader();
                if (!result.success) return showToast(result.message ?? 'Có lỗi xảy ra', 'error');
                document.getElementById('tbody-blocked-ips').innerHTML =
                    '<tr id="row-no-ip"><td colspan="2" class="text-center text-muted">Chưa có IP nào bị chặn</td></tr>';
                showToast('Đã xóa tất cả IP bị chặn', 'success');
            })
            .catch(() => { hideFullScreenLoader(); showToast('Có lỗi xảy ra', 'error'); });
        }

        // Allow pressing Enter to add IP
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('.ipt-new-ip')?.addEventListener('keydown', e => {
                if (e.key === 'Enter') blockIP();
            });
        });
    </script>
@endsection
