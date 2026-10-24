@extends('admin.layouts.app')
@section('title', 'Payment history')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
   <span class="title d-none">History</span>
   <div class="d-flex align-items-center mb-3">
      <div class="flex-grow-1">
         <h3><span data-lang="Total">Tổng</span>: <strong class="total-funds text-success">0</strong></h3>
      </div>
   </div>
   <div class="row mb-5">
      <div class="col-12 col-md-8 offset-md-4">
         <div class="input-group">
            <div class="overflow-hidden flex-grow-1">
               <select class="form-select rounded-end-0 sl-method" data-control="select2"
                  onchange="_payments.on.change.history()">
                  <option value="">All</option>
                  @foreach ($paymentMethods as $paymentMethod)
                  <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                  @endforeach
               </select>
            </div>
            <input class="form-control text-center ipt-date"
               value="{{ now()->format('Y/m/d') }} - {{ now()->format('Y/m/d') }}">
         </div>
      </div>
   </div>
   <div class="card shadow-sm">
      <div class="card-body p-0">
         <div class="table-responsive">
            <table class="table table-row-dashed table-hover fs-7 gy-2 gs-5 mb-0" id="table-history-fund">
               <thead>
                  <tr class="text-start text-muted bg-secondary fw-bold fs-7 text-uppercase gs-0">
                     <th data-lang="Account">Tài khoản</th>
                     <th data-lang="Amount">Số lượng</th>
                     <th data-lang="Method">Phương thức</th>
                     <th data-lang="Created">Ngày tạo</th>
                     <th data-lang="Details">Chi tiết</th>
                  </tr>
               </thead>
               <tbody>
                  @forelse ($payments as $payment)
                  <tr>
                     <td class="fw-semibold ls-1 td-colspan">{{ $payment['account_user'] }}</td>
                     <td class="fw-bold text-success ls-1">{{ number_format($payment['fund_amount'], 2) }}</td>
                     <td class="text-nowrap">{{ $payment['pm_name'] }}</td>
                     <td class="text-nowrap">{{ $payment['fund_created_1'] }}</td>
                     <td class="text-muted">{{ $payment['fund_details'] }}</td>
                  </tr>
                  @empty
                  <tr>
                     <td colspan="5" class="text-center text-muted py-8">Đang tải lịch sử thanh toán...</td>
                  </tr>
                  @endforelse
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')
<script>
   $(function() {
      _payments.init();
   });
</script>
@endpush
