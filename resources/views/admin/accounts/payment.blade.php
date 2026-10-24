@extends('admin.layouts.app')
@section('title', 'Payment')
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <span class="title d-none">View account - Payment</span>

        @include('admin.accounts.partials.header', ['activeTab' => 'payment', 'showEditButton' => true])
        <div class="d-flex flex-wrap flex-stack mb-6">
            <h3 class="fw-bold my-2" data-lang="Payment">Payment</h3>
        </div>
        <div class="row g-6">
            <div class="col-md-6 col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-5">
                            <label class="form-label" data-page="/payments" data-lang="Payment methods">Payment
                                methods</label>
                            <select class="form-select form-select-solid datatable-input sl-payment-method"
                                data-control="select2" data-hide-search="true"
                                onchange="_accounts.on.change.paymentmethod()">
                                <option value="0" data-lang="Choose">Choose</option>
                                @foreach ($paymentOptions as $option)
                                    <option value="{{ $option['value'] }}" data-currency="{{ $option['currency'] }}"
                                        data-rate="{{ $option['rate'] }}">{{ $option['name'] }}</option>
                                @endforeach
                                <option value="1" data-icon="https://cdn-icons-png.flaticon.com/512/5622/5622939.png"
                                    data-lang="Bonus">Bonus</option>
                            </select>
                        </div>
                        <fieldset class="div-currency border border-1 border-info rounded p-5 pt-0 mb-5"
                            style="display:none">
                            <legend class="float-none w-auto mb-0"><span class="form-label text-info" data-page="/payments"
                                    data-lang="Currency">Currency</span></legend>
                            <div class="input-group input-group-solid">
                                <input type="number" min="0"
                                    class="form-control form-control-solid ipt-currency-value"
                                    onkeyup="_accounts.on.keyup.convertCurrency()">
                                <input type="number" min="0"
                                    class="form-control bg-secondary form-control-solid ipt-currency-rate"
                                    value="{{ $vndExchangeRate }}" onkeyup="_accounts.on.keyup.convertCurrency()">
                                <span class="input-group-text bg-secondary currency-symbol">USD</span>
                            </div>
                        </fieldset>
                        <div class="mb-5"><label class="form-label" data-lang="Amount">Amount</label>
                            <div class="input-group input-group-solid"><input type="number" min="0.00000001"
                                    step="0.00000001" class="form-control form-control-solid ipt-fund-amount"><span
                                    class="input-group-text bg-secondary">USD</span></div>
                        </div>
                        <div class="mb-5"><label class="form-label" data-lang="Details">Details</label>
                            <textarea rows="5" class="form-control form-control-solid txa-fund-details"></textarea>
                        </div>
                        <div class="mb-5"><button type="button" class="btn btn-primary w-100"
                                onclick="_accounts.on.click.addFunds({{ $accounts->id }}, document.querySelector('.sl-payment-method').value, document.querySelector('.ipt-fund-amount').value, document.querySelector('.txa-fund-details').value)"
                                data-lang="New">New</button></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row g-6">
                    <div class="col-md-6 col-6">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h2 class="info-fund-deposit text-primary">{{ formatCharge($totalDeposit) }}</h2><span
                                    class="text-gray-700" data-lang="Total deposit">Total deposit</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-6">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h2 class="info-fund-bonus text-warning">{{ formatCharge($totalBonus) }}</h2><span
                                    class="text-gray-700" data-lang="Total bonus">Total bonus</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-6">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h2 class="info-fund-spent text-danger">{{ formatCharge($totalSpent) }}</h2><span
                                    class="text-gray-700" data-lang="Total spent">Total spent</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-6">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h2 class="info-fund-can-refund">{{ formatCharge($canRefund) }}</h2><span
                                    class="text-gray-700" data-lang="Can refund">Can refund</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap flex-stack my-6">
            <h3 class="fw-bold my-2" data-lang="History">History</h3>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="mb-5"><input class="form-control ipt-date" placeholder="Date" data-lang="Date"></div>
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-7 gy-2 table-payment-history">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="d-none">Account</th>
                                <th class="d-none">ID</th>
                                <th data-lang="Created">Created</th>
                                <th data-lang="Amount">Amount</th>
                                <th data-lang="Method">Method</th>
                                <th data-lang="Details">Details</th>
                            </tr>
                        </thead>
                        <tbody class="fs-7 fw-semibold text-gray-700"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_edit_account" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-450px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="fw-bold mb-0" data-lang="Edit account">Edit account</h4>
                    <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-solid fa-xmark fs-2"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column">
                        <div class="mb-5">
                            <label class="required form-label" data-lang="Username">Username</label>
                            <input type="text" class="form-control form-control-solid ipt-user"
                                value="{{ $accounts->username }}" placeholder="Username" data-lang="Username">
                        </div>
                        <div class="mb-5">
                            <label class="form-label" data-page="/payments" data-lang="Name">Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-solid ipt-name"
                                    value="{{ $accounts->name ?? '' }}" placeholder="Name">
                                <input type="text" class="form-control form-control-solid ipt-name-postfix"
                                    value="" placeholder="Name">
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="required form-label">Email</label>
                            <input type="email" class="form-control form-control-solid ipt-email"
                                value="{{ $accounts->email ?? '' }}" placeholder="Email">
                        </div>
                        <div class="mb-5">
                            <label class="form-label" data-lang="Phone">Phone</label>
                            <input type="tel" class="form-control form-control-solid ipt-phone"
                                value="{{ $accounts->phone ?? '' }}" placeholder="Phone" data-lang="Phone">
                        </div>
                        <div class="mb-5">
                            <label class="form-label" data-lang="Password">Password</label>
                            <input type="password" class="form-control form-control-solid ipt-password"
                                autocomplete="new-password" placeholder="Password" data-lang="Password">
                        </div>
                        <div class="mb-5">
                            <label class="form-label" data-lang="Percent bonus">Percent Bonus (%)</label>
                            <input type="number" min="0" max="100" step="1"
                                class="form-control form-control-solid ipt-percent"
                                value="{{ $accounts->percent_bonus ?? '' }}" placeholder="Percent Bonus (%)"
                                data-lang="Percent bonus">
                        </div>
                        <div class="mb-5">
                            <label class="required form-label" data-lang="Role">Role</label>
                            <select class="form-select form-select-solid datatable-input sl-role" data-control="select2"
                                data-hide-search="true">
                                @foreach (\App\Models\User::ROLE_LABELS as $role => $label)
                                    <option value="{{ $role }}" @selected($accounts->role === $role)>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="required form-label" data-lang="Status">Status</label>
                            <select class="form-select form-select-solid datatable-input sl-status" data-control="select2"
                                data-hide-search="true">
                                <option value="0" @selected($accounts->is_active) data-lang="Active">Active</option>
                                <option value="1" @selected(!$accounts->is_active) data-lang="Suspended">Suspended
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 flex-center">
                    <button type="button" class="btn btn-primary"
                        onclick="_accounts.on.click.updateAccount({{ $accounts->id }}, document.querySelector('.ipt-user').value.trim(), document.querySelector('.ipt-name').value.trim(), document.querySelector('.ipt-name-postfix').value.trim(), document.querySelector('.ipt-email').value.trim(), document.querySelector('.ipt-phone').value.trim(), document.querySelector('.ipt-password').value.trim(), document.querySelector('.ipt-percent').value.trim(), document.querySelector('.sl-role').value.trim(), document.querySelector('.sl-status').value.trim())"
                        data-lang="button::Edit">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            _accounts.init();
        });
    </script>
@endpush
