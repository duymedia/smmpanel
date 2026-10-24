@extends('admin.layouts.app')

@section('title', 'Providers')

@section('content')
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
  <div class="content flex-row-fluid" id="kt_content">
    <span class="title d-none">Providers</span>

    <div class="mb-6 row">
      <div class="col-lg-12">
        <button class="btn btn-primary btn-sm me-3" onclick="_providers.on.click.showModalProvider()">
          <span>Thêm nhà cung cấp</span>
        </button>
        <button class="btn btn-primary btn-sm" onclick="_providers.on.click.checkAllBalance()">
          <span>Kiểm tra số dư</span>
        </button>
      </div>
    </div>

    <div class="shadow-sm card">
      <div class="card-body">
        <p class="fst-italic">
          * Nếu bạn muốn sử dụng tính năng cảnh báo số dư, bạn cần phải kích hoạt tiện ích Telegram
          <a target="_blank" href="/admin/settings/modules">tại đây</a>
        </p>

        <div class="table-responsive">
          <table class="table mb-0 align-middle table-row-dashed fs-7 gy-2 table-providers">
            <thead>
              <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th></th>
                <th>Nhà cung cấp</th>
                <th>Số dư</th>
                <th>Tiền tệ</th>
                <th>Cảnh báo</th>
                <th></th>
              </tr>
            </thead>
            <tbody class="provider-sortable">
              @forelse ($providers as $provider)
                <tr class="row-{{ $provider->id }} {{ $provider->status ? '' : 'text-muted' }}" data-id="{{ $provider->id }}">
                  <td width="1"><i class="fas fa-bars"></i></td>
                  <td>{{ $provider->name }}</td>
                  <td>
                    <span class="fw-bold text-uppercase balance-{{ $provider->id }}">
                      {{ (float) $provider->balance }}
                    </span>
                  </td>
                  <td>
                    {{ $provider->currency ?: 'USD' }}
                    <i
                      class="fa fa-exclamation-circle ms-2"
                      data-bs-toggle="tooltip"
                      data-bs-placement="top"
                      title="Tỉ giá: {{ $provider->rate_api ?: 1 }}, Làm tròn: {{ $provider->fixed_decimal ?: 10 }}"
                    ></i>
                  </td>
                  <td>{{ (float) $provider->warning > 0 ? (float) $provider->warning : '' }}</td>
                  <td class="text-end">
                    <button
                      type="button"
                      class="px-3 py-1 btn btn-secondary btn-sm rotate"
                      data-kt-menu-trigger="click"
                      data-kt-menu-placement="bottom-start"
                      data-kt-menu-offset="0,5"
                    >
                      <span>Tùy chọn</span>
                      <span class="rotate-180 svg-icon svg-icon-3 ms-3 me-0">
                        <i class="fa-solid fa-chevron-down"></i>
                      </span>
                    </button>
                    <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px" data-kt-menu="true">
                      <div class="px-3 menu-item">
                        <a href="javascript:;" class="px-3 menu-link" onclick="_providers.on.click.showModalProvider('Edit provider', {{ $provider->id }})">Tùy chỉnh</a>
                      </div>
                      <div class="px-3 menu-item">
                        <a href="javascript:;" class="px-3 menu-link" onclick="_providers.on.click.checkBalance({{ $provider->id }})">Kiểm tra số dư</a>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="py-10 text-center text-muted">Chưa có nhà cung cấp</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal-provider" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Thêm nhà cung cấp</h4>
          </div>
          <div class="modal-body div-provider">
            <div class="mb-5">
              <label class="required form-label">API URL</label>
              <input type="text" class="form-control form-control-solid ipt-url">
            </div>
            <div class="mb-5">
              <label class="required form-label">Key</label>
              <input type="text" class="form-control form-control-solid ipt-key">
            </div>
            <div class="mb-5">
              <label class="required form-label">Rate</label>
              <input type="text" class="form-control form-control-solid ipt-rate" value="1">
              <span class="form-text text-muted">Tỷ giá 1 USD với nhà cung cấp. Ví dụ nếu đơn vị tiền tệ của nhà cung cấp là VND, đặt tỷ giá là 25000.</span>
            </div>
            <div class="mb-5">
              <label class="required form-label">Làm tròn</label>
              <select class="form-select form-select-solid sl-fixed-decimal" data-control="select2" data-hide-search="true">
                @for ($i = 0; $i <= 10; $i++)
                  <option value="{{ $i }}" @selected($i === 10)>{{ $i }}</option>
                @endfor
              </select>
              <span class="form-text text-muted">Làm tròn sau chữ số thập phân.</span>
            </div>
            <div class="mb-5">
              <label class="form-label">Số dư cảnh báo</label>
              <input type="number" class="form-control form-control-solid ipt-balance-alert" value="0">
              <span class="form-text text-muted">Nhập 0 nếu muốn vô hiệu hóa</span>
            </div>
            <div>
              <label class="form-label">Tên dễ nhớ</label>
              <input type="text" class="form-control form-control-solid ipt-name">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Đóng</button>
            <button type="button" class="btn btn-primary btn-sm">Add</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  typeof _providers !== 'undefined' && typeof _providers.init !== 'undefined' && _providers.init();
</script>
@endpush
