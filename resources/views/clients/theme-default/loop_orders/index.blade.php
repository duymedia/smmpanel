@extends('clients.theme-default.layouts.app')
@section('title', 'Loop Orders')

@section('content')
    <div class="content flex-column-fluid" id="kt_content">
        @include('clients.theme-default.layouts.toolbar', [
            'title' => 'Loop Orders',
            'langKey' => 'Loop Orders',
        ])

        <div class="post" id="kt_post">
            <div class="card mb-4">
                <div class="card-body py-3 px-4">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-md-9">
                            <div class="input-group input-group-sm input-group-solid">
                                <span class="input-group-text">
                                    <i class="ki-outline ki-magnifier fs-4"></i>
                                </span>
                                <input type="text" id="ipt-loop-link" class="form-control"
                                    placeholder="Search link..." data-lang="Search link..."
                                    data-lang-attr="placeholder" value="{{ $link }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <button type="button" class="btn btn-primary btn-sm w-100"
                                onclick="_loop_orders.on.click.refresh()">
                                <i class="ki-outline ki-arrows-circle fs-5 me-1"></i>
                                <span data-lang="Refresh">Refresh</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-row-bordered table-row-gray-300 gs-3 gy-2 gx-2 fs-7"
                            id="table-loop-orders">
                            <thead>
                                <tr class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                                    <th data-lang="Order">Order</th>
                                    <th data-lang="Link &amp; Service">Link &amp; Service</th>
                                    <th data-lang="Loop Progress">Loop Progress</th>
                                    <th data-lang="Loop Spacing">Loop Spacing</th>
                                    <th data-lang="Cost">Cost</th>
                                    <th data-lang="Status">Status</th>
                                    <th data-lang="Actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="loop-orders-tbody">
                                @forelse ($orders as $order)
                                    <tr id="loop-order-{{ $order->id }}" class="align-middle">
                                        <td class="fw-bold">#{{ $order->id }}</td>
                                        <td>
                                            <a href="{{ $order->link }}" target="_blank" rel="noopener noreferrer"
                                                class="text-gray-800 text-break d-inline-block"
                                                style="max-width: 420px">{{ $order->link }}</a>
                                            <div class="text-muted fs-8 mt-1">{{ $order->service_name_display }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 6px; min-width: 70px;">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $order->loop_progress }}%"
                                                        aria-valuenow="{{ $order->loop_progress }}" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <span
                                                    class="text-nowrap text-gray-700">{{ $order->loop_done_display }}/{{ $order->loop_total_display }}</span>
                                            </div>
                                        </td>
                                        <td class="text-nowrap">{{ $order->loop_spacing }} <span
                                                data-lang="min">min</span></td>
                                        <td class="fw-bold text-nowrap">{{ $order->charge_display }}</td>
                                        <td>
                                            <span class="badge badge-light-{{ $order->status_class }}"
                                                data-lang="status::{{ $order->display_status }}">
                                                {{ $order->display_status }}
                                            </span>
                                        </td>
                                        <td class="text-nowrap">
                                            <button type="button" class="btn btn-sm btn-light-primary"
                                                onclick="_loop_orders.on.click.viewLoop({{ $order->id }})"
                                                data-lang="Details">Details</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-10">
                                            <i class="bi bi-inbox fs-2x text-muted mb-3 d-block"></i>
                                            <p class="fw-semibold fs-6 text-gray-600 mb-1" data-lang="No loop orders found">
                                                No loop orders found</p>
                                            <p class="fs-8 text-gray-500"
                                                data-lang="Create orders with loop option to view here">Create orders with
                                                loop option to view here</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <ul class="pagination mb-0">
                    {{ $orders->onEachSide(1)->links('pagination::bootstrap-5') }}
                </ul>
            </div>

            <!-- Modal: Loop Order Detail -->
            <div class="modal fade" id="modal-loop-detail" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header" style="background:#1976d2">
                            <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-arrows-circle fs-4 text-white"><span class="path1"></span><span
                                        class="path2"></span></i>
                                <span data-lang="Loop Orders Detail">Loop Orders Detail</span>
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body fs-7">
                            <div class="text-center py-10">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                        </div>
                        <div class="modal-footer py-2">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"
                                data-lang="button::Close">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

@push('scripts')
    <script>_loop_orders.init();</script>
@endpush
