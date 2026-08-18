@extends('clients.theme-2.layouts.app')
@section('title', 'Update')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4" data-lang="update.title">Cập nhật dịch vụ</h4>
    <div class="card shadow-sm">
        <div class="card-body">
            @if ($logs->isEmpty())
                <div class="text-center text-muted py-10">
                    <i class="bi bi-inbox fs-2x d-block mb-2"></i>
                    <span data-lang="update.no_data">Không có cập nhật nào</span>
                </div>
            @else
                <div class="timeline timeline-border-dashed">
                    @foreach ($logs as $log)
                        @php
                            $type = $log->change_type ?? '';
                            $isDown = $type === 'price_decrease';
                            $isUp = in_array($type, ['price_increase', 'min_max_change']);
                            $icon = match(true) {
                                $isDown => 'ki-arrow-down text-success',
                                $isUp => 'ki-arrow-up text-danger',
                                $type === 'enable' => 'ki-check-circle text-success',
                                $type === 'disable' => 'ki-cross-circle text-danger',
                                default => 'ki-information text-info',
                            };
                            $langKey = match($type) {
                                'price_increase' => 'update.price_increase', 'price_decrease' => 'update.price_decrease',
                                'min_max_change' => 'update.min_max_change', 'enable' => 'update.enable_service',
                                'disable' => 'update.disable_service', default => 'update.other_change',
                            };
                            $langText = match($type) {
                                'price_increase' => 'Price increase', 'price_decrease' => 'Price decrease',
                                'min_max_change' => 'Min/Max change', 'enable' => 'Enable service',
                                'disable' => 'Disable service', default => ucfirst(str_replace('_', ' ', $type)),
                            };
                            $textClass = in_array($type, ['price_decrease', 'enable']) ? 'text-success' : 'text-danger';
                            $serviceName = $log->service->name ?? null;
                            if (is_array($serviceName)) $serviceName = $serviceName[app()->getLocale()] ?? $serviceName['en'] ?? reset($serviceName);
                            $serviceLabel = ($log->service_id ? $log->service_id . ' | ' : '') . ($serviceName ?? '');
                        @endphp
                        <div class="timeline-item">
                            <div class="timeline-line"></div>
                            <div class="timeline-icon me-4">
                                <i class="ki-duotone {{ $icon }} fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                            <div class="timeline-content mb-10 mt-n2">
                                <div class="fs-6 mb-2">
                                    {{ $serviceLabel }}
                                    <p class="mb-0 fs-7 fw-semibold">
                                        <span data-lang="{{ $langKey }}" class="{{ $textClass }}">{{ $langText }}</span>
                                        @if ($log->old_value !== null && $log->new_value !== null)
                                            : ${{ rtrim(rtrim(number_format((float)$log->old_value, 6, '.', ''), '0'), '.') }}
                                            <i class="fa fa-arrow-{{ $isDown ? 'down text-success' : 'up text-danger' }} mx-2"></i>
                                            ${{ rtrim(rtrim(number_format((float)$log->new_value, 6, '.', ''), '0'), '.') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="text-muted fs-8 mt-1">{{ $log->created_at }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($logs->hasPages())
                    <div class="d-flex justify-content-center py-4">{{ $logs->links() }}</div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
