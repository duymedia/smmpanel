@extends('admin.layouts.app')

@section('title', 'Child Panels')

@section('content')

@push('styles')
<style>
    .child-panels-page { --cp-navy: #132d55; --cp-border: #e9eef5; }
    .child-panels-hero { position: relative; overflow: hidden; border: 0; border-radius: 1rem; background: linear-gradient(120deg, #132d55 0%, #1e4f91 62%, #2876c7 100%); box-shadow: 0 10px 25px rgba(18, 52, 93, .12); }
    .child-panels-hero::after { content: ''; position: absolute; width: 230px; height: 230px; right: -55px; top: -95px; border: 22px solid rgba(255,255,255,.08); border-radius: 50%; }
    .child-panels-hero .symbol { background: rgba(255,255,255,.14) !important; }
    .child-panels-hero .hero-copy { position: relative; z-index: 1; }
    .child-panels-hero h2 { color: #fff; letter-spacing: -.025em; }
    .child-panels-hero p { color: rgba(255,255,255,.72); }
    .child-panel-stat { border: 1px solid var(--cp-border); border-radius: .85rem; box-shadow: 0 3px 12px rgba(16, 42, 86, .035); transition: transform .18s ease, box-shadow .18s ease; }
    .child-panel-stat:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(16, 42, 86, .08); }
    .child-panel-stat .card-body { padding: 1.1rem 1.15rem; }
    .child-panel-stat .fs-2 { color: var(--cp-navy); line-height: 1.2; }
    .child-panel-filter, .child-panel-list-card { border: 1px solid var(--cp-border); border-radius: .85rem; overflow: hidden; box-shadow: 0 3px 12px rgba(16, 42, 86, .035) !important; }
    .child-panel-list-header { min-height: 68px; padding: 1rem 1.5rem !important; background: #fff; }
    .child-panel-list-header h3 { color: #102a56; font-size: 1.05rem; letter-spacing: -.01em; }
    .child-panel-list-header .badge { font-size: .7rem; font-weight: 600; }
    .child-panel-table { min-width: 1080px; margin-bottom: 0; }
    .child-panel-table thead th { padding: .75rem .85rem; font-size: .66rem; letter-spacing: .04em; white-space: nowrap; background: #f8fafd; color: #8793aa; border-bottom: 1px solid #edf0f5; }
    .child-panel-table tbody td { padding: .9rem .85rem; border-bottom: 1px solid #f0f2f6; }
    .child-panel-table tbody tr:last-child td { border-bottom: 0; }
    .child-panel-table tbody tr:hover { background: #fbfdff; }
    .child-panel-table .child-panel-domain { min-width: 220px; }
    .child-panel-table .child-panel-metric { min-width: 145px; }
    .child-panel-table .child-panel-actions { width: 118px; }
    .child-panel-chip { display: inline-flex; align-items: center; gap: .25rem; padding: .2rem .45rem; border-radius: .45rem; font-size: .7rem; font-weight: 600; white-space: nowrap; }
    .child-panel-id { color: var(--bs-gray-500); font: .72rem ui-monospace, SFMono-Regular, Menlo, monospace; }
    .child-panel-actions .btn { width: 30px; height: 30px; }
    .child-panel-toggle { width: 2.4rem !important; height: 1.25rem !important; cursor: pointer; }
    .child-panel-status-wrap { min-width: 108px; }
    .child-panel-modal .modal-dialog { max-width: 520px; }
    #modal-child-panel-access .modal-dialog { max-width: 760px; }
    .child-panel-modal .modal-title { font-size: 1.05rem; }
    #modal-child-panel-access .modal-content { max-height: calc(100vh - 2rem); border-radius: 1rem; overflow: hidden; }
    #modal-child-panel-access .modal-dialog { width: calc(100% - 1rem); margin: .5rem auto; }
    #modal-child-panel-access .modal-header { padding: 1rem 1.25rem; background: linear-gradient(135deg, #eff6ff, #f8fafc); }
    #modal-child-panel-access .modal-body { padding: 1rem 1.25rem; overflow: hidden; }
    #modal-child-panel-access .modal-footer { padding: .75rem 1.25rem; }
    .access-summary { display: flex; align-items: center; gap: .65rem; padding: .65rem .75rem; margin-bottom: .85rem; border: 1px solid var(--bs-gray-200); border-radius: .65rem; background: var(--bs-gray-100); }
    .access-summary .symbol { width: 32px; height: 32px; }
    .access-summary-title { font-size: .72rem; color: var(--bs-gray-500); }
    .access-summary-domain { max-width: 430px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-weight: 700; }
    .child-panel-access-option { min-height: 62px; padding: .65rem .75rem; border-radius: .65rem; }
    .child-panel-access-option .form-check-label { font-size: .82rem; }
    .child-panel-access-option .text-muted { font-size: .72rem; }
    .child-panel-access-list { margin-left: -.35rem; margin-right: -.35rem; max-height: min(300px, 42vh); overflow-y: auto; padding: .1rem .35rem .35rem; }
    .child-panel-access-page { display: flex; box-sizing: border-box; padding: .55rem .65rem !important; min-height: 52px; border: 1px solid var(--bs-gray-200); border-radius: .55rem !important; background: var(--bs-gray-100); cursor: pointer; }
    .child-panel-access-page:hover { border-color: var(--bs-primary); background: #fff; }
    .child-panel-access-page:has(input:checked) { border-color: var(--bs-primary); background: rgba(37, 99, 235, .06); }
    .child-panel-access-page .fw-bold { font-size: .76rem; }
    .child-panel-access-page .text-muted { font-size: .68rem; }
    .child-panel-list-card .pagination { margin: 1rem 1.25rem 1.25rem; }
    .child-panel-filter .form-label { margin-bottom: .45rem; color: #51627b; font-size: .75rem; font-weight: 700; }
    .child-panel-filter .form-control, .child-panel-filter .form-select { min-height: 42px; }
    @media (max-width: 767.98px) { .child-panel-list-header { padding: 1rem !important; } .child-panel-list-header .card-toolbar { width: 100%; margin-top: .5rem; } .child-panel-list-header .card-toolbar .badge { width: 100%; text-align: left; } }
    @media (max-width: 575.98px) { #modal-child-panel-access .modal-dialog { margin: .5rem; } .access-summary-domain { max-width: 220px; } .child-panels-hero .card-body { padding: 1.25rem !important; } }
</style>
@endpush

<div class="content flex-row-fluid child-panels-page" id="kt_content">

    <div class="child-panels-hero mb-5">
        <div class="card-body p-5 p-lg-6 d-flex align-items-center gap-4">
            <span class="symbol symbol-55px flex-shrink-0"><i class="ki-duotone ki-share fs-1 text-white"><span class="path1"></span><span class="path2"></span></i></span>
            <div class="hero-copy">
                <h2 class="mb-1 fs-2">Quản lý panel con</h2>
                <p class="mb-0 fs-7">Theo dõi, phân quyền và cập nhật trạng thái các hệ thống trực thuộc.</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-sm-6 col-xl-3"><div class="card child-panel-stat h-100"><div class="card-body d-flex align-items-center gap-3"><span class="symbol symbol-40px bg-light-primary"><i class="ki-duotone ki-share fs-2 text-primary"><span class="path1"></span><span class="path2"></span></i></span><div><div class="text-muted fs-9">Tổng panel</div><div class="fs-2 fw-bold">{{ number_format($childPanels->total()) }}</div></div></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card child-panel-stat h-100"><div class="card-body d-flex align-items-center gap-3"><span class="symbol symbol-40px bg-light-success"><i class="ki-duotone ki-check-circle fs-2 text-success"><span class="path1"></span><span class="path2"></span></i></span><div><div class="text-muted fs-9">Hoạt động</div><div class="fs-2 fw-bold">{{ number_format($childPanels->getCollection()->where('status', 'completed')->count()) }}</div></div></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card child-panel-stat h-100"><div class="card-body d-flex align-items-center gap-3"><span class="symbol symbol-40px bg-light-warning"><i class="ki-duotone ki-time fs-2 text-warning"><span class="path1"></span><span class="path2"></span></i></span><div><div class="text-muted fs-9">Chờ duyệt</div><div class="fs-2 fw-bold">{{ number_format($childPanels->getCollection()->where('status', 'pending')->count()) }}</div></div></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card child-panel-stat h-100"><div class="card-body d-flex align-items-center gap-3"><span class="symbol symbol-40px bg-light-info"><i class="ki-duotone ki-abstract-26 fs-2 text-info"><span class="path1"></span><span class="path2"></span></i></span><div><div class="text-muted fs-9">Trang này</div><div class="fs-2 fw-bold">{{ number_format($childPanels->count()) }}</div></div></div></div></div>
    </div>

    <div class="card child-panel-filter shadow-sm mb-5">
        <div class="card-header border-0 pt-6">
            <div class="card-title d-flex flex-column">
                <h3 class="mb-1" data-lang="Filter">Bộ lọc</h3>
                <span class="text-muted fs-8">
                    Domain hiện tại: <span class="fw-bold text-gray-800">{{ $currentDomain }}</span>
                </span>
            </div>
        </div>
        <form method="GET" class="card-body pt-0" id="form-child-panel-filter">
            <div class="row g-4 align-items-end">
                <div class="col-md-4">
                    <label class="form-label" data-lang="Domain">Domain</label>
                    <input class="form-control form-control-solid" name="domain" value="{{ request('domain') }}" placeholder="child.example.com">
                </div>
                <div class="col-md-3">
                    <label class="form-label" data-lang="Status">Trạng thái</label>
                    <select class="form-select form-select-solid sl-status" name="status" data-control="select2" data-hide-search="true" data-placeholder="Tất cả">
                        <option value="" data-lang="All">Tất cả</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status) data-lang="{{ ucfirst($status) }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" data-lang="Owner">Chủ sở hữu</label>
                    <select class="form-select form-select-solid sl-user" name="user_id" data-control="select2" data-placeholder="Tất cả">
                        <option value="" data-lang="All">Tất cả</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected((string) request('user_id') === (string) $user->id)>{{ $user->name ?: $user->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1" data-lang="Filter">Lọc</button>
                    <a href="{{ route('admin.child-panels.index') }}" class="btn btn-light" data-lang="Clear">Xóa</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card shadow-sm border-0 child-panel-list-card">
        <div class="card-header border-0 child-panel-list-header align-items-center">
            <div class="card-title">
                <h3 class="mb-0 d-flex align-items-center gap-2">
                    <span class="symbol symbol-30px bg-light-primary"><i class="ki-duotone ki-grid fs-2 text-primary"><span class="path1"></span><span class="path2"></span></i></span>
                    <span data-lang="List of child panels">Danh sách hệ thống panel con</span>
                    <span class="badge badge-light-primary">{{ $childPanels->total() }}</span>
                </h3>
            </div>
            <div class="card-toolbar">
                <span class="badge badge-light-secondary text-gray-700"><i class="ki-duotone ki-refresh fs-6"><span class="path1"></span><span class="path2"></span></i> <span data-lang="Updated per panel">Cập nhật theo panel</span></span>
            </div>
        </div>
        <div class="card-body pt-0 table-responsive">
            <table class="table child-panel-table align-middle table-row-dashed fs-7 gy-4">
                <thead>
                    <tr class="text-muted fw-bold text-uppercase">
                        <th data-lang="ID">ID</th>
                        <th data-lang="System tree">Cây hệ thống</th>
                        <th data-lang="Owner">Chủ sở hữu</th>
                        <th data-lang="Price">Giá panel</th>
                        <th data-lang="Summary">Tổng quan</th>
                        <th data-lang="Status">Trạng thái</th>
                        <th data-lang="Created">Ngày tháng</th>
                        <th class="text-end" data-lang="Actions">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($childPanels as $panel)
                    <tr class="row-panel-{{ $panel->id }}" data-id="{{ $panel->id }}">
                        <td><span class="child-panel-id">#{{ $panel->id }}</span></td>
                        <td class="child-panel-domain">
                            <div class="d-flex align-items-center gap-2">
                                <span class="symbol symbol-34px symbol-circle bg-light-primary flex-shrink-0"><i class="ki-duotone ki-share fs-2 text-primary"><span class="path1"></span><span class="path2"></span></i></span>
                                <div>
                                    <a href="{{ $panel->full_url }}" target="_blank" class="fw-semibold text-gray-900 text-hover-primary d-block mb-1 text-truncate" style="max-width: 190px">{{ $panel->domain_panel }}</a>
                                    <div class="d-flex flex-wrap align-items-center gap-1">
                                        <span class="badge badge-sm badge-light-{{ $panel->is_current_domain ? 'success' : 'secondary' }}" data-lang="{{ $panel->is_current_domain ? 'Current site' : 'Main site' }}">{{ $panel->is_current_domain ? 'Trang hiện tại' : 'Web mẹ' }}</span>
                                        @if($panel->access === 'grandchild')
                                            <span class="badge badge-sm badge-light-warning">Cháu</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($panel->user)
                                <div class="d-flex align-items-center gap-2">
                                    <span class="symbol symbol-22px symbol-circle bg-light-info flex-shrink-0"><i class="ki-duotone ki-profile-circle fs-6 text-info"><span class="path1"></span><span class="path2"></span></i></span>
                                    <span class="fw-semibold text-truncate d-inline-block" style="max-width: 150px">{{ $panel->user->name ?: $panel->user->email }}</span>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-gray-900">{{ number_format((float) $panel->price, 2, ',', '.') }}</span>
                            <span class="text-muted ms-1 fs-8">USD</span>
                        </td>
                        <td class="child-panel-metric">
                            <div class="d-flex flex-wrap gap-2">
                                <span class="child-panel-chip bg-light-primary text-primary" title="Dịch vụ"><i class="ki-duotone ki-abstract-26 fs-7"><span class="path1"></span><span class="path2"></span></i>{{ number_format($panel->total_services) }}</span>
                                <span class="child-panel-chip bg-light-success text-success" title="Đơn hàng"><i class="ki-duotone ki-basket fs-7"><span class="path1"></span><span class="path2"></span></i>{{ number_format($panel->total_orders) }}</span>
                                <span class="child-panel-chip bg-light-info text-info" title="Người dùng"><i class="ki-duotone ki-profile-user fs-7"><span class="path1"></span><span class="path2"></span></i>{{ number_format($panel->total_users) }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 child-panel-status-wrap">
                                <input class="form-check-input child-panel-toggle js-panel-status-toggle" type="checkbox"
                                    data-id="{{ $panel->id }}" data-status="{{ $panel->status }}"
                                    @checked($panel->status === 'completed')
                                    aria-label="Bật/tắt trạng thái panel {{ $panel->domain_panel }}">
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column gap-1 fs-8">
                                <span class="text-muted"><i class="ki-duotone ki-calendar text-gray-500"><span class="path1"></span><span class="path2"></span></i> {{ $panel->created_at?->format('d/m/Y') ?: '-' }}</span>
                                <span class="text-muted"><i class="ki-duotone ki-refresh text-gray-500"><span class="path1"></span><span class="path2"></span></i> {{ $panel->updated_at?->format('d/m/Y H:i') ?: '-' }}</span>
                                <span class="{{ $panel->is_expired ? 'text-danger fw-bold' : 'text-muted' }}"><i class="ki-duotone ki-clock text-{{ $panel->is_expired ? 'danger' : 'gray-500' }}"><span class="path1"></span><span class="path2"></span></i> {{ $panel->expires_at ? ($panel->is_expired ? 'Hết hạn' : 'Còn ' . number_format(max(0, (int) floor(now()->diffInDays($panel->expires_at, false)))) . ' ngày') : 'Vô hạn' }}</span>
                            </div>
                        </td>
                        <td class="child-panel-actions text-end text-nowrap">
                            <div class="d-inline-flex gap-1">
                            <button type="button" class="btn btn-icon btn-light-primary js-panel-edit"
                                data-id="{{ $panel->id }}"
                                data-domain-panel="{{ $panel->domain_panel }}"
                                data-price="{{ (float) $panel->price }}"
                                data-status="{{ $panel->status }}"
                                data-user-id="{{ $panel->user_id }}"
                                data-expires-at="{{ $panel->expires_at?->format('Y-m-d H:i') }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Chỉnh sửa" data-lang-title="Edit">
                                <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Phân quyền" data-lang-title="Permission"><button type="button" class="btn btn-icon btn-light-info js-panel-access"
                                data-id="{{ $panel->id }}"
                                data-domain-panel="{{ $panel->domain_panel }}"
                                data-access-all="{{ $panel->is_access_all ? 1 : 0 }}"
                                data-access="{{ implode(',', $panel->access_list) }}"><i class="ki-duotone ki-shield-tick fs-3"><span class="path1"></span><span class="path2"></span></i></button></span>
                            <button type="button" class="btn btn-icon btn-light-danger js-panel-delete"
                                data-id="{{ $panel->id }}"
                                data-domain-panel="{{ $panel->domain_panel }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Xóa" data-lang-title="Delete">
                                <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-10" data-lang="No child panel found">Chưa có child panel.</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $childPanels->links() }}
        </div>
    </div>

    <div class="modal fade child-panel-modal" id="modal-child-panel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" data-lang="Edit child panel">Chỉnh sửa panel con</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form class="child-panel-form" id="form-child-panel">
                    <div class="modal-body">
                        <input type="hidden" class="ipt-id">
                        <div class="mb-4 p-4 rounded bg-light-primary border border-primary border-opacity-25">
                            <label class="form-label" data-lang="Domain">Domain</label>
                            <input type="text" class="form-control form-control-solid ipt-domain-panel" readonly>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" data-lang="Owner">Chủ sở hữu</label>
                            <select class="form-select form-select-solid sl-user" data-control="select2" data-dropdown-parent="#modal-child-panel" data-placeholder="Chọn tài khoản">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name ?: $user->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" data-lang="Price">Giá panel</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text">$</span>
                                <input type="number" min="0" step="0.01" class="form-control ipt-price">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" data-lang="Status">Trạng thái</label>
                            <select class="form-select form-select-solid sl-status" data-control="select2" data-hide-search="true" data-dropdown-parent="#modal-child-panel">
                                <option value="pending" data-lang="Pending">Pending</option>
                                <option value="completed" data-lang="Completed">Completed</option>
                                <option value="suspended" data-lang="Suspended">Suspended</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label" data-lang="Expires at">Ngày hết hạn</label>
                            <input type="text" class="form-control form-control-solid ipt-expires-at" placeholder="YYYY-MM-DD HH:mm">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" data-lang="Close">Đóng</button>
                        <button type="button" class="btn btn-primary js-panel-save" data-lang="Save">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade child-panel-modal" id="modal-child-panel-access" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"><div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><span data-lang="Permission">Phân quyền</span></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form class="access-form" id="form-child-panel-access" data-panel="">
                <div class="modal-body">
                    <div class="access-summary">
                        <span class="symbol symbol-32px bg-light-primary"><i class="ki-duotone ki-shield-tick fs-4 text-primary"><span class="path1"></span><span class="path2"></span></i></span>
                        <div class="min-width-0">
                            <div class="access-summary-title">Panel</div>
                            <div class="access-summary-domain js-access-domain-panel"></div>
                        </div>
                    </div>
                    <div class="row g-2 mb-4">
                        <div class="col-md-6"><label class="child-panel-access-option d-flex align-items-start gap-3 h-100">
                            <input class="form-check-input access-all" type="checkbox">
                            <span><span class="form-check-label fw-bold d-block">ALL · Toàn quyền</span><span class="text-muted">Mở toàn bộ trang quản trị.</span></span>
                        </label></div>
                        <div class="col-md-6"><label class="child-panel-access-option d-flex align-items-start gap-3 h-100">
                            <input class="form-check-input access-child" type="checkbox">
                            <span><span class="form-check-label fw-bold d-block">Child · Gói cơ bản</span><span class="text-muted">Chỉ mở quyền theo navbar.</span></span>
                        </label></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="child-panel-section-title">Quyền truy cập</span>
                        <span class="badge badge-light-primary">{{ count($accessPages) }} trang</span>
                    </div>
                    <div class="row g-2 child-panel-access-list">
                    @foreach($accessPages as $key => $label)
                        <div class="col-md-6"><label class="child-panel-access-page w-100 d-flex align-items-center gap-2"><input class="form-check-input access-page" type="checkbox" value="{{ $key }}" data-key="{{ $key }}"><span><span class="fw-bold d-block">{{ $label }}</span><span class="text-muted fs-8">/admin/{{ $key }}</span></span></label></div>
                    @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" data-lang="Close">Hủy</button>
                    <button class="btn btn-primary btn-sm js-panel-access-save" type="button" data-lang="Save">Lưu quyền</button>
                </div>
            </form>
        </div></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    if (typeof _child_panels !== 'undefined' && typeof _child_panels.init === 'function') {
        _child_panels.init();
    }
</script>
@endpush
