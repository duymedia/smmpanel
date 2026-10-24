@extends('clients.theme-default.layouts.app')
@section('title', 'Services')

@push('styles')
    <style>
        #table-service {
            min-width: 980px;
            table-layout: auto;
        }

        #table-service th,
        #table-service td:not(.col-name) {
            white-space: nowrap;
        }

        #table-service .col-name {
            min-width: 360px;
        }
    </style>
@endpush

@section('content')
    @php
        $isVndCurrency = strtoupper((string) (auth()->user()?->currency ?? '')) === 'VND';
    @endphp
    <div class="content flex-column-fluid" id="kt_content">
        @include('clients.theme-default.layouts.toolbar', ['title' => 'Services', 'langKey' => 'menu::Services'])

        <div class="post" id="kt_post">
            {{-- Filter --}}
            <div class="card mb-4">
                <div class="card-body py-3 px-4">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-md-3">
                            <input type="text" id="ipt-keyword" class="form-control form-control-sm form-control-solid"
                                placeholder="Keyword" data-lang="Keyword">
                        </div>
                        <div class="col-12 col-md-3">
                            <select id="sl-platform" class="form-select form-select-sm form-select-solid"
                                data-kt-select2="true" data-control="select2" data-hide-search="true"
                                data-placeholder="All social media"
                                onchange="_services.on.change.platform(this.value)">
                                <option value="-100" data-lang="All social media">All social media</option>
                                @foreach ($platforms as $platform)
                                    <option value="{{ $platform['id'] }}" data-content="{{ $platform['option_html'] }}"
                                        data-lang="">{{ $platform['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <select id="sl-category" class="form-select form-select-sm form-select-solid"
                                data-kt-select2="true" data-control="select2" data-hide-search="true"
                                data-placeholder="All category">
                                <option value="-100" data-platform="-100" data-lang="All category">All category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}" data-platform="{{ $category['platform_id'] ?? -1 }}">
                                        {{ $category['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-12">
                            <button type="button" id="btn-filter" class="btn btn-sm btn-primary"
                                onclick="_services.on.click.filter()" data-lang="button::Filter">Filter</button>
                            <button type="button" id="btn-toggle-rate" class="btn btn-warning btn-sm ms-2"
                                onclick="_services.on.click.toggleRate()" data-lang="button::Rate Filter">Rate
                                Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-sm btn-secondary"
                                onclick="_services.on.click.reset()" data-lang="button::Reset">Reset</button>
                        </div>
                    </div>

                    <div id="rate-filter-wrap" class="mt-3 mb-1 d-none" data-rate-min="{{ $rateMin }}" data-rate-max="{{ $rateMax }}">
                        <div id="kt_slider_rate_range" class="ms-6 me-10 noUi-sm"></div>
                        <div class="d-flex justify-content-between mt-2 text-muted fs-8">
                            <span id="rate_min_text">{{ $rateMin }}</span>
                            <span id="rate_max_text">{{ $rateMax }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="card card-services mb-5">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-row-dashed table-row-gray-300 gs-3 gy-2 gx-2 mb-0"
                            id="table-service">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th width="1"></th>
                                    <th width="1"></th>
                                    <th data-lang="Service" width="40%">Service</th>
                                    <th class="text-end">
                                        <span data-lang="Rate">Rate</span>
                                        <span class="ms-1 fa-regular fa-circle-question" data-bs-toggle="tooltip"
                                            data-bs-placement="top" aria-label="Rate on 1000 units"
                                            data-bs-original-title="Rate on 1000 units"></span>
                                    </th>
                                    <th class="text-end col-min" width="1">Min</th>
                                    <th class="text-end col-max" width="1">Max</th>
                                    @if($showAverageTime)
                                    <th class="text-end col-avg" width="1">
                                        <span data-lang="Average time">Average time</span>
                                        <span class="ms-1 fa-regular fa-circle-question" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            aria-label="The average time is based on 10 latest completed orders per 1000 quantity"
                                            data-bs-original-title="The average time is based on 10 latest completed orders per 1000 quantity"></span>
                                    </th>
                                    @endif
                                    <th class="text-center" width="1" data-lang="Description">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($serviceGroups as $group)
                                        {{-- Category header row --}}
                                        <tr class="svc-cat-row bg-white border-top border-2"
                                            data-platform="{{ $group['platform_id'] }}"
                                            data-category="{{ $group['id'] }}">
                                            <td colspan="{{ $serviceColumnCount }}" class="fs-5 fw-bolder">
                                                <div class="d-flex align-items-center">
                                                    @if ($group['platform_image_url'])
                                                        <img src="{{ $group['platform_image_url'] }}" class="w-15px h-15px me-1">
                                                    @elseif ($group['platform_icon_class'])
                                                        <i class="{{ $group['platform_icon_class'] }} fs-5 me-1"></i>
                                                    @endif
                                                    <div class="d-flex flex-column ls-1">
                                                        {{ $group['title'] }}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Service rows --}}
                                        @foreach ($group['services'] as $svc)
                                            <tr class="service svc-row" data-platform="{{ $group['platform_id'] }}"
                                                data-category="{{ $svc['category_id'] }}"
                                                data-name="{{ strtolower($svc['name']) }} {{ $svc['id'] }}"
                                                data-rate="{{ $svc['rate'] }}">
                                                <td class="ps-3">
                                                    @auth
                                                    <a href="javascript:;" class="svc-fav-btn"
                                                        data-id="{{ $svc['id'] }}"
                                                        data-cat="{{ $svc['category_id'] }}"
                                                        data-pid="{{ $group['platform_id'] }}"
                                                        onclick="_services.on.click.favorite({{ $svc['id'] }})">
                                                        <i class="fa-regular fa-star text-muted fs-7"></i>
                                                    </a>
                                                    @endauth
                                                </td>
                                                <td class="fw-bold text-gray-600 fs-8 col-id">{{ $svc['id'] }}</td>
                                                <td class="py-2 col-name">
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="fw-semibold text-gray-800 fs-7">{{ $svc['name'] }}</span>
                                                        @if ($svc['attribute_badges'])
                                                            <div class="mt-1 d-flex flex-wrap gap-1">
                                                                @foreach ($svc['attribute_badges'] as $badge)
                                                                    <span
                                                                        class="badge badge-outline badge-{{ $badge['color'] }} fw-light fs-9 py-1 px-1">{{ $badge['name'] }}</span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-end col-rate">
                                                    <span class="fw-bold text-primary fs-7">
                                                        @if ($isVndCurrency)
                                                            @php
                                                                $rateNumber = preg_replace('/[^\d,.-]/u', '', (string) $svc['rate_formatted']);
                                                                $rateNumber = str_replace('.', '', $rateNumber);
                                                                $rateNumber = str_replace(',', '.', $rateNumber);
                                                            @endphp
                                                            {{ number_format(round((float) $rateNumber), 0, ',', '.') }} VND
                                                        @else
                                                            {{ $svc['rate_formatted'] }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="text-end text-gray-700 fs-7 col-min">
                                                    {{ $svc['min_formatted'] }}</td>
                                                <td class="text-end text-gray-700 fs-7 col-max">
                                                    {{ $svc['max_formatted'] }}</td>
                                                @if($showAverageTime)
                                                <td class="text-nowrap text-end text-gray-600 fs-7 col-avg">
                                                    {{ $svc['average_time'] ?: '—' }}</td>
                                                @endif
                                                <td class="text-center pe-3 col-desc">
                                                    <button type="button"
                                                        class="btn btn-secondary btn-sm px-4 py-1"
                                                        onclick="_services.on.click.viewDescription({{ $svc['id'] }})"
                                                        data-lang="View">View</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- No results row --}}
            <div id="svc-no-result" class="text-center text-muted py-5 d-none">
                <i class="fa-regular fa-face-sad-tear fs-2 mb-2"></i>
                <div data-lang="services.no_services_found">No services found.</div>
            </div>
        </div>
    </div>

    {{-- Description modal --}}
    <div class="modal fade" id="modal-description" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-start p-5">
                    <div id="service-name"></div>
                    <div class="separator separator-dashed my-5"></div>
                    <div id="service-description"></div>
                    <a id="modal-desc-buy" href="#" target="_blank"
                        class="btn btn-primary w-100 mt-5 text-uppercase" data-lang="Buy now">Buy now</a>
                </div>
            </div>
        </div>
    </div>

    <script>var SERVICES = @json($servicesPayload);</script>
@endsection

@push('scripts')
    <script>
        _services.init();
    </script>
@endpush

