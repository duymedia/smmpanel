@extends('adminpanel.layouts.app')
@section('title', 'Accounts')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
    @include('adminpanel.accounts.partials.header')

    <span class="title d-none">View account - Custom rates</span>
    <div class="d-flex flex-wrap flex-stack mb-6">
        <h3 class="fw-bold my-2" data-lang="Custom rates">Thiết lập giá</h3>
    </div>

    <div class="row g-6">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-lg-6 col-12">
                            <div class="mb-5">
                                <select class="form-select form-select-solid sl-services"
                                    data-placeholder="Select service" data-lang="Select service">
                                    <option value="0" data-lang="Select service">Chọn dịch vụ</option>
                                    <option value="-1" data-lang="All active services">Tất cả dịch vụ đang hoạt động</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            data-orate="{{ $service->rate_original }}"
                                            @if ($service->image) data-icon="{{ $service->image }}" @endif>
                                            {{ $service->id }} | {{ $service->getName() }} | ${{ rtrim(rtrim(number_format($service->rate_original, 8, '.', ''), '0'), '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-5">
                            <div class="mb-5">
                                <select class="form-select form-select-solid sl-mode"
                                    data-placeholder="Select mode" data-lang="Select mode"
                                    data-hide-search="true" onchange="setModeCustomRates()">
                                    <option></option>
                                    <option value="1" data-lang="Set by price">Thiết lập theo giá</option>
                                    <option value="2" data-lang="Set by percent">Thiết lập theo phần trăm</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-5">
                            <div class="input-group input-group-solid div-ipt-rate mb-5">
                                <span class="input-group-text">$</span>
                                <input type="number" min="0" step="0.0001" class="form-control ipt-rate">
                            </div>
                            <div class="input-group input-group-solid div-ipt-rate-percent mb-5" style="display:none;">
                                <input type="text" class="form-control ipt-rate-percent"
                                    data-inputmask="'mask': '9', 'repeat': 3, 'greedy': false"
                                    data-bs-toggle="tooltip" data-bs-placement="top" value=""
                                    aria-label="Nếu giá nhà cung cấp là 1$, bạn thiết lập 110% thì giá mới là 1.1$">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-1 col-2">
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-primary btn-icon" onclick="addCustomRate()" title="Add">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-icon" onclick="clearAllCustomRate()" title="Clear all">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="form-check form-check-custom form-check-sm form-check-solid">
                            <input class="form-check-input h-15px w-15px cb-all" type="checkbox" onchange="cbSelectAll(this.checked)">
                        </div>
                        <div class="checkall ms-5" style="display:none;">
                            <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm py-1 px-2"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <span data-lang="Action">Tùy chọn</span>
                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-3" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <a href="javascript:;" class="menu-link px-3" onclick="removeSelectedRates()" data-lang="Remove">Xóa</a>
                                </div>
                            </div>
                            <label class="ms-3 fs-7"></label>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-7 gy-2 table-customrates" style="width:100%;">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th style="width:30px;"></th>
                                    <th data-lang="ID">ID</th>
                                    <th data-lang="Service">Dịch vụ</th>
                                    <th data-lang="Rate">Giá bán</th>
                                    <th data-lang="Percent">Phần trăm</th>
                                </tr>
                            </thead>
                            <tbody class="fs-7 text-gray-700"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
(function () {
    var U = '{{ $account->username }}';
    var CSRF = (document.querySelector('meta[name="csrf-token"]') || {}).content;
    var BASE = '/admin/accounts/' + U + '/customrates';
    var qs = function (s) { return document.querySelector(s); };

    function loader(msg) { if (typeof showFullScreenLoader === 'function') showFullScreenLoader(msg, 'body'); }
    function unload() { if (typeof hideFullScreenLoader === 'function') hideFullScreenLoader(); }

    function api(url, method, body, cb) {
        loader(method === 'POST' ? 'Đang lưu...' : 'Đang xóa...');
        fetch(url, { method: method, headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF }, body: JSON.stringify(body) })
            .then(function (r) { return r.json(); })
            .then(function (res) { unload(); cb(res); })
            .catch(function () { unload(); showToast('Có lỗi xảy ra', 'error'); });
    }

    document.addEventListener('DOMContentLoaded', function () {
        loadCustomRates();
        setTimeout(function () {
            if (window.jQuery && jQuery.fn.select2) {
                jQuery('.sl-services').select2({ placeholder: qs('.sl-services').getAttribute('data-placeholder'), width: '100%' });
                jQuery('.sl-mode').select2({ placeholder: qs('.sl-mode').getAttribute('data-placeholder'), minimumResultsForSearch: Infinity, width: '100%' });
            }
        }, 900);
    });

    window.setModeCustomRates = function () {
        var m = qs('.sl-mode').value;
        qs('.div-ipt-rate').style.display = m === '2' ? 'none' : '';
        qs('.div-ipt-rate-percent').style.display = m === '2' ? '' : 'none';
        if (m === '1') qs('.ipt-rate-percent').value = '';
        if (m === '2') qs('.ipt-rate').value = '';
    };

    function loadCustomRates() {
        loader('Đang tải dữ liệu...');
        fetch(BASE + '/list').then(function (r) { return r.json(); })
            .then(function (res) { unload(); renderTable(res.data || []); })
            .catch(function () { unload(); });
    }

    function renderTable(data) {
        var tbody = qs('.table-customrates tbody');
        if (!data.length) { tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Chưa có custom rate nào</td></tr>'; return; }
        tbody.innerHTML = data.map(function (r) {
            return '<tr data-id="' + r.id + '">'
                + '<td><input type="checkbox" class="form-check-input cb-row h-15px w-15px" value="' + r.id + '" onchange="onRowCheck()"></td>'
                + '<td>' + r.service_id + '</td>'
                + '<td>' + r.name + '</td>'
                + '<td>' + (r.rate !== null ? '$' + parseFloat(r.rate).toFixed(4) : '<span class="text-muted">-</span>') + '</td>'
                + '<td>' + (r.percent !== null ? r.percent + '%' : '<span class="text-muted">-</span>') + '</td>'
                + '</tr>';
        }).join('');
    }

    window.addCustomRate = function () {
        var sid = qs('.sl-services').value, mode = qs('.sl-mode').value;
        var rate = qs('.ipt-rate').value, pct = qs('.ipt-rate-percent').value;
        if (!sid || sid === '0') return showToast('Vui lòng chọn dịch vụ', 'warning');
        if (!mode) return showToast('Vui lòng chọn chế độ thiết lập', 'warning');
        if (mode === '1' && !rate) return showToast('Vui lòng nhập giá', 'warning');
        if (mode === '2' && !pct) return showToast('Vui lòng nhập phần trăm', 'warning');
        api(BASE, 'POST', { service_id: sid, mode: mode, rate: rate, percent: pct }, function (res) {
            if (res.success) { showToast(res.message || 'Lưu thành công', 'success'); loadCustomRates(); }
            else showToast(res.message || 'Lỗi khi lưu', 'error');
        });
    };

    window.clearAllCustomRate = function () {
        api(BASE, 'DELETE', { all: true }, function (res) {
            if (res.success) { showToast(res.message || 'Xóa thành công', 'success'); loadCustomRates(); }
            else showToast(res.message || 'Xóa thất bại', 'error');
        });
    };

    window.removeSelectedRates = function () {
        var ids = Array.from(document.querySelectorAll('.cb-row:checked')).map(function (cb) { return +cb.value; });
        if (!ids.length) return;
        api(BASE, 'DELETE', { ids: ids }, function (res) {
            if (res.success) {
                showToast(res.message || 'Xóa thành công', 'success');
                qs('.cb-all').checked = false;
                qs('.checkall').style.display = 'none';
                loadCustomRates();
            } else showToast(res.message || 'Xóa thất bại', 'error');
        });
    };

    window.cbSelectAll = function (checked) {
        document.querySelectorAll('.cb-row').forEach(function (cb) { cb.checked = checked; });
        qs('.checkall').style.display = checked ? '' : 'none';
    };

    window.onRowCheck = function () {
        var all = document.querySelectorAll('.cb-row').length;
        var chk = document.querySelectorAll('.cb-row:checked').length;
        qs('.checkall').style.display = chk ? '' : 'none';
        qs('.cb-all').checked = all === chk;
    };
}());
</script>
@endsection
