@extends('adminpanel.layouts.app')
@section('title', 'Accounts')
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        @include('adminpanel.accounts.partials.header')

        <span class="title d-none">View account - Affiliates</span>
        <div class="d-flex flex-wrap flex-stack mb-6">
            <h3 class="fw-bold my-2" data-lang="menu::Affiliates">Tiếp thị liên kết</h3>
        </div>

        <div class="row g-6">
            <div class="col-lg-8">

                {{-- Summary --}}
                <div class="card shadow-sm mb-5">
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-7 gy-2">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th data-lang="Total Earnings">Tổng tiền thu nhập</th>
                                        <th data-lang="Unpaid">Chưa thanh toán</th>
                                        <th data-lang="Paid">Đã thanh toán</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="fw-bolder fs-5">
                                        <td class="text-success">{{ number_format($stats['total_affiliate_earnings'], 2) }}</td>
                                        <td>0.000</td>
                                        <td>{{ number_format($stats['total_affiliate_earnings'], 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Transaction list --}}
                <div class="card shadow-sm">
                    <div class="card-body pb-0">
                        <div class="dt-container dt-bootstrap5 dt-empty-footer">
                            <div class="table-responsive">
                                <div id="table-affiliates_processing" class="dt-processing card" role="status" style="display:none">
                                    <span class="spinner-border w-15px h-15px text-muted align-middle me-2"></span>
                                    <span class="text-gray-600">Loading...</span>
                                </div>
                                <table class="table align-middle table-row-dashed fs-7 gy-2" id="table-affiliates" style="width:100%">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0" role="row">
                                            <th class="dt-orderable-none"><span class="dt-column-title" data-lang="Status">Trạng thái</span></th>
                                            <th class="dt-orderable-none"><span class="dt-column-title" data-lang="Type">Hình thức</span></th>
                                            <th class="dt-orderable-none"><span class="dt-column-title" data-lang="Amount">Số tiền</span></th>
                                            <th class="dt-orderable-none"><span class="dt-column-title" data-lang="Details">Chi tiết</span></th>
                                            <th class="dt-orderable-none"><span class="dt-column-title" data-lang="Created">Thời gian</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-7 text-gray-700" style="display:none">
                                        @forelse($affiliates as $aff)
                                        <tr>
                                            <td>
                                                @if($aff->status === 'active')
                                                    <span class="badge badge-light-success">Hoạt động</span>
                                                @elseif($aff->status === 'suspended')
                                                    <span class="badge badge-light-danger">Tạm khóa</span>
                                                @else
                                                    <span class="badge badge-light-secondary">Không HĐ</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-light-primary">{{ number_format($aff->commission_rate, 2) }}%</span>
                                            </td>
                                            <td class="fw-bold text-success">
                                                {{ number_format($aff->total_earned, 4) }}
                                            </td>
                                            <td>
                                                @if($aff->referred)
                                                    <a href="{{ route('admin.accounts.show', $aff->referred->username) }}" class="fw-bold text-dark">
                                                        {{ $aff->referred->username }}
                                                    </a>
                                                    @if($aff->referral_code)
                                                        <br><small class="text-muted"><code>{{ $aff->referral_code }}</code></small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">#{{ $aff->referred_id }}</span>
                                                @endif
                                            </td>
                                            <td class="text-muted">
                                                {{ $aff->created_at?->format('Y-m-d H:i:s') }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3">
                                                <span class="text-muted">Chưa có dữ liệu</span>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            <div class="row">
                                <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                    <div class="dt-info ms-3" aria-live="polite" role="status">
                                        Hiển thị {{ $affiliates->firstItem() ?? 0 }} - {{ $affiliates->lastItem() ?? 0 }} / {{ $affiliates->total() }}
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                    @if($affiliates->hasPages())
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination mb-0">
                                            @if($affiliates->onFirstPage())
                                                <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-left"></i></span></li>
                                            @else
                                                <li class="page-item"><a class="page-link" href="{{ $affiliates->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a></li>
                                            @endif

                                            @foreach($affiliates->getUrlRange(1, $affiliates->lastPage()) as $page => $url)
                                                @if($page == $affiliates->currentPage())
                                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                                @else
                                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                                @endif
                                            @endforeach

                                            @if($affiliates->hasMorePages())
                                                <li class="page-item"><a class="page-link" href="{{ $affiliates->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a></li>
                                            @else
                                                <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-right"></i></span></li>
                                            @endif
                                        </ul>
                                    </nav>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-7 gy-2">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th data-lang="Refer">Giới thiệu</th>
                                        <th data-lang="Earnings">Thu nhập</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($affiliates->sortByDesc('total_earned')->take(10) as $i => $aff)
                                    <tr>
                                        <td class="text-muted">{{ $i + 1 }}</td>
                                        <td class="fw-bold">
                                            {{ $aff->referred?->username ?? '#'.$aff->referred_id }}
                                        </td>
                                        <td class="text-success fw-bold">
                                            {{ number_format($aff->total_earned, 2) }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">Không có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var processing = document.getElementById('table-affiliates_processing');
            var table      = document.getElementById('table-affiliates');
            var tbody      = table ? table.querySelector('tbody') : null;

            if (processing) processing.style.display = 'block';
            if (table)      table.style.opacity = '0.4';

            setTimeout(function () {
                if (processing) processing.style.display = 'none';
                if (table)      table.style.opacity = '1';
                if (tbody)      tbody.style.display = '';
            }, 400);
        });
    </script>
@endsection
