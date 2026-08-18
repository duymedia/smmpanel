@extends('adminpanel.layouts.app')
@section('title', 'Refill services')
@section('content')
    <style>
        .table-refill td {
            line-height: 1.5;
        }
    </style>
    <div class="content flex-row-fluid" id="kt_content">

        <div class="card shadow mb-5">
            <div class="card-body p-5">
                <div class="mb-5">
                    <a href="javascript:;" class="btn btn-sm btn-outline btn-outline- px-3 py-1 me-3 {{ !$status ? 'active' : '' }}"
                        onclick="filterStatusGo('/admin/refill_services','All')" data-lang="status::All">Tất cả</a>
                    <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-secondary text-gray-500 px-3 py-1 me-3 {{ $status === 'awaiting' ? 'active' : '' }}"
                        onclick="filterStatusGo('/admin/refill_services','Awaiting')" data-lang="status::Awaiting">Đang chờ</a>
                    <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-warning px-3 py-1 me-3 {{ $status === 'failed' ? 'active' : '' }}"
                        onclick="filterStatusGo('/admin/refill_services','Failed')" data-lang="status::Failed">Thất bại</a>
                    <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-secondary text-gray-600 px-3 py-1 me-3 {{ $status === 'pending' ? 'active' : '' }}"
                        onclick="filterStatusGo('/admin/refill_services','Pending')" data-lang="status::Pending">Chờ xử lý</a>
                    <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-info px-3 py-1 me-3 {{ $status === 'inprogress' ? 'active' : '' }}"
                        onclick="filterStatusGo('/admin/refill_services','In progress')" data-lang="status::In progress">Đang chạy</a>
                    <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-success px-3 py-1 me-3 {{ $status === 'completed' ? 'active' : '' }}"
                        onclick="filterStatusGo('/admin/refill_services','Completed')" data-lang="status::Completed">Hoàn thành</a>
                    <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-danger px-3 py-1 me-3 {{ $status === 'rejected' ? 'active' : '' }}"
                        onclick="filterStatusGo('/admin/refill_services','Rejected')" data-lang="status::Rejected">Từ chối</a>
                </div>
                <div class="row g-3">
                    <div class="col-lg-2 col-sm-4 col-6">
                        <input type="text" id="ipt-refill-id"
                            class="form-control form-control-solid form-control-sm datatable-input"
                            data-col-name="refill_id" placeholder="Mã bảo hành" data-page="/refill_services"
                            data-lang="Refill ID">
                    </div>
                    <div class="col-lg-2 col-sm-4 col-6">
                        <input type="text" id="ipt-order-id"
                            class="form-control form-control-solid form-control-sm datatable-input" data-col-name="order_id"
                            placeholder="Mã đơn hàng" data-page="/refill_services" data-lang="Order ID">
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <button type="button" class="btn btn-primary btn-sm me-2"
                            onclick="_refill_services.on.click.filter()" data-lang="button::Search">Tìm kiếm</button>
                        <button type="button" class="btn btn-sm btn-secondary"
                            onclick="_refill_services.on.click.resetFilter()" data-lang="button::Reset">Thiết lập
                            lại</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-5">
                <div class="d-flex mb-3">
                    <div class="form-check form-check-custom form-check-sm form-check-solid">
                        <input class="form-check-input h-15px w-15px cb-all" type="checkbox"
                            onchange="_refill_services.on.change.cbSelectAll(this.checked)">
                    </div>
                    <div class="checkall ms-5 d-none">
                        <a href="#"
                            class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm py-1 px-2"
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <span data-page="common" data-lang="">Tùy chọn</span>
                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                            data-kt-menu="true">
                            <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                                <a href="javascript:;" class="menu-link px-3">
                                    <span class="menu-title" data-page="/orders" data-lang="">Chuyển trạng thái</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="menu-sub menu-sub-dropdown py-4 w-150px">
                                    <div class="menu-item px-3">
                                        <a href="javascript:;" class="menu-link px-3"
                                            onclick="_refill_services.on.click.actionBulk('Change status', 'In progress')"
                                            data-lang="status::In progress">Đang chạy</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="javascript:;" class="menu-link px-3"
                                            onclick="_refill_services.on.click.actionBulk('Change status', 'Completed')"
                                            data-lang="status::Completed">Hoàn thành</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="javascript:;" class="menu-link px-3"
                                            onclick="_refill_services.on.click.actionBulk('Change status', 'Rejected')"
                                            data-lang="status::Rejected">Từ chối</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label class="ms-3 fs-7 selected-count"></label>
                    </div>
                </div>

                <div class="table-responsive">
                    <div id="tbl-refill-services_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer" style="position:relative;">
                        <div id="tbl-refill-services_processing" class="dt-processing card" role="status"
                            style="display:none;">
                            <span class="spinner-border w-15px h-15px text-muted align-middle me-2"></span>
                            <span class="text-gray-600">Loading...</span>
                            <div><div></div><div></div><div></div><div></div></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle table-refill table-row-dashed fs-7 gy-2" id="tbl-refill-services">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th data-page="/refill_services" data-lang="Status">Trạng thái</th>
                                        <th data-page="/refill_services" data-lang="Refill ID">Mã bảo hành</th>
                                        <th data-page="/refill_services" data-lang="Account">Tài khoản</th>
                                        <th data-page="/refill_services" data-lang="Order ID">Mã đơn hàng</th>
                                        <th data-page="/refill_services" data-lang="Created">Ngày tạo</th>
                                    </tr>
                                </thead>
                                <tbody>
                            @forelse($items as $item)
                                @php
                                    $sMap = [
                                        'pending' => [
                                            'label' => 'Chờ xử lý',
                                            'class' => 'btn-secondary',
                                            'badge' => false,
                                        ],
                                        'completed' => [
                                            'label' => 'Hoàn thành',
                                            'class' => 'badge-success',
                                            'badge' => true,
                                        ],
                                        'rejected' => [
                                            'label' => 'Từ chối',
                                            'class' => 'badge-danger',
                                            'badge' => true,
                                        ],
                                    ];
                                    $s = $sMap[$item->status ?? 'pending'] ?? $sMap['pending'];
                                @endphp
                                <tr>
                                    <td>
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input h-15px w-15px cb-select" type="checkbox"
                                                value="{{ $item->id }}" data-pid="{{ $item->id }}"
                                                onchange="_refill_services.on.change.cbSelect(this.checked)">
                                        </label>
                                    </td>
                                    <td>
                                        @if (!$s['badge'])
                                            <button type="button"
                                                class="btn {{ $s['class'] }} btn-sm py-1 px-2 action-{{ $item->id }}"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                                <span data-page="/refill_services"
                                                    data-lang="Status">{{ $s['label'] }}</span>
                                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                            </button>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4"
                                                data-kt-menu="true">
                                                <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                                    data-kt-menu-placement="right-start">
                                                    <a href="javascript:;" class="menu-link px-3">
                                                        <span class="menu-title" data-page="/orders"
                                                            data-lang="">Chuyển trạng thái</span>
                                                        <span class="menu-arrow"></span>
                                                    </a>
                                                    <div class="menu-sub menu-sub-dropdown py-4 w-150px">
                                                        <div class="menu-item px-3">
                                                            <a href="javascript:;" class="menu-link px-3"
                                                                onclick="_refill_services.on.click.changeStatus('In progress', '{{ $item->id }}')"
                                                                data-lang="status::In progress">Đang chạy</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a href="javascript:;" class="menu-link px-3"
                                                                onclick="_refill_services.on.click.changeStatus('Completed', '{{ $item->id }}')"
                                                                data-lang="status::Completed">Hoàn thành</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a href="javascript:;" class="menu-link px-3"
                                                                onclick="_refill_services.on.click.changeStatus('Rejected', '{{ $item->id }}')"
                                                                data-lang="status::Rejected">Từ chối</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span
                                                class="badge {{ $s['class'] }} badge-sm fs-7 py-2 px-4 action-{{ $item->id }}">
                                                <span
                                                    data-lang="status::{{ ucfirst($item->status) }}">{{ $s['label'] }}</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bolder ls-1">{{ $item->id }}</span>
                                        <p class="m-0 text-gray-600 fs-7">
                                            {{ $item->provider_name }}{{ $item->orders_api ? ' - ' . $item->orders_api : '' }}
                                        </p>
                                    </td>
                                    <td>{{ $item->username }}</td>
                                    <td><a href="/admin/orders?id={{ $item->id }}" target="_blank"
                                            class="ls-1">{{ $item->id }}</a></td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5" data-page="/refill_services"
                                        data-lang="Please select at least one row">Không có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-4">{{ $items->links() }}</div>
            </div>
        </div>
    </div>

    <script>
        window._refill_services = {
            _status: '{{ request('status', 'All') }}',
            on: {
                click: {
                    filterStatus: function(s) {
                        _refill_services._status = s;
                        if (typeof showFullScreenLoader === 'function') showFullScreenLoader(typeof tr === 'function' ? tr('Loading...') : 'Loading...', 'body');
                        window.location.href = '/admin/refill_services?status=' + encodeURIComponent(s);
                    },
                    filter: function() {
                        var id = document.getElementById('ipt-refill-id').value;
                        var oid = document.getElementById('ipt-order-id').value;
                        var url = '/admin/refill_services?status=' + encodeURIComponent(_refill_services._status);
                        if (id) url += '&refill_id=' + encodeURIComponent(id);
                        if (oid) url += '&order_id=' + encodeURIComponent(oid);
                        if (typeof showFullScreenLoader === 'function') showFullScreenLoader(typeof tr === 'function' ? tr('Loading...') : 'Loading...', 'body');
                        window.location.href = url;
                    },
                    resetFilter: function() {
                        if (typeof showFullScreenLoader === 'function') showFullScreenLoader(typeof tr === 'function' ? tr('Loading...') : 'Loading...', 'body');
                        window.location.href = '/admin/refill_services';
                    },
                    changeStatus: function(status, id) {
                        var map = {
                            'In progress': 'pending',
                            'Completed': 'completed',
                            'Rejected': 'rejected'
                        };
                        fetch('/admin/refill_services/update-status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                ids: [id],
                                status: map[status]
                            })
                        }).then(r => r.json()).then(() => window.location.reload());
                    },
                    actionBulk: function(action, status) {
                        var ids = Array.from(document.querySelectorAll('.cb-select:checked')).map(el => el.value);
                        if (!ids.length) {
                            alert(typeof tr === 'function' ? tr('Please select at least one row') :
                                'Vui lòng chọn ít nhất một dòng');
                            return;
                        }
                        var map = {
                            'In progress': 'pending',
                            'Completed': 'completed',
                            'Rejected': 'rejected'
                        };
                        fetch('/admin/refill_services/update-status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                ids: ids,
                                status: map[status]
                            })
                        }).then(r => r.json()).then(() => window.location.reload());
                    }
                },
                change: {
                    cbSelectAll: function(checked) {
                        document.querySelectorAll('.cb-select').forEach(el => el.checked = checked);
                        document.querySelector('.checkall').classList.toggle('d-none', !checked);
                    },
                    cbSelect: function() {
                        var any = document.querySelectorAll('.cb-select:checked').length > 0;
                        document.querySelector('.checkall').classList.toggle('d-none', !any);
                    }
                }
            }
        };

        window.filterStatusGo = window.filterStatusGo || function(url, status) {
            if (typeof showFullScreenLoader === 'function') showFullScreenLoader(typeof tr === 'function' ? tr('Loading...') : 'Loading...', 'body');
            window.location.href = status === 'All' ? url : url + '/' + status.toLowerCase().replace(/ /g, '');
        };

        function showTableLoader() {
            var loader = document.getElementById('tbl-refill-services_processing');
            var table  = document.getElementById('tbl-refill-services');
            if (loader) loader.style.display = 'block';
            if (table)  table.style.opacity  = '0.4';
        }
        function hideTableLoader() {
            var loader = document.getElementById('tbl-refill-services_processing');
            var table  = document.getElementById('tbl-refill-services');
            if (loader) loader.style.display = 'none';
            if (table)  table.style.opacity  = '1';
        }

        document.addEventListener('DOMContentLoaded', function () {
            showTableLoader();
            setTimeout(hideTableLoader, 400);
        });
    </script>
@endsection
