@extends('admin.layouts.app')
@section('title', 'Services')

@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <span class="title d-none">List</span>

    <div class="row g-3 g-xl-3">
        <div class="col-md-4 col-12">
            <div class="d-flex align-items-center">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control ipt-keyword" placeholder="ID hoặc tên" data-page="/services" data-lang="ID or Name">
                    <button class="px-4 btn btn-primary btn-sm btn-icon" type="button"
                        onclick="_services.on.click.filter(document.querySelector('.ipt-keyword').value.trim())">
                        <i class="las la-search fs-2"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-start">
                <a class="btn btn-primary btn-sm me-3" href="/admin/services/add">
                    <span data-page="/services" data-lang="Add service">Thêm dịch vụ</span>
                </a>
                <a class="btn btn-primary btn-sm" href="/admin/services/import">
                    <span data-page="/services" data-lang="Import services">Nhập dịch vụ</span>
                </a>
            </div>
        </div>
    </div>

    <div class="p-5 text-muted text-end"
        onclick="_services.on.click.collapseAll(this.querySelector('i'), this.querySelector('i').className.includes('expand'))">
        <span class="fst-italic pointer" data-page="/services" data-lang="Collapse all">Thu gọn tất cả</span>
        <i class="bi bi-arrows-collapse fs-4 ms-2"></i>
    </div>

    <div class="shadow-sm card">
        <div class="p-0 card-body">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed table-hover fs-7 gy-0 gx-2 gs-3 mb-0" id="table-service">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                            <th class="w-10px"></th>
                            <th class="min-w-60px">ID</th>
                            <th class="min-w-120px" data-page="/services" data-lang="Provider">Nhà cung cấp</th>
                            <th class="min-w-300px" data-page="/services" data-lang="Service">Dịch vụ</th>
                            <th class="min-w-120px" data-page="/services" data-lang="Rate">Giá bán</th>
                            <th class="min-w-90px" data-page="/services" data-lang="Min/Max">Min/Max</th>
                            <th class="min-w-120px">
                                <span class="text-nowrap" data-page="/services" data-lang="Avg time">Thời gian TB</span>
                                <span class="ml-1 mr-1 fa fa-exclamation-circle"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-custom-class="tooltip-dark"
                                    data-page="/services"
                                    data-lang="Avg time tooltip"
                                    title="Thời gian trung bình được tính dựa trên 10 đơn hàng hoàn thành gần nhất trên mỗi số lượng 1000."></span>
                            </th>
                            <th class="w-50px"></th>
                            <th class="w-40px"></th>
                        </tr>
                    </thead>

                    @forelse ($plat_cat as $platform)
                        @php
                            $platformCategories = collect($platform['categories'] ?? []);
                            $platformServiceCount = $platformCategories->sum(function ($category) {
                                return collect($category['services'] ?? [])->count();
                            });
                            $platformActiveCount = $platformCategories->sum(function ($category) {
                                return collect($category['services'] ?? [])->where('status', 1)->count();
                            });
                            $platformDataStatus = $platformActiveCount > 0 ? 'Hide' : 'Show';
                        @endphp

                        <thead class="platform platform-{{ $platform['id'] }}">
                            <tr class="static bg-secondary">
                                <td colspan="10">
                                    <div class="d-flex align-items-center flex-nowrap gap-2">
                                        <div class="flex-grow-1 fs-5 fw-bold text-nowrap overflow-hidden">
                                            @if (!empty($platform['image']) && filter_var($platform['image'], FILTER_VALIDATE_URL))
                                                <img src="{{ $platform['image'] }}" class="me-2"
                                                    alt=""
                                                    style="width:24px;height:24px;object-fit:contain;border-radius:4px;"
                                                    loading="lazy"
                                                    onerror="this.style.display='none'">
                                            @elseif (!empty($platform['image']))
                                                <i class="{{ $platform['image'] }} me-2"></i>
                                            @else
                                                <i class="fa-solid fa-star me-2"></i>
                                            @endif
                                            <span class="ls-1 text-truncate d-inline-block align-middle mw-100">{{ $platform['name'] }}</span>
                                        </div>
                                        <div data-status="{{ $platformDataStatus }}" class="flex-shrink-0 text-end fs-8 show-hide pointer text-nowrap"
                                            style="border-bottom:0.5px dashed"
                                            onclick="_services.on.click.collapse(this, this.getAttribute('data-status'), {{ $platform['id'] }}, 'platform')">
                                            <span class="show-hide-text" data-page="common" data-lang="{{ $platformDataStatus === 'Hide' ? 'Hide' : 'Show' }}">{{ $platformDataStatus === 'Hide' ? 'Ẩn' : 'Hiện' }}</span>
                                            ({{ $platformServiceCount }})
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </thead>

                        @foreach ($platformCategories as $category)
                            @php
                                $catServices = $category['services'] instanceof \Illuminate\Support\Collection
                                    ? $category['services']
                                    : collect($category['services'] ?? []);
                                $catCount = $catServices->count();
                                $catDataStatus = $catServices->where('status', 1)->count() > 0 ? 1 : 0;
                                $catToggleStatus = $catDataStatus ? 'Hide' : 'Show';
                            @endphp

                            <thead class="category category-{{ $category['id'] }}"
                                data-status="{{ $catDataStatus }}"
                                data-cat="{{ $category['id'] }}"
                                data-platform="{{ $platform['id'] }}">
                                <tr class="static bg-secondary">
                                    <td colspan="10" class="py-2">
                                        <div class="d-flex align-items-center flex-nowrap gap-2">
                                            <div class="flex-grow-1 fs-5 fw-bold text-nowrap overflow-hidden">
                                                @if (!empty($category['image']) && filter_var($category['image'], FILTER_VALIDATE_URL))
                                                    <img src="{{ $category['image'] }}" class="me-2 ms-5"
                                                        alt=""
                                                        style="width:20px;height:20px;object-fit:contain;border-radius:4px;"
                                                        loading="lazy"
                                                        onerror="this.style.display='none'">
                                                @elseif (!empty($category['image']))
                                                    <i class="{{ $category['image'] }} me-2 ms-5"></i>
                                                @else
                                                    <i class="fa-solid fa-star me-2 ms-5"></i>
                                                @endif
                                                <span class="text-truncate d-inline-block align-middle mw-100">{{ $category['name'] }}</span>
                                            </div>
                                            <div data-status="{{ $catToggleStatus }}" class="flex-shrink-0 text-end fs-9 show-hide pointer text-nowrap"
                                                style="border-bottom:0.5px dashed"
                                                onclick="_services.on.click.collapse(this, this.getAttribute('data-status'), {{ $category['id'] }}, 'cat')">
                                            <span class="show-hide-text" data-page="common" data-lang="{{ $catToggleStatus === 'Hide' ? 'Hide' : 'Show' }}">{{ $catToggleStatus === 'Hide' ? 'Ẩn' : 'Hiện' }}</span>
                                                ({{ $catCount }})
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </thead>

                            <tbody class="tbody-{{ $category['id'] }}"
                                data-status="{{ $catDataStatus }}"
                                data-platform-id="{{ $platform['id'] }}"
                                data-cat-id="{{ $category['id'] }}">
                                @foreach ($catServices as $service)
                                    @php
                                        $isActive = (bool) $service->status;
                                        $hasSyncRate = (bool) ($service->sync_rate ?? false);
                                        $hasSyncMinMax = (bool) ($service->sync_min_max ?? false);
                                        $avgTime = formatAverageTime($service->average_time ?? 0);
                                        $attributes = $service->attributes;
                                        $badges = [];
                                        if (is_string($attributes) && $attributes !== '') {
                                            $decoded = json_decode($attributes, true);
                                            $badges = is_array($decoded) ? $decoded : [];
                                        } elseif (is_array($attributes)) {
                                            $badges = $attributes;
                                        }
                                        $badgeColors = [
                                            'Best seller' => 'danger',
                                            'Exclusive' => 'danger',
                                            'Provider Direct' => 'danger',
                                            'Instant' => 'success',
                                            'Super Fast' => 'success',
                                            'Refill' => 'success',
                                            '7 days Refill' => 'success',
                                            '15 days Refill' => 'success',
                                            '30 days Refill' => 'success',
                                            '60 days Refill' => 'success',
                                            '90 days Refill' => 'success',
                                            '365 days Refill' => 'success',
                                            'Lifetime' => 'success',
                                            'Promotion' => 'success',
                                            'Real' => 'success',
                                            'New' => 'primary',
                                            'Recommend' => 'warning',
                                        ];
                                        $fallbackColors = ['primary', 'info', 'warning', 'danger', 'success'];
                                    @endphp

                                    <tr class="row-{{ $service->id }} {{ !$isActive ? 'text-muted' : '' }} service fs-7"
                                        data-id="{{ $service->id }}"
                                        data-status="{{ $isActive ? 1 : 0 }}"
                                        data-platform="{{ $platform['id'] }}"
                                        data-category="{{ $category['id'] }}"
                                        data-psid="{{ $service->service_api ?? '' }}"
                                        style="{{ $isActive && $catDataStatus ? '' : 'display:none' }}">
                                        <td width="1"><i class="fas fa-bars"></i></td>
                                        <td width="1">
                                            <span class="fw-bolder fs-6 ls-1">{{ $service->id }}</span>
                                            <p class="mb-0 text-muted fs-7 text-nowrap">
                                                {{ $service->type_service ?? 'Default' }}
                                                @if ($service->refill)
                                                    <i class="las la-fill-drip fs-6 ms-1 text-success"></i>
                                                @endif
                                                @if ($service->cancel)
                                                    <i class="las la-ban fs-7 text-warning"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-lang="Cancel enabled"
                                                        title="Hủy"></i>
                                                @endif
                                                @if (!$isActive)
                                                    <i class="las la-ban fs-7 text-danger"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Vô hiệu hóa"></i>
                                                @endif
                                            </p>
                                        </td>
                                        <td width="1">
                                            {{ $service->provider_name ?? '' }}
                                            <p class="mb-0 text-muted fs-7">{{ $service->service_api ?? '' }}</p>
                                        </td>
                                        <td class="service-name">
                                            {{ trim($service->getName()) }}
                                            @if (!empty($badges))
                                            <p class="mb-1 text-muted">
                                                @foreach ($badges as $badge)
                                                    @php
                                                        $label = is_array($badge) ? ($badge['label'] ?? '') : $badge;
                                                        $fallback = $fallbackColors[abs(crc32($label)) % count($fallbackColors)];
                                                        $color = is_array($badge) ? ($badge['color'] ?? $fallback) : ($badgeColors[$label] ?? $fallback);
                                                    @endphp
                                                    @if ($label !== '')
                                                        <span class="badge badge-outline badge-{{ $color }} fw-light fs-9 py-1 px-1 me-1"
                                                            data-lang="label::{{ $label }}">{{ $label }}</span>
                                                    @endif
                                                @endforeach
                                            </p>
                                            @endif
                                        </td>
                                        <td width="1" class="text-nowrap">
                                            <span class="d-block">
                                                <i class="invisible fa fa-circle text-secondary fs-10 me-1" aria-hidden="true"></i>{{ formatCharge($service->rate_retail) }} -
                                                {{ formatCharge($service->rate_agent) }} -
                                                {{ formatCharge($service->rate_distributor) }}
                                            </span>
                                            <span class="text-gray-600 fs-7 d-block">
                                                <i class="fa fa-circle {{ $hasSyncRate ? 'text-success' : 'text-secondary' }} fs-10 me-1"
                                                    aria-hidden="true"></i>{{ formatCharge($service->rate_original ?? $service->rate_retail) }}
                                            </span>
                                        </td>
                                        <td width="1" class="text-nowrap">
                                            <span class="d-block">
                                                <i class="invisible fa fa-circle text-secondary fs-10 me-1" aria-hidden="true"></i>{{ number_format($service->min ?? 0, 0, '.', '') }}
                                            </span>
                                            <span class="text-gray-600 fs-7 d-block">
                                                <i class="fa fa-circle {{ $hasSyncMinMax ? 'text-success' : 'text-secondary' }} fs-10 me-1"
                                                    aria-hidden="true"></i>{{ number_format($service->max ?? 0, 0, '.', '') }}
                                            </span>
                                        </td>
                                        <td width="1" class="text-nowrap">
                                            @if ($avgTime)
                                                {{ $avgTime }}
                                            @else
                                                <span class="text-muted"></span>
                                            @endif
                                        </td>
                                        <td width="1">
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input h-15px w-25px"
                                                    type="checkbox"
                                                    value="{{ $service->id }}"
                                                    {{ $isActive ? 'checked' : '' }}
                                                    data-cat-status="{{ $catDataStatus }}"
                                                    onchange="_services.on.change.statusService(this.value, this.checked, this.getAttribute('data-cat-status'))">
                                            </div>
                                        </td>
                                        <td width="1">
                                            <a href="/admin/services/edit?id={{ $service->id }}">
                                                <i class="bi bi-pencil fs-8"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endforeach
                    @empty
                        <tbody>
                            <tr>
                                <td colspan="10" class="py-10 text-center text-muted">Chưa có dịch vụ</td>
                            </tr>
                        </tbody>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>typeof _services !== 'undefined' && typeof _services.init !== 'undefined' && _services.init();</script>
@endpush
