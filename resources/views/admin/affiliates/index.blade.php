@extends('admin.layouts.app')
@section('title', 'Affiliates')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <div class="row g-5 mb-5">
        <div class="col-sm-6 col-xl-3"><div class="card shadow-sm"><div class="card-body text-center"><div class="fs-2 fw-bold text-primary stat-affiliate-total">0</div><div class="text-muted fs-7">Tổng liên kết</div></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card shadow-sm"><div class="card-body text-center"><div class="fs-2 fw-bold text-success stat-affiliate-active">0</div><div class="text-muted fs-7">Đang hoạt động</div></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card shadow-sm"><div class="card-body text-center"><div class="fs-2 fw-bold text-warning stat-affiliate-earned">0</div><div class="text-muted fs-7">Tổng hoa hồng</div></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card shadow-sm"><div class="card-body text-center"><div class="fs-2 fw-bold text-info stat-affiliate-orders">0</div><div class="text-muted fs-7">Tổng giá trị đơn</div></div></div></div>
    </div>
    <div class="row g-3 mb-5">
        <div class="col-lg-5 col-12"><input type="text" class="form-control form-control-sm ipt-affiliate-search" placeholder="Tìm tài khoản giới thiệu..." onkeyup="if(event.key==='Enter') _affiliates.on.click.search()"></div>
        <div class="col-lg-3 col-6"><select class="form-select form-select-sm sl-affiliate-status" data-kt-select2="true" data-hide-search="true"><option value="">Tất cả trạng thái</option><option value="active">Hoạt động</option><option value="inactive">Không hoạt động</option><option value="suspended">Tạm khóa</option></select></div>
        <div class="col-lg-2 col-3"><button type="button" class="btn btn-primary btn-sm w-100" onclick="_affiliates.on.click.search()" data-lang="button::Search">Tìm kiếm</button></div>
        <div class="col-lg-2 col-3"><button type="button" class="btn btn-secondary btn-sm w-100" onclick="_affiliates.on.click.reset()" data-lang="button::Reset">Đặt lại</button></div>
    </div>
    <div class="card shadow-sm div-affiliates"><div class="card-body p-0"><div class="table-responsive">
        <table class="table table-striped table-row-bordered table-hover align-middle fs-7 gy-2 gs-5 mb-0" id="table-affiliates">
            <thead><tr class="fw-bold bg-secondary text-muted"><th>Thời gian</th><th>Người giới thiệu</th><th>Người được giới thiệu</th><th>Mã giới thiệu</th><th class="text-end">Hoa hồng</th><th class="text-end">Đã nhận</th><th class="text-end">Tổng đơn</th><th class="text-center">Số đơn</th><th>Trạng thái</th><th class="text-end">Thao tác</th></tr></thead><tbody></tbody>
        </table>
    </div></div></div>
</div>
@endsection
@push('scripts')
<script>$(function(){ _affiliates.init(); });</script>
@endpush
