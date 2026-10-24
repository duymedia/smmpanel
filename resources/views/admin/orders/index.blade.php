@extends('admin.layouts.app')
@section('title', 'Orders')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
   <div class="card shadow">
      <div class="card-body p-5">
         <div class="div-filter-status">
            <div class="mb-3">
               <a href="javascript:;" class="btn btn-sm btn-outline btn-outline- px-3 py-1 me-3" onclick="_orders.on.click.filterStatus('All')" data-lang="status::All">Tất cả</a>
               <a href="javascript:;" class="btn btn-sm btn-outline btn-outline- px-3 py-1 me-3" onclick="_orders.on.click.filterStatus('Manual')">
                  <span data-lang="status::Manual">Thủ công</span>
                  @if (($manualCount ?? 0) > 0)
                     <span class="badge badge-circle badge-secondary ms-1">{{ $manualCount }}</span>
                  @endif
               </a>
               <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-warning px-3 py-1 me-3" onclick="_orders.on.click.filterStatus('Failed')">
                  <span data-lang="status::Failed">Thất bại</span>
                  @if (($failedCount ?? 0) > 0)
                     <span class="badge badge-circle badge-warning ms-1">{{ $failedCount }}</span>
                  @endif
               </a>
               <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-secondary text-gray-500 px-3 py-1 me-3" onclick="_orders.on.click.filterStatus('Awaiting')" data-lang="status::Awaiting">Đang chờ</a>
               <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-danger px-3 py-1 me-3" onclick="_orders.on.click.filterStatus('Ticket')" data-lang="status::Ticket">Hỗ trợ</a>
            </div>
            <div class="mb-3">
               <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-secondary text-gray-600 px-3 py-1 me-3" onclick="_orders.on.click.filterStatus('Pending')" data-lang="status::Pending">Chờ xử lý</a>
               <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-primary px-3 py-1 me-3" onclick="_orders.on.click.filterStatus('Processing')" data-lang="status::Processing">Đang xử lý</a>
               <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-info px-3 py-1 me-3" onclick="_orders.on.click.filterStatus('In progress')" data-lang="status::In progress">Đang chạy</a>
               <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-success px-3 py-1 me-3" onclick="_orders.on.click.filterStatus('Completed')" data-lang="status::Completed">Hoàn thành</a>
               <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-danger px-3 py-1 me-3" onclick="_orders.on.click.filterStatus('Partial')" data-lang="status::Partial">Hoàn tiền một phần</a>
               <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-warning px-3 py-1 me-3" onclick="_orders.on.click.filterStatus('Canceled')" data-lang="status::Canceled">Hủy</a>
            </div>
         </div>
         <div class="row g-3">
            <div class="col-lg-2 col-md-6 col-6">
               <input type="text" class="form-control form-control-solid form-control-sm ipt-order-id datatable-input" placeholder="Mã đơn hàng" data-lang="Order ID" data-col-name="order_id">
            </div>
            <div class="col-lg-2 col-md-6 col-6">
               <input type="text" class="form-control form-control-solid form-control-sm ipt-porder-id datatable-input" placeholder="Mã đơn hàng NCC" data-lang="Provider Order ID" data-col-name="provider_oid">
            </div>
            <div class="col-lg-4 col-md-6 col-12">
               <div class="input-group input-group-solid input-group-sm">
                  <span class="input-group-text">
                     <div class="form-check form-check-solid form-check-custom form-check-sm">
                        <input class="form-check-input w-15px h-15px cb-link" type="checkbox" onchange="_orders.on.change.link(this.checked) ">
                     </div>
                  </span>
                  <input type="text" class="form-control form-control-solid form-control-sm ipt-link datatable-input" placeholder="Link (Chính xác từ khóa)" data-lang="Link-exact" data-col-name="order_link">
               </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
               <button type="button" class="btn btn-primary btn-sm me-2" onclick="_orders.on.click.filter()" data-lang="Search">Tìm kiếm</button>
               <button type="button" class="btn btn-sm btn-secondary" onclick="document.querySelector('.div-advanced-search').style.display = ''" data-lang="button::Advanced">Nâng cao</button>
               <button type="button" class="btn btn-sm btn-secondary" onclick="_orders.on.click.resetFilter()" data-lang="Reset">Thiết lập lại</button>
            </div>
            <div class="col-lg-12 div-advanced-search" style="display: none;">
               <div class="row g-3">
                  <div class="col-lg-2 col-md-6 col-6">
                     <div class="input-group input-group-solid input-group-sm">
                        <span class="input-group-text">
                           <div class="form-check form-check-solid form-check-custom form-check-sm">
                              <input class="form-check-input w-15px h-15px cb-date" type="checkbox">
                           </div>
                        </span>
                        <input class="form-control datatable-input ipt-date" data-col-name="order_created" placeholder="Pick date range" data-lang="Select date range">
                     </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-6">
                     <select class="form-select form-select-solid form-select-sm datatable-input sl-account" data-col-name="account_id">
                        <option value="" data-lang="All accounts" selected>Tất cả tài khoản</option>
                     </select>
                  </div>
                  <div class="col-lg-6 col-md-6 col-6">
                     <select class="form-select form-select-solid form-select-sm datatable-input" data-kt-select2="true" data-col-name="service_id">
                        <option value="" data-lang="All services" selected>Tất cả dịch vụ</option>
                        @foreach($services ?? [] as $service)
                        <option value="{{ $service['id'] }}" {{ ($searchParams['service_id'] ?? '') == $service['id'] ? 'selected' : '' }}>
                        {{ $service['id'] }} - {{ $service['name'] }}
                        </option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-lg-2 col-md-6 col-6">
                     <select class="form-select form-select-solid form-select-sm datatable-input" data-kt-select2="true" data-col-name="provider_id">
                        <option value="" data-lang="All providers" selected>Tất cả</option>
                        <option value="Manual" data-lang="All manual">Tất cả đơn thủ công</option>
                        <option value="Api" data-lang="All providers">Tất cả nhà cung cấp</option>
                        @foreach($providers ?? [] as $provider)
                        <option value="{{ $provider->id }}" {{ ($searchParams['provider_id'] ?? '') == $provider->id ? 'selected' : '' }}>
                        {{ $provider->name }}
                        </option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- ── switch note ─────────────────────────────────────────────── -->
   <div class="d-flex flex-wrap flex-stack">
      <h3 class="fw-bold my-2"></h3>
      <div class="d-flex flex-wrap my-2">
         <div class="text-end switch-text current">
            <p class="fst-italic fw-semibold p-2 mb-0">
               <a href="javascript:;" onclick="_orders.on.click.switchOrderDiv('div-table-orders-old')"
                  data-bs-toggle="tooltip" data-bs-placement="top"
                  data-lang="note-order-1">
               * <span data-lang="note-order">Truy cập dữ liệu cũ hơn</span>
               </a>
            </p>
         </div>
         <div class="text-end switch-text old" style="display:none;">
            <p class="fst-italic fw-semibold p-2 mb-0">
               <a href="javascript:;" onclick="_orders.on.click.switchOrderDiv('div-table-orders')"
                  data-bs-toggle="tooltip" data-bs-placement="top"
                  data-lang="note-order-3">
               * <span data-lang="note-order-2">Quay lại danh sách hiện tại</span>
               </a>
            </p>
         </div>
      </div>
   </div>
   <!-- ── main orders card ──────────────────────────────────────────── -->
   <div class="card shadow-sm div-orders">
      <!-- ════ current orders ════════════════════════════════════════ -->
      <div class="card-body p-5 card-orders" id="div-table-orders">
         <!-- bulk-action toolbar -->
         <div class="d-flex mb-2">
            <div class="form-check form-check-custom form-check-sm form-check-solid">
               <input class="form-check-input h-15px w-15px cb-all" type="checkbox"
                  onchange="app_admin.on.change.cbSelectAll(this.checked)">
            </div>
            <div class="checkall ms-5" style="display:none;">
               <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm py-1 px-2"
                  data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
               <span data-lang="common::Actions">Tùy chọn</span>
               <i class="ki-duotone ki-down fs-5 ms-1"></i>
               </a>
               <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600
                  menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true">
                  <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                     <a href="javascript:;" class="menu-link px-3">
                     <span class="menu-title" data-lang="Change status">Chuyển trạng thái</span>
                     <span class="menu-arrow"></span>
                     </a>
                     <div class="menu-sub menu-sub-dropdown py-4 w-200px">
                        <div class="menu-item px-3"><a href="javascript:;" class="menu-link px-3" onclick="_orders.on.click.actionBulk('Change status','In progress')"    data-lang="status::In progress">Đang chạy</a></div>
                        <div class="menu-item px-3"><a href="javascript:;" class="menu-link px-3" onclick="_orders.on.click.actionBulk('Change status','Completed')"    data-lang="status::Completed">Hoàn thành</a></div>
                        <div class="menu-item px-3"><a href="javascript:;" class="menu-link px-3" onclick="_orders.on.click.actionBulk('Change status','Canceled')"    data-lang="status::Canceled">Hủy</a></div>
                     </div>
                  </div>
                  <div class="separator my-2"></div>
                  <div class="menu-item px-3"><a href="javascript:;" class="menu-link px-3" onclick="_orders.on.click.actionBulk('Provider - Update Status')" data-lang="Provider - Update Status">Cập nhật trạng thái</a></div>
                  <div class="menu-item px-3"><a href="javascript:;" class="menu-link px-3" onclick="_orders.on.click.actionBulk('Send order')" data-lang="Provider - Send Order">Gửi lại đơn hàng</a></div>
                  <div class="separator my-2"></div>
                  <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                     <a href="javascript:;" class="menu-link px-3">
                     <span class="menu-title" data-lang="Copy">Sao chép</span>
                     <span class="menu-arrow"></span>
                     </a>
                     <div class="menu-sub menu-sub-dropdown p-3 w-200px">
                        <div class="menu-item">
                           <a href="javascript:;" onclick="_orders.on.click.actionBulk('Copy Order ID','',false)"          class="menu-link px-3" data-lang="Copy Order ID">Mã đơn hàng</a>
                           <a href="javascript:;" onclick="_orders.on.click.actionBulk('Copy Link','',false)"              class="menu-link px-3">Link</a>
                           <a href="javascript:;" onclick="_orders.on.click.actionBulk('Copy Provider Order ID','',false)" class="menu-link px-3" data-lang="Provider Order ID">Mã đơn hàng NCC</a>
                        </div>
                     </div>
                  </div>
                  <div class="separator my-2"></div>
                  <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                     <a href="javascript:;" class="menu-link px-3">
                     <span class="menu-title" data-lang="Tag - Add">Thêm yêu cầu</span>
                     <span class="menu-arrow"></span>
                     </a>
                     <div class="menu-sub menu-sub-dropdown p-3 w-200px">
                        <div class="menu-item">
                           <a href="javascript:;" onclick="_orders.on.click.actionBulk('Tag - Add','Cancel')"  class="menu-link px-3" data-lang="Cancel">Yêu cầu hủy</a>
                           <a href="javascript:;" onclick="_orders.on.click.actionBulk('Tag - Add','Refill')"  class="menu-link px-3" data-lang="Refill">Yêu cầu bảo hành</a>
                           <a href="javascript:;" onclick="_orders.on.click.actionBulk('Tag - Add','Speedup')" class="menu-link px-3" data-lang="Speed up">Yêu cầu tăng tốc</a>
                        </div>
                     </div>
                  </div>
                  <div class="menu-item px-3"><a href="javascript:;" class="menu-link px-3" onclick="_orders.on.click.actionBulk('Tag - Add','')" data-lang="Tag - Clear">Xóa yêu cầu</a></div>
                  <div class="separator my-2"></div>
                  <div class="menu-item px-3"><a href="javascript:;" class="menu-link px-3" onclick="_orders.on.click.actionBulk('Total quantity','',false)" data-lang="Stats">Thống kê</a></div>
               </div>
               <label class="ms-3 fs-7"></label>
            </div>
         </div>
         <!-- /bulk toolbar -->
         <!-- DataTable — server-side, populated via AJAX Admin-Order-list -->
         <div class="table-responsive">
            <table class="table fs-7 gy-1 gx-2 gs-3 table-orders custom-table" id="table-orders" style="width:100%;">
               <thead class="fs-6 fw-bold">
                  <tr class="bg-lighten d-none">
                     <th></th>
                     {{-- col 0: checkbox --}}
                     <th class="pt-2 text-nowrap"></th>
                     {{-- col 1: order_status --}}
                     <th></th>
                     {{-- col 2: order_id --}}
                     <th class="text-nowrap"></th>
                     {{-- col 3: order_start (stats) --}}
                     <th></th>
                     {{-- col 4: order_link --}}
                     <th></th>
                     {{-- col 5: account_id (hidden) --}}
                     <th></th>
                     {{-- col 6: service_id (hidden) --}}
                     <th></th>
                     {{-- col 7: provider_oid (hidden) --}}
                     <th></th>
                     {{-- col 8: provider_id (hidden) --}}
                     <th></th>
                     {{-- col 9: order_tag (hidden) --}}
                     <th></th>
                     {{-- col 10: order_type (hidden) --}}
                     <th></th>
                     {{-- col 11: order_created (hidden) --}}
                  </tr>
               </thead>
               <tbody></tbody>
            </table>
         </div>
      </div>
      <!-- /div-table-orders -->
      <!-- ════ history (completed > 3 months) ════════════════════════ -->
      <div class="card-body p-5 card-orders-old" id="div-table-orders-old" style="display:none;">
         <div class="table-responsive">
            <table class="table fs-7 gy-1 gs-3 table-orders custom-table" id="table-orders-old" style="width:100%;">
               <thead class="fs-6 fw-bold">
                  <tr class="bg-lighten d-none">
                     <th></th>
                     {{-- col 0: checkbox/edit --}}
                     <th class="pt-2"></th>
                     {{-- col 1: order_status --}}
                     <th></th>
                     {{-- col 2: order_id --}}
                     <th></th>
                     {{-- col 3: order_start (stats) --}}
                     <th></th>
                     {{-- col 4: order_link --}}
                     <th></th>
                     {{-- col 5: account_id (hidden) --}}
                     <th></th>
                     {{-- col 6: service_id (hidden) --}}
                     <th></th>
                     {{-- col 7: provider_oid (hidden) --}}
                     <th></th>
                     {{-- col 8: provider_id (hidden) --}}
                     <th></th>
                     {{-- col 9: order_tag (hidden) --}}
                     <th></th>
                     {{-- col 10: order_type (hidden) --}}
                     <th></th>
                     {{-- col 11: order_created (hidden) --}}
                  </tr>
               </thead>
               <tbody></tbody>
            </table>
         </div>
      </div>
      <!-- /div-table-orders-old -->
   </div>
   <!-- /card div-orders -->
   <!-- ── ticket history modal ──────────────────────────────────────── -->
   <div class="modal fade" tabindex="-1" id="modal-history-ticket">
      <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" data-lang="/tickets::History request">Lịch sử yêu cầu</h4>
            </div>
            <div class="modal-body p-5">
               <div class="table-responsive">
                  <table class="table table-row-bordered fs-7">
                     <thead>
                        <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                           <th>#</th>
                           <th data-lang="/tickets::Request">Yêu cầu</th>
                           <th data-lang="/refill_services::Created">Created</th>
                           <th data-lang="/refill_services::Updated">Updated</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" tabindex="-1" id="modal-copy">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <div class="d-flex align-items-center">
                  <h4 class="modal-title"></h4>
                  <button type="button" class="btn btn-outline btn-outline-primary btn-sm ms-2" onclick="_orders.on.click.copy()">Copy</button>
               </div>
            </div>
            <div class="modal-body">
               <textarea class="form-control" rows="20"></textarea>
            </div>
         </div>
      </div>
   </div>
   {{-- Modal: More data (Custom Comments, Special, etc.) --}}
   <div class="modal fade" tabindex="-1" id="modal-comments">
      <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title"></h4>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-5"></div>
         </div>
      </div>
   </div>
</div>

@push('scripts')
<script>
   // Các biến này được _orders.init() trong assets/admin/admin.js đọc để
   // khởi tạo DataTable và áp dụng bộ lọc từ URL ngay trong lần tải đầu tiên.
   var STATUS_ORDER = @json($statusOrder ?? ''),
       ORDER_ID_SEARCH = @json($searchParams['order_id'] ?? ''),
       USER_SEARCH = @json((string) ($searchParams['user_id'] ?? '0')),
       ROLE = 1,
       ROLE_PERMISSONS = [],
       LABEL_FEATURES = true;

   $(document).ready(function () { _orders.init(); });
</script>

@endpush
@endsection
 
