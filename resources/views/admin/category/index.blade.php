@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="content flex-row-fluid" id="kt_content">
    <div class="d-flex">
        <button type="button" class="btn btn-primary btn-sm" onclick="_categories.on.click.showModalAddCategory()">
            <span data-lang="button::Add category">Thêm danh mục</span>
        </button>
        <button type="button" class="btn btn-primary btn-sm ms-3" onclick="_categories.on.click.showModalAddPlatform()">
            <span data-lang="button::Add platform">Thêm nền tảng</span>
        </button>
    </div>

    <div class="p-5 text-muted text-end"
        onclick="_categories.on.click.collapseAll(this.querySelector('i'), this.querySelector('i').className.includes('expand'))">
        <span class="fst-italic pointer" data-page="/categories" data-lang="Collapse all to modify platforms">Thu gọn tất cả để chỉnh sửa nền tảng</span>
        <i class="bi bi-arrows-collapse fs-4 ms-2"></i>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-7 gy-2 gs-5 mb-0" id="table-platform">
                    @forelse ($plat_cat as $platform)
                        @php
                            $platformIcon = $platform['image'] ?? '';
                            $platformName = $platform['name'] ?? '';
                        @endphp
                        <tbody class="tbody-{{ $platform['id'] }} sort-category" data-platform-id="{{ $platform['id'] }}">
                            <tr class="bg-secondary row-{{ $platform['id'] }} disabled tr-platform" data-platform-id="{{ $platform['id'] }}">
                                <td colspan="10" class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 fs-5 fw-bolder">
                                            <i class="fas fa-bars icon-sort-platform me-3" style="display:none"></i>
                                            @if ($platform['is_url'] ?? false)
                                                <img src="{{ $platformIcon }}" alt="" class="rounded w-20px h-20px me-2" loading="lazy" onerror="this.style.display='none'">
                                            @elseif ($platformIcon)
                                                <i class="{{ $platformIcon }} me-2"></i>
                                            @endif
                                            <span class="ls-1">{{ $platformName }}</span>
                                            <a href="javascript:;" class="a-update-platform" style="display:none"
                                                onclick="_categories.on.click.showModalUpdatePlatform({{ $platform['id'] }}, @js($platformName), @js($platformIcon))"
                                                aria-label="Edit">
                                                <i class="bi bi-pencil fs-8 ms-2"></i>
                                            </a>
                                        </div>
                                        @if ($platform['category_count'] > 0)
                                            <div data-status="Hide" class="text-end fs-8 show-hide pointer"
                                                style="border-bottom: 0.5px dashed"
                                                onclick="_categories.on.click.collapse(this, this.getAttribute('data-status'), {{ $platform['id'] }})">
                                                <span class="show-hide-text" data-page="common" data-lang="Hide">Ẩn</span>
                                                ({{ $platform['category_count'] }})
                                            </div>
                                        @else
                                            <div data-status="Hide" class="text-end fs-8 d-none show-hide pointer"
                                                style="border-bottom: 0.5px dashed"
                                                onclick="_categories.on.click.collapse(this, this.getAttribute('data-status'), {{ $platform['id'] }})">
                                                <span class="show-hide-text" data-page="common" data-lang="Hide">Ẩn</span>
                                                (0)
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @foreach ($platform['categories'] as $category)
                                @php
                                    $names = is_array($category->name)
                                        ? $category->name
                                        : (json_decode($category->name ?? '', true) ?: ['en' => $category->name]);
                                    $categoryName = $names['en'] ?? reset($names) ?: '';
                                    $translations = array_filter(
                                        $names,
                                        fn ($value, $code) => $code !== 'en' && $value !== '',
                                        ARRAY_FILTER_USE_BOTH
                                    );
                                    $categoryPayload = [
                                        'cat_id' => $category->id,
                                        'cat_name' => $categoryName,
                                        'cat_name_translated' => json_encode($translations, JSON_UNESCAPED_UNICODE),
                                        'cat_display' => (int) ($category->display ?? 0),
                                        'cat_status' => (int) $category->status,
                                        'platform_id' => (int) $platform['id'],
                                        'platform_name' => $platformName,
                                        'platform_icon' => $platformIcon,
                                    ];
                                @endphp
                                <tr class="{{ $category->status ? '' : 'text-muted' }} tr-category"
                                    data-id="{{ $category->id }}" data-status="{{ (int) $category->status }}">
                                    <td width="1"><i class="fas fa-bars" aria-hidden="true"></i></td>
                                    <td width="1">
                                        <a href="javascript:;"
                                            onclick="_categories.on.click.showModalUpdateCategory(@js(base64_encode(json_encode($categoryPayload))))"
                                            aria-label="Edit">
                                            <i class="bi bi-pencil fs-8"></i>
                                        </a>
                                    </td>
                                    <td class="name category-name">
                                        {{ trim($categoryName) }}
                                        @if ($translations)
                                            <i class="fa-solid fa-language ms-2"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="fa-solid {{ (int) ($category->display ?? 0) === 1 ? 'fa-table' : 'fa-list-ul' }}"
                                            data-bs-custom-class="tooltip-dark"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ (int) ($category->display ?? 0) === 1 ? 'Bảng' : 'Mặc định' }}"></i>
                                    </td>
                                    <td class="text-end" width="1">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input h-20px w-30px" type="checkbox"
                                                value="{{ $category->id }}" @checked($category->status)
                                                aria-label="Active"
                                                onchange="_categories.on.change.statusCategory(this.value, this.checked)">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @empty
                        <tbody>
                            <tr>
                                <td class="py-10 text-center text-muted" data-lang="No categories">Chưa có danh mục</td>
                            </tr>
                        </tbody>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-category" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modal-category-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-category-label" data-lang="button::Add category">Thêm danh mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <label class="required form-label" data-page="/categories" data-lang="Social Media Platform">Nền tảng</label>
                        <select class="form-control form-control-solid sl-platform" name="platform_id" data-dropdown-parent="#modal-category">
                            @foreach ($platforms as $platform)
                                <option value="{{ $platform->id }}" data-icon="{{ $platform->image }}">{{ $platform->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="required form-label" data-page="/categories" data-lang="Name">Tên</label>
                        <input type="text" class="form-control form-control-solid ipt-name" autocomplete="off">
                    </div>
                    <div id="div-translated-name"></div>
                    @if ($languages->isNotEmpty())
                        <div class="dropdown">
                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-page="/services" data-lang="Add translated name">Thêm tên ngôn ngữ khác</button>
                            <div class="dropdown-menu dropdown-menu-end">
                                @foreach ($languages as $language)
                                    @php
                                        $flagCode = $language->code === 'vi' ? 'vn' : $language->code;
                                    @endphp
                                    <button type="button" class="dropdown-item ai-icon" onclick="_categories.on.click.addTranslatedName(@js($flagCode))">
                                        <span class="rounded-1 fi fi-{{ $flagCode }} fs-5 me-2"></span>
                                        {{ $language->name ?? strtoupper($language->code) }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="my-5 separator separator-dashed"></div>
                    <div class="d-flex mt-5 flex-wrap gap-5">
                        <span class="me-5 fs-6" data-page="/categories" data-lang="Display services as">Hiển thị dịch vụ dạng</span>
                        <div class="form-check form-check-custom form-check-solid me-5">
                            <input class="form-check-input h-20px w-20px" type="radio" value="0" name="display" checked>
                            <label class="form-check-label">
                                <span data-page="/categories" data-lang="Default">Mặc định</span> <i class="fa-solid fa-list-ul"></i>
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input h-20px w-20px" type="radio" value="1" name="display">
                            <label class="form-check-label">
                                <span data-page="/categories" data-lang="Table">Bảng</span> <i class="fa-solid fa-table"></i>
                            </label>
                        </div>
                    </div>
                    <div class="my-5 separator separator-dashed"></div>
                    <label class="form-check form-switch form-check-custom mt-5">
                        <input class="form-check-input h-20px w-30px cb-status" type="checkbox" name="status" value="1" checked>
                        <span class="form-check-label ms-2" data-page="/categories" data-lang="Active">Kích hoạt</span>
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" data-lang="button::Close">Đóng</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="_categories.on.click.addCategory()" data-lang="button::Add">Thêm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal-platform" data-bs-backdrop="static" aria-labelledby="modal-platform-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-platform-label" data-lang="button::Add platform">Thêm nền tảng</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <label class="required form-label" data-page="/categories" data-lang="Name">Tên</label>
                        <input type="text" class="form-control form-control-solid ipt-platform-name" autocomplete="off">
                    </div>
                    <div class="mb-5">
                        <label class="required form-label" data-page="/categories" data-lang="Icon">Biểu tượng</label>
                        <div class="input-group input-group-solid">
                            <input type="text" class="form-control ipt-platform-icon"
                                oninput="_categories.on.keyup.icon(this.value)"
                                placeholder="fa-brands fa-youtube || image link">
                            <span class="input-group-text platform-icon"></span>
                        </div>
                        <div class="form-text" data-page="/categories" data-lang="Example icon">Ví dụ: fa-brands fa-facebook hoặc URL hình ảnh</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" data-lang="button::Close">Đóng</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="_categories.on.click.addPlatform(document.querySelector('.ipt-platform-name').value.trim(), document.querySelector('.ipt-platform-icon').value.trim())" data-lang="button::Add">Thêm</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () { _categories.init(); });
</script>
@endpush
