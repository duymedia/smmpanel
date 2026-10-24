@extends('admin.layouts.app')
@section('title', 'Cancel services')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <div class="card shadow-sm mb-5"><div class="card-body p-5">
        <div class="mb-5 d-flex flex-wrap gap-2">
            @foreach (['All' => 'Tất cả', 'Pending' => 'Chờ xử lý', 'Completed' => 'Hoàn thành'] as $value => $label)<a href="javascript:;" class="btn btn-sm btn-outline btn-outline-{{ $value === 'Completed' ? 'success' : 'secondary' }} px-3 py-1" onclick="_cancel_services.on.click.filterStatus('{{ $value }}')" data-lang="status::{{ $value }}">{{ $label }}</a>@endforeach
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-lg-2 col-sm-4"><input type="text" class="form-control form-control-solid form-control-sm datatable-input" placeholder="Mã hủy" data-col-name="cancel_id"></div>
            <div class="col-lg-2 col-sm-4"><input type="text" class="form-control form-control-solid form-control-sm datatable-input" placeholder="Mã đơn hàng" data-col-name="order_id"></div>
            <div class="col-lg-4 col-sm-4"><button class="btn btn-primary btn-sm me-2" onclick="_cancel_services.on.click.filter()">Tìm kiếm</button><button class="btn btn-secondary btn-sm" onclick="_cancel_services.on.click.resetFilter()">Đặt lại</button></div>
        </div>
    </div></div>
    <div class="card shadow-sm card-orders"><div class="card-body p-5">
        <div class="d-flex align-items-center mb-3"><label class="form-check form-check-custom form-check-solid"><input class="form-check-input h-15px w-15px cb-all" type="checkbox" onchange="app_admin.on.change.cbSelectAll(this.checked)"></label><div class="checkall ms-5" style="display:none"><a href="javascript:;" class="btn btn-light btn-sm" onclick="_cancel_services.on.click.actionBulk('Change status', 1)">Đánh dấu hoàn thành</a><label class="ms-3 fs-7"></label></div></div>
        <div class="table-responsive"><table class="table align-middle table-row-dashed fs-7 gy-3"><thead><tr class="text-start text-muted fw-bold text-uppercase"><th></th><th>Trạng thái</th><th>Mã hủy</th><th>Tài khoản</th><th>Mã đơn hàng</th><th>Ngày tạo</th></tr></thead><tbody></tbody></table></div>
    </div></div>
</div>
@endsection
@push('scripts')
<script>var STATUS_ORDER = @json($statusOrder ?? ''); $(function(){ _cancel_services.init(); });</script>
@endpush
