@extends('admin.layouts.app')

@section('title', 'Coupon usage')

@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <div class="d-flex flex-wrap flex-stack mb-5">
            <h3 class="fw-bold my-2">Lịch sử dùng mã giảm giá</h3>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-light-primary btn-sm">Mã giảm giá</a>
        </div>
        <div class="card shadow-sm"><div class="card-body p-0"><div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-7 gy-2 mb-0">
                <thead><tr class="text-muted fw-bold"><th>Mã</th><th>Tài khoản</th><th>Loại</th><th>Thời gian</th></tr></thead>
                <tbody>
                    @forelse ($usages as $usage)
                        <tr><td>{{ $usage->coupon?->code ?? '-' }}</td><td>{{ $usage->account?->username ?? '-' }}</td><td>{{ $usage->item_type ?? '-' }}</td><td>{{ $usage->created_at }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-10">Chưa có lượt sử dụng</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>@if ($usages->hasPages())<div class="p-4">{{ $usages->links() }}</div>@endif</div></div>
    </div>
@endsection
