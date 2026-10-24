@extends('admin.layouts.app')
@section('title', 'Accounts')
@section('content')

<div class="content flex-row-fluid" id="kt_content">
        <span class="title d-none">List</span>

        <div class="row g-5 mb-5">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header pt-5">
                        <div class="card-title d-flex flex-column">
                            <div class="d-flex align-items-center">
                                <span class="fw-semibold text-gray-400 me-2"><i class="fa fa-user fs-1"
                                        aria-hidden="true"></i></span>
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-4"
                                    id="total_users">{{ $stats['total_accounts'] ?? 0 }}</span>

                            </div>
                            <span class="text-gray-400 pt-1 fw-semibold fs-6" data-lang="Total accounts">Tổng số lượng tài
                                khoản</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 d-flex flex-wrap">
                                <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                    <div class="d-flex fw-semibold align-items-center">
                                        <div class="bullet w-20px h-10px rounded-2 bg-primary me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4" data-lang="Retail">Khách lẻ</div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end ls-2" id="count_retail">
                                            {{ $stats['user_count'] ?? 0 }}</div>
                                    </div>

                                    <div class="d-flex fw-semibold align-items-center my-3">
                                        <div class="bullet w-20px h-10px rounded-2 bg-warning me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4" data-lang="Distributor">Nhà phân phối
                                        </div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end ls-2" id="count_distributor">
                                            {{ $stats['distributor_count'] ?? 0 }}
                                        </div>
                                    </div>

                                    <div class="d-flex fw-semibold align-items-center">
                                        <div class="bullet w-20px h-10px rounded-2 bg-warning me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4" data-lang="Agent">Đại lý</div>
                                        <div class=" fw-bolder text-gray-700 text-xxl-end ls-2" id="count_agent">
                                            {{ $stats['reseller_count'] ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex flex-wrap">
                                <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                    <div class="d-flex fw-semibold align-items-center">
                                        <div class="bullet w-20px h-10px rounded-2 bg-danger me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4" data-lang="Admin">Admin</div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end ls-2" id="count_admin">
                                            {{ $stats['admin_count'] ?? 0 }}</div>
                                    </div>

                                    <div class="d-flex fw-semibold align-items-center my-3">
                                        <div class="bullet w-8px h-3px rounded-2 bg-info me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4" data-lang="Active">Hoạt động</div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end ls-2" id="count_active">
                                            {{ $stats['staff_count'] ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-lg-100">
                    <div class="card-header pt-5">
                        <div class="card-title d-flex flex-column">
                            <div class="d-flex align-items-center">
                                <span class="fw-semibold text-gray-400 me-2"><i class="fa fa-dollar fs-1"
                                        aria-hidden="true"></i></span>
                                <span class="fs-2hx fw-bold me-2 lh-1 ls-4 total_balance"
                                    id="total_balance">{{ formatCharge($stats['total_balance'] ?? 0) }}</span>
                            </div>
                            <span class="text-gray-400 pt-1 fw-semibold fs-6" data-lang="Total current balance">Tổng số dư
                                hiện có</span>
                        </div>
                    </div>

                    <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
                        <div class="d-flex flex-column content-justify-center flex-row-fluid">
                            <div class="d-flex fw-semibold align-items-center">
                                <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                <div class="text-gray-500 flex-grow-1 me-4" data-lang="Deposit">Tiền nạp</div>
                                <div class="fw-bolder text-gray-700 text-xxl-end ls-2 total_deposit">
                                    {{ formatCharge($totalDeposit ?? 0) }}</div>
                            </div>

                            <div class="d-flex fw-semibold align-items-center my-3">
                                <div class="bullet w-8px h-3px rounded-2 bg-warning me-3"></div>
                                <div class="text-gray-500 flex-grow-1 me-4" data-lang="Bonus">Tiền thưởng</div>
                                <div class="fw-bolder text-gray-700 text-xxl-end ls-2 total_bonus">
                                    {{ formatCharge($totalBonus ?? 0) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-6">
            <div class="col-xl-12">
                <div class="card shadow-sm">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <select
                                class="form-select form-select-solid fw-bold w-300px w-xl-400px sl-account datatable-input select2-hidden-accessible"
                                data-col-name="account_id" data-kt-select2="true"
                                data-placeholder="Tìm tài khoản hoặc email" data-allow-clear="true" tabindex="-1"
                                aria-hidden="true">
                                <option></option>
                            </select>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-sm btn-light-primary me-3"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                    <span data-lang="Filter">Lọc</span>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown w-400px" data-kt-menu="true">
                                    <div class="px-7 py-5">
                                        <div class="fs-5 fw-bold" data-lang="Filter Options">Tùy chọn lọc</div>
                                    </div>
                                    <div class="separator border-gray-200"></div>
                                    <div class="px-7 py-5">
                                        <div class="mb-10">
                                            <label class="form-label fs-6 fw-semibold"><span data-lang="Role">Loại tài
                                                    khoản</span>:</label>
                                            <select
                                                class="form-select form-select-solid fw-bold sl-role datatable-input select2-hidden-accessible"
                                                data-col-name="account_role" data-kt-select2="true"
                                                data-placeholder="Select option" data-allow-clear="true"
                                                data-hide-search="true" tabindex="-1" aria-hidden="true">
                                                <option></option>
                                                <option value="0" data-lang="Retail">Khách lẻ</option>
                                                <option value="1" data-lang="Admin">Admin</option>
                                                <option value="6" data-lang="Staff">Nhân viên</option>
                                                <option value="4" data-lang="Agent">Đại lý</option>
                                                <option value="5" data-lang="Distributor">Nhà phân phối</option>
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="reset"
                                                class="btn btn-sm btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                                data-kt-menu-dismiss="true"
                                                onclick="_accounts.on.click.resetFilter()"
                                                data-lang="button::Reset">Thiết lập lại</button>
                                            <button type="submit" class="btn btn-sm btn-primary fw-semibold px-6"
                                                data-kt-menu-dismiss="true"
                                                onclick="_accounts.on.click.filter()"
                                                data-lang="button::Apply">Áp dụng</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_add_account">
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor">
                                            </rect>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                    <span data-lang="New">Thêm</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div id="table-orders_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer"
                            style="position: relative;">
                            <div id="table-orders_processing" class="dt-processing card" role="status"
                                style="display: none;"><span
                                    class="spinner-border w-15px h-15px text-muted align-middle me-2"></span>
                                <span class="text-gray-600">Loading...</span>
                                <div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-row-dashed fs-7 gy-2 gs-10"
                                    id="users_table" style="width: 100%;">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0" role="row">
                                            <th data-dt-column="0" class="ls-1 fw-bold dt-orderable-asc dt-orderable-desc"
                                                rowspan="1" colspan="1" aria-label="ID: Activate to sort"
                                                tabindex="0"><span class="dt-column-title"
                                                    role="button">ID</span><span class="dt-column-order"></span></th>
                                            <th data-lang="Username" data-dt-column="1"
                                                class="d-flex align-items-center dt-orderable-none" rowspan="1"
                                                colspan="1" aria-label="Tài khoản"><span class="dt-column-title">Tài
                                                    khoản</span><span class="dt-column-order"></span></th>
                                            <th data-lang="Role" data-dt-column="2" rowspan="1" colspan="1"
                                                class="dt-orderable-none" aria-label="Loại tài khoản"><span
                                                    class="dt-column-title">Loại tài khoản</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="4" rowspan="1" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc"
                                                aria-label="Thưởng (%): Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button"><span
                                                        data-lang="Percent bonus">Thưởng</span> (%)</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="5" class="text-nowrap dt-orderable-asc dt-orderable-desc"
                                                rowspan="1" colspan="1" aria-label="Số dư ($): Activate to sort"
                                                tabindex="0"><span class="dt-column-title" role="button"><span
                                                        data-lang="Balance">Số dư</span> ($)</span><span
                                                    class="dt-column-order"></span></th>
                                            <th class="text-end text-nowrap dt-orderable-none" data-dt-column="6"
                                                rowspan="1" colspan="1" aria-label=""><span
                                                    class="dt-column-title"></span><span class="dt-column-order"></span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700 fw-semibold"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Sao chép giá -->
        <div class="modal fade" tabindex="-1" id="modal-copy-rates" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" data-lang="Copy rates">Sao chép giá</h4>
                    </div>
                    <div class="modal-body">
                        <div class="mb-5">
                            <label class="required form-label" data-lang="From account">Từ tài khoản</label>
                            <select class="form-select form-select-solid ipt-from-account select2-hidden-accessible"
                                data-kt-select2="true" data-dropdown-parent="#modal-copy-rates"
                                data-placeholder="Lựa chọn tài khoản">
                                <option></option>
                            </select>
                        </div>
                        <div class="div-to-account">
                            <label class="form-label" data-lang="To account">Đến tài khoản</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal"
                            data-lang="button::Close">Đóng</button>
                        <button type="button" class="btn btn-sm btn-primary" data-lang="button::Apply"
                            onclick="copyRates()">Áp dụng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tạo tài khoản mới -->
        <div class="modal fade" id="kt_modal_add_account" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" data-lang="New account">Tạo tài khoản mới</h4>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                        transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                        transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <div class="mb-5">
                            <label class="required form-label" data-lang="Username">Tài khoản</label>
                            <input type="text" class="form-control ipt-username">
                        </div>
                        <div class="mb-5">
                            <label class="required form-label">Email</label>
                            <input type="email" class="form-control ipt-email">
                        </div>
                        <div class="mb-5">
                            <label class="required form-label" data-lang="Password">Mật khẩu</label>
                            <input type="password" class="form-control ipt-password">
                        </div>
                        <div class="mb-5">
                            <label class="required form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control ipt-password-confirm">
                        </div>
                        <div class="mb-5">
                            <label class="form-label" data-lang="Percent bonus">Thưởng (%)</label>
                            <input type="number" class="form-control ipt-percent" value="0" min="0"
                                max="100">
                            <span class="text-muted fst-italic fs-7" data-lang="Percent bonus - desc">Nếu bạn đặt phần
                                thưởng ĐẶC BIỆT cho tài khoản này, phần thưởng THANH TOÁN và phần thưởng THÀNH VIÊN sẽ không
                                được sử dụng</span>
                        </div>
                        <div class="mb-5">
                            <label class="required form-label" data-lang="Role">Loại tài khoản</label>
                            <select class="form-select form-select-solid sl-role" data-control="select2"
                                data-hide-search="true">
                                <option value="user" selected data-lang="User">Người dùng</option>
                                <option value="admin" data-lang="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-5 div-level">
                            <label class="form-label" data-lang="Level">Cấp độ</label>
                            <select class="form-select form-select-solid sl-level" data-control="select2"
                                data-hide-search="true">
                                <option value="retail" selected data-lang="Retail">Khách lẻ</option>
                                <option value="agent" data-lang="Agent">Đại lý</option>
                                <option value="distributor" data-lang="Distributor">Nhà phân phối</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="required form-label" data-lang="Status">Trạng thái</label>
                            <select class="form-select form-select-solid sl-status" data-control="select2"
                                data-hide-search="true">
                                <option value="1" selected data-lang="Active">Kích hoạt</option>
                                <option value="0" data-lang="Suspended">Vô hiệu hóa</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" onclick="addAccount()"
                            data-lang="button::Add">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
  </div>
        @push('scripts')
            <script>
                if (typeof _accounts !== 'undefined' && typeof _accounts.init === 'function') {
                    _accounts.init();
                }
            </script>
        @endpush

    @endsection
