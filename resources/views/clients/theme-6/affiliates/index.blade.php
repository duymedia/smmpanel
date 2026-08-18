@extends('clients.theme-6.layouts.app')

@section('title', __('affiliates.title'))

@section('content')
    <div id="block_115">
        <div class="block-bg"></div>
        <div class="container">
            <div class="affiliates-info">

                {{-- Referral link + rates --}}
                <div class="row affiliates-info__alignment affiliate-block__main-table">
                    <div class="col-lg-12">
                        <div class="table-bg affiliates-info__data-table component_table_link">
                            <div class="table-wr table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('affiliates.referral_link') }}</th>
                                            <th>{{ __('affiliates.commission_rate') }}</th>
                                            <th>{{ __('affiliates.minimum_payout') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-label="{{ __('affiliates.referral_link') }}" nowrap="">
                                                @if($authUser && $authUser->referral_code)
                                                    <span id="link" class="mr-1">https://{{ getDomain() }}/ref/{{ $authUser->referral_code }}</span>
                                                    <a href="#">
                                                        <span data-clip="true" title="Link copied"
                                                            data-clipboard-action="copy"
                                                            data-clipboard-target="#link"
                                                            class="fas fa-clone"></span>
                                                    </a>
                                                @else
                                                    <span class="text-muted">{{ __('affiliates.no_referral_code') }}</span>
                                                @endif
                                            </td>
                                            <td data-label="{{ __('affiliates.commission_rate') }}">{{ $config->affiliate_percent ?? 0 }}%</td>
                                            <td data-label="{{ __('affiliates.minimum_payout') }}">${{ $config->affiliate_min ?? 0 }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Statistics --}}
                <div class="row affiliates-info__alignment">
                    <div class="col-lg-12">
                        <div class="table-bg component_table_statistics">
                            <div class="table-wr table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('affiliates.visits') }}</th>
                                            <th>{{ __('affiliates.registrations') }}</th>
                                            <th>{{ __('affiliates.total_referrals') }}</th>
                                            <th>{{ __('affiliates.conversion_rate') }}</th>
                                            <th>{{ __('affiliates.total_earnings') }}</th>
                                            <th>{{ __('affiliates.available_earnings') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="affiliates-table-border-none">
                                            <td data-label="{{ __('affiliates.visits') }}">{{ $data['visits'] ?? 0 }}</td>
                                            <td data-label="{{ __('affiliates.registrations') }}">{{ $data['registrations'] ?? 0 }}</td>
                                            <td data-label="{{ __('affiliates.total_referrals') }}">{{ $data['total_referrals'] ?? 0 }}</td>
                                            <td data-label="{{ __('affiliates.conversion_rate') }}">{{ $data['conversion_rate'] ?? '0.00%' }}</td>
                                            <td data-label="{{ __('affiliates.total_earnings') }}">{{ $data['total_earnings'] ?? '$0.00' }}</td>
                                            <td data-label="{{ __('affiliates.available_earnings') }}">{{ $data['available_earnings'] ?? '$0.00' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Payout history --}}
    <div id="block_116">
        <div class="block-bg"></div>
        <div class="container">
            <div class="affiliates-list">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-bg affiliate-block__table-payments component_table">
                            <div class="table-wr table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('affiliates.payout_date') }}</th>
                                            <th>{{ __('affiliates.payout_amount') }}</th>
                                            <th>{{ __('affiliates.payout_status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data['payouts'] ?? [] as $payout)
                                            <tr>
                                                <td data-label="{{ __('affiliates.payout_date') }}">{{ $payout['date'] ?? '' }}</td>
                                                <td data-label="{{ __('affiliates.payout_amount') }}">{{ $payout['amount'] ?? '' }}</td>
                                                <td data-label="{{ __('affiliates.payout_status') }}">{{ $payout['status'] ?? '' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">&nbsp;</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="component_pagination">
                            <div class="">
                                {{ $data['pagination'] ?? '' }}
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
