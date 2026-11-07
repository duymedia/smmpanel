@extends('clients.theme-default.layouts.app')
@section('title', 'Services')

@section('content')
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
        @if ($showMultiRate)
        <div class="m-3 text-center">
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal-cheaper" data-gtag="services_cheaper_modal|Click to show how to get cheaper rate">
                <i class="fa-solid fa-bolt-lightning fa-bounce fs-1 text-danger"></i>
                <span data-lang="cheaper" class="text-danger mx-2 fw-bolder fs-3">Bạn muốn giá rẻ hơn ?</span>
                <i class="fa-solid fa-bolt-lightning fa-bounce fs-1 text-danger"></i>
            </a>
            <div class="modal fade" id="modal-cheaper" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" data-lang="cheaper">Bạn muốn giá rẻ hơn ?</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start p-5">
                            <p><span data-lang="cheaper1">Có ba mức giá cho một dịch vụ</span>: <strong class="text-primary" data-lang="Retail">Giá bán lẻ</strong> - <strong class="text-primary" data-lang="Wholesale">Giá đại lý</strong> - <strong class="text-primary" data-lang="Reseller">Giá phân phối</strong>.</p>
                            <p><span data-lang="cheaper2">Nếu bạn muốn được giá đại lý thì tổng nạp tiền phải trên</span> <strong class="text-primary">{{ $childPanelDepositMinimum }}</strong>.</p>
                            <p><span data-lang="cheaper3">Nếu bạn muốn được giá phân phối thì tổng nạp tiền phải trên</span> <strong class="text-primary">{{ $resellerDepositMinimum }}</strong>.</p>
                            <p data-lang="cheaper4">Khi bạn được được điều kiện đó thì liên hệ với Admin để được giá mới.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
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
                                <td width="1" class="text-center align-middle">
                                    @auth
                                    <a href="javascript:;" class="svc-fav-btn d-inline-flex align-items-center justify-content-center"
                                        data-id="{{ $svc['id'] }}"
                                        data-cat="{{ $svc['category_id'] }}"
                                        data-pid="{{ $group['platform_id'] }}"
                                        onclick="_services.on.click.favorite({{ $svc['id'] }})">
                                        <i class="fa-regular fa-star text-muted fs-7"></i>
                                    </a>
                                    @endauth
                                </td>
                                <td width="1" class="fw-bold text-gray-600 fs-8 col-id">{{ $svc['id'] }}</td>
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
                                <td width="1" class="text-end col-rate">
                                    <span class="fw-bold text-primary fs-7"
                                        @if ($showMultiRate)
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                        title="{{ $svc['multi_rate_tooltip'] }}"
                                        @endif>
                                        @if (strtoupper((string) (($userCurrency ?? null)?->code ?? auth()->user()?->currency ?? 'USD')) === 'VND')
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
                                <td width="1" class="text-end text-gray-700 fs-7 col-min">
                                    {{ $svc['min_formatted'] }}
                                </td>
                                <td width="1" class="text-end text-gray-700 fs-7 col-max">
                                    {{ $svc['max_formatted'] }}
                                </td>
                                @if($showAverageTime)
                                <td width="1" class="text-nowrap text-end text-gray-600 fs-7 col-avg">
                                    @php
                                    $avgTimeV2Items = averageTimeV2Items($svc['average_time_v2'] ?? '');
                                    $avgTimeValue = $svc['average_time'] ?? null;
                                    $avgTimeDisplay = is_numeric($avgTimeValue)
                                    ? (formatAverageTime((int) $avgTimeValue) ?: '—')
                                    : (trim((string) $avgTimeValue) !== '' ? $avgTimeValue : '—');
                                    $avgTimeV2ModalItems = array_map(static function ($item) {
                                    return [
                                    'quantity' => number_format($item['quantity']),
                                    'duration' => formatAverageTimeV2Duration($item['seconds']),
                                    ];
                                    }, $avgTimeV2Items);
                                    @endphp
                                    <div class="d-inline-flex align-items-center justify-content-end gap-2">
                                        <span class="fw-semibold">{{ $avgTimeDisplay }}</span>
                                        @if ($avgTimeV2ModalItems !== [])
                                        <button type="button" class="btn btn-light-primary btn-sm rounded-2 w-25px h-25px p-0 lh-1 d-inline-flex align-items-center justify-content-center"
                                            data-average-time-v2='@json($avgTimeV2ModalItems)'
                                            data-service-name="{{ $svc['name'] }}"
                                            data-service-id="{{ $svc['id'] }}"
                                            aria-haspopup="dialog" aria-label="View average time details"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="View average time details"
                                            onclick="_services.on.click.averageTimeV2(this)">
                                            <i class="fa-regular fa-clock d-block" aria-hidden="true"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                                @endif
                                <td width="1" class="text-center pe-3 col-desc">
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

{{-- Average time v2 modal --}}
<div class="modal fade" id="modal-average-time-v2" tabindex="-1"
    aria-labelledby="modal-average-time-v2-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-4">
                <div class="d-flex flex-column">
                    <h5 class="modal-title" id="modal-average-time-v2-title" data-lang="Average time V2">Average time V2</h5>
                    <div class="text-muted fs-8" data-average-time-v2-service></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="d-flex flex-wrap gap-2" data-average-time-v2-items></div>
            </div>
        </div>
    </div>
</div>

<script>
    var SERVICES = @json($servicesPayload);
</script>
@endsection

@push('scripts')
<script>
    _services.init();
</script>
@endpush