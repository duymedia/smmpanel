@extends('clients.theme-default.layouts.app')
@section('title', 'Product orders')

@section('content')
<div class="content flex-column-fluid" id="kt_content">
    @include('clients.theme-default.layouts.toolbar', ['title' => 'Product orders', 'langKey' => 'menu::Product orders'])
    <div class="post" id="kt_post">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-7 gy-3 gs-5 mb-0">
                        <thead>
                            <tr class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                                <th>ID</th>
                                <th data-lang="Created">Created</th>
                                <th data-lang="Product">Product</th>
                                <th data-lang="Quantity">Quantity</th>
                                <th data-lang="Charge">Charge</th>
                                <th data-lang="Status">Status</th>
                                <th data-lang="Result">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                @php
                                    $charge = $exRate > 0 ? (float)$order->charge * $exRate : (float)$order->charge;
                                    $chargeStr = rtrim(rtrim(number_format($charge, 8, '.', ''), '0'), '.');
                                    $chargeDisplay = $symPos === 'before' ? $sym . $chargeStr : $chargeStr . ' ' . $sym;

                                    $badgeClass = match($order->status) {
                                        'Completed'   => 'badge-light-success',
                                        'In progress' => 'badge-light-info',
                                        'Pending'     => 'badge-light-secondary',
                                        'Awaiting'    => 'badge-light-secondary',
                                        'Manual'      => 'badge-light-primary',
                                        'Failed'      => 'badge-light-danger',
                                        'Canceled'    => 'badge-light-warning',
                                        default       => 'badge-light-secondary',
                                    };
                                @endphp
                                <tr>
                                    <td class="fw-bold">{{ $order->id }}</td>
                                    <td class="text-gray-600 fs-8 text-nowrap">{{ $order->created_at }}</td>
                                    <td>
                                        @if ($order->product)
                                            <a href="/products/{{ $order->product->slug }}" class="text-gray-900 text-hover-primary">
                                                {{ $order->product->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->quantity }}</td>
                                    <td class="fw-bold">{{ $chargeDisplay }}</td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}"
                                            data-lang="status::{{ $order->status }}">{{ $order->status }}</span>
                                    </td>
                                    <td>
                                        @if ($order->note)
                                            <button class="btn btn-sm btn-light-info px-2 py-1 fs-8"
                                                onclick="_product_orders.on.click.result({{ $order->id }})"
                                                data-lang="View">View</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-10">
                                        <i class="bi bi-inbox fs-2x d-block mb-2"></i>
                                        <span data-lang="No orders found">No orders found</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($orders->hasPages())
                    <div class="d-flex justify-content-center py-4">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Modal view result --}}
        <div class="modal fade" tabindex="-1" id="modal-view-result">
            <div class="modal-dialog modal-dialog-centered mw-600px">
                <div class="modal-content">
                    <div class="modal-header py-3">
                        <h5 class="modal-title" data-lang="Result">Result</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="modal-result-body" style="word-break:break-all"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

