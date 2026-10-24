@extends('admin.layouts.app')
@section('title', 'Refill services')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <div class="card shadow-sm mb-5"><div class="card-body p-5">
        <div class="mb-5 d-flex flex-wrap gap-2">
            @foreach (['All' => 'Tất cả', 'Awaiting' => 'Đang chờ', 'Failed' => 'Thất bại', 'Pending' => 'Chờ xử lý', 'In progress' => 'Đang chạy', 'Completed' => 'Hoàn thành', 'Rejected' => 'Từ chối'] as $value => $label)
                <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-{{ ['Failed'=>'warning','In progress'=>'info','Completed'=>'success','Rejected'=>'danger'][$value] ?? 'secondary' }} px-3 py-1" onclick="_refill_services.on.click.filterStatus('{{ $value }}')" data-lang="status::{{ $value }}">{{ $label }}</a>
            @endforeach
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-lg-2 col-sm-4"><input type="text" class="form-control form-control-solid form-control-sm datatable-input" placeholder="Mã bảo hành" data-col-name="refill_id"></div>
            <div class="col-lg-2 col-sm-4"><input type="text" class="form-control form-control-solid form-control-sm datatable-input" placeholder="Mã đơn hàng" data-col-name="order_id"></div>
            <div class="col-lg-4 col-sm-4"><button class="btn btn-primary btn-sm me-2" onclick="_refill_services.on.click.filter()">Tìm kiếm</button><button class="btn btn-secondary btn-sm" onclick="_refill_services.on.click.resetFilter()">Đặt lại</button></div>
        </div>
    </div></div>
    <div class="card shadow-sm card-orders"><div class="card-body p-5">
        <div class="d-flex align-items-center mb-3">
            <label class="form-check form-check-custom form-check-solid"><input class="form-check-input h-15px w-15px cb-all" type="checkbox" onchange="app_admin.on.change.cbSelectAll(this.checked)"></label>
            <div class="checkall ms-5" style="display:none"><button class="btn btn-light btn-sm" data-kt-menu-trigger="click">Tùy chọn <i class="ki-duotone ki-down fs-5"></i></button><div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-175px py-3" data-kt-menu="true">
                @foreach (['In progress' => 'Đang chạy', 'Completed' => 'Hoàn thành', 'Rejected' => 'Từ chối'] as $value => $label)<div class="menu-item px-3"><a href="javascript:;" class="menu-link px-3" onclick="_refill_services.on.click.actionBulk('Change status', '{{ $value }}')">{{ $label }}</a></div>@endforeach
            </div><label class="ms-3 fs-7"></label></div>
        </div>
        <div class="table-responsive"><table class="table align-middle table-row-dashed fs-7 gy-3"><thead><tr class="text-start text-muted fw-bold text-uppercase">
            <th></th><th>Trạng thái</th><th>Mã bảo hành</th><th>Tài khoản</th><th>Mã đơn hàng</th><th>Ngày tạo</th>
        </tr></thead><tbody></tbody></table></div>
    </div></div>
</div>
@endsection
@push('scripts')
<script>var STATUS_ORDER = @json($statusOrder ?? ''); $(function(){ _refill_services.init(); });</script>
@endpush
