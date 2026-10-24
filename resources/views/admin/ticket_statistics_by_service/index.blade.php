@extends('admin.layouts.app')
@section('title', 'Ticket Statistics by Service')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-5">
        <h3 class="fw-bold my-2" data-lang="menu::Ticket Statistics by Service">Thống kê phiếu hỗ trợ theo dịch vụ</h3>
        <div class="input-group input-group-sm w-250px">
            <span class="input-group-text"><i class="la la-calendar fs-3"></i></span>
            <input type="text" class="form-control form-control-solid text-center ipt-date" readonly>
        </div>
    </div>
    <div class="card card-flush shadow-sm"><div class="card-body p-5">
        <div class="w-100" style="min-height:400px"><canvas id="chart"></canvas></div>
    </div></div>
</div>
@endsection
@push('scripts')
<script>$(function(){ _ticket_statistics_by_service.init(); });</script>
@endpush
