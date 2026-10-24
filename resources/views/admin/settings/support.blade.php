@extends('admin.layouts.app')
@section('title', 'Settings')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
    @include('admin.settings.partials.header')

        <div class="d-flex flex-wrap flex-stack mb-6">
            <h3 class="fw-bold my-2" data-lang="Direct message">Tin nhắn trực tiếp</h3>
            <button type="button" class="btn btn-primary btn-sm" data-lang="button::Update"
                onclick="_settings.on.click.updateSupport(
                    document.querySelector('.ipt-contact-facebook').value.trim(),
                    document.querySelector('.ipt-contact-zalo').value.trim(),
                    document.querySelector('.ipt-contact-telegram').value.trim(),
                    document.querySelector('.ipt-contact-whatsapp').value.trim(),
                    document.querySelector('.ipt-contact-phone').value.trim(),
                    document.querySelector('.cb-direct-message-chatbox').checked
                )">Cập nhật</button>
        </div>

            <div class="card shadow-sm mb-8">
                <div class="card-body">
                <div class="mb-5">
                    <div class="form-check form-switch form-check-custom form-check-solid me-10">
                        <input class="form-check-input cb-direct-message-chatbox" type="checkbox"
                            {{ ($config->direct_message_chatbox ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" data-lang="Show direct message chatbox">
                            Hiển thị chatbox tin nhắn trực tiếp
                        </label>
                    </div>
                </div>

                <div>
                    @foreach ([
                        ['Facebook', 'facebook', 'fa-brands', 'fa-facebook', $config->link_facebook ?? '', 'https://facebook.com/...'],
                        ['Telegram', 'telegram', 'fa-brands', 'fa-telegram', $config->link_telegram ?? '', 'https://t.me/...'],
                        ['Whatsapp', 'whatsapp', 'fa-brands', 'fa-whatsapp', $config->link_whatsapp ?? '', 'https://wa.me/...'],
                        ['Zalo', 'zalo', 'fa-solid', 'fa-comment-dots', $config->link_zalo ?? '', 'https://zalo.me/...'],
                    ] as [$label, $name, $iconStyle, $icon, $value, $placeholder])
                        <div class="mb-5">
                            <label class="form-label">{{ $label }}</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text"><i class="{{ $iconStyle }} {{ $icon }} fs-2"></i></span>
                                <input type="text" class="form-control ipt-contact-{{ $name }}"
                                    value="{{ $value }}" placeholder="{{ $placeholder }}">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mb-5">
                    <label class="form-label">Phone</label>
                    <div class="input-group input-group-solid">
                        <span class="input-group-text"><i class="fa-solid fa-phone fs-4"></i></span>
                        <input type="text" class="form-control ipt-contact-phone"
                            value="{{ $config->phone_admin ?? '' }}">
                    </div>
                </div>

                <div class="mb-5">
                    <label class="form-label" data-lang="Other contact">Liên hệ khác</label>
                    <div class="quill-contact h-200px">{!! $config->other_contact ?? '' !!}</div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap flex-stack my-6">
            <h3 class="fw-bold my-2" data-lang="Quick chat messages">Tin nhắn nhanh</h3>
            <div class="d-flex flex-wrap my-2">
                <button class="btn btn-primary btn-sm" data-lang="button::Update"
                    onclick="_settings.on.click.updateQuickReply()">Cập nhật</button>
            </div>
        </div>

        <div class="row g-6" id="support">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="messages mt-5">
                            @foreach ($quickMessages as $message)
                                <div class="input-group input-group-solid mb-2">
                                    <input type="text" class="form-control" value="{{ $message }}"
                                        placeholder="Nhập nội dung tin nhắn">
                                    <span class="input-group-text bg-danger">
                                        <a href="javascript:;" onclick="this.closest('.input-group').remove()">
                                            <i class="fa-solid fa-xmark text-white"></i>
                                        </a>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-end">
                             <button type="button" class="btn btn-sm btn-outline btn-outline-primary btn-icon"
                                onclick="_settings.on.click.addQuickReply()">
                                <i class="la la-plus fs-3"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

@push('scripts')
<script>$(document).ready(function () { _settings.init(); });</script>
@endpush
@endsection