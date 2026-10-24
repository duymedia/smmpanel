@extends('admin.layouts.app')
@section('title', 'Services')
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <span class="title d-none">Import</span>
        <div class="mb-5 shadow-sm card">
            <div class="card-body">
                <div class="row g-5 g-xl-5 align-items-end">
                    <div class="col-lg-3">
                        <select class="form-select form-select-sm form-select-solid sl-provider" id="providerSelect"
                            data-kt-select2="true" data-placeholder="Chọn nhà cung cấp">
                            <option value="0" data-page="/services" data-lang="Choose provider">Chọn nhà cung cấp</option>
                            @foreach ($providers as $pro)
                                <option value="{{ $pro->id }}" data-fixed-decimal="{{ $pro->fixed_decimal ?? 10 }}"
                                data-rate="{{ $pro->rate_api ?: 1 }}">{{ $pro->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <button type="button" class="btn btn-outline btn-outline-primary btn-sm w-100"
                            onclick="_services.on.click.serviceOfProvider()" data-page="/services" data-lang="List services">Tải dịch vụ</button>
                    </div>

                    <div class="col-lg-5">
                        <select class="form-select form-select-sm form-select-solid sl-category"
                            data-placeholder="Chọn danh mục" data-page="/services" data-lang-placeholder="Choose category">
                            <option value="0" data-page="/services" data-lang="Choose category">Chọn danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" data-icon="{{ $category->image }}">
                                    {{ $category->platform->name ?? '' }} | {{ $category->getName() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <button type="button" class="btn btn-primary btn-sm w-100"
                            onclick="_services.on.click.import(document.querySelector('.sl-provider').value, document.querySelector('.sl-category').value)"
                            data-lang="button::Import">Nhập</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="shadow-sm card">
            <div class="p-0 card-body">
                <script>
                    var provider_rate, provider_fixed_decimal;
                </script>
                <script>
                    var percent_inc_service = {{ number_format((float) ($markupConfig['markup_retail'] ?? 110), 2, '.', '') }},
                        percent_inc_service_1 = {{ number_format((float) ($markupConfig['markup_agent'] ?? 108), 2, '.', '') }},
                        percent_inc_service_2 = {{ number_format((float) ($markupConfig['markup_distributor'] ?? 105), 2, '.', '') }};
                </script>
                <div class="table-responsive service-import-table-wrap">
                    <table class="table align-middle table-row-bordered fs-7 gy-2 gs-3 service-import-table"></table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>typeof _services !== 'undefined' && typeof _services.init !== 'undefined' && _services.init();</script>
@endpush

