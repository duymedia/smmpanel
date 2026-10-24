<div class="card mb-6">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed symbol-circle">
                    <img src="https://cdn.whoispanel.com/admin/media/avatars/300-1.jpg" alt="">
                </div>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <span class="fs-2 fw-bolder ls-2 me-2">{{ $accounts->username }}</span>
                            <span class="badge {{ $accounts->is_active ? 'badge-success' : 'badge-danger' }}" data-lang="{{ $accounts->is_active ? 'Active' : 'Suspended' }}">{{ $accounts->is_active ? 'Active' : 'Suspended' }}</span>
                        </div>
                        <div class="d-flex flex-wrap fs-7 pe-2 mb-2">
                            <span class="d-flex align-items-center text-gray-500 me-5"><i class="fa-solid fa-id-card fs-5 me-2"></i><span id="account-id">{{ $accounts->id }}</span></span>
                            <span class="d-flex align-items-center text-gray-500 fw-semibold me-5"><i class="fa-solid fa-user-secret fs-5 me-2"></i><span class="text-primary">{{ $accounts->role_label }}</span></span>
                        </div>
                        <div class="d-flex flex-wrap fs-7 pe-2 mb-2">
                            <span class="d-flex align-items-center text-gray-500 me-5"><i class="fa-solid fa-phone fs-5 me-2"></i>{{ $accounts->phone ?: '—' }}</span>
                            <span class="d-flex align-items-center text-gray-500 me-5"><i class="fa-solid fa-envelope fs-5 me-2"></i>{{ $accounts->email ?: '—' }}</span>
                            <span class="d-flex align-items-center text-gray-500 me-5"><i class="fa-solid fa-percent fs-5 me-2"></i>{{ formatCharge($accounts->percent_bonus ?? 0) }}%</span>
                        </div>
                        <div class="d-flex flex-wrap fs-7 mb-2 pe-2">
                            <span class="d-flex align-items-center text-gray-500 me-5"><span class="fst-italic" data-lang="Created">Created</span>: {{ optional($accounts->created_at)->format('Y-m-d H:i:s') ?? '—' }}</span>
                            <span class="d-flex align-items-center text-gray-500"><span class="fst-italic" data-lang="Last login">Last login</span>: {{ optional(data_get($lastLogin, 'created_at'))->format('Y-m-d H:i:s') ?? '—' }}</span>
                        </div>
                    </div>
                    @if ($showEditButton ?? false)
                        <div class="d-flex my-4">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_account" data-lang="Edit account">Edit account</button>
                        </div>
                    @endif
                </div>
                <div class="d-flex flex-wrap flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded py-3 px-4 me-6 mb-3">
                                <span class="fs-2 ls-2 fw-bold text-primary account-fund">$ {{ formatCharge($accounts->balance) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.accounts.partials.tabs', ['activeTab' => $activeTab])
    </div>
</div>
