@extends('clients.theme-default.layouts.app')
@section('title', 'Tickets')

@section('content')
    <div class="content flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        @include('clients.theme-default.layouts.toolbar', ['title' => 'Support', 'langKey' => 'menu::Support'])
        <!--begin::Post-->
        <div class="post" id="kt_post">
            <div class="card mb-5">
                <div class="card-header">
                    <div class="card-title fw-bold" data-lang="Contact Us">Contact Us</div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap d-grid gap-2">
                        @if (!empty($config?->link_facebook))
                            <div class="d-flex align-items-center me-10 flex-grow-1">
                                <div class="symbol symbol-30px symbol-circle me-3">
                                    <i class="bi bi-facebook text-primary fs-2x"></i>
                                </div>
                                <div class="m-0">
                                    <span class="fw-bold text-gray-600 d-block fs-8">Facebook</span>
                                    <a href="{{ $config->link_facebook }}" target="_blank"
                                        class="fw-bolder text-gray-800 fs-6">{{ $config->link_facebook }}</a>
                                </div>
                            </div>
                        @endif

                        @if (!empty($config?->link_zalo))
                            <div class="d-flex align-items-center me-10 flex-grow-1">
                                <div class="symbol symbol-30px symbol-circle me-3">
                                    <i class="bi bi-chat-dots text-primary fs-2x"></i>
                                </div>
                                <div class="m-0">
                                    <span class="fw-bold text-gray-600 d-block fs-8">Zalo</span>
                                    <a href="{{ $config->link_zalo }}" target="_blank"
                                        class="fw-bolder text-gray-800 fs-6">{{ $config->link_zalo }}</a>
                                </div>
                            </div>
                        @endif

                        @if (!empty($config?->link_telegram))
                            <div class="d-flex align-items-center me-10 flex-grow-1">
                                <div class="symbol symbol-30px symbol-circle me-3">
                                    <i class="bi bi-telegram text-primary fs-2x"></i>
                                </div>
                                <div class="m-0">
                                    <span class="fw-bold text-gray-600 d-block fs-8">Telegram</span>
                                    <a href="{{ $config->link_telegram }}" target="_blank"
                                        class="fw-bolder text-gray-800 fs-6">{{ $config->link_telegram }}</a>
                                </div>
                            </div>
                        @endif

                        @if (!empty($config?->link_whatsapp))
                            <div class="d-flex align-items-center flex-grow-1">
                                <div class="symbol symbol-30px symbol-circle me-3">
                                    <i class="bi bi-whatsapp text-success fs-2x"></i>
                                </div>
                                <div class="m-0">
                                    <span class="fw-bold text-gray-600 d-block fs-8">Whatsapp</span>
                                    <a href="{{ $config->link_whatsapp }}" target="_blank"
                                        class="fw-bolder text-gray-800 fs-6">{{ $config->link_whatsapp }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card mb-5">
                <div class="card-header">
                    <div class="card-title fw-bold" data-lang="Tickets">Tickets</div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-7 gy-3 gs-5 mb-0">
                            <thead class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                                <tr>
                                    <th data-lang="ID">ID</th>
                                    <th data-lang="Order ID">Order ID</th>
                                    <th data-lang="Request">Request</th>
                                    <th data-lang="Status">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                    @php
                                        $cf = is_array($ticket->custom_fields) ? $ticket->custom_fields : json_decode($ticket->custom_fields ?? '{}', true);
                                        $orderId = $cf['order_id'] ?? '—';
                                        $request = $ticket->ticketSubject?->subcategory ?: ($ticket->ticketSubject?->category ?: $ticket->subject);
                                    @endphp
                                    <tr>
                                        <td class="ls-1">{{ $ticket->id }}</td>
                                        <td class="ls-1 fw-bold">{{ $orderId }}</td>
                                        <td>{{ $request }}</td>
                                        <td class="fw-bold">{{ $ticket->status_text }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5" data-lang="No ticket found">No ticket found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card" id="kt_chat_messenger">
                <div class="card-header" id="kt_chat_messenger_header">
                    <div class="card-title">
                        <div class="d-flex justify-content-center flex-column me-3">
                            <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1"
                                data-lang="Direct message">Direct message</a>
                        </div>
                    </div>
                </div>
                <div class="card-body py-5" id="kt_chat_messenger_body" style="min-height: 300px">
                    <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto chat-mess" id="chat-messages"
                        data-kt-element="messages"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                        data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body"
                        data-kt-scroll-offset="5px">
                        {{-- Render server-side lần đầu --}}
                        @php
                            $allMessages = collect();
                            foreach ($tickets as $ticket) {
                                foreach ($ticket->replies as $reply) {
                                    $allMessages->push((object)[
                                        'id'         => $reply->id,
                                        'is_admin'   => $reply->is_admin,
                                        'message'    => $reply->message,
                                        'created_at' => $reply->created_at,
                                    ]);
                                }
                            }
                            $allMessages = $allMessages->sortBy('created_at')->values();
                        @endphp
                        @forelse ($allMessages as $msg)
                            @if ($msg->is_admin)
                                <div class="d-flex justify-content-start mb-10">
                                    <div class="d-flex flex-column align-items-start">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="symbol symbol-35px symbol-circle me-3"></div>
                                            <div>
                                                <span class="fs-5 fw-bold text-gray-900 me-1">Support</span>
                                                <span class="text-muted fs-7">{{ $msg->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start">{!! nl2br(e($msg->message)) !!}</div>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-end mb-10">
                                    <div class="d-flex flex-column align-items-end">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="me-3">
                                                <span class="text-muted fs-7">{{ $msg->created_at->format('d/m/Y H:i') }}</span>
                                                <span class="fs-5 fw-bold text-gray-900 ms-1">You</span>
                                            </div>
                                            <div class="symbol symbol-35px symbol-circle"></div>
                                        </div>
                                        <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end">{!! nl2br(e($msg->message)) !!}</div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="text-center text-muted py-5" id="chat-empty" data-lang="No ticket found">No ticket found.</div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                    <select id="sl-ticket-category" style="display:none;">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ strtolower($cat) === 'other' ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <textarea id="txa-message" class="form-control form-control-flush mb-3" style="overflow:auto;resize:none;max-height:200px"
                        placeholder="Type a message" data-lang="Type a message" rows="1"></textarea>
                    <button type="button" id="btn-send" class="btn btn-primary float-end" data-lang="Send">Send</button>
                </div>
            </div>
        </div>
        <!--end::Post-->
    </div>

@endsection

@push('scripts')
<script>
    $(function () {
        const $message = $('#txa-message');
        const $sendButton = $('#btn-send');
        let activeTicketId = @json($tickets->firstWhere('status', 'open')?->id);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const replyUrl = @json(route('clients.tickets.reply', ['id' => '__ticket_id__']));
        const createUrl = @json(route('clients.tickets.store'));

        const showError = (xhr, fallback) => {
            const response = xhr.responseJSON || {};
            const errors = response.errors ? Object.values(response.errors).flat()[0] : null;
            app.alert(errors || response.message || fallback, 'danger');
        };

        const appendMessage = (reply) => {
            if (!reply) return;
            $('#chat-empty').remove();
            const createdAt = reply.created_at || new Date().toLocaleString('vi-VN');
            const message = $('<div>').text(reply.message || '').html().replace(/\n/g, '<br>');
            $('#chat-messages').append(`
                <div class="d-flex justify-content-end mb-10">
                    <div class="d-flex flex-column align-items-end">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-3"><span class="text-muted fs-7">${createdAt}</span>
                                <span class="fs-5 fw-bold text-gray-900 ms-1">You</span></div>
                            <div class="symbol symbol-35px symbol-circle"></div>
                        </div>
                        <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end">${message}</div>
                    </div>
                </div>`);
            const chat = document.getElementById('chat-messages');
            chat.scrollTop = chat.scrollHeight;
        };

        const sendMessage = () => {
            const message = $message.val().trim();

            if (!message) {
                app.alert('Please enter a message', 'danger');
                return;
            }

            const request = activeTicketId
                ? {
                    url: replyUrl.replace('__ticket_id__', activeTicketId),
                    data: { TicketMessageForm: { message } },
                }
                : {
                    url: createUrl,
                    data: {
                        category: $('#sl-ticket-category').val() || 'Other',
                        message,
                    },
                };

            $sendButton.prop('disabled', true);

            $.ajax({
                url: request.url,
                method: 'POST',
                data: request.data,
                headers: { 'X-CSRF-TOKEN': csrfToken },
            })
                .done((response) => {
                    if (!response.success) {
                        app.alert(response.message || 'Unable to send message.', 'danger');
                        return;
                    }

                    activeTicketId = activeTicketId || response.ticket?.id || response.ticket_id;
                    appendMessage(response.reply || { message, created_at: new Date().toLocaleString('vi-VN') });
                    $message.val('').trigger('input').focus();
                })
                .fail((xhr) => showError(xhr, 'Unable to send message. Please try again.'))
                .always(() => $sendButton.prop('disabled', false));
        };

        $sendButton.on('click', sendMessage);
        $message.on('keydown', function (event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        });
    });
</script>
@endpush

