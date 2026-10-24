@extends('admin.layouts.app')
@section('title', 'Tin nhắn')

@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <div class="d-flex flex-column flex-lg-row">
        <div class="flex-column flex-lg-row-auto w-100 w-lg-400px w-xl-400px mb-10 mb-lg-0">
            <div class="card card-flush">
                <div class="card-header pt-7">
                    <form class="w-100 position-relative" autocomplete="off" onsubmit="return false">
                        <span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity=".5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                <path d="M11 19C6.56 19 3 15.44 3 11S6.56 3 11 3s8 3.56 8 8-3.56 8-8 8Zm0-14c-3.47 0-6 2.53-6 6s2.53 6 6 6 6-2.53 6-6-2.53-6-6-6Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <input type="text" id="search-ticket" class="form-control form-control-solid ps-15"
                               placeholder="Tìm tài khoản" data-lang-placeholder="Search by username"
                               onkeyup="_messages.on.keyup.filter(this.value.trim())">
                    </form>
                </div>
                <div class="card-body ps-3 pt-5">
                    <div class="scroll-y me-n5 pe-5 h-300px h-lg-600px chat_user"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header"
                         data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="5px">
                        <div id="div_chat_users"><div class="text-center py-10"><span class="spinner-border spinner-border-sm text-primary"></span></div></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><div class="d-flex justify-content-center flex-column me-3">
                        <a href="javascript:;" class="fs-3 fw-bold chat-user ls-2">{{ $activeUsername ?? '' }}</a>
                    </div></div>
                </div>
                <div class="card-body" id="kt_chat_messenger_body">
                    <div class="scroll-y me-n5 pe-5 h-300px h-lg-400px chat-mess"
                         data-kt-element="messages" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                         data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px">
                        <div class="text-center text-muted py-10">Chọn tài khoản để xem tin nhắn</div>
                    </div>
                </div>
                <div class="card-footer pt-4 pb-0 d-none" id="kt_chat_messenger_footer">
                    <textarea id="txa-message" class="form-control form-control-flush bg-secondary fs-7 mb-3 chat-message"
                              data-kt-autosize="true" rows="1" placeholder="Nhập nội dung tin nhắn"
                              data-lang-placeholder="Enter message"></textarea>
                    <button class="btn btn-primary btn-sm float-end btn-send" type="button" disabled data-lang="Send">Gửi</button>
                </div>
                <div class="separator d-flex flex-center my-8">
                    <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3" data-lang="Suggested replies">Các mẫu trả lời có sẵn</span>
                </div>
                <div class="px-5 pb-5">
                    @if(!empty($quickMessages))
                        <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                            @foreach($quickMessages as $message)
                                <button type="button" class="btn btn-light-primary btn-sm" onclick='_messages.on.click.send("", @js($message))'>{{ $message }}</button>
                            @endforeach
                        </div>
                    @endif
                    <p class="text-center mb-0"><a href="/admin/settings/support" class="text-hover-primary">* <span data-lang="Go to Setting">Thiết lập</span> *</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var CUS_USER = @json($activeUsername ?? 0);
    $(function () { _messages.init(); });
</script>
@endpush
