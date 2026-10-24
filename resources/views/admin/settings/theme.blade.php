@extends('admin.layouts.app')
@section('title', 'Settings')
@section('content')
    <div class="content flex-row-fluid theme-settings" id="kt_content">

        @include('admin.settings.partials.header')

        @php
            $currentLanding = (string) ($config->default_landingpage ?? 'default');
            $landingPageEnabled = !in_array($currentLanding, ['-1', '-2'], true);
        @endphp

        <div class="d-flex flex-wrap flex-stack my-6">
            <h3 class="fw-bold my-2" data-lang="Landing theme">Giao diện trang chủ</h3>
            <div class="d-flex flex-wrap my-2">
                <label class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox"
                        onchange="_settings.on.change.enableLandingPage(this.checked);"
                        {{ $landingPageEnabled ? 'checked' : '' }}>
                    <span class="form-check-label" data-lang="Show">Hiển thị</span>
                </label>
            </div>
        </div>
        <div class="row g-6">
            <div class="col-xl-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex div-set-landing-as {{ $landingPageEnabled ? 'd-none' : '' }}">
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="radio" name="landingpage" value="-1"
                                    onchange="_settings.on.change.setLandingAsServicePage(this.value);"
                                    {{ $currentLanding === '-1' ? 'checked' : '' }}>
                                <span class="form-check-label" data-lang="Redirect to services page">Chuyển đến trang dịch vụ</span>
                            </label>
                            <label class="form-check form-switch form-check-custom form-check-solid ms-10">
                                <input class="form-check-input" type="radio" name="landingpage" value="-2"
                                    onchange="_settings.on.change.setLandingAsServicePage(this.value);"
                                    {{ $currentLanding === '-2' ? 'checked' : '' }}>
                                <span class="form-check-label" data-lang="Redirect to products page">Chuyển đến trang sản phẩm</span>
                            </label>
                        </div>
                        <div class="row g-6 div-list-landing-page {{ $landingPageEnabled ? '' : 'd-none' }}">
                            @php
                                $landingImages = collect(
                                    glob(public_path('images/landing/*.{jpg,jpeg,png,gif,webp}'), GLOB_BRACE),
                                )
                                    ->map(function ($path) {
                                        $filename = pathinfo($path, PATHINFO_FILENAME);
                                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                                        // Extract number from filename like "page-1" => "1", "default" => "default"
                                        if (preg_match('/page-(\d+)/', $filename, $m)) {
                                            return ['id' => $m[1], 'label' => $m[1], 'file' => basename($path)];
                                        } elseif ($filename === 'default') {
                                            return ['id' => 'default', 'label' => 'Default', 'file' => basename($path)];
                                        }
                                        return [
                                            'id' => $filename,
                                            'label' => ucfirst($filename),
                                            'file' => basename($path),
                                        ];
                                    })
                                    ->sortBy(function ($item) {
                                        return $item['id'] === 'default' ? 999 : (int) $item['id'];
                                    })
                                    ->values();
                            @endphp
                            @foreach ($landingImages as $landing)
                                @php
                                    $isActive =
                                        $currentLanding == $landing['id'] ||
                                        $currentLanding == 'lang-' . $landing['id'];
                                @endphp
                                <div class="col-xl-2 col-lg-3 col-sm-4 text-center">
                                    <div class="card overlay overflow-hidden {{ $isActive ? 'theme-active' : '' }}"
                                        data-theme="{{ $landing['id'] }}">
                                        <div class="card-body p-0">
                                            <div class="overlay-wrapper">
                                                <img src="{{ asset('images/landing/' . $landing['file']) }}"
                                                    class="w-100 rounded" alt="">
                                            </div>
                                            <div class="overlay-layer bg-dark bg-opacity-75">
                                                <button type="button"
                                                    class="btn btn-primary btn-sm btn-shadow {{ $isActive ? 'd-none' : '' }}"
                                                    onclick="_settings.on.click.updateDesign('{{ $landing['id'] }}', 'landing')"
                                                    data-lang="button::Apply">Áp
                                                    dụng</button>
                                                <button type="button"
                                                    class="btn btn-info btn-sm btn-shadow ms-2 {{ $isActive ? '' : 'd-none' }}"
                                                    onclick="window.location.href='{{ route('admin.settings.landing.editor', ['theme' => $landing['id']]) }}'"
                                                    data-lang="button::Modify">Tùy
                                                    chỉnh</button>
                                            </div>
                                        </div>
                                    </div>
                                    <h4
                                        class="mt-3 badge {{ $landing['id'] !== 'default' ? 'badge-circle' : '' }} badge-primary {{ $isActive ? '' : 'badge-outline' }}">
                                        {{ $landing['label'] }}</h4>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal bg-dark fade" tabindex="-1" id="modal-modify-landing-page">
                            <div class="modal-dialog modal-fullscreen">
                                <div class="modal-content shadow-none">
                                    <div class="modal-body p-0 text-center">
                                        <iframe id="ifr-theme"></iframe>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                                            data-lang="button::Cancel">Hủy</button>
                                        <button type="button" class="btn btn-info btn-default"
                                            data-lang="button::Default"
                                            onclick="_settings.on.click.defaultLanding(document.getElementById('modal-modify-landing-page').dataset.theme)">Mặc định</button>
                                        <button type="button" class="btn btn-primary btn-save" data-lang="button::Save">Lưu
                                            thay đổi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap flex-stack my-6">
            <h3 class="fw-bold my-2" data-lang="Sign-in theme">Giao diện đăng nhập</h3>
        </div>
        <div class="row g-6">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row g-6 div-list-login-page">
                            @php
                                $loginImages = collect(
                                    glob(public_path('images/login/*.{jpg,jpeg,png,gif,webp}'), GLOB_BRACE),
                                )
                                    ->map(function ($path) {
                                        $filename = pathinfo($path, PATHINFO_FILENAME);
                                        if ($filename === 'default') {
                                            return ['id' => 'default', 'label' => 'Default', 'file' => basename($path)];
                                        }
                                        return ['id' => $filename, 'label' => $filename, 'file' => basename($path)];
                                    })
                                    ->sortBy(function ($item) {
                                        return $item['id'] === 'default' ? 999 : (int) $item['id'];
                                    })
                                    ->values();
                                $currentLogin = $config->default_login ?? 'default';
                            @endphp
                            @foreach ($loginImages as $login)
                                @php
                                    $isLoginActive = $currentLogin == $login['id'];
                                @endphp
                                <div class="col-xl-2 col-lg-3 col-sm-4 text-center">
                                    <div class="card overlay overflow-hidden theme-picker-card {{ $isLoginActive ? 'theme-active' : '' }}"
                                        data-theme="{{ $login['id'] }}" tabindex="0" role="button"
                                        aria-label="{{ $isLoginActive ? 'Giao diện đang dùng' : 'Chọn giao diện ' . $login['label'] }}">
                                        <div class="card-body p-0">
                                            <div class="overlay-wrapper theme-preview">
                                                <img src="{{ asset('images/login/' . $login['file']) }}" alt=""
                                                    class="w-100 rounded">
                                            </div>
                                            <div class="overlay-layer bg-dark bg-opacity-75">
                                                <button type="button"
                                                    class="btn btn-primary btn-sm btn-shadow {{ $isLoginActive ? 'd-none' : '' }}"
                                                    onclick="_settings.on.click.updateDesign('{{ $login['id'] }}', 'home')"
                                                    data-lang="button::Apply">Áp
                                                    dụng</button>
                                                <button type="button"
                                                    class="btn btn-info btn-sm btn-shadow {{ $isLoginActive ? '' : 'd-none' }}"
                                                    onclick="window.location.href='{{ route('admin.settings.theme.editor', ['default_login' => $login['id']]) }}'"
                                                    data-lang="button::Modify">Tùy
                                                    chỉnh</button>
                                            </div>
                                        </div>
                                    </div>
                                    <h4
                                        class="mt-3 badge {{ $login['id'] !== 'default' ? 'badge-circle' : '' }} badge-primary {{ $isLoginActive ? '' : 'badge-outline' }}">
                                        {{ $login['label'] }}</h4>
                                </div>
                            @endforeach
                        </div>

                        <div class="modal bg-dark fade" tabindex="-1" id="modal-modify-signin-page">
                            <div class="modal-dialog modal-fullscreen">
                                <div class="modal-content shadow-none">
                                    <div class="modal-body p-0 text-center signin-customizer-shell">
                                        <aside class="signin-customizer-rail" aria-label="Customizer tools">
                                            <button type="button" class="active"><i class="fa-solid fa-file-lines"></i><span>Pages</span></button>
                                            <button type="button"><i class="fa-solid fa-layer-group"></i><span>Blocks</span></button>
                                            <button type="button"><i class="fa-solid fa-sliders"></i><span>Styles</span></button>
                                            <button type="button"><i class="fa-solid fa-language"></i><span>Lang</span></button>
                                        </aside>
                                        <section class="signin-customizer-panel">
                                            <strong class="signin-customizer-title">Customizer</strong>
                                            <p class="text-muted fs-8 mb-0">Ch? ch?nh s?a giao di?n. Li?n k?t v? bi?u m?u ???c kh?a trong khi xem tr??c.</p>
                                        </section>
                                        <iframe id="ifr-signintheme" title="Login theme preview"></iframe>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                                            data-lang="button::Cancel">Hủy</button>
                                        <button type="button" class="btn btn-primary btn-save"
                                            data-lang="button::Save">Lưu thay đổi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap flex-stack my-6">
            <h3 class="fw-bold my-2" data-lang="Client theme">Giao diện người dùng</h3>
        </div>
        <div class="row g-6">
            <div class="col-lg-12">
                <div class="card shadow-sm">

                    <div class="card-body">
                        @php
                            $currentInterface = (string) ($config->default_interface ?? '1');
                            $isDefaultInterface = in_array($currentInterface, ['default', '1'], true);
                        @endphp
                        <div class="row div-style-theme div-style-theme-1">
                            <div class="col-xl-2 col-lg-3 col-sm-4 text-center">
                                <div class="card overlay overflow-hidden {{ $isDefaultInterface ? 'theme-active' : '' }}"
                                    data-theme="1">
                                    <div class="card-body p-0 card-preview">
                                        <div class="overlay-wrapper">
                                            <img src="{{ asset('images/theme/default.jpg') }}" alt=""
                                                class="w-100 rounded">
                                        </div>
                                        <div class="overlay-layer bg-dark bg-opacity-75">
                                            <button type="button"
                                                class="btn btn-primary btn-sm {{ $isDefaultInterface ? 'd-none' : '' }}"
                                                onclick="_settings.on.click.updateDesign('default', 'client')"
                                                data-lang="button::Apply">Áp dụng</button>
                                            <button type="button"
                                                class="btn btn-info btn-sm {{ $isDefaultInterface ? '' : 'd-none' }}"
                                                onclick="_settings.on.click.editClientTheme('{{ route('admin.settings.client-theme.editor', ['theme' => 'default']) }}')"
                                                data-lang="button::Modify">Tùy chỉnh</button>
                                        </div>
                                    </div>
                                </div>
                                <h4
                                    class="mt-3 badge badge-primary {{ $isDefaultInterface ? '' : 'badge-outline' }}">
                                    Default</h4>
                            </div>

                            <div class="col-xl-2 col-lg-3 col-sm-4 text-center">
                                <div class="card overlay overflow-hidden {{ $currentInterface === '4' ? 'theme-active' : '' }}"
                                    data-theme="4">
                                    <div class="card-body p-0 card-preview">
                                        <div class="overlay-wrapper">
                                            <img src="{{ asset('images/theme/4.jpg') }}" alt=""
                                                class="w-100 rounded">
                                        </div>
                                        <div class="overlay-layer bg-dark bg-opacity-75">
                                            <button type="button"
                                                class="btn btn-primary btn-sm {{ $currentInterface === '4' ? 'd-none' : '' }}"
                                                onclick="_settings.on.click.updateDesign('4', 'client')"
                                                data-lang="button::Apply">Áp dụng</button>
                                            <button type="button"
                                                class="btn btn-info btn-sm {{ $currentInterface === '4' ? '' : 'd-none' }}"
                                                onclick="_settings.on.click.editClientTheme('{{ route('admin.settings.client-theme.editor', ['theme' => '4']) }}')"
                                                data-lang="button::Modify">Tùy chỉnh</button>
                                        </div>
                                    </div>
                                </div>
                                <h4
                                    class="mt-3 badge badge-circle badge-primary {{ $currentInterface === '4' ? '' : 'badge-outline' }}">
                                    4</h4>
                            </div>

                            <div class="col-xl-2 col-lg-3 col-sm-4 text-center">
                                <div class="card overlay overflow-hidden {{ $currentInterface === '6' ? 'theme-active' : '' }}"
                                    data-theme="6">
                                    <div class="card-body p-0 card-preview">
                                        <div class="overlay-wrapper">
                                            <img src="{{ asset('images/theme/6.jpg') }}" alt=""
                                                class="w-100 rounded">
                                        </div>
                                        <div class="overlay-layer bg-dark bg-opacity-75">
                                            <button type="button"
                                                class="btn btn-primary btn-sm {{ $currentInterface === '6' ? 'd-none' : '' }}"
                                                onclick="_settings.on.click.updateDesign('6', 'client')"
                                                data-lang="button::Apply">Áp dụng</button>
                                            <button type="button"
                                                class="btn btn-info btn-sm {{ $currentInterface === '6' ? '' : 'd-none' }}"
                                                onclick="_settings.on.click.editClientTheme('{{ route('admin.settings.client-theme.editor', ['theme' => '6']) }}')"
                                                data-lang="button::Modify">Tùy chỉnh</button>
                                        </div>
                                    </div>
                                </div>
                                <h4
                                    class="mt-3 badge badge-circle badge-primary {{ $currentInterface === '6' ? '' : 'badge-outline' }}">
                                    6</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $(function () {
        _settings.init();

        // Make theme cards behave like the WordPress Customizer: the selected
        // card is always announced to screen readers and can be activated by
        // keyboard without changing the existing _settings API.
        $('.theme-picker-card').on('keydown', function (event) {
            if (event.key !== 'Enter' && event.key !== ' ') return;
            event.preventDefault();
            $(this).find('button:not(.d-none)').first().trigger('click');
        });
    });
</script>
@endpush

@push('styles')
<style>
    .theme-settings .theme-toolbar {
        border: 1px solid var(--bs-gray-200, #e4e6ef);
        border-radius: 12px;
        background: var(--bs-gray-100, #f5f8fa);
    }

    .theme-settings .theme-picker-card {
        border: 2px solid transparent;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .theme-settings .theme-picker-card:hover,
    .theme-settings .theme-picker-card:focus-within {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(35, 45, 65, .12);
    }

    .theme-settings .theme-picker-card.theme-active {
        border-color: var(--bs-primary, #009ef7);
        box-shadow: 0 0 0 3px rgba(0, 158, 247, .12);
    }

    .theme-settings .theme-preview {
        aspect-ratio: 16 / 10;
        background: var(--bs-gray-200, #eef1f5);
    }

    .theme-settings .theme-preview img {
        height: 100%;
        object-fit: cover;
    }

    .theme-settings .theme-status {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
    }

    .theme-settings .modal iframe {
        width: 100%;
        height: 100%;
        min-height: 70vh;
        border: 0;
        background: #fff;
    }

    .signin-customizer-shell { display: flex; min-height: 75vh; background: #f7f8fb; }
    .signin-customizer-rail { width: 78px; padding: 18px 8px; background: #fff; border-right: 1px solid #e4e6ef; display: flex; flex-direction: column; gap: 12px; }
    .signin-customizer-rail button { border: 0; background: transparent; color: #91a0bd; font-size: 11px; text-transform: uppercase; display: grid; gap: 6px; justify-items: center; padding: 10px 2px; border-radius: 8px; }
    .signin-customizer-rail button i { font-size: 18px; }
    .signin-customizer-rail button.active, .signin-customizer-rail button:hover { color: #2463eb; background: #eef4ff; }
    .signin-customizer-panel { width: 260px; padding: 24px 18px; text-align: left; background: #fff; border-right: 1px solid #e4e6ef; }
    .signin-customizer-title { display: block; font-size: 16px; margin-bottom: 8px; }
    .signin-customizer-shell iframe { flex: 1; min-width: 0; }
    @media (max-width: 768px) { .signin-customizer-panel { width: 190px; } }
</style>
@endpush
