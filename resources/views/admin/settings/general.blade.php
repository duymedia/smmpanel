@extends('admin.layouts.app')
@section('title', 'Settings')
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        @include('admin.settings.partials.header')
        <div class="d-flex flex-wrap flex-stack mb-6">
            <h3 class="fw-bold my-2" data-lang="">Tổng quan</h3>
            <div class="d-flex flex-wrap my-2">
                <button class="btn btn-primary btn-sm" data-lang="button::Update" onclick="_settings.on.click.updateGeneral()">Cập nhật</button>
            </div>
        </div>
        <div class="row g-6 mb-6">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5">
                            <label class="form-label" data-lang="Website title">Tiêu đề website</label>
                            <input type="text" class="form-control form-control-solid ipt-website-title"
                                value="{{ $config->title ?? '' }}">
                        </div>
                        <div class="mb-5">
                            <label class="form-label" data-lang="Meta description">Mô tả Meta</label>
                            <input type="text" class="form-control form-control-solid ipt-website-description"
                                value="{{ $config->description ?? '' }}">
                        </div>
                        <div>
                            <label class="form-label" data-lang="Meta keywords">Từ khóa Meta</label>
                            <input type="text" class="form-control form-control-solid ipt-website-keywords"
                                value="{{ $config->keywords ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-5">
                            <label class="form-label" data-lang="Default language">Ngôn ngữ mặc định</label>
                            <select id="sl-default-language" class="form-select form-select-solid sl-default-language"
                                data-allow-clear="false" data-hide-search="true">
                                @forelse($languages ?? [] as $lang)
                                    <option value="{{ $lang->flag_code ?: ($lang->code === 'en' ? 'us' : strtolower($lang->code)) }}"
                                        {{ ($config->default_lang ?? 'en') == $lang->code ? 'selected' : '' }}
                                        data-language-code="{{ $lang->code }}">
                                        {{ $lang->name }}
                                    </option>
                                @empty
                                    <option value="us" selected data-language-code="en">English
                                    </option>
                                @endforelse
                            </select>
                        </div>
                        <div>
                            <label class="form-label" data-lang="Default currency">Tiền tệ mặc định</label>
                            <select id="sl-default-currency" class="form-select form-select-solid sl-default-currency"
                                data-control="select2" data-allow-clear="false" data-hide-search="false">
                                @forelse($currencies ?? [] as $currency)
                                    <option value="{{ $currency->code }}"
                                        {{ ($config->default_currency ?? 'USD') == $currency->code ? 'selected' : '' }}>
                                        {{ $currency->code }} - {{ $currency->name }}
                                    </option>
                                @empty
                                    <option value="USD" selected="">USD - United States Dollar</option>
                                @endforelse
                            </select>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="row g-6">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-5">
                            <label class="form-label" data-lang="Announcement style">Kiểu thông báo</label>
                            <select id="sl-announcement-position"
                                class="form-select form-select-solid sl-announcement-position" data-control="select2"
                                data-hide-search="true">
                                <option value="modal"
                                    {{ ($config->announcement_position ?? 'page') == 'modal' ? 'selected' : '' }}
                                    data-lang="announcement_position_modal">Hiển thị dưới dạng hộp thoại. Hiển thị một lần
                                    sau khi đăng nhập.</option>
                                <option value="page"
                                    {{ ($config->announcement_position ?? 'page') == 'page' ? 'selected' : '' }}
                                    data-lang="announcement_position_page">Hiển thị ở trang đặt hàng</option>
                                <option value="page_and_modal"
                                    {{ ($config->announcement_position ?? 'page') == 'page_and_modal' ? 'selected' : '' }}
                                    data-lang="announcement_position_page_and_modal">Hiển thị ở trang đặt hàng và hộp
                                    thoại. Hiển thị hộp thoại một lần sau khi đăng nhập.</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="form-label" data-lang="Announcement">Thông báo</label>
                            <div class="quill-announcement h-250px">{!! $config->announcement_content ?? '' !!}</div>
                            <input type="hidden" id="announcement-content"
                                value="{{ $config->announcement_content ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap flex-stack my-6">
            <h3 class="fw-bold my-2">Terms</h3>
            <div class="d-flex flex-wrap my-2">
                <button class="btn btn-primary btn-sm" data-lang="button::Update" onclick="_settings.on.click.updateTerms()">Cập
                    nhật</button>
            </div>
        </div>
        <div class="row g-6">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="quill-terms h-500px">{!! $config->terms_content ?? '' !!}</div>
                        <input type="hidden" id="terms-content" value="{{ $config->terms_content ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap flex-stack my-6">
            <h3 class="fw-bold my-2">FAQs</h3>
            <div class="d-flex flex-wrap my-2">
                <button class="btn btn-primary btn-sm" data-lang="button::Update"
                    onclick="updateFAQ()">Cập nhật</button>
            </div>
        </div>
        <div class="row g-6">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="div-faq">
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm me-2"
                            onclick="newFAQ()" data-lang="button::New">Thêm mới</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
<script>$(document).ready(function () { _settings.init(); });</script>
@endpush
