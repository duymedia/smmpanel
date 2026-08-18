@extends('adminpanel.layouts.app')
@section('title', 'Sync Logs')
@section('content')
<style>
.sync-log-cell { min-width: 280px; }
.sync-change-item { display:flex; gap:.75rem; align-items:flex-start; padding:.75rem .875rem; border-radius:.875rem; background:#f8fafc; border:1px solid rgba(82,100,132,.08); margin-bottom:.3rem; }
[data-bs-theme="dark"] .sync-change-item { background:rgba(255,255,255,.04); border-color:rgba(255,255,255,.07); }
.sync-change-item .sync-change-icon { width:2rem; height:2rem; display:inline-flex; align-items:center; justify-content:center; border-radius:999px; flex:0 0 2rem; font-size:.9rem; }
.sync-change-item .sync-change-title { font-weight:600; font-size:.8rem; line-height:1.3; color:#1f2937; }
.sync-change-item .sync-change-note  { color:#6b7280; font-size:.75rem; }
[data-bs-theme="dark"] .sync-change-item .sync-change-title { color:#e5e7eb; }
[data-bs-theme="dark"] .sync-change-item .sync-change-note  { color:#9ca3af; }
.sync-change-item.change-danger  .sync-change-icon { background:rgba(241,65,108,.12);  color:#f1416c; }
.sync-change-item.change-success .sync-change-icon { background:rgba(80,205,137,.14);  color:#50cd89; }
.sync-change-item.change-info    .sync-change-icon { background:rgba(54,153,255,.14);  color:#3699ff; }
.sync-change-item.change-warning .sync-change-icon { background:rgba(255,199,0,.16);   color:#c18a00; }
.sync-change-item.change-dark    .sync-change-icon { background:rgba(24,28,50,.12);    color:#565674; }
[data-bs-theme="dark"] .sync-change-item.change-dark .sync-change-icon { background:rgba(255,255,255,.08); color:#9ca3af; }
</style>
<div class="content flex-row-fluid" id="kt_content">

    {{-- Header --}}
    <div class="d-flex flex-wrap flex-stack mb-5">
        <div class="d-flex align-items-center gap-2">
            <h3 class="fw-bold my-2" data-lang="menu::Sync Logs">Sync Logs</h3>
            <span class="badge badge-danger ms-1" id="unread-badge"
                style="{{ $unreadCount > 0 ? '' : 'display:none' }}">{{ $unreadCount }}</span>
        </div>
        <div class="d-flex my-2">
            <button type="button" class="btn btn-sm btn-light-primary" onclick="markAllRead()">
                <i class="fa-solid fa-check-double me-1"></i>Đánh dấu đã đọc tất cả
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card shadow-sm mb-5">
        <div class="card-body py-3">
            <div class="d-flex flex-wrap align-items-end gap-3">
                <div class="flex-fill" style="min-width:160px">
                    <label class="form-label fs-7 text-muted mb-1">Loại thay đổi</label>
                    <select id="filter-change-type" class="form-select form-select-sm form-select-solid">
                        <option value="">Tất cả</option>
                        <option value="price_increase">↑ Tăng giá</option>
                        <option value="price_decrease">↓ Giảm giá</option>
                        <option value="price_same">= Giá không đổi</option>
                        <option value="min_max_change">Min/Max</option>
                        <option value="enable">Enabled</option>
                        <option value="disable">Disabled</option>
                    </select>
                </div>
                <div class="flex-fill" style="min-width:130px">
                    <label class="form-label fs-7 text-muted mb-1">Trạng thái</label>
                    <select id="filter-is-read" class="form-select form-select-sm form-select-solid">
                        <option value="">Tất cả</option>
                        <option value="0">Chưa đọc</option>
                        <option value="1">Đã đọc</option>
                    </select>
                </div>
                <div class="flex-fill" style="min-width:180px">
                    <label class="form-label fs-7 text-muted mb-1">Nhà cung cấp</label>
                    <select id="filter-provider" class="form-select form-select-sm form-select-solid">
                        <option value="">Tất cả</option>
                        @foreach($providers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-fill" style="min-width:200px">
                    <label class="form-label fs-7 text-muted mb-1">Thời gian</label>
                    <input class="form-control form-control-sm text-center ipt-date" placeholder="Chọn khoảng ngày" readonly>
                </div>
                <div class="d-flex gap-2 pb-1">
                    <button type="button" class="btn btn-sm btn-primary" onclick="applyFilters()">
                        <i class="fa-solid fa-filter me-1"></i>Lọc
                    </button>
                    <button type="button" class="btn btn-sm btn-light-secondary" id="btn-clear-filter" onclick="clearFilter()" style="display:none">
                        <i class="fa-solid fa-xmark me-1"></i>Xóa lọc
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-7 gy-2 mb-0">
                    <thead>
                        <tr class="text-start bg-secondary text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="ps-4 w-25px"></th>
                            <th>Dịch vụ</th>
                            <th class="text-nowrap">Loại</th>
                            <th>Chi tiết thay đổi</th>
                            <th class="text-nowrap">Thời gian</th>
                            <th class="w-30px"></th>
                        </tr>
                    </thead>
                    <tbody id="logs-tbody">
                        @forelse($logs as $log)
                            @php
                                $f     = $log->field_changed ?? '';
                                $isPrice = in_array($log->change_type, ['price_increase','price_decrease','price_same']);
                                $isUp    = $isPrice && ($log->change_type === 'price_increase' || ($log->old_value !== null && $log->new_value !== null && (float)$log->old_value < (float)$log->new_value));
                                $isDown  = $isPrice && ($log->change_type === 'price_decrease' || ($log->old_value !== null && $log->new_value !== null && (float)$log->old_value > (float)$log->new_value));

                                $badgeHtml = match(true) {
                                    $isUp                                              => '<span class="badge badge-light-danger me-1">↑ Price</span>',
                                    $isDown                                            => '<span class="badge badge-light-success me-1">↓ Price</span>',
                                    $log->change_type === 'price_same'                => '<span class="badge badge-light-secondary me-1">= Price</span>',
                                    $log->change_type === 'min_max_change'            => '<span class="badge badge-light-info me-1">Min/Max</span>',
                                    $log->change_type === 'disable' && $f === 'status'=> '<span class="badge badge-danger text-white me-1">Disabled</span>',
                                    $log->change_type === 'disable' && $f === 'cancel'=> '<span class="badge badge-light-warning me-1">Cancel ✕</span>',
                                    $log->change_type === 'disable' && $f === 'refill'=> '<span class="badge badge-light-warning me-1">Refill ✕</span>',
                                    $log->change_type === 'enable'  && $f === 'cancel'=> '<span class="badge badge-light-primary me-1">Cancel ✓</span>',
                                    $log->change_type === 'enable'  && $f === 'refill'=> '<span class="badge badge-light-primary me-1">Refill ✓</span>',
                                    $log->change_type === 'enable'                    => '<span class="badge badge-light-success me-1">Enabled</span>',
                                    default                                           => '<span class="badge badge-light-secondary me-1">Other</span>',
                                };

                                $itemClass = match(true) {
                                    $isUp                                              => 'change-danger',
                                    $isDown                                            => 'change-success',
                                    $log->change_type === 'price_same'                => 'change-warning',
                                    $log->change_type === 'min_max_change'            => 'change-info',
                                    $log->change_type === 'enable'  && $f === 'refill'=> 'change-info',
                                    $log->change_type === 'enable'  && $f === 'cancel'=> 'change-warning',
                                    $log->change_type === 'enable'                    => 'change-success',
                                    $log->change_type === 'disable' && $f === 'status'=> 'change-dark',
                                    $log->change_type === 'disable'                   => 'change-warning',
                                    default                                           => 'change-info',
                                };

                                $biIcon = match(true) {
                                    $isUp                                              => 'bi bi-graph-up-arrow',
                                    $isDown                                            => 'bi bi-graph-down-arrow',
                                    $log->change_type === 'price_same'                => 'bi bi-dash-circle',
                                    $log->change_type === 'min_max_change'            => 'bi bi-distribute-vertical',
                                    $log->change_type === 'enable'  && $f === 'cancel'=> 'bi bi-slash-circle',
                                    $log->change_type === 'enable'  && $f === 'refill'=> 'bi bi-arrow-repeat',
                                    $log->change_type === 'enable'                    => 'bi bi-check-circle-fill',
                                    $log->change_type === 'disable' && $f === 'status'=> 'bi bi-pause-circle',
                                    $log->change_type === 'disable' && $f === 'cancel'=> 'bi bi-slash-circle',
                                    $log->change_type === 'disable' && $f === 'refill'=> 'bi bi-arrow-repeat',
                                    $log->change_type === 'disable'                   => 'bi bi-x-circle',
                                    default                                           => 'bi bi-arrow-left-right',
                                };

                                $changeTitle = match(true) {
                                    $isUp                                              => 'Price increase',
                                    $isDown                                            => 'Price decrease',
                                    $log->change_type === 'price_same'                => 'Price unchanged',
                                    $log->change_type === 'min_max_change'            => ucfirst($f ?: 'Min/Max') . ' change',
                                    $log->change_type === 'disable' && $f === 'status'=> 'DISABLED',
                                    $log->change_type === 'disable' && $f === 'cancel'=> 'Cancel disabled',
                                    $log->change_type === 'disable' && $f === 'refill'=> 'Refill disabled',
                                    $log->change_type === 'enable'  && $f === 'cancel'=> 'Cancel enabled',
                                    $log->change_type === 'enable'  && $f === 'refill'=> 'Refill enabled',
                                    default                                           => ucfirst(str_replace('_', ' ', $log->change_type)),
                                };

                                // Note mô tả thêm cho từng loại
                                $changeNote = match(true) {
                                    $log->change_type === 'disable' && $f === 'status'
                                        => 'DISABLED Service ' . ($log->service_api ?? '') . ' of provider: ' . ($log->provider_name ?? ''),
                                    $log->change_type === 'disable' && $f === 'cancel' => 'Cancel = 0',
                                    $log->change_type === 'disable' && $f === 'refill' => 'Refill = 0',
                                    $log->change_type === 'enable'  && $f === 'cancel' => 'Cancel = 1',
                                    $log->change_type === 'enable'  && $f === 'refill' => 'Refill = 1',
                                    default => null,
                                };

                                $fmt = fn($v) => is_numeric($v) ? rtrim(rtrim(number_format((float)$v, 6, '.', ''), '0'), '.') : $v;
                            @endphp
                            <tr class="{{ $log->is_read ? '' : 'bg-light-primary' }}" id="log-row-{{ $log->id }}">
                                <td class="ps-4">
                                    @if ($log->is_read)
                                        <i class="fa-solid fa-circle-check text-primary fs-9"></i>
                                    @else
                                        <i class="fa-solid fa-circle text-warning fs-9"></i>
                                    @endif
                                </td>
                                <td>
                                    <a class="text-gray-700 text-hover-primary fw-semibold" target="_blank"
                                        href="/admin/services/edit?id={{ $log->service_id }}">
                                        <strong>#{{ $log->service_id }}</strong>
                                        @if ($log->service_api)
                                            <span class="text-muted">| SID {{ $log->service_api }}</span>
                                        @endif
                                    </a>
                                    @if ($log->service)
                                        <p class="m-0 text-muted fs-8">{{ $log->service->getName() }}</p>
                                    @endif
                                </td>
                                <td class="text-nowrap">{!! $badgeHtml !!}</td>
                                <td class="sync-log-cell">
                                    <div class="sync-change-item {{ $itemClass }}">
                                        <span class="sync-change-icon"><i class="{{ $biIcon }}"></i></span>
                                        <div>
                                            <div class="sync-change-title">{{ $changeTitle }}</div>
                                            @if ($changeNote)
                                                <div class="sync-change-note">{{ $changeNote }}</div>
                                            @elseif ($log->old_value !== null && $log->new_value !== null)
                                                <div class="sync-change-note">From {{ $fmt($log->old_value) }} to {{ $fmt($log->new_value) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap text-muted fs-8">
                                    <div>{{ $log->created_at->format('Y-m-d H:i:s') }}</div>
                                    @if ($log->is_read)
                                        <div class="badge badge-light-success mt-2">Reviewed</div>
                                    @endif
                                </td>
                                <td class="pe-4" id="log-action-{{ $log->id }}">
                                    @if (!$log->is_read)
                                        <button type="button"
                                            class="btn btn-icon btn-light-primary btn-circle btn-sm w-25px h-25px"
                                            onclick="markOneRead({{ $log->id }})" title="Đánh dấu đã đọc">
                                            <i class="fa-solid fa-check fs-8"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-10">
                                    <i class="fa-solid fa-inbox fs-2x mb-3 d-block opacity-50"></i>
                                    <span>Không có dữ liệu đồng bộ nào</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center py-3" id="logs-footer"
            style="{{ $logs->hasPages() || $logs->total() > 0 ? '' : 'display:none' }}">
            <span class="text-muted fs-7" id="logs-info">
                Hiển thị {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }} / {{ $logs->total() }} bản ghi
            </span>
            <div id="logs-pagination"></div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    initDatePicker();
});

function initDatePicker() {
    if (window.jQuery?.fn?.daterangepicker && window.moment) {
        jQuery(function ($) {
            if ($.fn.select2) {
                $('#filter-change-type, #filter-is-read').select2({ minimumResultsForSearch: Infinity, width: '100%' });
                $('#filter-provider').select2({ width: '100%' });
            }
            $('.ipt-date').daterangepicker({ autoUpdateInput: false, locale: { format: 'YYYY/MM/DD', separator: ' - ', applyLabel: 'Áp dụng', cancelLabel: 'Hủy' } });
            $('.ipt-date').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
            });
            $('.ipt-date').on('cancel.daterangepicker', function () { $(this).val(''); });
        });
    } else {
        setTimeout(initDatePicker, 100);
    }
}

var _currentPage = 1, _activeFilters = { log_type: 'api' };

function applyFilters() {
    const dateRange = jQuery('.ipt-date').val();
    _activeFilters = { log_type: 'api' }; // luôn filter type = api
    if (dateRange) {
        const p = dateRange.split(' - ');
        if (p.length === 2) { _activeFilters.start_date = p[0]; _activeFilters.end_date = p[1]; }
    }
    const ct = jQuery('#filter-change-type').val();
    const ir = jQuery('#filter-is-read').val();
    const pv = jQuery('#filter-provider').val();
    if (ct) _activeFilters.change_type = ct;
    if (ir !== '') _activeFilters.is_read = ir;
    if (pv) _activeFilters.provider_id = pv;
    document.getElementById('btn-clear-filter').style.display = Object.keys(_activeFilters).length ? '' : 'none';
    loadData(1);
}

function clearFilter() {
    jQuery('#filter-change-type, #filter-is-read, #filter-provider').val(null).trigger('change');
    jQuery('.ipt-date').val('');
    document.getElementById('btn-clear-filter').style.display = 'none';
    _activeFilters = { log_type: 'api' };
    loadData(1);
}

function loadData(page) {
    _currentPage = page || _currentPage;
    showFullScreenLoader();
    $.ajax({
        url: '/admin/service_sync_logs/data',
        type: 'GET',
        data: Object.assign({}, _activeFilters, { page: _currentPage }),
        dataType: 'json',
        success: function (r) { updateTable(r.items); updatePagination(r); updateUnreadBadge(r.unreadCount); hideFullScreenLoader(); },
        error: function () { hideFullScreenLoader(); }
    });
}

function fmtVal(v) {
    if (v === null || v === undefined) return '';
    const n = parseFloat(v);
    return isNaN(n) ? v : parseFloat(n.toFixed(6)).toString();
}

const changeMap = {
    price_increase: { cls:'change-danger',  icon:'bi bi-graph-up-arrow',      badge:'<span class="badge badge-light-danger">↑ Price</span>',    title:'Price increase'  },
    price_decrease: { cls:'change-success', icon:'bi bi-graph-down-arrow',    badge:'<span class="badge badge-light-success">↓ Price</span>',   title:'Price decrease'  },
    price_same:     { cls:'change-warning', icon:'bi bi-dash-circle',         badge:'<span class="badge badge-light-secondary">= Price</span>', title:'Price unchanged' },
    min_max_change: { cls:'change-info',    icon:'bi bi-distribute-vertical', badge:'<span class="badge badge-light-info">Min/Max</span>',      title:null              },
};

function buildChangeCell(log) {
    const m = changeMap[log.change_type];
    const f = log.field_changed || '';
    const oldV = parseFloat(log.old_value);
    const newV = parseFloat(log.new_value);
    const hasValues = !isNaN(oldV) && !isNaN(newV);

    // Ưu tiên so sánh old/new để xác định tăng/giảm
    let effectiveType = log.change_type;
    if (log.change_type === 'price_same' && hasValues) {
        if (oldV < newV) effectiveType = 'price_increase';
        else if (oldV > newV) effectiveType = 'price_decrease';
    }

    let badge, title, cls, icon;
    const em = changeMap[effectiveType];

    if (em) {
        badge = em.badge; title = em.title; cls = em.cls; icon = em.icon;
        if (!title) title = (f ? f.charAt(0).toUpperCase() + f.slice(1) : 'Min/Max') + ' change';
    } else if (log.change_type === 'disable') {
        cls = f === 'status' ? 'change-dark' : 'change-warning';
        if      (f === 'status') { icon = 'bi bi-pause-circle';  badge = '<span class="badge badge-danger text-white">Disabled</span>';  title = 'DISABLED'; }
        else if (f === 'cancel') { icon = 'bi bi-slash-circle';  badge = '<span class="badge badge-light-warning">Cancel ✕</span>';      title = 'Cancel disabled'; }
        else if (f === 'refill') { icon = 'bi bi-arrow-repeat';  badge = '<span class="badge badge-light-warning">Refill ✕</span>';      title = 'Refill disabled'; }
        else                     { icon = 'bi bi-x-circle';      badge = '<span class="badge badge-danger text-white">Disabled</span>';  title = 'Disabled'; }
    } else if (log.change_type === 'enable') {
        cls = 'change-success';
        if      (f === 'cancel') { icon = 'bi bi-slash-circle';  badge = '<span class="badge badge-light-primary">Cancel ✓</span>';      title = 'Cancel enabled'; cls = 'change-warning'; }
        else if (f === 'refill') { icon = 'bi bi-arrow-repeat';  badge = '<span class="badge badge-light-primary">Refill ✓</span>';      title = 'Refill enabled'; cls = 'change-info'; }
        else                     { icon = 'bi bi-check-circle-fill'; badge = '<span class="badge badge-light-success">Enabled</span>';   title = 'Enabled'; }
    } else {
        icon = 'bi bi-arrow-left-right'; cls = 'change-info';
        badge = '<span class="badge badge-light-secondary">Other</span>';
        title = (f || log.change_type || '').replace(/_/g, ' ').replace(/^\w/, c => c.toUpperCase());
    }

    // Note mô tả thêm
    let note = '';
    if (log.change_type === 'disable' && f === 'status') {
        note = '<div class="sync-change-note">DISABLED Service ' + (log.service_api || '') + ' of provider: ' + (log.provider_name || '') + '</div>';
    } else if (log.change_type === 'disable' && f === 'cancel') {
        note = '<div class="sync-change-note">Cancel = 0</div>';
    } else if (log.change_type === 'disable' && f === 'refill') {
        note = '<div class="sync-change-note">Refill = 0</div>';
    } else if (log.change_type === 'enable' && f === 'cancel') {
        note = '<div class="sync-change-note">Cancel = 1</div>';
    } else if (log.change_type === 'enable' && f === 'refill') {
        note = '<div class="sync-change-note">Refill = 1</div>';
    } else if (hasValues) {
        note = '<div class="sync-change-note">From ' + fmtVal(log.old_value) + ' to ' + fmtVal(log.new_value) + '</div>';
    }

    return badge + '||'
        + '<div class="sync-change-item ' + cls + '">'
        + '<span class="sync-change-icon"><i class="' + icon + '"></i></span>'
        + '<div><div class="sync-change-title">' + title + '</div>' + note + '</div>'
        + '</div>';
}

function updateTable(items) {
    const tbody = $('#logs-tbody');
    tbody.empty();
    if (!items || !items.length) {
        tbody.html('<tr><td colspan="6" class="text-center text-muted py-10"><i class="fa-solid fa-inbox fs-2x mb-3 d-block opacity-50"></i>Không có dữ liệu</td></tr>');
        return;
    }
    items.forEach(function (log) {
        const readIcon = log.is_read
            ? '<i class="fa-solid fa-circle-check text-primary fs-9"></i>'
            : '<i class="fa-solid fa-circle text-warning fs-9"></i>';
        const parts = buildChangeCell(log).split('||');
        const svcLink = '<a class="text-gray-700 text-hover-primary fw-semibold" target="_blank" href="/admin/services/edit?id=' + log.service_id + '">'
            + '<strong>#' + log.service_id + '</strong>'
            + (log.service_api ? ' <span class="text-muted">| SID ' + log.service_api + '</span>' : '')
            + '</a>'
            + (log.service_name ? '<p class="m-0 text-muted fs-8">' + log.service_name + '</p>' : '');
        const timeHtml = '<div>' + log.created_at + '</div>'
            + (log.is_read ? '<div class="badge badge-light-success mt-2">Reviewed</div>' : '');
        const actionBtn = !log.is_read
            ? '<button type="button" class="btn btn-icon btn-light-primary btn-circle btn-sm w-25px h-25px" onclick="markOneRead(' + log.id + ')" title="Đánh dấu đã đọc"><i class="fa-solid fa-check fs-8"></i></button>'
            : '';
        tbody.append(
            '<tr class="' + (log.is_read ? '' : 'bg-light-primary') + '" id="log-row-' + log.id + '">'
            + '<td class="ps-4">' + readIcon + '</td>'
            + '<td>' + svcLink + '</td>'
            + '<td class="text-nowrap">' + parts[0] + '</td>'
            + '<td class="sync-log-cell">' + parts[1] + '</td>'
            + '<td class="text-nowrap text-muted fs-8">' + timeHtml + '</td>'
            + '<td class="pe-4" id="log-action-' + log.id + '">' + actionBtn + '</td>'
            + '</tr>'
        );
    });
}

function updatePagination(data) {
    const footer = document.getElementById('logs-footer');
    const info   = document.getElementById('logs-info');
    const pager  = document.getElementById('logs-pagination');
    if (!data.total) { footer.style.display = 'none'; return; }
    footer.style.display = '';
    info.textContent = 'Hiển thị ' + (data.from || 0) + '–' + (data.to || 0) + ' / ' + data.total + ' bản ghi';
    if (data.last_page <= 1) { pager.innerHTML = ''; return; }
    let html = '<nav><ul class="pagination pagination-sm mb-0">';
    html += '<li class="page-item' + (data.current_page <= 1 ? ' disabled' : '') + '"><a class="page-link" href="javascript:;" onclick="loadData(' + (data.current_page - 1) + ')">‹</a></li>';
    for (let p = 1; p <= data.last_page; p++) {
        if (p === 1 || p === data.last_page || Math.abs(p - data.current_page) <= 2)
            html += '<li class="page-item' + (p === data.current_page ? ' active' : '') + '"><a class="page-link" href="javascript:;" onclick="loadData(' + p + ')">' + p + '</a></li>';
        else if (Math.abs(p - data.current_page) === 3)
            html += '<li class="page-item disabled"><span class="page-link">…</span></li>';
    }
    html += '<li class="page-item' + (data.current_page >= data.last_page ? ' disabled' : '') + '"><a class="page-link" href="javascript:;" onclick="loadData(' + (data.current_page + 1) + ')">›</a></li>';
    html += '</ul></nav>';
    pager.innerHTML = html;
    _currentPage = data.current_page;
}

function updateUnreadBadge(count) {
    const badge = document.getElementById('unread-badge');
    if (count > 0) { badge.textContent = count; badge.style.display = ''; }
    else badge.style.display = 'none';
}

function markOneRead(id) {
    $.post('/admin/service_sync_logs/' + id + '/mark-read', { _token: document.querySelector('meta[name="csrf-token"]').content },
        function (data) {
            if (!data.success) return;
            const row = document.getElementById('log-row-' + id);
            if (row) { row.classList.remove('bg-light-primary'); row.querySelector('td:first-child i').className = 'fa-solid fa-circle-check text-primary fs-9'; }
            const action = document.getElementById('log-action-' + id);
            if (action) action.innerHTML = '';
            const cur = parseInt(document.getElementById('unread-badge').textContent) || 0;
            updateUnreadBadge(Math.max(0, cur - 1));
        }
    );
}

function markAllRead() {
    showFullScreenLoader();
    $.post('/admin/service_sync_logs/mark-read', { _token: document.querySelector('meta[name="csrf-token"]').content },
        function (data) { hideFullScreenLoader(); if (data.success) { updateUnreadBadge(0); loadData(_currentPage); } }
    ).fail(function () { hideFullScreenLoader(); });
}
</script>
@endsection
