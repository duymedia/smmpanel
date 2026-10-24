@extends('admin.layouts.app')
@section('title', 'Sync Logs')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
   <style>
      .sync-toolbar {
      background: linear-gradient(135deg, rgba(30, 32, 37, 0.04), rgba(54, 153, 255, 0.06));
      border: 1px solid rgba(82, 100, 132, 0.14);
      }
      .sync-provider-overview .sync-provider-card {
      border: 1px solid rgba(82, 100, 132, 0.14);
      border-radius: 1rem;
      box-shadow: 0 10px 30px rgba(20, 20, 43, 0.05);
      }
      .sync-provider-overview .sync-provider-card.is-unread {
      background: linear-gradient(180deg, rgba(255, 248, 229, 0.95), rgba(255, 255, 255, 1));
      border-color: rgba(255, 199, 0, 0.25);
      }
      .sync-provider-overview .sync-provider-card.is-read {
      background: linear-gradient(180deg, rgba(248, 250, 252, 1), rgba(255, 255, 255, 1));
      }
      .sync-provider-metric {
      min-width: 88px;
      padding: .75rem .875rem;
      border-radius: .875rem;
      background: rgba(255, 255, 255, 0.72);
      }
      .sync-group-row {
      background: linear-gradient(90deg, rgba(54, 153, 255, 0.10), rgba(54, 153, 255, 0.02));
      }
      .sync-log-cell {
      min-width: 340px;
      }
      .sync-change-list {
      display: grid;
      gap: .5rem;
      }
      .sync-change-item {
      display: flex;
      gap: .75rem;
      align-items: flex-start;
      padding: .75rem .875rem;
      border-radius: .875rem;
      background: #f8fafc;
      border: 1px solid rgba(82, 100, 132, 0.08);
      }
      .sync-change-item .sync-change-icon {
      width: 2rem;
      height: 2rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 999px;
      flex: 0 0 2rem;
      font-size: .85rem;
      }
      .sync-change-item .sync-change-title {
      font-weight: 600;
      color: #1f2937;
      line-height: 1.3;
      }
      .sync-change-item .sync-change-note {
      color: #6b7280;
      font-size: .8rem;
      line-height: 1.35;
      }
      .sync-change-item.change-danger .sync-change-icon {
      background: rgba(241, 65, 108, 0.12);
      color: #f1416c;
      }
      .sync-change-item.change-success .sync-change-icon {
      background: rgba(80, 205, 137, 0.14);
      color: #50cd89;
      }
      .sync-change-item.change-info .sync-change-icon {
      background: rgba(54, 153, 255, 0.14);
      color: #3699ff;
      }
      .sync-change-item.change-warning .sync-change-icon {
      background: rgba(255, 199, 0, 0.16);
      color: #c18a00;
      }
      .sync-change-item.change-dark .sync-change-icon {
      background: rgba(24, 28, 50, 0.12);
      color: #181c32;
      }
      .sync-empty-state {
      padding: 2.5rem 1rem;
      border: 1px dashed rgba(82, 100, 132, 0.22);
      border-radius: 1rem;
      background: rgba(248, 250, 252, 0.72);
      }
   </style>
   <div class="card shadow mb-5 sync-toolbar">
      <div class="card-body p-5">
         <div class="d-flex flex-wrap justify-content-between align-items-start gap-4 mb-6">
            <div>
               <div class="fs-3 fw-bold text-gray-900 mb-2">Service Sync Monitor</div>
               <div class="text-muted fs-7 mw-500px">Track changes by provider first, then drill down into each affected service with a cleaner visual summary.</div>
            </div>
            <div class="d-flex flex-wrap gap-2 sync-top-stats"><div class="sync-provider-metric"><span class="spinner-border spinner-border-sm text-primary"></span></div></div>
         </div>
         <div class="mb-4 d-flex align-items-center flex-wrap gap-2">
            <span class="fw-semibold text-muted me-2 fs-8 text-uppercase">Status</span>
            <a href="javascript:;" class="btn btn-sm btn-outline px-3 py-1 me-1 active ipt-unread-filter" data-val="" data-lang="All">All</a>
            <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-warning px-3 py-1 ipt-unread-filter" data-val="0" data-lang="Unread">Chưa đọc</a>
         </div>
         <div class="mb-5 d-flex align-items-center flex-wrap gap-2">
            <span class="fw-semibold text-muted me-2 fs-8 text-uppercase">Event</span>
            <a href="javascript:;" class="btn btn-sm btn-outline px-3 py-1 me-1 active ipt-event-filter" data-val="">All</a>
            <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-danger px-3 py-1 me-1 ipt-event-filter" data-val="price_up">↑ Price</a>
            <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-success px-3 py-1 me-1 ipt-event-filter" data-val="price_down">↓ Price</a>
            <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-info px-3 py-1 me-1 ipt-event-filter" data-val="minmax">Min/Max</a>
            <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-primary px-3 py-1 me-1 ipt-event-filter" data-val="refill">Refill</a>
            <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-warning px-3 py-1 me-1 ipt-event-filter" data-val="cancel">Cancel</a>
            <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-danger px-3 py-1 me-1 ipt-event-filter" data-val="disabled">Disabled</a>
            <a href="javascript:;" class="btn btn-sm btn-outline btn-outline-primary px-3 py-1 ipt-event-filter" data-val="new">New</a>
         </div>
         <div class="row g-3">
            <div class="col-lg-3 col-md-5 col-12">
               <select class="form-select form-select-solid form-select-sm ipt-provider" data-control="select2" data-placeholder="Tất cả nhà cung cấp">
                  <option value="">Tất cả nhà cung cấp</option>
                  @foreach($providers as $id => $name)
                     <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-lg-2 col-md-3 col-6">
               <input type="number" class="form-control form-control-solid form-control-sm ipt-service-id" placeholder="Service ID" onkeypress="if(event.key=='Enter') _service_sync_logs.on.click.filter()">
            </div>
            <div class="col-auto">
               <a href="javascript:;" class="btn btn-sm btn-primary me-2" onclick="_service_sync_logs.on.click.filter()" data-lang="button::Search">Tìm kiếm</a>
               <a href="javascript:;" class="btn btn-sm btn-secondary me-2" onclick="_service_sync_logs.on.click.resetFilter()" data-lang="button::Reset">Thiết lập lại</a>
               <a href="javascript:;" class="btn btn-sm btn-light-warning" onclick="_service_sync_logs.on.click.markReadSync(1, 1)"><span data-lang="Mark all as read">Đánh dấu đã đọc tất cả</span></a>
            </div>
         </div>
      </div>
   </div>
   <div class="card shadow-sm">
      <div class="card-body p-5">
         <div class="sync-provider-overview row g-3 mb-6"></div>
         <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-7 gy-1 gs-3">
               <!-- <thead>
                  <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                      <th class="w-20px"></th>
                      <th data-lang="Service">Service</th>
                      <th data-lang="Events">Events</th>
                      <th>Changes</th>
                      <th data-lang="Date">Date</th>
                  </tr>
                  </thead> -->
               <tbody class="tbody-sync-logs"></tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script>
   $(function () {
      _service_sync_logs.init();
   });
</script>
@endpush
