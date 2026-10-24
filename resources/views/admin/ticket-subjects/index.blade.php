@extends('admin.layouts.app')
@section('title', 'Chủ đề hỗ trợ')

@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <button type="button" class="btn btn-primary btn-sm" onclick="_ticket_subjects.on.click.add()">Thêm mới</button>
        <a href="javascript:;" class="text-muted fst-italic" onclick="_ticket_subjects.on.click.collapseAll()">
            <span id="collapse-all-text">Thu gọn tất cả</span>
            <i class="bi bi-arrows-collapse fs-4 ms-2" id="collapse-all-icon"></i>
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-7 gy-2 gs-5 mb-0" id="table-subjects">
                    @forelse($subjects->groupBy('category') as $category => $items)
                        <tbody class="tbody-cat" data-category="{{ $category }}">
                            <tr class="bg-secondary tr-category-header">
                                <td colspan="6">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 fs-5 fw-bolder">
                                            <i class="bi bi-tag me-3 text-muted"></i>{{ $category }}
                                        </div>
                                        <a href="javascript:;" class="show-hide text-muted fs-8"
                                           data-collapsed="0" onclick="_ticket_subjects.on.click.collapse(this)">
                                            <span>Ẩn</span> ({{ $items->count() }})
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @foreach($items as $subject)
                                <tr id="row-{{ $subject->id }}" class="tr-subject {{ $subject->status ? '' : 'text-muted opacity-50' }}" data-id="{{ $subject->id }}">
                                    <td class="w-25px"><i class="fas fa-bars drag-handle text-muted"></i></td>
                                    <td class="w-25px"><a href="javascript:;" onclick="_ticket_subjects.on.click.edit({{ $subject->id }})"><i class="bi bi-pencil fs-8"></i></a></td>
                                    <td>
                                        <span class="fw-semibold text-gray-800">{{ $subject->subcategory ?: '—' }}</span>
                                        @if($subject->show_message_only)<span class="badge badge-light-primary ms-2">Chỉ tin nhắn</span>@endif
                                        @foreach(($subject->required_fields ?? []) as $field)
                                            <span class="badge badge-light-info ms-1">{{ $field['name'] ?? ($field['id'] ?? '') }}@if(!empty($field['required'])) <span class="text-danger">*</span>@endif</span>
                                        @endforeach
                                    </td>
                                    <td class="w-50px text-center text-muted"><span class="sort-order-display">{{ $subject->sort_order }}</span></td>
                                    <td class="w-50px text-end">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input h-20px w-30px" type="checkbox" @checked($subject->status)
                                                   onchange="_ticket_subjects.on.click.toggle({{ $subject->id }}, this)">
                                        </div>
                                    </td>
                                    <td class="w-25px"><a href="javascript:;" class="text-danger opacity-50" onclick="_ticket_subjects.on.click.remove({{ $subject->id }})"><i class="bi bi-trash fs-8"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    @empty
                        <tbody><tr><td colspan="6" class="text-center text-muted py-10">Chưa có chủ đề hỗ trợ</td></tr></tbody>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-subject" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-subject-label">Thêm chủ đề</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-5">
                    <label class="required form-label">Nhóm chủ đề</label>
                    <input type="text" id="ipt-category" class="form-control form-control-solid" list="cat-list">
                    <datalist id="cat-list">@foreach($categories as $category)<option value="{{ $category }}">@endforeach</datalist>
                </div>
                <div class="mb-5"><label class="form-label">Chủ đề</label><input type="text" id="ipt-subcategory" class="form-control form-control-solid"></div>
                <div class="row g-5 mb-5">
                    <div class="col-6"><label class="required form-label">Trạng thái</label><select id="ipt-status" class="form-select form-select-solid" data-kt-select2="true" data-hide-search="true" data-dropdown-parent="#modal-subject"><option value="1">Hoạt động</option><option value="0">Tạm ẩn</option></select></div>
                    <div class="col-6"><label class="form-label">Thứ tự</label><input type="number" id="ipt-sort" class="form-control form-control-solid" value="0" min="0"></div>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                    <input class="form-check-input h-20px w-30px" type="checkbox" id="ipt-message-only">
                    <label class="form-check-label ms-2" for="ipt-message-only">Chỉ hiển thị ô tin nhắn</label>
                </div>
                <div>
                    <label class="form-label">Trường bắt buộc <span class="text-muted fs-7">(JSON array)</span>
                        <a href="javascript:;" class="ms-2 fs-8" onclick="_ticket_subjects.on.click.example()">Ví dụ</a>
                    </label>
                    <textarea id="ipt-fields" class="form-control form-control-solid font-monospace" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary btn-sm btn-save-subject"><span class="btn-text">Thêm</span></button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', function () { _ticket_subjects.init(); });</script>
@endpush
