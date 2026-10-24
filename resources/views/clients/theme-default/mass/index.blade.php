@extends('clients.theme-default.layouts.app')
@section('title', 'Mass Order')

@section('content')
    <div class="content flex-column-fluid" id="kt_content">
        @include('clients.theme-default.layouts.toolbar', [
            'title' => 'Mass Order',
            'langKey' => 'menu::Mass order',
        ])

        <div class="post" id="kt_post">
            <div class="card">
                <div class="card-body">

                    {{-- Textarea nhập liệu --}}
                    <div class="mb-3">
                        <label class="form-label" data-page="/mass" data-lang="One order per line in format">One order per line in format</label>
                        <textarea id="txa-data-order" class="form-control"
                            placeholder="service_id | link | quantity
service_id | link | quantity | comment1 / comment2 / comment3 / ... (Separate by /)
service_id | link | quantity | suggest video list
service_id | link | quantity | keyword search
service_id | link | quantity | suggest video list | keyword search (Mix views)"
                            rows="15"></textarea>
                    </div>

                    {{-- Schedule --}}
                    <div class="mb-3 schedule">
                        <div class="form-check form-switch">
                            <input type="checkbox" id="cb-schedule" class="form-check-input"
                                onchange="document.querySelector('.schedule-time').style.display = this.checked ? '' : 'none';">
                            <label class="form-check-label">
                                <span class="fw-bold" data-page="/new" data-lang="Schedule">Schedule</span>.
                                <span data-page="/new" data-lang="Your timezone">Your timezone</span>:
                                <span class="fw-bolder">+07:00</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 schedule-time" style="display: none;">
                        <label class="form-label" data-page="/new" data-lang="Choose time">Choose time</label>
                        <input type="text" id="ipt-schedule-time" class="form-control form-control-solid" readonly="">
                    </div>

                    {{-- Loop --}}
                    <div class="mb-3 loop">
                        <div class="form-check form-switch">
                            <input type="checkbox" id="cb-loop" class="form-check-input"
                                onchange="document.querySelector('.loop-quantity').style.display = this.checked ? '' : 'none';document.querySelector('.loop-spacing').style.display = this.checked ? '' : 'none';">
                            <label class="form-check-label">
                                <span class="fw-bold" data-page="/new" data-lang="Loop">Loop</span>.
                                <span data-page="/new" data-lang="Loop desciption">Auto Re-order when this order has been
                                    <span class="fw-bolder">COMPLETED</span>. Carefully when to use this function.
                                    Always make sure balance is enough.</span>
                            </label>
                        </div>
                    </div>
                    <div class="row g-5">
                        <div class="col-sm-6">
                            <div class="mb-3 loop-quantity" style="display: none;">
                                <label for="sl-loop-quantity" class="form-label" data-page="/mass" data-lang="Loop quantity">Loop
                                    quantity</label>
                                <select id="sl-loop-quantity" class="form-select form-select-solid">
                                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100] as $v)
                                        <option value="{{ $v }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3 loop-spacing" style="display: none;">
                                <label for="sl-loop-spacing" class="form-label" data-page="/mass" data-lang="Loop spacing (minutes)">Loop
                                    spacing (minutes)</label>
                                <select id="sl-loop-spacing" class="form-select form-select-solid">
                                    @for ($i = 0; $i <= 1440; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="button" id="btn-order" class="btn btn-primary w-100 mt-3"
                        onclick="_mass.on.click.order()" data-page="/mass" data-lang="Submit">Submit</button>

                    {{-- Result table (giữ nguyên cấu trúc gốc, không có thead) --}}
                    <div class="table-responsive mt-10">
                        <table class="table align-middle table-row-dashed fs-7 gy-2 gs-3 table-log-bulk"
                            style="display: none;">
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>_mass.init();</script>
@endpush

