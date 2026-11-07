<div class="flex-wrap mt-6 d-flex flex-stack average-time-settings-toggle" style="{{ isset($service) ? 'display: none;' : '' }}">
    <div class="form-check form-switch form-check-custom">
        <input class="form-check-input cb-service-avg-time" type="checkbox" @checked($hasAverageTime)
            onchange="document.querySelector('.card-avg-time').setAttribute('style', this.checked ? '' : 'display: none;')">
        <label class="text-gray-900 form-check-label fs-3 fw-bold" data-lang="/services::Set average time">Thiết lập thời gian trung bình</label>
    </div>
</div>

<div class="mt-0 row g-5 card-avg-time" data-average-time-value="{{ $legacyAverageTime }}" data-average-time-v2-value="{{ $averageTimeV2Value }}" style="{{ isset($service) || !$hasAverageTime ? 'display: none;' : '' }}">
    <div class="col-12">
        <div class="shadow-sm card">
            <div class="card-body">
                <div class="mb-5 row g-4 align-items-end average-time-v1-panel">
                    <div class="col-xl-12">
                        <label class="required form-label" data-lang="/services::Time">Thời gian (tính bằng giây)</label>
                        <div class="input-group input-group-solid mb-5">
                            <span class="input-group-text bg-text text-avg-time">{{ $legacyAverageTime }}</span>
                            <input type="text" class="form-control ipt-service-avg-time" data-average-time-v1
                                data-inputmask="'mask': '9', 'repeat': 9, 'greedy' : false"
                                value="{{ $legacyAverageTime }}"
                                onkeyup="document.querySelector('.text-avg-time').textContent = app.timeAvg(this.value.trim())"
                                inputmode="text">
                        </div>
                    </div>
                </div>

                <div class="mb-5 form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input cb-service-avg-time-v2" type="checkbox" @checked($hasAverageTimeV2)>
                    <label class="form-check-label" data-lang="/services::Average time V2">Average time V2</label>
                </div>

                <div class="average-time-v2-panel" style="{{ $hasAverageTimeV2 ? '' : 'display: none;' }}">
                    <template class="average-time-v2-row-template">
                        <div class="row g-3 mb-3 align-items-end average-time-v2-item">
                            <div class="col-12 col-md-3"><label class="form-label" data-lang="/services::Quantity">Số lượng</label><input type="number" min="1" max="100000000" class="form-control average-time-v2-quantity"></div>
                            <div class="col-12 col-md-8">
                                <label class="form-label" data-lang="/services::Time in seconds">Thời gian (giây)</label>
                                <div class="input-group input-group-solid mb-5">
                                    <span class="input-group-text bg-text text-avg-time" data-average-time-v2-time>0 sec</span>
                                    <input type="text" class="form-control ipt-service-avg-time" data-average-time-v2-seconds data-inputmask="'mask': '9', 'repeat': 9, 'greedy' : false" value="0" onkeyup="this.parentElement.querySelector('[data-average-time-v2-time]').textContent = app.timeAvg(this.value.trim())" inputmode="text">
                                </div>
                            </div>
                            <div class="col-12 col-md-1 d-flex justify-content-md-end"><button type="button" class="btn btn-light-danger btn-icon btn-sm average-time-v2-remove" aria-label="Remove row"><i class="bi bi-trash"></i></button></div>
                        </div>
                    </template>
                    <div class="mb-4 average-time-v2-rows"></div>
                    <button type="button" class="btn btn-light-primary btn-sm average-time-v2-add">
                        <i class="bi bi-plus-lg"></i>
                        <span data-lang="/services::Add average time row">Thêm mốc</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
