@extends('clients.theme-default.layouts.app')
@section('title', 'Affiliates')

@section('content')

    <div class="content flex-column-fluid" id="kt_content">
        @include('clients.theme-default.layouts.toolbar', ['title' => 'Affiliates', 'langKey' => 'menu::Affiliate'])
        <div class="post" id="kt_post">

            <div class="alert alert-primary fw-bold mb-5" data-page="/affiliate" data-lang="alert-header">
                🤑 Wanna get money? Use our Affiliate Programs to get more! Refer your friends and lets make money! 👍
            </div>

            {{-- Referral link + config --}}
            <div class="card mb-5">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-7 gy-3 gs-5 mb-0">
                            <thead class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                                <tr>
                                    <th data-page="/affiliate" data-lang="Referral link">Referral link</th>
                                    <th data-page="/affiliate" data-lang="Commission rate">Commission rate</th>
                                    <th data-page="/affiliate" data-lang="Minimum withdraw">Minimum withdraw</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group input-group-sm" style="max-width:420px">
                                            <input type="text" id="ipt-ref-link"
                                                class="form-control form-control-solid form-control-sm"
                                                value="{{ $referralLink }}" readonly>
                                            <button class="btn btn-sm btn-light-primary" data-clipboard-target="#ipt-ref-link"
                                                type="button">
                                                <i class="bi bi-clipboard"></i> <span
                                                    data-lang="button::Copy">Copy</span>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="fw-bold">{{ $config->affiliate_percent ?? 0 }}%</td>
                                    <td class="fw-bold">${{ number_format($config->affiliate_min ?? 0) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="card mb-5">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-7 gy-3 gs-5 mb-0">
                            <thead class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                                <tr>
                                    <th data-page="/affiliate" data-lang="Registrations">Registrations</th>
                                    <th data-page="/affiliate" data-lang="Total Referrals">Total Referrals</th>
                                    <th data-page="/affiliate" data-lang="Total Earnings">Total Earnings</th>
                                    <th data-page="/affiliate" data-lang="Available Earnings">Available Earnings</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="fw-bold fs-6">
                                    <td>{{ $referrals->count() }}</td>
                                    <td>{{ $totalOrders }}</td>
                                    <td class="text-success">${{ number_format($totalEarned, 4) }}</td>
                                    <td class="text-success">${{ number_format($totalEarned, 4) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Referrals list --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title fw-bold" data-page="/affiliate" data-lang="Referrals">Referrals</div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-7 gy-3 gs-5 mb-0">
                            <thead class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                                <tr>
                                    <th>#</th>
                                    <th data-page="/affiliate" data-lang="User">User</th>
                                    <th data-page="/affiliate" data-lang="Commission">Commission</th>
                                    <th data-page="/affiliate" data-lang="Earnings">Earnings</th>
                                    <th data-page="/affiliate" data-lang="Orders">Orders</th>
                                    <th data-page="/affiliate" data-lang="Joined">Joined</th>
                                    <th data-page="/affiliate" data-lang="Status">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($referrals as $i => $ref)
                                    <tr>
                                        <td class="text-muted">{{ $i + 1 }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $ref->referred->name ?? '—' }}</div>
                                            <div class="text-muted fs-8">{{ $ref->referred->email ?? '' }}</div>
                                        </td>
                                        <td class="fw-bold">{{ $ref->commission_rate }}%</td>
                                        <td class="fw-bold text-success">${{ number_format($ref->total_earned, 4) }}</td>
                                        <td>{{ $ref->orders_count }}</td>
                                        <td class="text-muted text-nowrap">{{ $ref->created_at?->format('d/m/Y') ?? '—' }}
                                        </td>
                                        <td>
                                            @if ($ref->isActive())
                                                <span class="badge badge-light-success" data-page="/affiliate"
                                                    data-lang="Active">Active</span>
                                            @else
                                                <span class="badge badge-light-danger" data-page="/affiliate"
                                                    data-lang="Inactive">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5" data-page="/affiliate"
                                            data-lang="No data">No
                                            data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // The dashboard script exposes the legacy affiliate handler as _affiliate.
        // Keep the current page compatible with callers using __affiliate.
        window.__affiliate = window._affiliate;
    </script>
@endpush

