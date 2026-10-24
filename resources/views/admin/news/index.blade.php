@extends('admin.layouts.app')
@section('title', 'News')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <div class="div-form mb-5" style="display:none">
        <div class="d-flex flex-wrap flex-stack mb-5"><h3 class="fw-bold my-2 div-title"></h3></div>
        <div class="card shadow-sm mb-5"><div class="card-body p-5">
            <div class="mb-5">
                <label class="required form-label" data-lang="Category">Danh mục</label>
                <select class="form-select form-select-solid sl-category" data-kt-select2="true" data-hide-search="true">
                    <option value="Notification" data-lang="Notification">Thông báo</option>
                    <option value="New service" data-lang="New service">Dịch vụ mới</option>
                    <option value="Change service" data-lang="Change service">Thay đổi dịch vụ</option>
                </select>
            </div>
            <div class="mb-5"><label class="required form-label" data-lang="Title">Tiêu đề</label><input type="text" class="form-control form-control-solid ipt-title"></div>
            <div><label class="form-label" data-lang="Content">Nội dung</label><div class="txa-content min-h-200px"></div></div>
        </div></div>
        <button type="button" class="btn btn-primary btn-new w-100" onclick="_news.on.click.submit(0)" data-lang="button::Add">Thêm</button>
        <button type="button" class="btn btn-primary btn-update w-100" style="display:none" data-lang="button::Update">Cập nhật</button>
    </div>

    <div class="d-flex flex-wrap flex-stack mb-5">
        <h3 class="fw-bold my-2" data-lang="menu::News">Danh sách thông báo</h3>
        <button type="button" class="btn btn-primary btn-sm" onclick="_news.on.click.showFormAdd()" data-lang="button::Add">Thêm thông báo</button>
    </div>
    <div class="card shadow-sm"><div class="card-body p-0"><div class="table-responsive">
        <table class="table align-middle table-row-dashed fs-7 gy-2 mb-0"><tbody>
        @forelse ($news as $item)
            @php($badge = ['Notification' => 'danger', 'New service' => 'success', 'Change service' => 'warning'][$item->category] ?? 'secondary')
            <tr>
                <td class="px-5 py-4"><span class="badge badge-{{ $badge }} me-2" data-lang="{{ $item->category }}">{{ $item->category }}</span><span class="fw-semibold text-gray-800">{{ $item->title }}</span></td>
                <td class="text-nowrap text-muted">{{ $item->created_at?->format('Y-m-d H:i:s') }}</td>
                <td class="text-end text-nowrap px-5">
                    <a href="javascript:;" class="btn btn-icon btn-light-primary btn-sm" onclick="_news.on.click.showFormEdit({{ $item->id }})"><i class="bi bi-pencil"></i></a>
                    <a href="javascript:;" class="btn btn-icon btn-light-danger btn-sm ms-1" onclick="_news.on.click.delete({{ $item->id }})"><i class="bi bi-trash3"></i></a>
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="text-center text-muted py-10">Chưa có thông báo</td></tr>
        @endforelse
        </tbody></table>
    </div>@if ($news->hasPages())<div class="p-4">{{ $news->links() }}</div>@endif</div></div>
</div>
@endsection
@push('scripts')
<script>$(function(){ _news.init(); });</script>
@endpush
