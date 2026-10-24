@extends('admin.layouts.app')
@section('title', 'Product warehouse')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <span class="title d-none">Warehouse</span>
    <div class="d-flex flex-wrap flex-stack mb-6">
        <h3 class="fw-bold my-2">Kho sản phẩm</h3>
        <button type="button" class="btn btn-primary btn-sm" onclick="_products.on.click.showModalAddWarehouse()">Thêm kho</button>
    </div>
    <div class="card shadow-sm"><div class="card-body p-0"><div class="table-responsive">
        <table class="table align-middle table-row-dashed fs-7 gy-3 gs-5 mb-0">
            <thead><tr class="text-muted fw-bold"><th class="w-40px"></th><th>ID</th><th>Tên kho</th><th>Tổng hàng</th><th>Còn lại</th><th class="text-end">Tùy chọn</th></tr></thead>
            <tbody>
            @forelse($warehouses as $warehouse)
                <tr data-id="{{ $warehouse->id }}">
                    <td><i class="fas fa-bars pointer"></i></td><td>{{ $warehouse->id }}</td><td class="fw-bold">{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->goods_count }}</td><td>{{ $warehouse->available_goods_count }}</td>
                    <td class="text-end text-nowrap">
                        <button class="btn btn-sm btn-light-primary px-3 py-1" onclick="_products.on.click.showModalAddGoods({{ $warehouse->id }})">Thêm hàng</button>
                        <button class="btn btn-sm btn-light-info px-3 py-1" onclick="_products.on.click.downloadGoods({{ $warehouse->id }}, @js($warehouse->name))">Tải xuống</button>
                        <button class="btn btn-sm btn-light-danger px-3 py-1" onclick="_products.on.click.deleteGoods({{ $warehouse->id }}, @js($warehouse->name))">Xóa hàng</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-10">Chưa có kho sản phẩm.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div></div></div>

    <div class="modal fade" id="modal-new-warehouse" tabindex="-1" data-bs-backdrop="static"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">Thêm kho</h4></div><div class="modal-body"><label class="required form-label">Tên kho</label><input class="form-control form-control-solid ipt-warehouse-name"></div>
        <div class="modal-footer"><button class="btn btn-light btn-sm" data-bs-dismiss="modal">Đóng</button><button class="btn btn-primary btn-sm">Thêm</button></div>
    </div></div></div>
    <div class="modal fade" id="modal-add-goods" tabindex="-1" data-bs-backdrop="static"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">Thêm hàng</h4></div><div class="modal-body"><label class="required form-label">Mỗi sản phẩm một dòng</label><textarea class="form-control form-control-solid txa-goods" rows="12"></textarea></div>
        <div class="modal-footer"><button class="btn btn-light btn-sm" data-bs-dismiss="modal">Đóng</button><button class="btn btn-primary btn-sm">Thêm</button></div>
    </div></div></div>
</div>
@endsection
@push('scripts')
<script>$(function(){ _products.init(); });</script>
@endpush
