@extends('adminpanel.layouts.app')
@section('title', 'Settings')
@section('content')
    <div class="content flex-row-fluid" id="kt_content">

        @include('adminpanel.settings.partials.header')

        <div class="d-flex flex-wrap flex-stack mb-6">
            <h3 class="fw-bold my-2" data-lang="Direct message">Tin nhắn trực tiếp</h3>
            <div class="d-flex flex-wrap my-2">
                <button class="btn btn-primary btn-sm" data-lang="button::Update"
                    onclick="_settings.on.click.updateSupport()">Cập nhật</button>
            </div>
        </div>

        <div class="row g-6">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="mb-5">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input cb-direct-message-chatbox" type="checkbox"
                                    {{ $config->direct_message_chatbox ?? true ? 'checked' : '' }}>
                                <label class="form-check-label" data-lang="Show direct message chatbox">
                                    Hiển thị chatbox tin nhắn trực tiếp
                                </label>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Facebook</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text"><i class="fa-brands fa-facebook fs-2"></i></span>
                                <input type="text" class="form-control ipt-contact-facebook"
                                    value="{{ $config->link_facebook ?? '' }}"
                                    placeholder="https://facebook.com/...">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Telegram</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text"><i class="fa-brands fa-telegram fs-2"></i></span>
                                <input type="text" class="form-control ipt-contact-telegram"
                                    value="{{ $config->link_telegram ?? '' }}"
                                    placeholder="https://t.me/...">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Whatsapp</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text"><i class="fa-brands fa-whatsapp fs-2"></i></span>
                                <input type="text" class="form-control ipt-contact-whatsapp"
                                    value="{{ $config->link_whatsapp ?? '' }}"
                                    placeholder="https://wa.me/...">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Zalo</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text"><i class="fa-solid fa-comment-dots fs-2"></i></span>
                                <input type="text" class="form-control ipt-contact-zalo"
                                    value="{{ $config->link_zalo ?? '' }}"
                                    placeholder="https://zalo.me/...">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Phone</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text"><i class="fa-solid fa-phone fs-4"></i></span>
                                <input type="text" class="form-control ipt-contact-phone"
                                    value="{{ $config->phone_admin ?? '' }}"
                                    placeholder="0xxxxxxxxx">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label" data-lang="Other contact">Liên hệ khác</label>
                            <div id="editor-other-contact" style="min-height: 120px;">{!! $config->other_contact ?? '' !!}</div>
                            <input type="hidden" class="ipt-other-contact" value="{{ $config->other_contact ?? '' }}">
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        window._settings = window._settings || { on: { click: {}, change: {} } };

        _settings.on.click.updateSupport = function () {
            showFullScreenLoader();
            const data = {
                _token: '{{ csrf_token() }}',
                _method: 'PUT',
                link_facebook: document.querySelector('.ipt-contact-facebook')?.value.trim() ?? '',
                link_telegram: document.querySelector('.ipt-contact-telegram')?.value.trim() ?? '',
                link_whatsapp: document.querySelector('.ipt-contact-whatsapp')?.value.trim() ?? '',
                link_zalo: document.querySelector('.ipt-contact-zalo')?.value.trim() ?? '',
                phone_admin: document.querySelector('.ipt-contact-phone')?.value.trim() ?? '',
                other_contact: document.querySelector('.ipt-other-contact')?.value ?? '',
                direct_message_chatbox: document.querySelector('.cb-direct-message-chatbox')?.checked ? 1 : 0,
            };

            fetch('{{ route('admin.settings.update.support') }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(r => r.json())
            .then(res => {
                hideFullScreenLoader();
                showToast(res.message || 'Cập nhật thành công', res.success !== false ? 'success' : 'error');
            })
            .catch(() => {
                hideFullScreenLoader();
                showToast('Có lỗi xảy ra', 'error');
            });
        };

        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Quill !== 'undefined') {
                const quill = new Quill('#editor-other-contact', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{ list: 'ordered' }, { list: 'bullet' }, { align: [] }],
                            [{ color: [] }, { background: [] }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });

                quill.on('text-change', function () {
                    document.querySelector('.ipt-other-contact').value = quill.root.innerHTML;
                });
            }
        });
    </script>
@endsection
