@extends('admin.layouts.app')
@section('title', 'Đơn hàng sản phẩm')

@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <div class="card shadow-sm">
        <div class="card-body p-5">
            <div class="mb-5 div-filter-status">
                @foreach([
                'All' => ['Tất cả', ''], 'Manual' => ['Thủ công', ''],
                'Awaiting' => ['Đang chờ', 'secondary text-gray-500'], 'Failed' => ['Thất bại', 'warning'],
                'Pending' => ['Chờ xử lý', 'secondary text-gray-600'], 'In progress' => ['Đang chạy', 'info'],
                'Completed' => ['Hoàn thành', 'success'], 'Partial' => ['Hoàn tiền một phần', 'warning'],
                'Canceled' => ['Hủy', 'danger']
                ] as $value => [$label, $color])
                <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-{{ $color }} px-3 py-1 me-3 mb-2"
                    onclick="_product_orders.on.click.filterStatus('{{ $value }}')" data-lang="status::{{ $value }}">{{ $label }}</a>
                @endforeach
            </div>

            <div class="row g-3">
                <div class="col-lg-3 col-6">
                    <input type="text" class="form-control form-control-solid form-control-sm datatable-input"
                        data-col-name="product_order_id" value="{{ request('id') }}" placeholder="Product Order ID">
                </div>
                <div class="col-lg-3 col-6">
                    <input type="text" class="form-control form-control-solid form-control-sm datatable-input"
                        data-col-name="provider_product_order_id" value="{{ request('provider_id') }}" placeholder="Provider Order ID">
                </div>
                <div class="col-lg-3 col-7">
                    <select class="form-select form-select-solid form-select-sm datatable-input" data-col-name="product_id"
                        data-kt-select2="true" data-placeholder="Tất cả sản phẩm" data-allow-clear="true">
                        <option value=""></option>
                        @foreach($products as $product)<option value="{{ $product->id }}">{{ $product->id }} - {{ $product->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-5">
                    <button type="button" class="btn btn-primary btn-sm me-2" onclick="_product_orders.on.click.filter()">Tìm kiếm</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="_product_orders.on.click.resetFilter()">Đặt lại</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-5">
        <div class="card-body p-5 div-orders">
            <div class="table-responsive">
                <table class="table fs-7 gy-1 gs-3 table-orders custom-table" style="width:100%">
                    <thead>
                        <tr class="d-none">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-result" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
            <div class="modal-body text-center">
                <textarea class="form-control txa-result" rows="8" placeholder="Nhập kết quả" onkeyup="this.classList.remove('is-invalid')"></textarea>
                <div class="mt-5"><button type="button" class="btn btn-primary btn-sm">Xác nhận</button></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-view-result" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kết quả</h5><button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-change-service-combo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yêu cầu</h5><button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer"><button type="button" class="btn btn-primary btn-sm">Cập nhật</button></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var STATUS_ORDER = @json($statusOrder ?? ''),
        ORDER_ID_SEARCH = @json((string) request('id', ''));
    $(function() {
        _product_orders.init();
    });
</script>
@endpush