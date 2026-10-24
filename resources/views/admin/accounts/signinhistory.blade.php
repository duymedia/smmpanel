@extends('admin.layouts.app')
@section('title', 'Sign-in history')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
   
   @include('admin.accounts.partials.header', ['activeTab' => 'signinhistory', 'showEditButton' => true])
   <div class="d-flex flex-wrap flex-stack mb-6">
      <h3 class="fw-bold my-2" data-lang="">Lịch sử đăng nhập</h3>
   </div>
   <div class="row g-6">
      <div class="col-xl-12">
         <div class="card shadow-sm">
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table align-middle table-row-dashed fs-7 gy-2">
                     <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                           <th data-lang="Created">Ngày tạo</th>
                           <th>IP</th>
                           <th>User agent</th>
                        </tr>
                     </thead>
                     <tbody class="fs-7 fw-semibold text-gray-700">
                        @forelse ($loginHistory as $login)
                           <tr>
                              <td>{{ $login['created_at']->format('Y-m-d H:i:s') }}</td>
                              <td>{{ $login['ip_address'] }}</td>
                              <td class="wrap">{{ $login['user_agent'] }}</td>
                           </tr>
                        @empty
                           <tr>
                              <td colspan="3" class="text-center text-muted py-5" data-lang="No data available">No data available</td>
                           </tr>
                        @endforelse
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="kt_modal_edit_account" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered mw-450px">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="fw-bold" data-lang="">Tùy chỉnh tài khoản</h4>
               <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                  <span class="svg-icon svg-icon-1">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                     </svg>
                  </span>
               </div>
            </div>
            <div class="modal-body">
               <div class="d-flex flex-column scroll-y me-n7 pe-7">
                  <div class="mb-5">
                     <label class="required form-label" data-lang="">Tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-user" value="{{ $accounts->username }}">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label" data-lang="">Name</label>
                     <div class="input-group">
                        <input type="text" class="form-control form-control-solid ipt-name" value="" ;="">
                        <input type="text" class="form-control form-control-solid ipt-name-postfix" value="" ;="">
                     </div>
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Email</label>
                     <input type="email" class="form-control form-control-solid ipt-email" value="{{ $accounts->email }}">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label" data-lang="">Số điện thoại</label>
                     <input type="tel" class="form-control form-control-solid ipt-phone" value="{{ $accounts->phone }}">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label" data-lang="">Mật khẩu</label>
                     <input type="text" class="form-control form-control-solid ipt-password">
                     <span class="text-muted">Leave blank if you don't want to change password</span>
                  </div>
                  <div class="mb-5">
                     <label class="required form-label" data-lang="">Thưởng</label>
                     <input type="number" class="form-control form-control-solid ipt-percent" value="{{ $accounts->percent_bonus ?? 0 }}">
                     <span class="text-muted fst-italic" data-lang="Percent bonus - desc">Nếu bạn đặt phần thưởng ĐẶC BIỆT cho tài khoản này, phần thưởng THANH TOÁN và phần thưởng THÀNH VIÊN sẽ không được sử dụng</span>
                  </div>
                  <div class="mb-5">
                     <label class="required form-label" data-lang="">Loại tài khoản</label>
                     <select class="form-select form-select-solid datatable-input sl-role select2-hidden-accessible" data-kt-select2="true" data-hide-search="true" data-select2-id="select2-data-1-ei7e" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                        <option value="0" data-lang="">Khách lẻ</option>
                        <option value="1" data-lang="">Admin</option>
                        <option value="6" data-lang="">Nhân viên</option>
                        <option value="4" data-lang="">Đại lý</option>
                        <option value="5" selected="" data-lang="" data-select2-id="select2-data-3-wfoy">Nhà phân phối</option>
                     </select>
                     <span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-2-kmvx" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid datatable-input sl-role" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-hs2d-container" aria-controls="select2-hs2d-container"><span class="select2-selection__rendered" id="select2-hs2d-container" role="textbox" aria-readonly="true" title="Nhà phân phối">Nhà phân phối</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                  </div>
                  <div>
                     <label class="required form-label" data-lang="">Trạng thái</label>
                     <select class="form-select form-select-solid datatable-input sl-status select2-hidden-accessible" data-kt-select2="true" data-hide-search="true" data-select2-id="select2-data-4-p8nj" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                        <option value="0" selected="" data-lang="" data-select2-id="select2-data-6-wdk2">Kích hoạt</option>
                        <option value="1" data-lang="">Vô hiệu hóa</option>
                        <option value="2" data-lang="">Chưa xác thực</option>
                     </select>
                     <span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-5-rwhg" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid datatable-input sl-status" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-yj32-container" aria-controls="select2-yj32-container"><span class="select2-selection__rendered" id="select2-yj32-container" role="textbox" aria-readonly="true" title="Kích hoạt">Kích hoạt</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer border-0 flex-center">
               <button type="button" class="btn btn-primary" onclick="_accounts.on.click.updateAccount('{{ $accounts->id }}', document.querySelector('.ipt-user').value.trim(), document.querySelector('.ipt-name').value.trim(), document.querySelector('.ipt-name-postfix').value.trim(), document.querySelector('.ipt-email').value.trim(), document.querySelector('.ipt-phone').value.trim(), document.querySelector('.ipt-password').value.trim(), document.querySelector('.ipt-percent').value.trim(), document.querySelector('.sl-role').value.trim(), document.querySelector('.sl-status').value.trim())">Update</button>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')
<script>
$(function () {
    _accounts.init();
});
</script>
@endpush