@extends('admin.layouts.app')
@section('title', 'Edit service')

@php
    $serviceId = $service->id ?? request('id');
    $featureOptions = [
        'Owner', 'Exclusive', 'Provider Direct', 'New', 'Best seller', 'Promotion', 'Recommend', 'Instant',
        'Super Fast', 'Real', 'Lifetime', '7 days Refill', '15 days Refill', '30 days Refill', '60 days Refill',
        '90 days Refill', '365 days Refill', 'No refill', 'Auto Refill', 'No refund', 'Refill Button', 'Cancel Button',
    ];
@endphp

@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <span class="title d-none">Edit</span>

        <div class="mb-5 shadow-sm card div-service">
            <div class="card-header">
                <div class="card-title">
                    <div class="form-check form-switch form-check-custom form-check-solid form-check-primary">
                        <input class="form-check-input cb-service-status" type="checkbox" checked>
                        <input class="form-check-input cb-service-oldstatus d-none" type="checkbox" checked>
                        <label class="form-check-label fs-3 fw-bold" data-lang="/services::Status">Trạng thái</label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <div class="mb-5 me-15 d-none">
                        <label class="form-label" data-lang="/services::Schedule">Schedule</label>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input cb-service-schedule" type="checkbox" checked>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2">
                        <div class="mb-5">
                            <label class="required form-label" data-lang="/services::Add Type">Dạng kết nối</label>
                            <select class="form-select form-select-solid sl-service-add-type" data-kt-select2="true"
                                data-hide-search="true" onchange="_services.on.change.addType(this.value)">
                                <option value="Manual" data-lang="/services::Manual">Thủ công</option>
                                <option value="Api" data-lang="/services::API">API</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-5 div-type-api" style="display: none;">
                                    <label class="required form-label" data-lang="/services::Providers">Nhà cung cấp</label>
                                    <select class="form-select form-select-solid sl-provider" id="providerSelect"
                                        data-kt-select2="true" data-placeholder="Choose provider"
                                        data-page="/services" data-lang-placeholder="/services::Choose provider"
                                        onchange="_services.on.change.provider(this.value, this.selectedOptions[0].getAttribute('data-type'))">
                                        <option value="0" data-type="" data-lang="/services::Choose">Choose</option>
                                        @foreach ($providers as $provider)
                                            <option value="{{ $provider->id }}" data-type="api"
                                                data-fixed-decimal="{{ $provider->fixed_decimal ?? 10 }}"
                                                data-rate="{{ $provider->rate_api ?? ($provider->rate ?? 1) }}">
                                                {{ $provider->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-9" style="display: none;">
                                <div class="mb-5 div-type-api"></div>
                            </div>
                        </div>
                        <div class="mb-5 div-oprice">
                            <label class="required form-label" data-lang="/services::Price of provider">Giá nhà cung cấp</label>
                            <input type="number" step="any" class="form-control form-control-solid ipt-service-oprice"
                                oninput="this.closest('.div-service').querySelector('.ipt-service-oldprice').value = this.value"
                                onkeyup="_services.on.keyup.oprice(this.value)">
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="required form-label" data-lang="/services::Category">Danh mục</label>
                    <select class="form-select form-select-solid sl-category">
                        @foreach ($categories as $category)
                            @php
    $serviceId = $service->id ?? request('id');
                                $categoryRawName = $category->name;
                                $categoryName = method_exists($category, 'getName')
                                    ? $category->getName()
                                    : (is_array($categoryRawName)
                                        ? ($categoryRawName['en'] ?? (array_values($categoryRawName)[0] ?? ''))
                                        : $categoryRawName);
                            @endphp
                            <option value="{{ $category->id }}" data-icon="{{ $category->image ?? '' }}">
                                {{ $category->platform->name ?? '' }} | {{ $categoryName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">
                        <span data-lang="/services::Label Features">Nhãn thông tin</span>
                        <button class="px-2 py-0 btn btn-sm btn-outline btn-outline-primary ms-2 btn-copy btn-copy-feature"
                            onclick="_services.on.click.copyFromProvider('feature')" style="display: none;" data-lang="/services::Copy from provider">
                            Sao chép từ nhà cung cấp
                        </button>
                    </label>
                    <select class="form-select form-select-solid sl-features" data-control="select2"
                        data-close-on-select="false" data-placeholder="Choose"
                        data-lang-placeholder="/services::Choose" data-allow-clear="true" multiple>
                        <option></option>
                        @foreach ($featureOptions as $feature)
                            <option value="{{ $feature }}" data-lang="label::{{ $feature }}">{{ $feature }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-5 shadow-sm card card-title">
            <div class="card-body">
                <div class="mb-5">
                    <label class="required form-label" data-lang="/services::Name">Tên dịch vụ</label>
                    <input type="text" class="form-control form-control-solid ipt-service-name">
                </div>
                <div id="div-translated-name"></div>
                @if (isset($languages) && $languages->count() > 0)
                    <a class="btn btn-secondary btn-sm" href="javascript:void(0);" role="button"
                        data-bs-toggle="dropdown" data-lang="/services::Add translated name">Thêm tên ngôn ngữ khác</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        @foreach ($languages as $language)
                            @php $flagCode = $language->code === 'vi' ? 'vn' : $language->code; @endphp
                            <a href="javascript:;" class="dropdown-item ai-icon"
                                onclick="_services.on.click.addTranslatedName('{{ $flagCode }}')">
                                <span class="rounded-1 fi fi-{{ $flagCode }} fs-4"></span>
                                <span class="ms-2">{{ $language->name }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-5 shadow-sm card card-sync">
            <div class="card-header" style="display: none;">
                <div class="card-title">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input cb-sync cb-service-sync" type="checkbox"
                            onchange="_services.on.change.sync(1)">
                        <label class="form-check-label fs-3 fw-bold" data-lang="/services::Auto sync">Tự động đồng bộ tất cả</label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-5">
                    <div class="col-lg-4 col-sm-6">
                        <fieldset class="p-2 border border-2 rounded">
                            <legend class="float-none w-auto p-2 mb-0 show-api">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input cb-sync cb-service-sync-rate w-30px h-20px" type="checkbox"
                                        onchange="_services.on.change.sync()">
                                    <label class="form-check-label fs-7" data-lang="/services::Sync?">Đồng bộ?</label>
                                </div>
                            </legend>
                            <input type="number" step="any" class="form-control ipt-service-oldprice d-none">
                            <div class="mb-5">
                                <label class="required form-label">
                                    <span data-lang="/services::Retail Rate">Giá bán lẻ</span>
                                    <span class="show-api"> | <span class="data-api"></span></span>
                                </label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text bg-secondary">$</span>
                                    <input type="text" class="form-control ipt-service-price"
                                        value="{{ number_format((float) ($service->rate_original ?? 0) * (float) ($service->rate_retail_up ?? 100) / 100, 8, '.', '') }}"
                                        onkeyup="_services.on.keyup.retail_rate(this.value)">
                                    <input type="text" class="border-2 form-control border-start float-end text-end ipt-service-price-percent"
                                        value="{{ $service->rate_retail_up ?? ($markupConfig['markup_retail'] ?? 110) }}"
                                        onkeyup="_services.on.keyup.price_percent(this.value, 0)"
                                        data-inputmask="'mask': '9{1,4}.9{1,2}', 'greedy': false, 'placeholder': '0'">
                                    <span class="input-group-text bg-secondary">%</span>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="required form-label" data-lang="/services::Wholesale Rate - Child">Giá đại lý</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text bg-secondary">$</span>
                                    <input type="number" step="any" class="form-control ipt-service-price-1"
                                        value="{{ number_format((float) ($service->rate_original ?? 0) * (float) ($service->rate_agent_up ?? 100) / 100, 8, '.', '') }}">
                                    <input type="text" class="border-2 form-control border-start float-end text-end ipt-service-price-1-percent"
                                        value="{{ $service->rate_agent_up ?? ($markupConfig['markup_agent'] ?? 108) }}"
                                        onkeyup="_services.on.keyup.price_percent(this.value, 1)"
                                        data-inputmask="'mask': '9{1,4}.9{1,2}', 'greedy': false, 'placeholder': '0'">
                                    <span class="input-group-text bg-secondary">%</span>
                                </div>
                            </div>
                            <div>
                                <label class="required form-label" data-lang="/services::Wholesale Rate - Reseller">Giá nhà phân phối</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text bg-secondary">$</span>
                                    <input type="number" step="any" class="form-control ipt-service-price-2"
                                        value="{{ number_format((float) ($service->rate_original ?? 0) * (float) ($service->rate_distributor_up ?? 100) / 100, 8, '.', '') }}">
                                    <input type="text" class="border-2 form-control border-start float-end text-end ipt-service-price-2-percent"
                                        value="{{ $service->rate_distributor_up ?? ($markupConfig['markup_distributor'] ?? 105) }}"
                                        onkeyup="_services.on.keyup.price_percent(this.value, 2)"
                                        data-inputmask="'mask': '9{1,4}.9{1,2}', 'greedy': false, 'placeholder': '0'">
                                    <span class="input-group-text bg-secondary">%</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <fieldset class="p-2 mb-5 border border-2 rounded">
                            <legend class="float-none w-auto p-2 mb-0 show-api">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input cb-sync cb-service-sync-minmax w-30px h-20px" type="checkbox"
                                        onchange="_services.on.change.sync()">
                                    <label class="form-check-label fs-7" data-lang="/services::Sync?">Đồng bộ?</label>
                                </div>
                            </legend>
                            <div class="mb-5">
                                <label class="required form-label">
                                    <span data-lang="/services::Min/Max">SL đặt hàng: Tối thiểu-Tối đa</span>
                                    <span class="show-api"> | <span class="data-api"></span></span>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-solid ipt-service-min"
                                        data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false">
                                    <span class="border-0 input-group-text bg-secondary">-</span>
                                    <input type="text" class="form-control form-control-solid ipt-service-max"
                                        data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false">
                                </div>
                            </div>
                        </fieldset>
                        <div class="mb-5">
                            <label class="required form-label" data-lang="/services::Total/User Limit">Giới hạn số đơn hàng: Tổng - Từng khách hàng</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-solid ipt-service-tlimit" value="100000"
                                    data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false">
                                <span class="border-0 input-group-text bg-secondary">-</span>
                                <input type="text" class="form-control form-control-solid ipt-service-limit" value="100000"
                                    data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false">
                            </div>
                        </div>
                        <div>
                            <label class="required form-label">
                                <span data-lang="/services::Order Type">Kiểu dịch vụ</span>
                                <span class="show-api"> | <span class="data-api"></span></span>
                            </label>
                            <select class="form-select form-select-solid sl-service-type" data-kt-select2="true"
                                data-hide-search="true" onchange="_services.on.change.type(this.value)">
                                <option value="Default" data-lang="Default">Default</option>
                                <option value="Custom Comments" data-lang="/services::Custom Comments">Custom Comments</option>
                                <option value="Package" data-lang="/services::Package">Package</option>
                                <option value="Special" data-lang="/services::Special">Special</option>
                                <option value="Special 1" data-lang="/services::Special 1">Special 1</option>
                                <option value="Mentions" data-lang="/services::Mentions">Mentions</option>
                                <option value="Mentions with Hashtags" data-lang="/services::Mentions with Hashtags">Mentions with Hashtags</option>
                                <option value="Mentions User Followers" data-lang="/services::Mentions User Followers">Mentions User Followers</option>
                                <option value="Mentions Custom List" data-lang="/services::Mentions Custom List">Mentions Custom List</option>
                                <option value="Mentions Hashtag" data-lang="/services::Mentions Hashtag">Mentions Hashtag</option>
                                <option value="Mentions Media Likers" data-lang="/services::Mentions Media Likers">Mentions Media Likers</option>
                                <option value="Comment Likes" data-lang="/services::Comment Likes">Comment Likes</option>
                                <option value="Invites from Groups" data-lang="/services::Invites from Groups">Invites from Groups</option>
                                <option value="SEO" data-lang="/services::SEO">SEO</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <fieldset class="p-2 mb-3 border border-2 rounded">
                            <legend class="float-none w-auto p-2 mb-0 show-api">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input cb-sync cb-service-sync-refill w-30px h-20px" type="checkbox"
                                        onchange="_services.on.change.sync()">
                                    <label class="form-check-label fs-7" data-lang="/services::Sync?">Đồng bộ?</label>
                                </div>
                            </legend>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input cb-service-refill" type="checkbox">
                                <label class="form-check-label required">
                                    <span data-lang="/services::Refill request">Yêu cầu bảo hành</span>
                                    <span class="show-api"> | <span class="data-api"></span></span>
                                </label>
                            </div>
                        </fieldset>
                        <fieldset class="p-2 border border-2 rounded">
                            <legend class="float-none w-auto p-2 mb-0 show-api">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input cb-sync cb-service-sync-cancel w-30px h-20px" type="checkbox"
                                        onchange="_services.on.change.sync()">
                                    <label class="form-check-label fs-7" data-lang="/services::Sync?">Đồng bộ?</label>
                                </div>
                            </legend>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input cb-service-cancel" type="checkbox">
                                <label class="form-check-label required">
                                    <span data-lang="/services::Cancel request">Yêu cầu hủy</span>
                                    <span class="show-api"> | <span class="data-api"></span></span>
                                </label>
                            </div>
                        </fieldset>
                        <fieldset class="p-2 border border-2 rounded">
                            <legend class="float-none w-auto p-2 mb-0 show-api">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input cb-sync cb-service-sync-status w-30px h-20px" type="checkbox"
                                        onchange="_services.on.change.sync()">
                                    <label class="form-check-label fs-7" data-lang="/services::Sync?">Đồng bộ?</label>
                                </div>
                            </legend>
                            <div class="fst-italic text-muted" data-lang="/services::When the provider disables service, will the service be disabled">Khi nhà cung cấp vô hiệu hóa dịch vụ, dịch vụ sẽ bị vô hiệu hóa?</div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-wrap mt-6 d-flex flex-stack">
            <h3 class="my-2 fw-bold">
                <span data-lang="/services::Summary">Thông số dịch vụ</span>
                <button class="px-2 py-0 btn btn-sm btn-outline btn-outline-primary ms-2 btn-copy btn-copy-summary"
                    onclick="_services.on.click.copyFromProvider('summary')" style="display: none;" data-lang="/services::Copy from provider">Sao chép từ nhà cung cấp</button>
            </h3>
        </div>
        <p class="mb-6 fst-italic" data-lang="/services::Use for display services as table for category">Dùng để hiển thị dịch vụ dưới dạng bảng cho danh mục</p>
        <div class="mb-5 shadow-sm card card-summary">
            <div class="card-body">
                <div class="row g-5">
                    @foreach ([
                        'start_time' => ['Thời gian bắt đầu', 'summary::Start time', ['Instant', '1-2h', '1-6h', '6-12h', '0-24h', '24-48h']],
                        'guarantee' => ['Bảo hành', 'summary::Guarantee', ['7 days refill', '15 days refill', '30 days refill', '60 days refill', '90 days refill', '180 days refill', '365 days refill', 'Lifetime', 'No refill', 'No refund']],
                        'real_user' => ['Người dùng thật', 'summary::Real user', ['Yes', 'No']],
                    ] as $key => $summary)
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="input-group input-group-solid" data-key="{{ $key }}">
                                <span class="input-group-text bg-secondary">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input h-20px w-20px" type="checkbox">
                                        <label class="form-check-label" data-lang="{{ $summary[1] }}">{{ $summary[0] }}</label>
                                    </div>
                                </span>
                                <input type="text" class="form-control {{ !empty($summary[3]) ? 'input-multi' : '' }}"
                                    list="list_{{ $key }}" {{ !empty($summary[3]) ? 'multiple' : '' }}
                                    onkeyup="_services.on.change.summary()">
                                <datalist id="list_{{ $key }}">
                                    @foreach ($summary[2] as $option)
                                        <option>{{ $option }}</option>
                                    @endforeach
                                </datalist>
                                @if (!empty($summary[4]))
                                    <span class="input-group-text bg-secondary">{{ $summary[4] }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="input-group input-group-solid" data-key="speed">
                            <span class="input-group-text bg-secondary">
                                <div class="form-check form-check-custom">
                                    <input class="form-check-input h-20px w-20px" type="checkbox">
                                    <label class="form-check-label" data-lang="summary::Speed">Tốc độ</label>
                                </div>
                            </span>
                            <input type="text" class="form-control" onkeyup="_services.on.change.summary()">
                            <span class="input-group-text bg-secondary">/</span>
                            <select class="form-select form-select-solid bg-secondary">
                                <option value="hour" data-lang="common::hour">hour</option>
                                <option value="day" data-lang="common::day">day</option>
                            </select>
                        </div>
                    </div>
                    @foreach ([
                        'source' => ['Nguồn', 'summary::Source', ['Suggested videos', 'External', 'Browse Features', 'Youtube Search', 'Google Search', 'YouTube advertising', 'Playlists', 'Channel pages', 'Direct or unknown'], true],
                        'drop_rate' => ['Tỉ lệ tụt', 'summary::Drop rate', ['5', '10', '15', '20', '25', '30', '40', '50', '100'], false, '%'],
                    ] as $key => $summary)
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="input-group input-group-solid" data-key="{{ $key }}">
                                <span class="input-group-text bg-secondary">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input h-20px w-20px" type="checkbox">
                                        <label class="form-check-label" data-lang="{{ $summary[1] }}">{{ $summary[0] }}</label>
                                    </div>
                                </span>
                                <input type="text" class="form-control {{ !empty($summary[3]) ? 'input-multi' : '' }}"
                                    list="list_{{ $key }}" {{ !empty($summary[3]) ? 'multiple' : '' }}
                                    onkeyup="_services.on.change.summary()">
                                <datalist id="list_{{ $key }}">
                                    @foreach ($summary[2] as $option)
                                        <option>{{ $option }}</option>
                                    @endforeach
                                </datalist>
                                @if (!empty($summary[4]))
                                    <span class="input-group-text bg-secondary">{{ $summary[4] }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="input-group input-group-solid" data-key="retention">
                            <span class="input-group-text bg-secondary">
                                <div class="form-check form-check-custom">
                                    <input class="form-check-input h-20px w-20px" type="checkbox">
                                    <label class="form-check-label" data-lang="summary::Retention">Thời gian xem</label>
                                </div>
                            </span>
                            <input type="text" class="form-control" onkeyup="_services.on.change.summary()">
                            <select class="form-select form-select-solid bg-secondary">
                                <option value="seconds" data-lang="common::seconds">seconds</option>
                                <option value="minutes" data-lang="common::minutes">minutes</option>
                                <option value="hours" data-lang="common::hours">hours</option>
                            </select>
                        </div>
                    </div>
                    @foreach ([
                        'device' => ['Thiết bị', 'summary::Device', ['Mobile phone', 'Computer', 'TV'], true],
                        'country' => ['Quốc gia', 'summary::Country', ['VN', 'US', 'TH', 'ID', 'PH', 'MY', 'SG', 'IN', 'BR', 'MX'], true],
                    ] as $key => $summary)
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="input-group input-group-solid" data-key="{{ $key }}">
                                <span class="input-group-text bg-secondary">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input h-20px w-20px" type="checkbox">
                                        <label class="form-check-label" data-lang="{{ $summary[1] }}">{{ $summary[0] }}</label>
                                    </div>
                                </span>
                                <input type="text" class="form-control input-multi" list="list_{{ $key }}" multiple
                                    onkeyup="_services.on.change.summary()">
                                <datalist id="list_{{ $key }}">
                                    @foreach ($summary[2] as $option)
                                        <option>{{ $option }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex-wrap my-6 d-flex flex-stack">
            <h3 class="my-2 fw-bold"><span data-lang="/services::Description">Mô tả dịch vụ</span> <button class="px-2 py-0 btn btn-sm btn-outline btn-outline-primary ms-2 btn-copy btn-copy-desc" onclick="_services.on.click.copyFromProvider('desc')" style="display: none;" data-lang="/services::Copy from provider">Sao chép từ nhà cung cấp</button></h3>
        </div>
        <div class="shadow-sm card"><div class="p-0 card-body"><div class="bg-transparent txa-service-description h-300px"></div></div></div>

        <div class="div-card-overflow" style="display: none;">
            <div class="mt-6">
                <div class="form-check form-switch form-check-custom">
                    <input class="form-check-input cb-service-overflow" type="checkbox" onchange="document.querySelector('.card-overflow').setAttribute('style', this.checked ? '' : 'display: none;')">
                    <label class="text-gray-900 form-check-label fs-3 fw-bold" data-lang="/services::Overflow">Overflow</label>
                </div>
            </div>
            <div class="mt-0 row g-5 card-overflow" style="display: none;">
                <div class="col-xl-12">
                    <div class="shadow-sm card">
                        <div class="card-body">
                            <label class="required form-label" data-lang="/services::Value">Giá trị</label>
                            <div class="mb-2 input-group input-group-solid">
                                <input type="number" step="1" min="-100" max="100" class="text-end form-control ipt-overflow" value="10">
                                <span class="input-group-text bg-secondary">%</span>
                            </div>
                            <span class="fst-italic" data-lang="/services::Overflow-desc">Nếu bạn nhập -10% thì khi khách hàng đặt hàng số lượng 1000, hệ thống sẽ gửi đặt hàng số lượng 900 cho nhà cung cấp. Nếu bạn nhập 10% thì hệ thống sẽ gửi số lượng là 1100.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-wrap mt-6 d-flex flex-stack"><div class="form-check form-switch form-check-custom"><input class="form-check-input cb-service-advanced-settings" type="checkbox" onchange="document.querySelector('.card-advanced-settings').setAttribute('style', this.checked ? '' : 'display: none;')"><label class="text-gray-900 form-check-label fs-3 fw-bold" data-lang="/services::Advanced settings">Cài đặt nâng cao</label></div></div>
        <div class="mt-0 row g-5 card-advanced-settings" style="display: none;"><div class="col-xl-12"><div class="shadow-sm card"><div class="card-body"><div class="row"><div class="col-lg-6"><div class="mb-5"><label class="required form-label" data-lang="/services::Advanced settings 1">Số dư tối thiểu để có thể mua</label><input type="text" class="form-control form-control-solid ipt-advanced-min-balance" value="0"></div><div><label class="required form-label" data-lang="/services::Advanced settings 2">Tối đa số đơn hàng trên từng tài khoản</label><input type="text" class="mb-2 form-control form-control-solid ipt-advanced-max-order" value="0" data-inputmask="'mask': '9', 'repeat': 4, 'greedy' : false"><span class="text-muted" data-lang="/services::Advanced settings 3">Để 0 nếu không muốn giới hạn</span></div></div></div></div></div></div></div>

        <div class="flex-wrap mt-6 d-flex flex-stack"><div class="form-check form-switch form-check-custom"><input class="form-check-input cb-service-quantity-discount" type="checkbox" onchange="document.querySelector('.card-discount').setAttribute('style', this.checked ? '' : 'display: none;')"><label class="text-gray-900 form-check-label fs-3 fw-bold" data-lang="/services::Quantity discount">Giảm giá</label></div></div>
        <div class="mt-0 row g-5 card-discount" style="display: none;"><div class="col-xl-12"><div class="shadow-sm card"><div class="card-body"><div class="div-conditions"></div><button type="button" class="btn btn-secondary btn-sm" onclick="_services.on.click.addConditionQuantityDiscount()" data-lang="/services::Add condition">Thêm điều kiện</button></div></div></div></div>

        <div class="flex-wrap mt-6 d-flex flex-stack div-card-check-count"><div class="form-check form-switch form-check-custom"><input class="form-check-input cb-service-check-count" type="checkbox" onchange="document.querySelector('.card-check-count').setAttribute('style', this.checked ? '' : 'display: none;')"><label class="text-gray-900 form-check-label fs-3 fw-bold"><span data-lang="/services::Check count order">Check count order (Get start count and complete the order)</span> <span class="text-danger" data-lang="/services::Beta time">*BETA TIME*</span></label></div></div>
        <div class="shadow-sm card card-check-count" style="display: none;"><div class="card-body"><div class="row"><div class="mb-5 col-lg-6"><label class="required form-label" data-lang="/services::Type">Type</label><select class="form-select sl-check-count-type" data-kt-select2="true"><option value="youtube-view" data-lang="/services::Youtube - Views">Youtube - Views</option><option value="youtube-like" data-lang="/services::Youtube - Likes">Youtube - Likes</option><option value="youtube-comment" data-lang="/services::Youtube - Comments">Youtube - Comments</option><option value="youtube-subscriber" data-lang="/services::Youtube - Subscribers">Youtube - Subscribers</option></select></div><div class="col-lg-6"><label class="required form-label" data-lang="/services::Complete when over quantity">Complete when over quantity</label><div class="mb-5 input-group"><input type="text" class="text-end form-control ipt-check-count-percent" data-inputmask="'mask': '9', 'repeat': 2, 'greedy' : false" value="0"><span class="input-group-text">%</span></div><div class="form-check form-switch form-check-solid"><input class="form-check-input cb-check-count-auto-check-completion" type="checkbox"><label class="form-check-label" data-lang="/services::Automatically check order completion">Automatically check order completion</label></div></div></div></div></div>

        <div class="flex-wrap mt-6 d-flex flex-stack"><div class="form-check form-switch form-check-custom"><input class="form-check-input cb-service-avg-time" type="checkbox" onchange="document.querySelector('.card-avg-time').setAttribute('style', this.checked ? '' : 'display: none;')"><label class="text-gray-900 form-check-label fs-3 fw-bold" data-lang="/services::Set average time">Thiết lập thời gian trung bình</label></div></div>
        <div class="mt-0 row g-5 card-avg-time" style="display: none;"><div class="col-12"><div class="shadow-sm card"><div class="card-body"><div class="row"><div class="col-xl-12"><label class="required form-label" data-lang="/services::Time">Thời gian (tính bằng giây)</label><div class="mb-5 input-group input-group-solid"><span class="input-group-text bg-text text-avg-time">0</span><input type="text" class="form-control ipt-service-avg-time" data-inputmask="'mask': '9', 'repeat': 9, 'greedy' : false" value="0" onkeyup="document.querySelector('.text-avg-time').textContent = app.timeAvg(this.value.trim())"></div></div></div></div></div></div></div>

        <div class="flex-wrap mt-6 d-flex flex-stack"><div class="form-check form-switch form-check-custom"><input class="form-check-input cb-hidden-api" type="checkbox"><label class="text-gray-900 form-check-label fs-3 fw-bold" data-lang="/services::Restrict access to this service in the API">Hạn chế truy cập dịch vụ này trong API</label></div></div>
        <div class="flex-wrap mt-6 d-flex flex-stack"><div class="form-check form-switch form-check-custom"><input class="form-check-input cb-news" type="checkbox" checked><label class="text-gray-900 form-check-label fs-3 fw-bold"><span data-lang="/services::Update to">Cập nhật</span> <a target="_blank" href="/admin/news" data-lang="/services::NEWS">Thông báo</a></label></div></div>

        <div class="flex-wrap mt-6 d-flex flex-stack"><div class="form-check form-switch form-check-custom"><input class="form-check-input cb-change-provider" type="checkbox"><label class="text-gray-900 form-check-label fs-3 fw-bold"><span data-lang="/services::Change provider for current orders">Change provider for current orders</span>: <span class="text-danger text-uppercase" data-lang="status::Failed">Failed</span>, <span class="text-uppercase" data-lang="status::Awaiting">Awaiting</span></label></div></div>
        <div class="mt-6 row g-5"><div class="col-12"><button type="button" class="btn btn-primary w-100" onclick="_services.on.click.update('{{ $serviceId }}')" data-lang="button::Update">Update</button><button type="button" class="mt-5 btn btn-sm btn-danger w-100" onclick="_services.on.click.delete('{{ $serviceId }}')" data-lang="button::Delete">Delete</button></div></div>
    </div>
@endsection

@push('scripts')
<script>
    typeof _services !== 'undefined' && typeof _services.init !== 'undefined' && _services.init();
</script>
@endpush
