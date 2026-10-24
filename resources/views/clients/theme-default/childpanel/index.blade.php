@extends('clients.theme-default.layouts.app')
@section('title', 'Child Panel')

@section('content')
    <div class="content flex-column-fluid" id="kt_content">
        @include('clients.theme-default.layouts.toolbar', ['title' => 'Child Panel', 'langKey' => 'menu::Child Panel'])
        <div class="post" id="kt_post">
            <div class="alert alert-primary">
                <p class="m-0" data-lang="Change nameservers">Please change domain nameservers to:</p>
                <p class="m-0 fw-bolder">{{ $config->namesv1 ?? '' }}</p>
                <p class="m-0 fw-bolder">{{ $config->namesv2 ?? '' }}</p>
            </div>
            <div class="alert alert-danger" data-lang="alert-header">Please use this account on this site as <strong>ADMIN</strong> account for log in to child panel.</div>

            <div class="card mb-5">
                <div class="card-body">
                    <form id="child-panel-form">
                        <label for="ipt-domain" class="form-label" data-lang="Domain">Domain</label>
                        <div class="input-group input-group-solid">
                            <span class="input-group-text fw-bold">{{ $costFormatted }}</span>
                            <input type="text" id="ipt-domain" name="domain" class="form-control"
                                placeholder="example.com" autocomplete="url" required>
                            <button type="submit" id="btn-create" class="btn btn-primary"
                                data-lang="Create child panel">Create child panel</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Feature cards --}}
            <div class="row g-5">
                @foreach ([
                    ['icon'=>'la-shopping-cart',     'title'=>'Unlimited Orders',           'desc'=>'Unlimited Orders - desc'],
                    ['icon'=>'la-universal-access',  'title'=>'White Label Panel',           'desc'=>'White Label Panel - desc'],
                    ['icon'=>'la-credit-card',        'title'=>'Unlimited Payment Methods',   'desc'=>'Unlimited Payment Methods - desc'],
                    ['icon'=>'la-rocket',             'title'=>'Auto Order Processing',       'desc'=>'Auto Order Processing - desc'],
                ] as $f)
                <div class="col-sm-6 col-xl-3 mb-xl-10">
                    <div class="card h-lg-100">
                        <div class="card-body d-flex justify-content-between align-items-center flex-column p-5">
                            <div class="m-0 text-center"><i class="las {{ $f['icon'] }} fs-3hx text-gray-600"></i></div>
                            <div class="d-flex flex-column my-5 text-center">
                                <span class="fw-semibold fs-2 text-gray-800 ls-1" data-lang="{{ $f['title'] }}">{{ $f['title'] }}</span>
                                <span class="fw-semibold fs-7 text-gray-500" data-lang="{{ $f['desc'] }}">{{ $f['desc'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Steps --}}
            <div class="row g-5">
                @foreach ([
                    [1, 'Buy a domain',          'Buy a domain - desc'],
                    [2, 'Change Name Servers',   'Change Name Servers - desc'],
                    [3, 'Order a child panel',   'Order a child panel - desc'],
                    [4, 'Import Services',       'Import Services - desc'],
                    [5, 'Add Payment Methods',   'Add Payment Methods - desc'],
                    [6, 'Start Making Money',    'Start Making Money - desc'],
                ] as [$n, $title, $desc])
                <div class="col-sm-6 col-xl-2 mb-xl-10">
                    <div class="card border border-primary h-lg-100">
                        <div class="card-body d-flex justify-content-between align-items-start flex-column py-1">
                            <div class="d-flex flex-column my-7">
                                <span class="fw-semibold fs-3x text-primary lh-1 ls-n2">
                                    {{ $n }}@if ($n < 6)<i class="las la-arrow-right fs-2x ms-1"></i>@endif
                                </span>
                                <span class="fw-semibold fs-6 text-gray-600" data-lang="{{ $title }}">{{ $title }}</span>
                                <span class="fw-semibold fs-7 text-gray-500" data-lang="{{ $desc }}">{{ $desc }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- FAQ --}}
            <div class="row g-5">
                @php
                $faqs = [
                    ['What is a SMM Panel?',              'What is a SMM Panel? - ans',              'kt_acc_1'],
                    ['What is a Child Panel?',            'What is a Child Panel? - ans',            'kt_acc_2'],
                    ['How can I find providers?',          'How can I find providers? - ans',          'kt_acc_3'],
                    ['What SMM services do you offer?',    'What SMM services do you offer? - ans',    'kt_acc_4'],
                    ['How can I manage my SMM Panel?',     'How can I manage my SMM Panel? - ans',     'kt_acc_5'],
                    ['How can I find customers?',          'How can I find customers? - ans',          'kt_acc_6'],
                ];
                @endphp
                <div class="col-lg-6">
                    <div class="accordion">
                        @foreach (array_slice($faqs, 0, 3) as [$q, $a, $id])
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button fs-4 fw-semibold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#{{ $id }}"
                                    data-lang="{{ $q }}">{{ $q }}</button>
                            </h2>
                            <div id="{{ $id }}" class="accordion-collapse collapse">
                                <div class="accordion-body" data-lang="{{ $a }}">{{ $a }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion">
                        @foreach (array_slice($faqs, 3) as [$q, $a, $id])
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button fs-4 fw-semibold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#{{ $id }}"
                                    data-lang="{{ $q }}">{{ $q }}</button>
                            </h2>
                            <div id="{{ $id }}" class="accordion-collapse collapse">
                                <div class="accordion-body" data-lang="{{ $a }}">{{ $a }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>_childpanel.init();</script>
@endpush

