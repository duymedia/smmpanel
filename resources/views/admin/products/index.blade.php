@extends('admin.layouts.app')
@section('title', 'Products')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <span class="title d-none">List</span>
    <div class="d-flex flex-wrap gap-3 mb-6">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.products.add') }}">Thêm sản phẩm</a>
        <button class="btn btn-info btn-sm" onclick="_products.on.click.showModalAddCategory()">Thêm danh mục</button>
        <button class="btn btn-info btn-sm" onclick="_products.on.click.showModalAddGroup()">Thêm nhóm</button>
    </div>
    <div class="row mb-6"><div class="col-lg-6 col-12"><div class="input-group input-group-sm">
        <input class="form-control ipt-keyword" placeholder="ID hoặc tên" onkeyup="if(event.key==='Enter') _products.on.click.filter(this.value.trim())">
        <button class="btn btn-primary btn-icon px-4" onclick="_products.on.click.filter(document.querySelector('.ipt-keyword').value.trim())"><i class="las la-search fs-2"></i></button>
    </div></div></div>
    <div class="mb-5 text-muted text-end pointer" onclick="_products.on.click.collapseAll(this.querySelector('i'),this.querySelector('i').className.includes('expand'))">
        <span class="fst-italic">Hiển thị tất cả sản phẩm</span><i class="bi bi-arrows-expand ms-2"></i>
    </div>
    <div class="card shadow-sm"><div class="card-body p-0"><div class="table-responsive">
        <table class="table align-middle table-row-dashed fs-7 gy-2 gs-5 mb-0" id="table-category">
        @forelse($categories as $category)
            <tbody class="tbody-{{ $category->id }} sort-product" data-cat-id="{{ $category->id }}">
                <tr class="bg-secondary disabled tr-cat" data-cat-id="{{ $category->id }}"><td colspan="10" class="py-3">
                    <div class="d-flex align-items-center"><div class="flex-grow-1 fs-5 fw-bolder text-muted">
                        <i class="fas fa-bars icon-sort-category me-3" style="display:none"></i>{{ $category->name }}
                        <a href="javascript:;" class="a-update-category" style="display:none"
                            data-category-name="{{ $category->name }}"
                            onclick="_products.on.click.showModalUpdateCategory({{ $category->id }},this.dataset.categoryName,'{{ $category->status ? 'Active' : 'Inactive' }}')"><i class="bi bi-pencil fs-8 ms-2"></i></a>
                        <span class="badge {{ $category->status ? 'badge-light-success' : 'badge-light-secondary' }} ms-2 div-status-category" style="display:none">{{ $category->status ? 'Active' : 'Inactive' }}</span>
                    </div><div data-status="Show" class="text-end fs-8 show-hide pointer" onclick="_products.on.click.collapse(this,this.getAttribute('data-status'),{{ $category->id }})"><span class="show-hide-text">Hiện</span> ({{ $category->products->count() }})</div></div>
                </td></tr>
                @foreach($category->products as $product)
                <tr data-id="{{ $product->id }}" class="tr-product" style="display:none">
                    <td><i class="fas fa-bars"></i></td><td class="fw-bolder">{{ $product->id }}</td>
                    <td>@if($product->thumbnail)<img alt="" src="{{ $product->thumbnail }}" class="w-30px h-30px rounded" alt="">@endif</td>
                    <td><span class="badge badge-light-{{ $product->type === 'Api' ? 'primary' : 'secondary' }}">{{ $product->type }}</span></td>
                    <td>{{ $product->name }}</td><td>{{ $product->price * 1 }} - {{ $product->price_1 * 1 }} - {{ $product->price_2 * 1 }}<div class="text-muted">{{ $product->cost_price * 1 }}</div></td>
                    <td>{{ $product->min }} - {{ $product->max }}</td><td>{{ $product->group?->name ?? '-' }}</td>
                    <td><span class="badge badge-light-{{ $product->status === 'In stock' ? 'success' : ($product->status === 'Out of stock' ? 'danger' : 'secondary') }}">{{ $product->status }}</span></td>
                    <td class="text-end text-nowrap"><a class="btn btn-sm btn-light-primary px-3 py-1" href="{{ route('admin.products.edit',['id'=>$product->id]) }}">Sửa</a> <button class="btn btn-sm btn-light-info px-3 py-1" onclick="_products.on.click.copyProduct({{ $product->id }})">Sao chép</button></td>
                </tr>
                @endforeach
            </tbody> 
        @empty
            <tbody><tr><td class="text-center text-muted py-10">Chưa có danh mục sản phẩm.</td></tr></tbody>
        @endforelse
        </table>
    </div></div></div>

    <div class="modal fade" id="modal-category" tabindex="-1" data-bs-backdrop="static"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"><div class="mb-5"><label class="required form-label">Tên</label><input class="form-control form-control-solid ipt-cat-name"></div><div class="form-check form-switch form-check-custom"><input class="form-check-input h-20px w-30px cb-cat-status" type="checkbox" checked><label class="form-check-label">Kích hoạt</label></div></div>
        <div class="modal-footer"><button class="btn btn-light btn-sm" data-bs-dismiss="modal">Đóng</button><button class="btn btn-primary btn-sm">Thêm</button></div>
    </div></div></div>
    <div class="modal fade" id="modal-group" tabindex="-1" data-bs-backdrop="static"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">Thêm nhóm</h4></div><div class="modal-body"><label class="required form-label">Tên</label><input class="form-control form-control-solid ipt-group-name"></div>
        <div class="modal-footer"><button class="btn btn-light btn-sm" data-bs-dismiss="modal">Đóng</button><button class="btn btn-primary btn-sm">Thêm</button></div>
    </div></div></div>
</div>
@endsection
@push('scripts')
<script>$(function(){ _products.init(); });</script>
@endpush
