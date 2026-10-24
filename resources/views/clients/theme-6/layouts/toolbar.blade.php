<div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
    <div class="page-title d-flex flex-column py-1">
        <h1 class="d-flex align-items-center my-1">
            <span class="text-gray-900 fw-bold fs-1" data-lang="{{ $langKey ?? '' }}">{{ $title ?? '' }}</span>
        </h1>
    </div>
    <div class="d-flex align-items-center py-2 gap-2">
        @auth
            <div class="d-flex align-items-center">
                <a href="{{ route('clients.addfunds.index') }}" class="btn btn-primary btn-sm fw-bold fs-4 ls-2 py-1">
                    {{ $uiData['balance']['formatted'] ?? $formattedBalance ?? '0' }}
                </a>
            </div>
            <div class="d-flex align-items-center" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <a href="{{ route('clients.settings.index') }}" aria-label="Change language">
                    <span class="rounded-1 {{ $uiData['lang']['flag_class'] ?? 'fi fi-us' }}"
                        style="font-size: 2em !important; background-image: url('{{ $uiData['lang']['flag_url'] ?? asset('cdn.whoispanel.com/flags/4x3/us.svg') }}') !important;"></span>
                </a>
            </div>
        @endauth
    </div>
</div>
