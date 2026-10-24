@extends('admin.layouts.app')
@section('title', 'Analytics')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <div class="row g-5">
        <div class="col-lg-12 div-summary">
            <div class="card shadow-sm"><div class="card-body text-center">
                <div class="row g-5 mb-10">
                    <div class="col-md-6"><h2 class="total-summary total_orders ls-1"></h2><span class="fs-8 text-gray-600">Total orders</span></div>
                    <div class="col-md-6"><h2 class="total-summary total_deposit ls-1"></h2><span class="fs-8 text-gray-600">Total deposit</span></div>
                </div>
                <div class="row g-5 mb-5">
                    <div class="col"><h4 class="total-summary total_Failed ls-1"></h4><span class="fs-8 text-gray-600">Failed</span></div>
                    <div class="col"><h4 class="total-summary total_Awaiting ls-1"></h4><span class="fs-8 text-gray-600">Awaiting</span></div>
                    <div class="col"><h4 class="total-summary total_Schedule ls-1"></h4><span class="fs-8 text-gray-600">Schedule</span></div>
                </div>
                <div class="row g-5">
                    <div class="col"><h4 class="total-summary total_Pending ls-1"></h4><span class="fs-8 text-gray-600">Pending</span></div>
                    <div class="col"><h4 class="total-summary total_Processing ls-1"></h4><span class="fs-8 text-gray-600">Processing</span></div>
                    <div class="col"><h4 class="total-summary total_In_progress ls-1"></h4><span class="fs-8 text-gray-600">In progress</span></div>
                    <div class="col"><h4 class="total-summary total_Done ls-1"></h4><span class="fs-8 text-gray-600">Done <i class="fa-solid fa-circle-info" data-bs-toggle="tooltip" title="Completed, Canceled, Partial"></i></span></div>
                </div>
            </div></div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow-sm"><div class="card-body">
                <div class="d-flex align-items-center mb-5"><div class="input-group input-group-sm w-250px"><span class="input-group-text"><i class="las la-calendar fs-2"></i></span><input class="form-control text-center ipt-date"></div></div>
                <div class="row g-5">
                    <div class="col-lg-9 border-end">
                        <div class="fw-semibold text-center mb-5 ls-1">Top 10 services</div>
                        <div class="loading-top-10-services text-center"><span class="spinner-border text-primary" role="status"></span></div>
                        <div class="table-responsive"><table class="table table-hover align-middle fs-7 gy-2 mb-0 table-top-10-services"><tbody></tbody></table></div>
                    </div>
                    <div class="col-lg-3">
                        <div class="fw-semibold text-center mb-5 ls-1">Top 10 users charge</div>
                        <div class="loading-top-10-users-charge text-center"><span class="spinner-border text-primary" role="status"></span></div>
                        <div class="table-responsive"><table class="table table-hover align-middle fs-7 gy-2 mb-0 table-top-10-users-charge"><tbody></tbody></table></div>
                    </div>
                </div>
            </div></div>
        </div>

        <div class="col-md-12">
            <div class="card shadow-sm"><div class="card-header"><h4 class="card-title" data-lang="">Tài khoản</h4></div><div class="card-body">
                <div class="loading-account text-center"><span class="spinner-border text-primary" role="status"></span></div>
                <canvas id="chart-account" class="mh-400px"></canvas>
                <div class="fw-semibold text-center mt-5 ls-1"><span data-lang="">Thống kê tài khoản mới và tài khoản hoạt động</span> - {{ $year }}</div>
            </div></div>
        </div>

        <div class="col-md-12">
            <div class="card shadow-sm"><div class="card-header"><h4 class="card-title" data-lang="">Dịch vụ</h4></div><div class="card-body">
                <div class="row g-5">
                    <div class="col-md-6"><div class="table-responsive"><table class="table table-hover align-middle table-row-bordered fs-7 gy-2 gs-2" id="table-best-service-by-count">
                        <thead><tr class="text-start text-muted fw-bold fs-7 text-uppercase"><td colspan="2" data-lang="Top service by order count">Dịch vụ được đặt hàng nhiều nhất</td><td class="text-end">COUNT</td></tr></thead><tbody></tbody>
                    </table></div></div>
                    <div class="col-md-6"><div class="table-responsive"><table class="table table-hover align-middle table-row-bordered fs-7 gy-2 gs-2" id="table-best-service-by-charge">
                        <thead><tr class="text-start text-muted fw-bold fs-7 text-uppercase"><td colspan="2" data-lang="Top service by order charge">Dịch vụ bán chạy nhất</td><td class="text-end">CHARGE</td></tr></thead><tbody></tbody>
                    </table></div></div>
                </div>
                <div class="loading-service text-center"><span class="spinner-border text-primary" role="status"></span></div>
                <div class="fw-semibold text-center mt-5 ls-1"><span data-lang="">Thống kê dịch vụ bán chạy nhất</span> (<span class="service-date"></span>)</div>
            </div></div>
        </div>

        <div class="col-md-12 d-none">
            <div class="card shadow-sm"><div class="card-header"><h4 class="card-title">Đơn hàng</h4></div><div class="card-body">
                <div class="loading-order text-center"><span class="spinner-border text-primary" role="status"></span></div><canvas id="chart-order" class="mh-400px"></canvas>
            </div></div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    var FROM_DATE = @json($fromDate), TO_DATE = @json($toDate);
    $(function () { _analytics.init(); });
</script>
@endpush
