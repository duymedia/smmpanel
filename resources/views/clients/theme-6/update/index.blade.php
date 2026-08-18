@extends('clients.theme-6.layouts.app')

@section('title', __('update.title') ?? 'Updates')

@section('content')
    <div id="block_103">
        <div class="block-bg"></div>
        <div class="container-fluid">
            <div class="updates-list">
                <div class="row">
                    <div class="col">
                        <div class="updates-filters component_filter_form_group component_filter_card updates__margin-search">
                            <div class="card">
                                <div class="row">
                                    {{-- Filter dropdown --}}
                                    <div class="col-md-auto mb-3 mb-md-0">
                                        <div class="component_filter_button">
                                            <div class="dropdown">
                                                <a class="btn btn-big-primary w-sm-auto w-100 dropdown-toggle"
                                                    href="#" role="button" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <span>
                                                        @php
                                                            $filterLabels = [
                                                                'new'       => __('update.new_service')      ?? 'New service',
                                                                'decreased' => __('update.rate_decreased')   ?? 'Rate decreased',
                                                                'increased' => __('update.rate_increased')   ?? 'Rate increased',
                                                                'enabled'   => __('update.service_enabled')  ?? 'Service enabled',
                                                                'disabled'  => __('update.service_disabled') ?? 'Service disabled',
                                                            ];
                                                            $currentFilter = request()->segment(2);
                                                            echo $filterLabels[$currentFilter] ?? (__('update.all') ?? 'All');
                                                        @endphp
                                                    </span>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item {{ !$currentFilter ? 'active' : '' }}" href="{{ route('clients.update.index') }}">
                                                        {{ __('update.all') ?? 'All' }}
                                                    </a>
                                                    <a class="dropdown-item {{ $currentFilter === 'new' ? 'active' : '' }}" href="/updates/new">
                                                        {{ __('update.new_service') ?? 'New service' }}
                                                    </a>
                                                    <a class="dropdown-item {{ $currentFilter === 'decreased' ? 'active' : '' }}" href="/updates/decreased">
                                                        {{ __('update.rate_decreased') ?? 'Rate decreased' }}
                                                    </a>
                                                    <a class="dropdown-item {{ $currentFilter === 'increased' ? 'active' : '' }}" href="/updates/increased">
                                                        {{ __('update.rate_increased') ?? 'Rate increased' }}
                                                    </a>
                                                    <a class="dropdown-item {{ $currentFilter === 'enabled' ? 'active' : '' }}" href="/updates/enabled">
                                                        {{ __('update.service_enabled') ?? 'Service enabled' }}
                                                    </a>
                                                    <a class="dropdown-item {{ $currentFilter === 'disabled' ? 'active' : '' }}" href="/updates/disabled">
                                                        {{ __('update.service_disabled') ?? 'Service disabled' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Search --}}
                                    <div class="col">
                                        <form action="{{ route('clients.update.index') }}" method="get" id="history-search">
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    value="{{ request('search') }}"
                                                    placeholder="{{ __('newOrder.search') }}" name="search">
                                                <span class="input-group-append component_button_search">
                                                    <button class="btn btn-big-secondary" type="submit">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="updates__margin-table">
                            <div class="table-bg component_table">
                                <div class="table-wr table-responsive">
                                    <table class="table updates-table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('update.service') ?? 'Service' }}</th>
                                                <th>{{ __('update.date') ?? 'Date' }}</th>
                                                <th>{{ __('update.update') ?? 'Update' }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($logs as $log)
                                                @php
                                                    $type   = $log->change_type ?? '';
                                                    $isDown = $type === 'price_decrease';
                                                    $fmt    = fn($v) => '$' . rtrim(rtrim(number_format((float)$v, 6, '.', ''), '0'), '.');
                                                    $hasValues = $log->old_value !== null && $log->new_value !== null && (float)$log->old_value != (float)$log->new_value;

                                                    $baseText = match($type) {
                                                        'price_increase' => __('update.price_increase') ?? 'Rate increased',
                                                        'price_decrease' => __('update.price_decrease') ?? 'Rate decreased',
                                                        'min_max_change' => __('update.min_max_change') ?? 'Min/Max change',
                                                        'enable'         => __('update.enable_service') ?? 'Service enabled',
                                                        'disable'        => __('update.disable_service') ?? 'Service disabled',
                                                        'new'            => __('update.new_service') ?? 'New service',
                                                        default          => ucfirst(str_replace('_', ' ', $type)),
                                                    };

                                                    $updateText = ($hasValues && in_array($type, ['price_increase', 'price_decrease', 'min_max_change']))
                                                        ? $baseText . ' from ' . $fmt($log->old_value) . ' to ' . $fmt($log->new_value)
                                                        : $baseText;

                                                    $updateClass = in_array($type, ['price_decrease', 'enable']) ? 'text-success' : 'text-danger';
                                                    $serviceName = $log->service->name ?? null;
                                                    if (is_array($serviceName)) {
                                                        $serviceName = $serviceName[app()->getLocale()] ?? $serviceName['en'] ?? reset($serviceName);
                                                    }
                                                @endphp
                                                @if(in_array($type, ['price_increase', 'price_decrease', 'min_max_change']) && !$hasValues)
                                                    @continue
                                                @endif
                                                <tr>
                                                    <td class="table-service">
                                                        @if($log->service_id)
                                                            <span class="badge badge-secondary mr-2">{{ $log->service_id }}</span>
                                                        @endif
                                                        <span>{{ $serviceName ?? '' }}</span>
                                                    </td>
                                                    <td nowrap="">{{ $log->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <span>{{ $updateText }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center py-4 text-muted">
                                                        {{ __('update.no_data') ?? 'No updates found' }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pagination --}}
                @if($logs->hasPages())
                    <div class="row">
                        <div class="col-12">
                            <nav class="component_pagination">
                                <div class="">
                                    @php
                                        $currentPage = $logs->currentPage();
                                        $lastPage    = $logs->lastPage();
                                        $baseUrl     = '/updates';
                                    @endphp
                                    <ul class="pagination">
                                        {{-- Prev --}}
                                        <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $currentPage > 1 ? $baseUrl . '/' . ($currentPage - 1) : '#' }}">‹</a>
                                        </li>
                                        {{-- Pages --}}
                                        @for($p = max(1, $currentPage - 3); $p <= min($lastPage, $currentPage + 3); $p++)
                                            <li class="page-item {{ $p === $currentPage ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $baseUrl . '/' . $p }}">{{ $p }}</a>
                                            </li>
                                        @endfor
                                        {{-- Next --}}
                                        <li class="page-item {{ $currentPage >= $lastPage ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $currentPage < $lastPage ? $baseUrl . '/' . ($currentPage + 1) : '#' }}">›</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
