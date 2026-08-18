@extends('clients.theme-4.layouts.app')
@section('title', 'Affiliate')

@section('content')

    <div class="content flex-column-fluid" id="kt_content">
        @include('clients.theme-4.layouts.toolbar', ['title' => 'Affiliate', 'langKey' => 'affiliates.title'])
        <div class="post" id="kt_post">

            <div class="alert alert-primary fw-bold mb-5">
                🤑 Wanna get money? Use our Affiliate Programs to get more! Refer your friends and lets make money! 👍
            </div>

            {{-- Referral link + config --}}
            <div class="card mb-5">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-7 gy-3 gs-5 mb-0">
                            <thead class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                                <tr>
                                    <th data-lang="affiliates.referral_link">Referral link</th>
                                    <th data-lang="affiliates.commission_rate">Commission rate</th>
                                    <th data-lang="affiliates.minimum_payout">Minimum withdraw</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group input-group-sm" style="max-width:420px">
                                            <input type="text" id="ipt-ref-link"
                                                class="form-control form-control-solid form-control-sm"
                                                value="{{ $referralLink }}" readonly>
                                            <button class="btn btn-sm btn-light-primary" onclick="_affiliate.copy()"
                                                type="button">
                                                <i class="bi bi-clipboard"></i> <span
                                                    data-lang="affiliates.copy_link">Copy</span>
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
                                    <th data-lang="affiliates.registrations">Registrations</th>
                                    <th data-lang="affiliates.total_referrals">Total Referrals</th>
                                    <th data-lang="affiliates.total_earnings">Total Earnings</th>
                                    <th data-lang="affiliates.available_earnings">Available Earnings</th>
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
                    <div class="card-title fw-bold" data-lang="affiliates.registrations">Referrals</div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-7 gy-3 gs-5 mb-0">
                            <thead class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                                <tr>
                                    <th>#</th>
                                    <th data-lang="common.name">User</th>
                                    <th data-lang="affiliates.commission_rate">Commission</th>
                                    <th data-lang="affiliates.total_earnings">Earnings</th>
                                    <th>Orders</th>
                                    <th data-lang="common.date">Joined</th>
                                    <th data-lang="common.status">Status</th>
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
                                                <span class="badge badge-light-success">Active</span>
                                            @else
                                                <span class="badge badge-light-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5" data-lang="common.no_data">No
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
        window._affiliate = {
            copy: function() {
                var el = document.getElementById('ipt-ref-link');
                if (!el) return;
                navigator.clipboard.writeText(el.value).then(function() {
                    var btn = el.nextElementSibling;
                    if (btn) {
                        var orig = btn.innerHTML;
                        btn.innerHTML = '<i class="bi bi-check"></i> Copied!';
                        setTimeout(function() {
                            btn.innerHTML = orig;
                        }, 2000);
                    }
                }).catch(function() {
                    el.select();
                    document.execCommand('copy');
                });
            }
        };
    </script>
@endpush
