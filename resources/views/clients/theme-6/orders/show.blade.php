@extends('clients.theme-6.layouts.app')
@section('title', __('orders.title'))
@section('content')
<div id="block_order_show"><div class="block-bg"></div><div class="container"><div class="component_card"><div class="card">
<h2>{{ __('orders.order_id') }} #{{ $order->id }}</h2>
<div class="table-responsive"><table class="table"><tbody>
<tr><td>{{ __('orders.service') }}</td><td>{{ $order->service_id }} — {{ $order->service_name ?? optional($order->service)->name }}</td></tr>
<tr><td>{{ __('orders.link') }}</td><td class="table-link"><a href="{{ $order->link }}" target="_blank" rel="noopener">{{ $order->link }}</a></td></tr>
<tr><td>{{ __('orders.status') }}</td><td>{{ getOrderStatusText($order->status) }}</td></tr>
<tr><td>{{ __('orders.quantity') }}</td><td>{{ $order->quantity }}</td></tr>
<tr><td>{{ __('newOrder.charge') }}</td><td>{{ $order->charge_display ?? $order->charge }}</td></tr>
<tr><td>{{ __('orders.start_count') }}</td><td>{{ $order->start_count }}</td></tr>
<tr><td>{{ __('orders.remains') }}</td><td>{{ $order->remains }}</td></tr>
</tbody></table></div>
<a class="btn btn-big-primary" href="{{ route('clients.orders.index') }}">{{ __('orders.all') ?? 'Back to orders' }}</a>
</div></div></div></div>
@endsection