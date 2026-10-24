@extends('admin.layouts.app')
@section('title', 'Phiếu hỗ trợ')

@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <div class="d-flex flex-wrap flex-stack mb-6">
        <h3 class="fw-bold my-2">
            <span><span data-lang="Waiting">Đang chờ</span>: {{ $stats['waiting'] ?? 0 }}</span> |
            <span class="text-primary"><span data-lang="Processing">Đang xử lý</span>: {{ $stats['processing'] ?? 0 }}</span>
        </h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-row-bordered fs-7 gx-0">
                    @forelse($ticketOrders as $providerId => $orders)
                        <tbody>
                            <tr>
                                <td colspan="7" class="fs-5 fw-bolder ls-1">
                                    <i class="fa-solid fa-house me-1"></i>{{ $orders->first()->provider_name ?: 'Manual' }}
                                    <span class="ticket-action-menu" data-type="0" data-id="{{ (int) $providerId }}"></span>
                                </td>
                            </tr>
                            @foreach($orders->groupBy('service_id') as $serviceId => $serviceOrders)
                                <tr>
                                    <td colspan="7" class="fs-6 fw-bold">
                                        <i class="fa fa-crosshairs ps-10"></i>
                                        {{ $serviceId }} - {{ $serviceOrders->first()->service_name ?: 'Dịch vụ #'.$serviceId }}
                                        <span class="ticket-action-menu" data-type="1" data-id="{{ (int) $serviceId }}"></span>
                                    </td>
                                </tr>
                                @foreach($serviceOrders as $order)
                                    <tr>
                                        <td class="ps-20">
                                            <a data-bs-toggle="tooltip" title="Lịch sử yêu cầu" href="javascript:;" onclick="_tickets.on.click.history({{ $order->id }})"><i class="fa-solid fa-clock-rotate-left"></i></a>
                                            <a target="_blank" class="fw-bold text-hover-primary" href="/admin/orders?id={{ $order->id }}">{{ $order->id }}</a>
                                        </td>
                                        <td><span class="badge badge-outline badge-{{ $order->ticket_color }}">{{ $order->ticket_label }}</span></td>
                                        <td><a target="_blank" class="text-gray-800" href="/admin/accounts/{{ urlencode($order->username) }}">{{ $order->username }}</a></td>
                                        <td data-bs-toggle="tooltip" title="Ngày tạo">{{ $order->created_at }} <span class="fst-italic">({{ \Illuminate\Support\Carbon::parse($order->created_at)->diffForHumans() }})</span></td>
                                        <td data-bs-toggle="tooltip" title="Cập nhật">{{ $order->updated_at }} <span class="fst-italic">({{ \Illuminate\Support\Carbon::parse($order->updated_at)->diffForHumans() }})</span></td>
                                        <td><span class="fw-bolder">{{ $order->ticket_status === 'completed' ? 'Hoàn thành' : ($order->ticket_status === 'processing' ? 'Đang xử lý' : 'Đang chờ') }}</span></td>
                                        <td class="text-end"><span class="ticket-action-menu" data-type="2" data-id="{{ (int) $order->id }}" data-no-margin="1"></span></td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    @empty
                        <tbody><tr><td colspan="7" class="text-center text-muted py-10">Không có yêu cầu hỗ trợ</td></tr></tbody>
                    @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-history-ticket" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Lịch sử yêu cầu</h4><button class="btn btn-icon btn-sm" data-bs-dismiss="modal"><i class="la la-times fs-3"></i></button></div><div class="modal-body"><div class="table-responsive"><table class="table table-row-bordered"><thead><tr><th>#</th><th>Yêu cầu</th><th>Ngày tạo</th><th>Cập nhật</th></tr></thead><tbody></tbody></table></div></div></div></div></div>
<div class="modal fade" id="modal-export-ticket" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Xuất danh sách</h4><button class="btn btn-icon btn-sm" data-bs-dismiss="modal"><i class="la la-times fs-3"></i></button></div><div class="modal-body"><textarea class="form-control" rows="12" readonly></textarea></div><div class="modal-footer"><button class="btn btn-primary btn-sm" onclick="_tickets.on.click.copy()">Sao chép</button></div></div></div></div>
@endsection

@push('scripts')
<script>$(document).ready(function () { _tickets.init(); });</script>
@endpush
