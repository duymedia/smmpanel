@extends('adminpanel.layouts.app')
@section('title', 'Quản lý Affiliates')
@section('content')
<div class="content flex-row-fluid" id="kt_content">

    {{-- Stats --}}
    <div class="row g-4 mb-5">
        <div class="col-sm-3">
            <div class="card border-0 shadow-sm text-center py-4">
                <div class="fs-2 fw-bold text-primary" id="stat-total">—</div>
                <div class="text-muted fs-7">Tổng affiliates</div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-0 shadow-sm text-center py-4">
                <div class="fs-2 fw-bold text-success" id="stat-active">—</div>
                <div class="text-muted fs-7">Đang hoạt động</div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-0 shadow-sm text-center py-4">
                <div class="fs-2 fw-bold text-warning" id="stat-earned">—</div>
                <div class="text-muted fs-7">Tổng hoa hồng đã trả</div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-0 shadow-sm text-center py-4">
                <div class="fs-2 fw-bold text-info" id="stat-orders">—</div>
                <div class="text-muted fs-7">Tổng tiền nạp từ referred</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row g-3 align-items-end">
                <div class="col-sm-4">
                    <input type="text" id="filter-referrer"
                        class="form-control form-control-solid form-control-sm"
                        placeholder="Tìm referrer (username)...">
                </div>
                <div class="col-sm-3">
                    <select id="filter-status" class="form-select form-select-solid form-select-sm">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Không HĐ</option>
                        <option value="suspended">Tạm khóa</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <button class="btn btn-primary btn-sm me-2" onclick="affFilter()">Tìm kiếm</button>
                    <button class="btn btn-secondary btn-sm" onclick="affReset()">Thiết lập lại</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm div-affiliates">
        <div class="card-body p-5">
            <div class="table-responsive">
                <div id="table-affiliates_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                    <div class="table-responsive">
                        <div id="table-affiliates_processing" class="dt-processing card" role="status" style="display:none">
                            <span class="spinner-border w-15px h-15px text-muted align-middle me-2"></span>
                            <span class="text-gray-600">Loading...</span>
                        </div>
                        <table class="table align-middle table-row-dashed fs-7 gy-2" id="table-affiliates" style="width:100%">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0" role="row">
                                    <th class="dt-orderable-none"><span class="dt-column-title">Thời gian</span></th>
                                    <th class="dt-orderable-none"><span class="dt-column-title">Referrer</span></th>
                                    <th class="dt-orderable-none"><span class="dt-column-title">Referred</span></th>
                                    <th class="dt-orderable-none"><span class="dt-column-title">Ref Code</span></th>
                                    <th class="dt-orderable-none"><span class="dt-column-title">Hoa hồng %</span></th>
                                    <th class="dt-orderable-none"><span class="dt-column-title">Đã nhận</span></th>
                                    <th class="dt-orderable-none"><span class="dt-column-title">Tổng nạp</span></th>
                                    <th class="dt-orderable-none"><span class="dt-column-title">Đơn</span></th>
                                    <th class="dt-orderable-none"><span class="dt-column-title">Lần cuối</span></th>
                                    <th class="dt-orderable-none"><span class="dt-column-title">Trạng thái</span></th>
                                </tr>
                            </thead>
                            <tbody id="affiliate-tbody" class="fs-7 text-gray-700">
                                <tr><td colspan="10" class="text-center py-5 text-muted">Đang tải...</td></tr>
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>

                    {{-- Pagination giống orders/index --}}
                    <div class="row mt-4">
                        <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <select class="form-select form-select-solid form-select-sm w-80px"
                                        id="per-page-select" onchange="affChangePerPage(this.value)">
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="dt-info" aria-live="polite" id="table-affiliates_info" role="status">
                                    <span>Hiển thị</span> <span id="aff-info-from">0</span> -
                                    <span id="aff-info-to">0</span> /
                                    <span id="aff-info-total">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end mt-3 mt-md-0">
                            <div class="dt-paging">
                                <nav>
                                    <ul class="pagination" id="aff-pagination"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    var _currentPage = 1;

    var statusMap = {
        active:    '<span class="badge badge-light-success">Hoạt động</span>',
        inactive:  '<span class="badge badge-light-secondary">Không HĐ</span>',
        suspended: '<span class="badge badge-light-danger">Tạm khóa</span>'
    };

    function getParams(page) {
        var p = new URLSearchParams();
        p.append('page',     page || _currentPage);
        p.append('per_page', document.getElementById('per-page-select').value || 15);
        var referrer = document.getElementById('filter-referrer').value.trim();
        var status   = document.getElementById('filter-status').value;
        if (referrer) p.append('referrer', referrer);
        if (status)   p.append('status', status);
        return p;
    }

    function setLoading(on) {
        var proc  = document.getElementById('table-affiliates_processing');
        var table = document.getElementById('table-affiliates');
        if (proc)  proc.style.display  = on ? 'block' : 'none';
        if (table) table.style.opacity = on ? '0.4'   : '1';
    }

    function load(page) {
        _currentPage = page || 1;
        setLoading(true);

        fetch('/admin/affiliates?' + getParams(_currentPage).toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(function (r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(function (res) {
            var data  = res.data || [];
            var tbody = document.getElementById('affiliate-tbody');

            // Stats từ server (toàn bộ, không chỉ trang hiện tại)
            document.getElementById('stat-total').textContent  = res.total        || 0;
            document.getElementById('stat-active').textContent = res.active_count || 0;
            document.getElementById('stat-earned').textContent = parseFloat(res.total_earned || 0).toFixed(2);
            document.getElementById('stat-orders').textContent = parseFloat(res.total_orders || 0).toFixed(2);

            // Info
            document.getElementById('aff-info-from').textContent  = res.from  || 0;
            document.getElementById('aff-info-to').textContent    = res.to    || 0;
            document.getElementById('aff-info-total').textContent = res.total || 0;

            if (!data.length) {
                tbody.innerHTML = '<tr><td colspan="10" class="text-center text-muted py-5">Không có dữ liệu</td></tr>';
                document.getElementById('aff-pagination').innerHTML = '';
                return;
            }

            tbody.innerHTML = data.map(function (a) {
                var referrer  = a.referrer
                    ? '<a href="/admin/accounts/' + a.referrer.username + '" class="fw-bold text-dark">' + a.referrer.username + '</a>'
                    : '<span class="text-muted">#' + a.referrer_id + '</span>';
                var referred  = a.referred
                    ? '<a href="/admin/accounts/' + a.referred.username + '" class="text-muted">' + a.referred.username + '</a>'
                    : '<span class="text-muted">#' + a.referred_id + '</span>';
                var date      = a.created_at    ? a.created_at.substring(0, 10)    : '—';
                var lastOrder = a.last_order_at ? a.last_order_at.substring(0, 10) : '—';
                var earned    = parseFloat(a.total_earned    || 0).toFixed(2);
                var orders    = parseFloat(a.total_orders    || 0).toFixed(2);
                var rate      = parseFloat(a.commission_rate || 0).toFixed(2);
                var refCode   = a.referral_code ? '<code class="text-primary">' + a.referral_code + '</code>' : '—';
                var status    = statusMap[a.status] || a.status;

                return '<tr>'
                    + '<td class="text-muted fs-8">' + date + '</td>'
                    + '<td>' + referrer + '</td>'
                    + '<td>' + referred + '</td>'
                    + '<td>' + refCode + '</td>'
                    + '<td><span class="badge badge-light-primary">' + rate + '%</span></td>'
                    + '<td class="fw-bold text-success">' + earned + '</td>'
                    + '<td class="text-muted">' + orders + '</td>'
                    + '<td class="text-center">' + (a.orders_count || 0) + '</td>'
                    + '<td class="text-muted fs-8">' + lastOrder + '</td>'
                    + '<td>' + status + '</td>'
                    + '</tr>';
            }).join('');

            renderPagination(res);
        })
        .catch(function (e) {
            document.getElementById('affiliate-tbody').innerHTML =
                '<tr><td colspan="10" class="text-center text-danger py-5">Lỗi: ' + e.message + '</td></tr>';
        })
        .finally(function () { setLoading(false); });
    }

    function renderPagination(res) {
        var ul        = document.getElementById('aff-pagination');
        var lastPage  = res.last_page  || 1;
        var curPage   = res.current_page || 1;
        var start     = Math.max(1, curPage - 2);
        var end       = Math.min(lastPage, curPage + 2);
        var html      = '';

        // Prev
        if (curPage <= 1) {
            html += '<li class="page-item disabled"><span class="page-link"><i class="previous"></i></span></li>';
        } else {
            html += '<li class="page-item"><a href="javascript:;" onclick="affGoToPage(' + (curPage - 1) + ')" class="page-link"><i class="previous"></i></a></li>';
        }

        if (start > 1) {
            html += '<li class="page-item"><a href="javascript:;" onclick="affGoToPage(1)" class="page-link">1</a></li>';
            if (start > 2) html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        for (var p = start; p <= end; p++) {
            if (p === curPage) {
                html += '<li class="page-item active"><span class="page-link">' + p + '</span></li>';
            } else {
                html += '<li class="page-item"><a href="javascript:;" onclick="affGoToPage(' + p + ')" class="page-link">' + p + '</a></li>';
            }
        }

        if (end < lastPage) {
            if (end < lastPage - 1) html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            html += '<li class="page-item"><a href="javascript:;" onclick="affGoToPage(' + lastPage + ')" class="page-link">' + lastPage + '</a></li>';
        }

        // Next
        if (curPage >= lastPage) {
            html += '<li class="page-item disabled"><span class="page-link"><i class="next"></i></span></li>';
        } else {
            html += '<li class="page-item"><a href="javascript:;" onclick="affGoToPage(' + (curPage + 1) + ')" class="page-link"><i class="next"></i></a></li>';
        }

        ul.innerHTML = html;
    }

    window.affGoToPage     = function (page) { load(page); };
    window.affChangePerPage = function ()    { load(1); };
    window.affFilter       = function ()     { load(1); };
    window.affReset        = function () {
        document.getElementById('filter-referrer').value = '';
        document.getElementById('filter-status').value   = '';
        document.getElementById('per-page-select').value = '15';
        load(1);
    };

    document.addEventListener('DOMContentLoaded', function () { load(1); });
})();
</script>
@endpush
@endsection
