@extends('admin.layouts.app')
@section('title', 'Reports')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <span class="title d-none">List</span>
    <div class="row g-3 mb-3">
        <div class="col-lg-2 col-4">
            <select class="form-select form-select-sm sl-year" data-kt-select2="true" data-hide-search="true">
                @foreach ($years as $year)<option value="{{ $year }}" @selected($year === $currentYear)>{{ $year }}</option>@endforeach
            </select>
        </div>
        <div class="col-lg-2 col-4">
            <select class="form-select form-select-sm sl-type" data-kt-select2="true" data-hide-search="true" onchange="_reports.on.change.type(this.value)">
                <option value="0" data-lang="Payments">Thanh toán</option><option value="1">Services</option><option value="2">Services - OLD</option><option value="3">Products</option>
            </select>
        </div>
        <div class="col-lg-2 col-4 type type-1 type-2 type-3" style="display:none">
            <select class="form-select form-select-sm sl-order-type" data-kt-select2="true" data-hide-search="true">
                <option value="0" data-lang="Charge">Số tiền</option><option value="3" data-lang="Profit">Lợi nhuận</option><option value="1" data-lang="Count">Số lượng đơn</option><option value="2" data-lang="View">Số lượng</option>
            </select>
        </div>
        <div class="col-lg-2 col-4 type type-0">
            <select class="form-select form-select-sm sl-method" data-kt-select2="true" data-hide-search="true"><option value="" data-lang="All methods">Tất cả phương thức</option>
                @foreach ($paymentMethods as $method)<option value="{{ $method->id }}">{{ $method->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-lg-3 col-6">
            <select class="form-select form-select-sm sl-account"><option value="" data-lang="All accounts">Tất cả tài khoản</option></select>
        </div>
        <div class="col-lg-3 col-6 type type-1 type-2 type-3" style="display:none">
            <select class="form-select form-select-sm sl-provider" data-kt-select2="true" onchange="_reports.on.change.provider(this.value,document.querySelector('.sl-year').value)"><option value="" data-lang="All providers">Tất cả nhà cung cấp</option>
                @foreach ($providers as $provider)<option value="{{ $provider->id }}">{{ $provider->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-lg-12 type type-1 type-2 type-3" style="display:none">
            <select class="form-select form-select-sm sl-order-status" data-kt-select2="true" multiple>
                @foreach (['Pending','Processing','In progress','Completed','Partial','Canceled'] as $status)<option value="{{ $status }}" selected data-lang="status::{{ $status }}">{{ $status }}</option>@endforeach
            </select>
        </div>
        <div class="col-lg-12 type type-1 type-2" style="display:none">
            <select class="form-select form-select-sm sl-service" data-kt-select2="true" data-hide-search="true" multiple data-placeholder="Chọn dịch vụ">
                @foreach ($services as $service)<option value="{{ $service['id'] }}">{{ $service['name'] }}</option>@endforeach
            </select>
        </div>
        <div class="col-lg-12 type type-3" style="display:none">
            <select class="form-select form-select-sm sl-product" data-kt-select2="true" data-hide-search="true" multiple data-placeholder="Choose products">
                @foreach ($products as $product)<option value="{{ $product->id }}">{{ $product->id }}</option>@endforeach
            </select>
        </div>
    </div>
    <div class="mb-5"><button type="button" class="btn btn-primary btn-sm w-100 w-sm-auto btn-report" onclick="_reports.on.click.report(document.querySelector('.sl-year').value,document.querySelector('.sl-type').value,document.querySelector('.sl-method').value,document.querySelector('.sl-order-type').value,document.querySelector('.sl-provider').value,document.querySelector('.sl-account').value)" data-lang="button::Apply">Áp dụng</button></div>

    <div class="card shadow-sm mb-5"><div class="card-body p-0"><div class="table-responsive">
        <table class="table table-striped table-row-bordered table-hover fs-7 gy-2 gs-9 mb-0">
            <thead><tr class="fw-bold bg-secondary"><th></th>@for ($month=1;$month<=12;$month++)<th class="text-right"><span>Tháng {{ $month }}</span> <a target="_blank" data-month="{{ $month }}" class="details provider" style="display:none"><i class="fa-solid fa-circle-info"></i></a><a href="javascript:;" onclick="_reports.on.click.detailsPayment({{ $month }},document.querySelector('.sl-year').value)" class="details payment"><i class="fa-solid fa-circle-info"></i></a></th>@endfor</tr></thead>
            <tbody>@for ($day=1;$day<=31;$day++)<tr><th class="fw-bold">{{ $day }}</th>@for ($month=1;$month<=12;$month++)<td class="text-right data-reports {{ $month }}-{{ $day }}"></td>@endfor</tr>@endfor</tbody>
            <tfoot>
                <tr class="fw-bolder text-uppercase bg-secondary"><th data-lang="Total">Tổng</th>@for ($month=1;$month<=12;$month++)<th class="text-right {{ $month }}-total"></th>@endfor</tr>
            </tfoot>
        </table>
    </div><canvas id="chart"></canvas></div></div>
</div>
@endsection
@push('scripts')
<script>$(function(){ _reports.init(); });</script>
@endpush
