@extends('admin.layouts.app')

@section('title', 'Coupons')

@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <div class="d-flex flex-wrap flex-stack mb-5">
            <h3 class="fw-bold my-2">Mã giảm giá</h3>
            <a href="{{ route('admin.coupons.usage') }}" class="btn btn-light-primary btn-sm">Lịch sử sử dụng</a>
        </div>

        <form method="GET" class="mb-5 d-flex gap-2">
            <input name="keyword" value="{{ $keyword }}" class="form-control form-control-sm w-250px" placeholder="Tìm mã giảm giá">
            <button class="btn btn-primary btn-sm" type="submit">Tìm kiếm</button>
        </form>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-7 gy-2 mb-0">
                        <thead><tr class="text-muted fw-bold"><th>Mã</th><th>Giảm giá</th><th>Đã dùng</th><th>Trạng thái</th></tr></thead>
                        <tbody>
                            @forelse ($coupons as $coupon)
                                <tr>
                                    <td class="fw-bold">{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount_value }} {{ $coupon->discount_type === 'percent' ? '%' : '' }}</td>
                                    <td>{{ $coupon->used_count }}{{ $coupon->usage_limit ? ' / ' . $coupon->usage_limit : '' }}</td>
                                    <td>{{ $coupon->status ? 'Kích hoạt' : 'Vô hiệu hóa' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-10">Chưa có mã giảm giá</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($coupons->hasPages())<div class="p-4">{{ $coupons->links() }}</div>@endif
            </div>
        </div>
    </div>
@endsection
