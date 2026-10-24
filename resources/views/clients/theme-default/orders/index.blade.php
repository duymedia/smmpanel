@extends('clients.theme-default.layouts.app')
@section('title', 'Orders')

@section('content')
    <style>
        .table-orders td {
            line-height: 1.5;
        }

        .wrap {
            word-break: break-all;
            overflow-wrap: anywhere;
        }

        #table-orders td:nth-child(2) {
            max-width: 260px;
            min-width: 120px;
        }
    </style>
    <div class="content flex-column-fluid" id="kt_content">
        @include('clients.theme-default.layouts.toolbar', [
            'title' => 'Orders',
            'langKey' => 'menu::My orders',
        ])

        <div class="post" id="kt_post">
            {{-- Filter bar --}}
            <div class="card mb-4">
                <div class="card-body py-3 px-4">
                    <div class="row g-2 align-items-center">
                        {{-- Status: navigate to /orders/{status} --}}
                        <div class="col-12 col-md-2">
                            <select id="sl-status" class="form-select form-select-sm form-select-solid"
                                onchange="_orders.on.change.status(this.value)" data-kt-select2="true"
                                data-control="select2" data-hide-search="true">
                                <option value="" data-url="{{ route('clients.orders.index') }}"
                                    data-lang="status::All">All status</option>
                                @foreach ($orderStatusOptions as $statusOption)
                                    <option value="{{ $statusOption['value'] }}"
                                        data-lang="status::{{ $statusOption['label'] }}"
                                        {{ request()->segment(2) === $statusOption['value'] ? 'selected' : '' }}>
                                        {{ $statusOption['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Date range --}}
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-sm input-group-solid">
                                <span class="input-group-text">
                                    <div class="form-check form-check-custom form-check-sm">
                                        <input id="cb-date" class="form-check-input w-15px h-15px cb-date" type="checkbox"
                                            {{ request('start') || request('end') ? 'checked' : '' }}>
                                    </div>
                                </span>
                                <input type="text" id="ipt-date" class="form-control ipt-date" readonly
                                    value="{{ request('start') && request('end') ? request('start') . ' - ' . request('end') : '' }}"
                                    placeholder="{{ now()->format('Y/m/01') }} - {{ now()->format('Y/m/d') }}">
                            </div>
                        </div>

                        {{-- Search type --}}
                        <div class="col-12 col-md-2">
                            <select id="sl-type" class="form-select form-select-sm form-select-solid"
                                data-kt-select2="true" data-control="select2" data-hide-search="true">
                                <option value="0" data-lang="Search type">Search type</option>
                                <option value="1" data-lang="Order ID"
                                    {{ request('type') === '1' ? 'selected' : '' }}>Order ID</option>
                                <option value="2" data-lang="Link"
                                    {{ request('type') === '2' ? 'selected' : '' }}>Link</option>
                                <option value="3" data-lang="Service ID"
                                    {{ request('type') === '3' ? 'selected' : '' }}>Service ID</option>
                            </select>
                        </div>

                        {{-- Keyword + Search --}}
                        <div class="col-12 col-md-4">
                            <div class="input-group input-group-sm input-group-solid">
                                <input type="text" id="ipt-keyword" class="form-control" placeholder="Keyword"
                                    data-page="/services" data-lang="Keyword" value="{{ request('keyword') }}">
                                <button type="button" class="btn btn-primary btn-sm" id="btn-search"
                                    onclick="_orders.on.click.search()" data-lang="button::Search">Search</button>
                            </div>
                        </div>
                        <div class="col-12 col-md-1">
                            <button type="button" class="btn btn-sm btn-info w-100" onclick="_orders.on.click.export()"
                                data-lang="Export">Export</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-2">
                <a class="text-muted fst-italic fs-8 text-hover-primary" href="/orders_old">
                    * <span data-lang="Access older data">Access older data</span>
                </a>
            </div>

            {{-- Orders list --}}
            <div class="card card-orders border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table
                            class="table table-striped table-orders table-row-bordered table-row-gray-200 gs-3 gy-2 gx-2 fs-7 mb-0"
                            id="table-orders">
                            <tbody>
                                {{-- Bulk action header --}}
                                <tr>
                                    <th colspan="10">
                                        <div class="form-check form-check-custom form-check-sm">
                                            <input class="form-check-input h-15px w-15px cb-all" type="checkbox"
                                                onchange="_orders.on.change.cbselectallOrder(this.checked)">
                                            <label class="ms-3 fs-7 count-selected"></label>
                                            <button class="btn btn-primary btn-sm px-2 py-1 ms-4 btn-action" type="button"
                                                onclick="_orders.on.click.bulkAction('Copy ID')" style="display:none"
                                                data-lang="Copy ID">Copy ID</button>
                                            <button class="btn btn-info btn-sm px-2 py-1 ms-2 btn-action" type="button"
                                                onclick="_orders.on.click.bulkAction('Refill')"
                                                style="display:none" data-lang="Refill">Refill</button>
                                        </div>
                                    </th>
                                </tr>

                                @forelse ($orders as $order)
                                    <tr class="bg-lighten">
                                        <td width="1" class="text-nowrap ps-3">
                                            <div class="form-check form-check-custom form-check-sm">
                                                <input class="form-check-input h-15px w-15px cb-select" type="checkbox"
                                                    onchange="_orders.on.change.cbselectOrder(this.checked)"
                                                    value="{{ $order->id }}">
                                                <span class="ms-2 fw-bolder ls-1">{{ $order->id }}</span>
                                            </div>
                                            <p class="m-0 fw-bolder {{ $order->status_class }}">
                                                <span class="text-uppercase"
                                                    data-lang="status::{{ $order->display_status }}">{{ $order->display_status }}</span>
                                            </p>
                                            <p class="m-0 fs-8 text-gray-500">{{ $order->created_at }}</p>
                                            <p class="m-0 fs-8 text-gray-500">{{ $order->updated_at }}</p>
                                            @if (serviceOn($config, 'service_allow_report'))
                                                <button class="btn btn-danger hover-scale fs-9 px-2 py-0 mt-1"
                                                    onclick="_orders.on.click.showModalReport({{ $order->id }})"
                                                    data-lang="Report">Report</button>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="d-flex flex-column">
                                                <p class="m-0 text-gray-700">
                                                    @if ($order->service_icon_url)
                                                        <img src="{{ $order->service_icon_url }}" alt=""
                                                            class="w-20px h-20px rounded-1 me-1"
                                                            style="object-fit:cover;vertical-align:middle">
                                                    @elseif ($order->service_icon_class)
                                                        <i class="{{ $order->service_icon_class }} me-1"></i>
                                                    @else
                                                        <i class="fa-solid fa-star text-warning me-1 fs-9"></i>
                                                    @endif
                                                    <span class="text-gray-900 fw-bold">{{ $order->service_id }}</span>
                                                    @if ($order->has_service_name)
                                                        <span class="text-muted ms-1">| {{ $order->service_name }}</span>
                                                    @endif
                                                </p>
                                                <p class="m-0 fs-7 fst-italic">
                                                    <a class="text-gray-500 text-hover-primary" target="_blank"
                                                        href="{{ $order->link }}">{{ $order->link }}</a>
                                                </p>
                                            </div>
                                        </td>


                                        <td width="1">
                                            <p class="m-0 fw-bold text-nowrap">
                                                <span class="text-gray-600 fw-normal fs-8"
                                                    data-lang="Charge">Charge</span>:
                                                <a href="/cashflow?id={{ $order->id }}">
                                                    <span class="text-primary">{{ $order->charge_display }}</span>
                                                </a>
                                            </p>
                                            <p class="m-0 fw-bold text-nowrap">
                                                <span class="text-gray-600 fw-normal fs-8"
                                                    data-lang="Quantity">Quantity</span>:
                                                {{ $order->quantity_display }}
                                            </p>
                                            <p class="m-0 fw-bold text-nowrap">
                                                <span class="text-gray-600 fw-normal fs-8"
                                                    data-lang="Start count">Start
                                                    count</span>: {{ $order->start_count ?? 0 }}
                                            </p>
                                            <p class="m-0 fw-bold text-nowrap">
                                                <span class="text-gray-600 fw-normal fs-8"
                                                    data-lang="Remains">Remains</span>: {{ $order->remains ?? 0 }}
                                            </p>
                                        </td>

                                        <td width="1">
                                            <div class="d-flex align-items-end flex-column text-nowrap">
                                                <div class="mb-auto d-flex flex-column">
                                                    @if ($order->refill == 1 && $order->status === 'completed')
                                                        <button
                                                            class="btn btn-info hover-scale fs-8 px-3 py-0 order-action-btn"
                                                            onclick="_orders.on.click.refill({{ $order->id }})"
                                                            data-lang="Request refill">Request
                                                            refill</button>
                                                    @endif
                                                    @if ($order->cancel == 1 && $order->cancel_status !== 'pending' && !in_array($order->status, ['canceled', 'completed', 'partial']))
                                                        <button
                                                            class="btn btn-warning hover-scale fs-8 px-3 py-0 mt-1 order-action-btn"
                                                            onclick="_orders.on.click.requestCancel({{ $order->id }})"
                                                            data-lang="Request cancel">Request cancel</button>
                                                    @endif
                                                    <a target="_blank"
                                                        class="btn btn-primary hover-scale fs-8 px-3 py-0 mt-1"
                                                        href="/new?service={{ $order->service_id }}"
                                                        data-lang="Reorder">Reorder</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox fs-2x d-block mb-2"></i>
                                            <span data-lang="No orders found">No orders found</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($orders->hasPages())
                        <div class="d-flex justify-content-center py-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal-ticket-order">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h5 class="modal-title" data-lang="Report Order">Report Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <label class="required form-label" data-lang="Order ID">Order ID</label>
                        <input type="text" class="form-control ipt-order-id" disabled>
                    </div>
                    <div class="mb-5">
                        <label class="required form-label" data-lang="Request">Request</label>
                        <select class="form-select form-select-solid sl-request" data-kt-select2="true"
                            data-control="select2" data-hide-search="true"
                            data-dropdown-parent="#modal-ticket-order">
                            <option value="0" data-lang="Please choose">Please choose</option>
                            <option value="1" data-lang="Cancel">Cancel</option>
                            <option value="2" data-lang="Refill">Refill</option>
                            <option value="3" data-lang="Speed up">Speed up</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary btn-icon w-100"
                        onclick="_orders.on.click.report(document.querySelector('.ipt-order-id').value, document.querySelector('.sl-request').value)"
                        data-lang="button::Request">Request</button>
                </div>
            </div>
        </div>
    </div>

    <script>var CURRENT_PATH = 'orders';</script>
@endsection

@push('scripts')
    <script>_orders.init();</script>
@endpush
