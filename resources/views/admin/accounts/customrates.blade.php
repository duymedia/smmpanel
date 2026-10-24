@extends('admin.layouts.app')
@section('title', 'Custom rates')

@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <span class="title d-none">View account - Custom rates</span>

        @include('admin.accounts.partials.header', ['activeTab' => 'customrates', 'showEditButton' => true])
    <div class="d-flex flex-wrap flex-stack mb-6"><h3 class="fw-bold my-2" data-lang="Custom rates">Custom rates</h3></div>
    <div class="row g-6">
        <div class="col-xl-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="mb-5">
                        <select class="form-select form-select-solid sl-services" data-control="select2"
                            onchange="_accounts.on.change.service_customrate(this.value)">
                            <option value="0" data-lang="Please choose services">Please choose services</option>
                            <option value="-1" data-lang="All currenct active services">All currenct active services</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" data-orate="{{ $service->rate_retail }}">
                                    {{ $service->id }} | {{ $service->getName('en') }} | ${{ formatCharge($service->rate_retail) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-5">
                    <div class="mb-5">
                        <select class="form-select form-select-solid sl-mode" data-control="select2" data-hide-search="true"
                            onchange="_accounts.on.change.setModeCustomRates()">
                            <option value="" data-lang="Select set mode">Select set mode</option>
                            <option value="1" data-lang="Set rate">Set rate</option>
                            <option value="2" data-lang="Set percent">Set percent</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-5">
                    <div class="input-group input-group-solid div-ipt-rate mb-5">
                        <span class="input-group-text">$</span>
                        <input type="number" min="0" step="0.00000001" class="form-control ipt-rate">
                    </div>
                    <div class="input-group input-group-solid div-ipt-rate-percent mb-5" style="display: none">
                        <input type="number" min="0" step="0.01" class="form-control ipt-rate-percent"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Custom rate by percent">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="col-lg-1 col-2">
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary me-1 btn-icon" data-bs-toggle="tooltip" title="Add"
                            onclick="_accounts.on.click.addCustomRate({{ $accounts->id }})"><i class="fa fa-plus"></i></button>
                        <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="tooltip" title="Clear all"
                            onclick="_accounts.on.click.clearAllCustomRate({{ $accounts->id }})"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
                    </div>
                    <div class="d-flex">
                <div class="form-check form-check-custom form-check-sm form-check-solid">
                    <input class="form-check-input h-15px w-15px cb-all" type="checkbox" onchange="app_admin.on.change.cbSelectAll(this.checked)">
                </div>
                <div class="checkall ms-5" style="display: none">
                    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm py-1 px-2"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <span data-page="common" data-lang="Options">Options</span>
                        <i class="ki-duotone ki-down fs-5 ms-1"></i>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-3"
                        data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a href="javascript:;" class="menu-link px-3"
                                onclick="_accounts.on.click.removeCustomRates({{ $accounts->id }})" data-lang="Remove">Remove</a>
                        </div>
                    </div>
                    <label class="ms-3 fs-7"></label>
                </div>
            </div>
                    <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-7 gy-2 table-customrates">
                    <thead><tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th></th><th colspan="2" data-lang="Service">Service</th><th data-lang="Rate">Rate</th><th data-lang="Percent">Percent</th>
                    </tr></thead>
                    <tbody class="fs-7 text-gray-700"></tbody>
                </table>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    _accounts.init();
});
</script>
@endpush
