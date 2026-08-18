@extends('clients.theme-6.layouts.app')

@section('title', __('newOrder.title'))

@section('content')
    <div id="block_107">
        <div class="block-bg"></div>
        <div class="container-fluid">
            <div class="new_order-block ">
                <div class="row new-order-form">
                    <div class="col-lg-8">
                        <div class="component_form_group component_card component_radio_button component_platforms">
                            <div class="card ">
                                <form action="{{ route('clients.orders.store') }}" method="post" id="order-form">
                                    @csrf
                                    {{-- Alert error --}}
                                    <div class="alert alert-dismissible mb-3 js-order-alert alert-danger" role="alert"
                                        id="js-order-alert-error" style="display:none;">
                                        <button type="button" class="close" data-hide="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="text"></div>
                                    </div>
                                    {{-- Alert success --}}
                                    <div class="alert alert-dismissible mb-3 js-order-alert alert-success" role="alert"
                                        id="js-order-alert-success" style="display:none;">
                                        <button type="button" class="close" data-hide="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="text"></div>
                                    </div>

                                    <div class="component_button_forms">
                                        {{-- Search --}}
                                        <div class="form-group">
                                            <div class="search-dropdown select2-container--default select2-container--below"
                                                id="search-container" style="position:relative;">
                                                <div class="input-wrapper">
                                                    <button type="button" class="input-wrapper__prepend">
                                                        <span class="fas fa-search"></span>
                                                    </button>
                                                    <input id="service-search-input"
                                                        placeholder="{{ __('newOrder.search') }}"
                                                        class="select2-selection select2-selection--single form-control"
                                                        autocomplete="off" type="text">
                                                    <button type="button" class="input-wrapper__append"
                                                        id="search-clear-btn" style="display:none;">
                                                        <span class="fas fa-times"></span>
                                                    </button>
                                                </div>
                                                <div id="search-results-container" style="position:relative;">
                                                    <span id="search-dropdown-wrapper"
                                                        class="select2-container select2-container--default select2-container--open"
                                                        style="position:absolute;top:0;left:0;width:100%;display:none;z-index:1050;">
                                                        <span class="select2-dropdown dropdown-menu select2-dropdown--below"
                                                            style="width:100%;">
                                                            <span class="select2-results">
                                                                <div style="max-height:300px;overflow-y:auto;">
                                                                    <ul role="group"
                                                                        class="select2-results__options dropdown-menu"
                                                                        id="search-results-list" style="padding:0;"></ul>
                                                                </div>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Category --}}
                                        <div class="form-group">
                                            <label for="orderform-category"
                                                class="control-label">{{ __('newOrder.category') }}</label>
                                            <select class="form-control select2-hidden-accessible" id="orderform-category"
                                                name="category" data-select="true" data-select-search="true"
                                                data-select-search-placeholder="{{ __('newOrder.search') }}"
                                                data-select-container="#select-category-container" tabindex="-1"
                                                aria-hidden="true">
                                                {{-- Option Favorites: chỉ hiển thị khi có favorite_services trong localStorage --}}
                                                @foreach ($data['categories'] as $category)
                                                    @php
                                                        $img = $category['image'] ?? '';
                                                        $dataIcon = '';
                                                        if ($img) {
                                                            if (
                                                                str_starts_with($img, 'http') ||
                                                                str_starts_with($img, '/') ||
                                                                str_contains($img, '.')
                                                            ) {
                                                                $dataIcon =
                                                                    '<img src="' .
                                                                    e($img) .
                                                                    '" style="width:16px;height:16px;object-fit:contain;">';
                                                            } else {
                                                                $dataIcon = '<span class="' . e($img) . '"></span>';
                                                            }
                                                        }
                                                    @endphp
                                                    <option value="{{ $category['id'] }}"
                                                        data-category-id="{{ $category['id'] }}"
                                                        data-platform_id="{{ $category['platform_id'] }}"
                                                        @if ($dataIcon) data-icon="{{ $dataIcon }}" @endif>
                                                        {{ $category['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div id="select-category-container" class="position-relative"></div>
                                        </div>

                                        {{-- Service --}}
                                        <div class="form-group">
                                            <label for="orderform-service"
                                                class="control-label">{{ __('newOrder.service') }}</label>
                                            <div class="d-flex">
                                                <div class="w-100 new_order-block__services-list">
                                                    <select class="form-control select2-hidden-accessible"
                                                        id="orderform-service" name="service" data-select="true"
                                                        data-select-search="true"
                                                        data-select-search-placeholder="{{ __('newOrder.search') }}"
                                                        data-select-container="#select-service-container" tabindex="-1"
                                                        aria-hidden="true">
                                                    </select>
                                                    <div id="select-service-container" class="position-relative"></div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Description --}}
                                        <div class="form-group fields component_service_description"
                                            id="service_description">
                                            <label for="service_description"
                                                class="control-label">{{ __('newOrder.description') }}</label>
                                            <div class="panel-description"><br></div>
                                        </div>

                                        <div id="fields">
                                            <div class="form-group hidden fields" id="order_user_name">
                                                <label class="control-label"
                                                    for="field-orderform-fields-user_name">Username</label>
                                                <input class="form-control w-full" name="OrderForm[user_name]"
                                                    value="" type="text" id="field-orderform-fields-user_name">
                                            </div>
                                            <div class="form-group fields" id="order_link">
                                                <label class="control-label"
                                                    for="field-orderform-fields-link">{{ __('newOrder.link') }}</label>
                                                <input class="form-control" name="link" value="" type="text"
                                                    dir="ltr" id="field-orderform-fields-link">
                                            </div>
                                            <div class="form-group fields" id="order_quantity">
                                                <label class="control-label"
                                                    for="field-orderform-fields-quantity">{{ __('newOrder.quantity') }}</label>
                                                <input class="form-control" name="quantity" value=""
                                                    type="text" id="field-orderform-fields-quantity">
                                                <small class="help-block min-max"></small>
                                            </div>
                                            <div class="form-group hidden fields" id="order_keywords">
                                                <label class="control-label"
                                                    for="field-orderform-fields-keywords">Keywords
                                                    (1 per line)</label>
                                                <textarea class="form-control" name="OrderForm[keywords]" id="field-orderform-fields-keywords" cols="30"
                                                    rows="10"></textarea>
                                            </div>
                                            <div class="form-group hidden fields" id="order_comment">
                                                <label class="control-label" for="field-orderform-fields-comment">Comments
                                                    (1 per line)</label>
                                                <textarea class="form-control" name="OrderForm[comment]" id="field-orderform-fields-comment" cols="30"
                                                    rows="10"></textarea>
                                            </div>
                                            <div class="form-group hidden fields" id="order_mentionUsernames">
                                                <label class="control-label"
                                                    for="field-orderform-fields-mentionUsernames">Usernames (1 per
                                                    line)</label>
                                                <textarea class="form-control" name="OrderForm[mentionUsernames]" id="field-orderform-fields-mentionUsernames"
                                                    cols="30" rows="10"></textarea>
                                            </div>
                                            <div class="form-group hidden fields" id="order_usernames">
                                                <label class="control-label"
                                                    for="field-orderform-fields-usernames">Usernames (1 per line)</label>
                                                <textarea class="form-control w-full" name="OrderForm[usernames]" id="field-orderform-fields-usernames"
                                                    cols="30" rows="10"></textarea>
                                            </div>
                                            <div class="form-group hidden fields" id="order_usernames_custom">
                                                <label class="control-label"
                                                    for="field-orderform-fields-usernames_custom">Usernames (1 per
                                                    line)</label>
                                                <textarea class="form-control" name="OrderForm[usernames_custom]" id="field-orderform-fields-usernames_custom"
                                                    cols="30" rows="10"></textarea>
                                            </div>
                                            <div class="form-group hidden fields" id="order_username">
                                                <label class="control-label"
                                                    for="field-orderform-fields-username">Username</label>
                                                <input class="form-control" name="OrderForm[username]" value=""
                                                    type="text" id="field-orderform-fields-username">
                                            </div>
                                            <div class="form-group hidden fields" id="order_mediaUrl">
                                                <label class="control-label" for="field-orderform-fields-mediaUrl">Media
                                                    URL</label>
                                                <input class="form-control" name="OrderForm[mediaUrl]" value=""
                                                    type="text" id="field-orderform-fields-mediaUrl">
                                            </div>
                                            <div class="form-group hidden fields" id="order_hashtag">
                                                <label class="control-label"
                                                    for="field-orderform-fields-hashtag">Hashtag</label>
                                                <input class="form-control" name="OrderForm[hashtag]" value=""
                                                    type="text" id="field-orderform-fields-hashtag">
                                            </div>
                                            <div class="form-group hidden fields" id="order_hashtags">
                                                <label class="control-label"
                                                    for="field-orderform-fields-hashtags">Hashtags
                                                    (1 per line)</label>
                                                <textarea class="form-control" name="OrderForm[hashtags]" id="field-orderform-fields-hashtags" cols="30"
                                                    rows="10"></textarea>
                                            </div>
                                            <div id="dripfeed">
                                                <div class="form-group fields hidden" id="order_check">
                                                    <div class="form-group__checkbox">
                                                        <label class="form-group__checkbox-label">
                                                            <input name="OrderForm[check]" value="1" type="checkbox"
                                                                id="field-orderform-fields-check">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label for="field-orderform-fields-check"
                                                            class="form-group__label-title">
                                                            Drip-feed
                                                        </label>
                                                    </div>
                                                    <div class="hidden depend-fields" id="dripfeed-options"
                                                        data-depend="field-orderform-fields-check">
                                                        <div class="form-group">
                                                            <label class="control-label"
                                                                for="field-orderform-fields-runs">Runs</label>
                                                            <input class="form-control" name="OrderForm[runs]"
                                                                value="" type="text"
                                                                id="field-orderform-fields-runs">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label"
                                                                for="field-orderform-fields-interval">Interval
                                                                (minutes)</label>
                                                            <input class="form-control" name="OrderForm[interval]"
                                                                value="" type="text"
                                                                id="field-orderform-fields-interval">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label"
                                                                for="field-orderform-fields-total-quantity">Total
                                                                quantity</label>
                                                            <input class="form-control" name="OrderForm[total_quantity]"
                                                                value="" type="text"
                                                                id="field-orderform-fields-total-quantity" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group hidden fields" id="order_posts">
                                                <label class="control-label" for="field-orderform-fields-posts">New
                                                    posts</label>
                                                <input class="form-control" name="OrderForm[posts]" value=""
                                                    type="text" id="field-orderform-fields-posts">
                                            </div>
                                            <div class="form-group hidden fields" id="order_old_posts">
                                                <label class="control-label" for="field-orderform-fields-old_posts">Old
                                                    posts</label>
                                                <input class="form-control" name="OrderForm[old_posts]" value=""
                                                    type="text" id="field-orderform-fields-old_posts">
                                                <small class="help-block max"></small>
                                            </div>
                                            <div class="form-group hidden fields" id="order_min">
                                                <label class="control-label" for="order_count">Quantity</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="order_count"
                                                            name="OrderForm[min]" value="" placeholder="Min"><small
                                                            class="help-block min-max">Min: 10 - Max: 500&nbsp;000</small>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="order_count"
                                                            name="OrderForm[max]" value="" placeholder="Max">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group hidden fields" id="order_delay">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label"
                                                            for="field-orderform-fields-delay">Delay</label>
                                                        <select class="form-control" name="OrderForm[delay]"
                                                            id="field-orderform-fields-delay">

                                                            <option value="0">No delay</option>

                                                            <option value="300">5 minutes</option>

                                                            <option value="600">10 minutes</option>

                                                            <option value="900">15 minutes</option>

                                                            <option value="1200">20 minutes</option>

                                                            <option value="1800">30 minutes</option>

                                                            <option value="2400">40 minutes</option>

                                                            <option value="3000">50 minutes</option>

                                                            <option value="3600">60 minutes</option>

                                                            <option value="5400">90 minutes</option>

                                                            <option value="7200">120 minutes</option>

                                                            <option value="9000">150 minutes</option>

                                                            <option value="10800">180 minutes</option>

                                                            <option value="12600">210 minutes</option>

                                                            <option value="14400">240 minutes</option>

                                                            <option value="16200">270 minutes</option>

                                                            <option value="18000">300 minutes</option>

                                                            <option value="21600">360 minutes</option>

                                                            <option value="25200">420 minutes</option>

                                                            <option value="28800">480 minutes</option>

                                                            <option value="32400">540 minutes</option>

                                                            <option value="36000">600 minutes</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="field-orderform-fields-expiry">Expiry</label>
                                                        <div class="input-group">
                                                            <input class="form-control datetime" autocomplete="off"
                                                                name="OrderForm[expiry]" value="" type="text"
                                                                id="field-orderform-fields-expiry">
                                                            <span class="input-group-btn">
                                                                <button
                                                                    class="btn btn-default btn-big-secondary clear-datetime"
                                                                    type="button"
                                                                    data-rel="#field-orderform-fields-expiry"><span
                                                                        class="fa far fa-trash-alt"></span></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group hidden fields" id="order_comment_username">
                                                <label class="control-label"
                                                    for="field-orderform-fields-comment_username">Username of the comment
                                                    owner</label>
                                                <input class="form-control" name="OrderForm[comment_username]"
                                                    value="" type="text"
                                                    id="field-orderform-fields-comment_username">
                                            </div>
                                            <div class="form-group hidden fields" id="order_answer_number">
                                                <label class="control-label"
                                                    for="field-orderform-fields-answer_number">Answer number</label>
                                                <input class="form-control" name="OrderForm[answer_number]"
                                                    value="" type="text"
                                                    id="field-orderform-fields-answer_number">
                                            </div>
                                            <div class="form-group hidden fields" id="order_email">
                                                <label class="control-label"
                                                    for="field-orderform-fields-email">Email</label>
                                                <input class="form-control" name="OrderForm[email]" value=""
                                                    type="text" id="field-orderform-fields-email">
                                            </div>
                                            <div class="form-group hidden fields" id="order_groups">
                                                <label class="control-label"
                                                    for="field-orderform-fields-groups">Groups</label>
                                                <textarea class="form-control" name="OrderForm[groups]" id="field-orderform-fields-groups" cols="30"
                                                    rows="10"></textarea>
                                            </div>
                                            <div class="form-group hidden fields" id="order_country">
                                                <label class="control-label" for="field-orderform-fields-country">
                                                    Country
                                                </label>
                                                <input class="form-control" name="OrderForm[country]" value=""
                                                    placeholder="US" type="text" id="field-orderform-fields-country">
                                            </div>
                                            <div class="form-group hidden fields" id="order_device">
                                                <label class="control-label" for="field-orderform-fields-device">
                                                    Device
                                                </label>

                                                <div class="form-group__checkbox">
                                                    <label class="form-group__checkbox-label">
                                                        <input class="form-check-input" type="radio"
                                                            name="OrderForm[device]" id="device-1" value="1">
                                                        <span class="radiomark"></span>
                                                    </label>
                                                    <label class="form-check-label form-group__label-title mr-5"
                                                        for="device-1">Desktop</label>
                                                </div>

                                                <div class="form-group__checkbox">
                                                    <label class="form-group__checkbox-label">
                                                        <input class="form-check-input" type="radio"
                                                            name="OrderForm[device]" id="device-2" value="2">
                                                        <span class="radiomark"></span>
                                                    </label>
                                                    <label class="form-check-label form-group__label-title mr-5"
                                                        for="device-2">Mobile (Android)</label>
                                                </div>

                                                <div class="form-group__checkbox">
                                                    <label class="form-group__checkbox-label">
                                                        <input class="form-check-input" type="radio"
                                                            name="OrderForm[device]" id="device-3" value="3">
                                                        <span class="radiomark"></span>
                                                    </label>
                                                    <label class="form-check-label form-group__label-title mr-5"
                                                        for="device-3">Mobile (iOS)</label>
                                                </div>

                                                <div class="form-group__checkbox">
                                                    <label class="form-group__checkbox-label">
                                                        <input class="form-check-input" type="radio"
                                                            name="OrderForm[device]" id="device-4" value="4">
                                                        <span class="radiomark"></span>
                                                    </label>
                                                    <label class="form-check-label form-group__label-title mr-5"
                                                        for="device-4">Mixed (Mobile)</label>
                                                </div>

                                                <div class="form-group__checkbox">
                                                    <label class="form-group__checkbox-label">
                                                        <input class="form-check-input" type="radio"
                                                            name="OrderForm[device]" id="device-5" value="5">
                                                        <span class="radiomark"></span>
                                                    </label>
                                                    <label class="form-check-label form-group__label-title mr-5"
                                                        for="device-5">Mixed (Mobile &amp; Desktop)</label>
                                                </div>

                                            </div>
                                            <div class="form-group hidden fields" id="order_type_of_traffic">
                                                <label class="control-label" for="field-orderform-fields-type_of_traffic">
                                                    Type of Traffic
                                                </label>

                                                <div class="form-group__checkbox">
                                                    <label class="form-group__checkbox-label">
                                                        <input class="form-check-input" type="radio"
                                                            name="OrderForm[type_of_traffic]" id="type_of_traffic-1"
                                                            checked="" value="1">
                                                        <span class="radiomark"></span>
                                                    </label>
                                                    <label class="form-check-label form-group__label-title mr-5"
                                                        for="type_of_traffic-1">Google Keyword</label>
                                                </div>

                                                <div class="form-group__checkbox">
                                                    <label class="form-group__checkbox-label">
                                                        <input class="form-check-input" type="radio"
                                                            name="OrderForm[type_of_traffic]" id="type_of_traffic-2"
                                                            value="2">
                                                        <span class="radiomark"></span>
                                                    </label>
                                                    <label class="form-check-label form-group__label-title mr-5"
                                                        for="type_of_traffic-2">Custom Referrer</label>
                                                </div>

                                                <div class="form-group__checkbox">
                                                    <label class="form-group__checkbox-label">
                                                        <input class="form-check-input" type="radio"
                                                            name="OrderForm[type_of_traffic]" id="type_of_traffic-3"
                                                            value="3">
                                                        <span class="radiomark"></span>
                                                    </label>
                                                    <label class="form-check-label form-group__label-title mr-5"
                                                        for="type_of_traffic-3">Blank Referrer</label>
                                                </div>

                                            </div>
                                            <div class="form-group hidden fields" id="order_google_keyword">
                                                <label class="control-label" for="field-orderform-fields-google_keyword">
                                                    Google Keyword
                                                </label>
                                                <input class="form-control" name="OrderForm[google_keyword]"
                                                    value="" placeholder="Google Keyword..." type="text"
                                                    id="field-orderform-fields-google_keyword">
                                            </div>
                                            <div class="form-group hidden fields" id="order_referring_url">
                                                <label class="control-label" for="field-orderform-fields-referring_url">
                                                    Referring URL
                                                </label>
                                                <input class="form-control" name="OrderForm[referring_url]"
                                                    value="" placeholder="https://instagram.com" type="text"
                                                    id="field-orderform-fields-referring_url">
                                            </div>
                                            <div class="form-group fields hidden" id="order_average_time">
                                                <label class="control-label" for="field-orderform-fields-average_time">
                                                    {{ __('newOrder.average_time') }}
                                                    <span class="ml-1 mr-1 fa fa-exclamation-circle" data-toggle="tooltip"
                                                        data-placement="right"
                                                        title="The average completion time is calculated based on the completion times of the latest orders."></span>
                                                </label>
                                                <input class="form-control" readonly="" value="" type="text"
                                                    id="field-orderform-fields-average_time" disabled="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="charge"
                                                class="control-label">{{ __('newOrder.charge') }}</label>
                                            <input type="text" class="form-control" id="charge" value=""
                                                readonly="">
                                        </div>
                                    </div>
                                    <div class="new-order-button-submit component_button_submit">
                                        <button id="submit-btn" type="submit"
                                            class="btn btn-block btn-big-primary">{{ __('newOrder.submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        .hidden {
            display: none !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allCategories = @json($data['categories']);
            const allServices = @json($data['services']);
            const selectedService = @json($data['selectedService']);
            let currentServiceRate = 0;

            const categorySelect = document.getElementById('orderform-category');
            const serviceSelect = document.getElementById('orderform-service');
            const quantityInput = document.getElementById('field-orderform-fields-quantity');

            // ── Favorites ─────────────────────────────────────────────────────────────
            const FAVORITES_CATEGORY_ID = 'favorites';
            const FAV_LABEL = '{{ __('services.favorite_services') }}';

            function getFavorites() {
                try {
                    return JSON.parse(localStorage.getItem('favorite_services')) || [];
                } catch (e) {
                    return [];
                }
            }

            // Chuẩn bị DOM trước khi theme init Select2:
            // nếu có favorites trong localStorage → tạo option và đặt lên đầu + selected
            const initFavIds = getFavorites().map(Number);
            const hasFavs = initFavIds.length > 0;
            if (hasFavs) {
                // Kiểm tra xem option favorites đã tồn tại chưa
                let favOpt = categorySelect.querySelector('option[data-fav="1"]');
                if (!favOpt) {
                    // Tạo option favorites nếu chưa tồn tại
                    favOpt = document.createElement('option');
                    favOpt.value = FAVORITES_CATEGORY_ID;
                    favOpt.textContent = FAV_LABEL;
                    favOpt.setAttribute('data-fav', '1');
                    favOpt.setAttribute('data-icon', "<span class='fas fa-star' style='color:#ffc107;'></span>");
                    categorySelect.insertBefore(favOpt, categorySelect.firstChild);
                }
                // Nếu không có ?service= → selected favorites
                if (!(selectedService && selectedService.id)) {
                    favOpt.selected = true;
                }
            }

            // ── Helpers ───────────────────────────────────────────────────────────────
            function setServiceDataAttrs(opt, svc) {
                ['id', 'name', 'title', 'description', 'min', 'max', 'rate_formatted',
                    'average_time', 'type_service', 'refill', 'cancel', 'dripfeed', 'category_id'
                ]
                .forEach(k => {
                    if (svc[k] != null)
                        opt.setAttribute('data-' + k.replace(/_/g, '-'), svc[k]);
                });
            }

            function buildServiceOptions(services) {
                serviceSelect.innerHTML = '';
                services.forEach(svc => {
                    const opt = document.createElement('option');
                    opt.value = svc.id;
                    opt.textContent = svc.id + ' - ' + svc.name + ' - ' + svc.rate_formatted;
                    setServiceDataAttrs(opt, svc);
                    serviceSelect.appendChild(opt);
                });
                $(serviceSelect).trigger('change.select2');
            }

            function updateCategorySelect(categories) {
                categorySelect.innerHTML = '';
                // Chỉ thêm option Favorites nếu có dữ liệu trong localStorage
                const favs = getFavorites();
                if (favs.length > 0) {
                    const favOpt = document.createElement('option');
                    favOpt.value = FAVORITES_CATEGORY_ID;
                    favOpt.textContent = FAV_LABEL;
                    favOpt.setAttribute('data-fav', '1');
                    favOpt.setAttribute('data-icon', "<span class='fas fa-star' style='color:#ffc107;'></span>");
                    categorySelect.appendChild(favOpt);
                }
                categories.forEach(cat => {
                    const opt = document.createElement('option');
                    opt.value = cat.id;
                    opt.textContent = cat.name;
                    if (cat.image) {
                        const icon = cat.image.match(/^https?:\/\/|^\/|\./) ?
                            '<img src="' + cat.image +
                            '" style="width:16px;height:16px;object-fit:contain;">' :
                            '<span class="' + cat.image + '"></span>';
                        opt.setAttribute('data-icon', icon);
                    }
                    categorySelect.appendChild(opt);
                });
                $(categorySelect).trigger('change.select2');
            }

            // ── Category change ────────────────────────────────────────────────────────
            $(categorySelect).on('change select2:select', function() {
                const catId = categorySelect.value;
                if (!catId) return;
                const services = catId === FAVORITES_CATEGORY_ID ?
                    allServices.filter(s => getFavorites().map(Number).includes(parseInt(s.id))) :
                    allServices.filter(s => s.category_id == catId);
                buildServiceOptions(services);
                if (serviceSelect.options.length > 0) {
                    serviceSelect.value = serviceSelect.options[0].value;
                    $(serviceSelect).trigger('change.select2');
                    serviceSelect.dispatchEvent(new Event('change'));
                }
            });

            // ── Service change ─────────────────────────────────────────────────────────
            serviceSelect.addEventListener('change', function() {
                const opt = this.options[this.selectedIndex];
                if (!opt) return;
                applyServiceInfo({
                    id: opt.getAttribute('data-id'),
                    name: opt.getAttribute('data-name'),
                    rate: opt.getAttribute('data-rate-formatted'),
                    min: opt.getAttribute('data-min'),
                    max: opt.getAttribute('data-max'),
                    description: opt.getAttribute('data-description') || '',
                    average_time: opt.getAttribute('data-average-time') || '',
                    type_service: opt.getAttribute('data-type-service') || 'Default'
                });
                resetInputFields();
                calculateCharge();
            });
            $(serviceSelect).on('select2:select', () => serviceSelect.dispatchEvent(new Event('change')));

            if (quantityInput) {
                quantityInput.addEventListener('input', calculateCharge);
                quantityInput.addEventListener('change', calculateCharge);
            }

            const dripCheck = document.getElementById('field-orderform-fields-check');
            if (dripCheck) {
                dripCheck.addEventListener('change', function() {
                    const opts = document.getElementById('dripfeed-options');
                    if (opts) opts.classList.toggle('hidden', !this.checked);
                });
            }

            // ── Apply service info ─────────────────────────────────────────────────────
            function applyServiceInfo(data) {
                const rateStr = data.rate || '';
                currentServiceRate = parseFloat(rateStr.replace(/[^0-9.-]/g, '')) || 0;
                const symMatch = rateStr.match(/[^\d\s.,\-]+/);
                window.currentCurrencySymbol = symMatch ? symMatch[0] : '';
                window.symbolPosition = rateStr.indexOf(window.currentCurrencySymbol) === 0 ? 'before' : 'after';

                const descBox = document.getElementById('service_description');
                const descText = document.querySelector('#service_description .panel-description');
                if (descText) {
                    descText.innerHTML = data.description ? data.description.replace(/\n/g, '<br>') : '<br>';
                    descBox.classList.toggle('hidden', !data.description);
                }

                const minMax = document.querySelector('#order_quantity .min-max');
                if (minMax && data.min && data.max)
                    minMax.textContent = 'Min: ' + data.min + ' - Max: ' + data.max;

                const avgInput = document.getElementById('field-orderform-fields-average_time');
                const avgBox = document.getElementById('order_average_time');
                if (avgInput && avgBox) {
                    const avgVal = parseFloat(data.average_time);
                    if (data.average_time && avgVal > 0) {
                        let d = data.average_time;
                        if (!isNaN(d)) {
                            const m = parseInt(d);
                            if (m < 60) d = m + ' minutes';
                            else if (m < 1440) {
                                const h = Math.floor(m / 60),
                                    r = m % 60;
                                d = r ? h + 'h ' + r + 'm' : h + ' hours';
                            } else {
                                const dy = Math.floor(m / 1440),
                                    rh = Math.floor((m % 1440) / 60);
                                d = rh ? dy + 'd ' + rh + 'h' : dy + ' days';
                            }
                        }
                        avgInput.value = d;
                        avgBox.classList.remove('hidden');
                    } else {
                        avgInput.value = '';
                        avgBox.classList.add('hidden');
                    }
                }

                const fieldIds = ['order_link', 'order_quantity', 'order_comment', 'order_username',
                    'order_min', 'order_posts', 'order_old_posts', 'order_check', 'order_delay'
                ];
                fieldIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.classList.add('hidden');
                });

                const show = id => {
                    const el = document.getElementById(id);
                    if (el) el.classList.remove('hidden');
                };
                const setQtyRO = ro => {
                    if (!quantityInput) return;
                    quantityInput.readOnly = ro;
                    quantityInput.style.backgroundColor = ro ? '#f5f5f5' : '';
                    quantityInput.style.cursor = ro ? 'not-allowed' : '';
                };

                switch (data.type_service || 'Default') {
                    case 'Custom Comments':
                        show('order_link');
                        show('order_comment');
                        show('order_quantity');
                        setQtyRO(true);
                        break;
                    case 'Package':
                        show('order_link');
                        setQtyRO(false);
                        break;
                    case 'Subscriptions':
                        show('order_username');
                        show('order_min');
                        show('order_delay');
                        show('order_posts');
                        show('order_old_posts');
                        setQtyRO(false);
                        break;
                    default:
                        show('order_link');
                        show('order_quantity');
                        show('order_check');
                        setQtyRO(false);
                        break;
                }
                calculateCharge();
            }

            function calculateCharge() {
                const chargeInput = document.getElementById('charge');
                if (!chargeInput) return;
                const qty = parseInt(quantityInput?.value) || 0;
                if (currentServiceRate > 0 && qty > 0) {
                    const total = currentServiceRate * qty / 1000;
                    const sym = window.currentCurrencySymbol || '';
                    const fmt = parseFloat(total.toFixed(10)).toString();
                    chargeInput.value = window.symbolPosition === 'before' ? sym + fmt : fmt + sym;
                } else {
                    chargeInput.value = '';
                }
            }

            function resetInputFields() {
                const link = document.getElementById('field-orderform-fields-link');
                if (link) link.value = '';
                if (quantityInput) quantityInput.value = '';
            }

            // ── Pre-select service from URL ────────────────────────────────────────────
            function loadServiceFromUrl(svc) {
                updateCategorySelect(allCategories);
                categorySelect.value = svc.category_id;
                $(categorySelect).trigger('change.select2');
                buildServiceOptions(allServices.filter(s => s.category_id == svc.category_id));
                serviceSelect.value = svc.id;
                $(serviceSelect).trigger('change.select2');
                applyServiceInfo({
                    id: svc.id,
                    name: svc.name,
                    rate: svc.rate_formatted,
                    min: svc.min,
                    max: svc.max,
                    description: svc.description || '',
                    average_time: svc.average_time || '',
                    type_service: svc.type_service || 'Default'
                });
            }

            // ── Init ──────────────────────────────────────────────────────────────────
            setTimeout(function() {
                if (selectedService && selectedService.id) {
                    loadServiceFromUrl(selectedService);
                } else if (hasFavs) {
                    buildServiceOptions(allServices.filter(s => initFavIds.includes(parseInt(s.id))));
                    categorySelect.value = FAVORITES_CATEGORY_ID;
                    $(categorySelect).trigger('change.select2');
                    if (serviceSelect.options.length > 0) {
                        serviceSelect.value = serviceSelect.options[0].value;
                        $(serviceSelect).trigger('change.select2');
                        serviceSelect.dispatchEvent(new Event('change'));
                    }
                } else {
                    const initCatId = categorySelect.value;
                    if (initCatId) {
                        buildServiceOptions(allServices.filter(s => s.category_id == initCatId));
                    }
                    $(categorySelect).trigger('change.select2');
                    if (serviceSelect.options.length > 0) {
                        serviceSelect.dispatchEvent(new Event('change'));
                    }
                }
            }, 50);

            if (typeof $().tooltip === 'function') $('[data-toggle="tooltip"]').tooltip();

            // ── Form submit ────────────────────────────────────────────────────────────
            const orderForm = document.getElementById('order-form');
            const submitBtn = document.getElementById('submit-btn');
            const alertError = document.getElementById('js-order-alert-error');
            const alertOk = document.getElementById('js-order-alert-success');

            function hideAlerts() {
                if (alertError) alertError.style.display = 'none';
                if (alertOk) alertOk.style.display = 'none';
            }

            function showAlert(type, message) {
                hideAlerts();
                const el = type === 'success' ? alertOk : alertError;
                if (!el) return;
                el.querySelector('.text').innerHTML = message;
                el.style.display = 'block';
                el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                if (type === 'success') setTimeout(() => {
                    el.style.display = 'none';
                }, 5000);
            }

            if (orderForm) {
                orderForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitBtn.disabled = true;
                    hideAlerts();
                    const formData = new FormData(orderForm);
                    if (quantityInput?.value) formData.set('quantity', quantityInput.value);
                    const comments = document.getElementById('field-orderform-fields-comments');
                    if (comments?.value) formData.set('comments', comments.value);
                    fetch(orderForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    ?.getAttribute('content') ||
                                    document.querySelector('input[name="_token"]')?.value
                            }
                        })
                        .then(r => r.json())
                        .then(data => {
                            const od = data.data || {},
                                ord = od.order || {};
                            if (od.has_api_error && od.error_message) {
                                showAlert('error', od.error_message);
                            } else if (data.success) {
                                let msg = '<h4>{{ __('newOrder.order_received') }}</h4>';
                                if (ord.id) msg += 'ID: ' + ord.id + '<br>';
                                if (ord.service) msg += 'Service: ' + ord.service + '<br>';
                                if (ord.link) msg += 'Link: ' + ord.link + '<br>';
                                if (ord.quantity) msg += 'Quantity: ' + ord.quantity + '<br>';
                                if (ord.charge) msg += 'Charge: ' + ord.charge + '<br>';
                                if (ord.balance) msg += 'Balance: ' + ord.balance + '<br>';
                                showAlert('success', msg);
                                resetInputFields();
                                const chargeInput = document.getElementById('charge');
                                if (chargeInput) chargeInput.value = '';
                            } else {
                                showAlert('error', data.errors ?
                                    Object.values(data.errors).flat().join('<br>') :
                                    (data.message || 'An error occurred.'));
                            }
                        })
                        .catch(() => showAlert('error', 'Network error. Please try again.'))
                        .finally(() => {
                            submitBtn.disabled = false;
                        });
                });
            }

            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.close[data-hide="alert"]');
                if (btn) {
                    const al = btn.closest('.alert');
                    if (al) al.style.display = 'none';
                }
            });

            // ── Search ─────────────────────────────────────────────────────────────────
            const searchInput = document.getElementById('service-search-input');
            const searchWrapper = document.getElementById('search-dropdown-wrapper');
            const searchList = document.getElementById('search-results-list');
            const clearBtn = document.getElementById('search-clear-btn');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const q = this.value.trim();
                    clearBtn.style.display = q ? 'block' : 'none';
                    clearTimeout(searchTimeout);
                    if (!q) {
                        hideSearch();
                        return;
                    }
                    searchTimeout = setTimeout(() => doSearch(q), 200);
                });
                searchInput.addEventListener('focus', function() {
                    if (this.value.trim()) doSearch(this.value.trim());
                });
                searchInput.addEventListener('blur', () => setTimeout(hideSearch, 200));
                clearBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    clearBtn.style.display = 'none';
                    hideSearch();
                    searchInput.focus();
                });
            }

            function doSearch(query) {
                const q = query.toLowerCase();
                const results = allServices.filter(s =>
                    s.name.toLowerCase().includes(q) || String(s.id).includes(q)
                ).slice(0, 30);
                searchList.innerHTML = '';
                if (!results.length) {
                    const li = document.createElement('li');
                    li.className = 'select2-results__option';
                    li.innerHTML = '<a href="#" onclick="return false;" style="color:#999;">No results found</a>';
                    searchList.appendChild(li);
                } else {
                    const escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                    const re = new RegExp('(' + escaped + ')', 'gi');
                    const hl = s => s.replace(re, '<b class="text__highlight" style="background:unset;">$1</b>');
                    results.forEach(svc => {
                        const li = document.createElement('li');
                        li.className = 'select2-results__option';
                        li.innerHTML = '<a href="#">' +
                            '<span class="select2-selection__id badge badge-secondary badge-pill rounded-pill"><span>' +
                            hl(String(svc.id)) + '</span></span> ' +
                            '<span class="select2-selection__text"><span>' + hl(svc.name) + '</span>' +
                            ' <span>- ' + svc.rate_formatted + '</span></span></a>';
                        li.addEventListener('mousedown', e => {
                            e.preventDefault();
                            selectSearchResult(svc);
                        });
                        searchList.appendChild(li);
                    });
                }
                searchWrapper.style.display = 'block';
            }

            function selectSearchResult(svc) {
                updateCategorySelect(allCategories);
                categorySelect.value = svc.category_id;
                $(categorySelect).trigger('change.select2');
                buildServiceOptions(allServices.filter(s => s.category_id == svc.category_id));
                serviceSelect.value = svc.id;
                $(serviceSelect).trigger('change.select2');
                serviceSelect.dispatchEvent(new Event('change'));
                searchInput.value = '';
                clearBtn.style.display = 'none';
                hideSearch();
            }

            function hideSearch() {
                if (searchWrapper) searchWrapper.style.display = 'none';
            }
        });
    </script>
@endpush
