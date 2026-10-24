@extends('clients.theme-default.layouts.app')
@section('title', 'New Order')

@section('content')
    <!--begin::Content-->
    <div class="content flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        @include('clients.theme-default.layouts.toolbar', [
            'title' => 'New Order',
            'langKey' => 'menu::New order',
        ])
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post" id="kt_post">
            @if ($data['announcement']['showPage'])
                <div class="alert alert-primary d-flex flex-column ql-editor">
                    {!! $data['announcement']['content'] !!}
                </div>
            @endif

            <div class="mb-5 card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="sl-quick-search" class="form-label" data-lang="Quick search service">Quick search
                            service</label>
                        <select id="sl-quick-search" class="form-select form-select-solid" multiple
                            onchange="_new.on.change.search(this.value)"
                            data-placeholder="Please choose"
                            style="height:43px;overflow:hidden"></select>
                    </div>
                    <div class="row g-5">
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <label for="sl-platform" class="form-label" data-lang="Social media">Social
                                    media</label>
                                <select id="sl-platform" class="form-select form-select-solid" title="Social media"
                                    aria-label="Social media"
                                    onchange="_new.on.change.platform(this.value)">
                                    <option value="-1"
                                        data-content="&lt;i class=&quot;fa-solid fa-star&quot;&gt;&lt;/i&gt; Best for you"
                                        data-lang="" data-fav="1" style="display:none" disabled>Best
                                        for you</option>
                                    @foreach ($data['platforms'] as $p)
                                        @if ($p->image && preg_match('/\.(?:png|jpe?g|gif|webp|svg)(?:\?.*)?$/i', $p->image))
                                            <option value="{{ $p->id }}" title="{{ $p->name }}"
                                                data-content="&lt;img src=&quot;{{ $p->image }}&quot; class=&quot;w-15px h-15px me-1&quot; /&gt; {{ $p->name }}"
                                                data-lang="">{{ $p->name }}</option>
                                        @elseif($p->image)
                                            <option value="{{ $p->id }}" title="{{ $p->name }}"
                                                data-content="&lt;i class=&quot;{{ $p->image }}&quot;&gt;&lt;/i&gt; {{ $p->name }}"
                                                data-lang="">{{ $p->name }}</option>
                                        @else
                                            <option value="{{ $p->id }}" title="{{ $p->name }}" data-content="{{ $p->name }}"
                                                data-lang="">{{ $p->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="mb-3"> 
                                <label for="sl-category" class="form-label" data-lang="Category">Category</label>
                                <select id="sl-category" class="form-select form-select-solid"
                                    onchange="_new.on.change.category(this.value)">
                                    <option value="-1"
                                        data-content="&lt;i class=&quot;fa-solid fa-star&quot;&gt;&lt;/i&gt; Favorite"
                                        data-lang="" data-fav="1">Favorite</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 display-as display-as-default">
                        <label for="sl-service" class="form-label" data-lang="Service">Service</label>
                        <select id="sl-service" class="form-select form-select-solid"
                            onchange="_new.on.change.service(this.value)">
                        </select>
                    </div>
                    <div class="display-as display-as-table" style="display: none;"></div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="card div-order">
                        <div class="card-body">
                            <fieldset class="p-2 mb-5 border border-2 rounded">
                                <legend class="float-none w-auto fs-7 d-flex">
                                    <div class="form-check form-check-custom form-check-solid me-5">
                                        <input class="form-check-input" type="radio" value="0" name="link_input_type"
                                            onchange="_new.on.change.link_input_type(this.value)" checked="">
                                        <label class="form-check-label" data-lang="One">One</label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" value="1" name="link_input_type"
                                            onchange="_new.on.change.link_input_type(this.value)">
                                        <label class="form-check-label" data-lang="Multi">Multi</label>
                                    </div>
                                </legend>
                                <div class="mb-0">
                                    <label class="form-label" data-lang="Link">Link</label>
                                    <div class="input-group input-group-solid">

                                        <input type="text" id="ipt-link" class="form-control form-control-solid"
                                            placeholder="" oninput="_new.on.input.showButton(this.value)">
                                        <button id="btn-convert" class="px-3 btn btn-light-primary d-none" type="button"
                                            onclick="_new.on.click.convertFbId()" title="Convert to UID">
                                            <i class="ki-duotone ki-arrows-loop fs-2"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                            <span class="badge badge-circle badge-primary ms-1 convert-count"
                                                style="display:none;">0</span>
                                        </button>
                                    </div>
                                    <small class="form-text text-muted fst-italic">
                                        <p class="mb-0 link-convert-notice d-none text-info"><i
                                                class="bi bi-info-circle me-1"></i><span
                                                data-lang="If service requires ID, click">If service
                                                requires ID, click</span> <i class="ki-solid ki-arrows-loop"></i><span
                                                class="convert-count-text ms-1"></span></p>
                                    </small>
                                </div>
                                <div class="mb-0" style="display: none;">
                                    <div class="mb-2 d-flex justify-content-between align-items-end">
                                        <label class="mb-0 form-label" data-lang="Link (1 per line)">Link (1 per
                                            line)</label>
                                        <button id="btn-convert-multi"
                                            class="px-3 py-1 btn btn-sm btn-light-primary d-none" type="button"
                                            onclick="_new.on.click.getUIDMulti()">
                                            <i class="ki-duotone ki-arrows-loop fs-4"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                            <span class="ms-1" data-lang="">Convert all</span>
                                            <span class="badge badge-circle badge-light ms-1 convert-multi-count">0</span>
                                        </button>
                                    </div>
                                    <div class="position-relative">
                                        <textarea id="txa-link" class="form-control form-control-solid" rows="8"
                                            oninput="_new.on.input.showButtonMulti(this.value)"></textarea>
                                        <div class="position-absolute text-muted fs-8 link-count-overlay"
                                            style="bottom: 8px; right: 12px; pointer-events: none; background: rgba(255,255,255,0.8); padding: 2px 6px; border-radius: 4px;">
                                            0</div>
                                    </div>
                                    <small class="form-text text-muted fst-italic">
                                        <p class="mb-0 link-convert-notice-multi d-none text-info"><i
                                                class="bi bi-info-circle me-1"></i><span
                                                data-lang="If service requires ID, click">If service
                                                requires ID, click</span> <i class="ki-solid ki-arrows-loop"></i><span
                                                class="convert-multi-count-text ms-1"></span></p>
                                    </small>
                                </div>
                            </fieldset>
                            <div class="mb-3">
                                <label class="form-label" data-lang="Quantity">Quantity</label>
                                <div class="input-group input-group-solid">

                                    <input type="text" id="ipt-quantity" class="form-control"
                                        onkeyup="_new.on.keyup.calculatePrice(0)"
                                        data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false" inputmode="text">
                                    <span class="input-group-text"><span class="badge badge-primary fw-bold charge">$
                                            0</span></span>
                                </div>
                                <small class="form-text text-muted fst-italic">
                                    <p class="mb-0"><span data-lang="Min">Min</span>: <span
                                            class="min">500</span> -
                                        <span data-lang="Max">Max</span>: <span class="max">1000000000</span>
                                    </p><a href="#" class="text-warning fw-bold span-quantity-discount ms-2"
                                        data-bs-toggle="modal" data-bs-target="#modal-quantity-discount"
                                    style="display: none;" data-lang="Special Discount">Special Discount</a>
                                </small>
                            </div> <!-- begin::Type -->
                            <div class="mb-3 service-type custom-comments" style="display: none;">
                                <label class="form-label" data-lang="Comments (1 per line)">Comments (1 per
                                    line)</label>
                                <textarea id="txa-comment" class="form-control form-control-solid" rows="8"
                                    onkeyup="_new.on.keyup.calculatePrice(1, '#txa-comment')"></textarea>

                            </div>
                            <div class="mb-3 service-type special special-1" style="display: none;">
                                <label class="form-label" data-lang="">List</label>
                                <input type="text" id="ipt-suggest" class="form-control form-control-solid">

                            </div>
                            <div class="mb-35 service-type special-1" style="display: none;">
                                <label class="form-label" data-lang="Keyword list">Keyword list</label>
                                <input type="text" id="ipt-search" class="form-control form-control-solid">

                            </div>
                            <div class="mb-3 service-type mentions mentions-with-hashtags mentions-custom-list"
                                style="display: none;">
                                <label class="form-label" data-lang="">Usernames (1 per
                                    line)</label>
                                <textarea id="txa-usernames" class="form-control form-control-solid" rows="8"></textarea>

                            </div>
                            <div class="mb-3 service-type mentions-with-hashtags" style="display: none;">
                                <label class="form-label" data-lang="">Hashtags (1 per
                                    line)</label>
                                <textarea id="txa-hashtags" class="form-control form-control-solid" rows="8"></textarea>

                            </div>
                            <div class="mb-3 service-type seo" style="display: none;">
                                <label class="form-label" data-lang="">Keywords (1 per
                                    line)</label>
                                <textarea id="txa-keywords" class="form-control form-control-solid" rows="8"></textarea>

                            </div>
                            <div class="mb-3 service-type mentions-user-followers comment-likes" style="display: none;">
                                <label class="form-label" data-lang="">Username</label>
                                <input type="text" id="ipt-username" class="form-control form-control-solid">

                            </div>
                            <div class="mb-3 service-type mentions-hashtag" style="display: none;">
                                <label class="form-label" data-lang="">Video description</label>
                                <input type="text" id="ipt-hashtag" class="form-control form-control-solid">

                            </div>
                            <div class="mb-3 service-type mentions-media-likers" style="display: none;">
                                <label class="form-label" data-lang="">Media URL</label>
                                <input type="text" id="ipt-media" class="form-control form-control-solid">

                            </div>
                            <div class="mb-3 service-type invites-from-groups" style="display: none;">
                                <label class="form-label" data-lang="">Groups (1 per line)</label>
                                <textarea id="txa-groups" class="form-control form-control-solid" rows="8"></textarea>

                            </div> <!-- end::Type -->
                            <div class="mb-3 schedule" style="">
                                <div class="form-check form-switch">
                                    <input type="checkbox" id="cb-schedule" class="form-check-input"
                                        onchange="document.querySelector('.schedule-time').style.display = this.checked ? '' : 'none';">
                                    <label class="form-check-label"><span class="fw-bold"
                                            data-lang="Schedule">Schedule</span>.
                                        <span data-lang="Your timezone">Your
                                            timezone</span>: <span class="fw-bolder">+07:00</span></label>
                                </div>

                            </div>
                            <div class="mb-3 schedule-time" style="display: none;">
                                    <label class="form-label" data-lang="Choose time">Choose time</label>
                                <input type="text" id="ipt-schedule-time" class="form-control form-control-solid"
                                    readonly="">

                            </div>
                            <div class="mb-3 loop" style="">
                                <div class="form-check form-switch">
                                    <input type="checkbox" id="cb-loop" class="form-check-input"
                                        onchange="document.querySelector('.loop-quantity').style.display = this.checked ? '' : 'none';document.querySelector('.loop-spacing').style.display = this.checked ? '' : 'none';">
                                    <label class="form-check-label"><span class="fw-bold"
                                            data-lang="Loop">Loop</span>.
                                        <span data-lang="Loop desciption">Auto
                                            Re-order when this order has been <span class="fw-bolder">COMPLETED</span>.
                                            Carefully when to use this
                                            function. Always make sure balance is enough.</span></label>
                                </div>

                            </div>
                            <div class="row g-5">
                                <div class="col-sm-6 loop-quantity" style="display: none;">
                                    <div class="mb-3">
                                        <label for="sl-loop-quantity" class="form-label"
                                            data-lang="Loop quantity">Loop quantity</label>
                                        <select id="sl-loop-quantity" class="form-select form-select-solid">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 loop-spacing" style="display: none;">
                                    <div class="mb-3">
                                        <label for="sl-loop-spacing" class="form-label"
                                            data-lang="Loop spacing (minutes)">Loop spacing (minutes)</label>
                                        <select id="sl-loop-spacing" class="form-select form-select-solid">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="btn-order" class="mt-5 btn btn-primary w-100 text-uppercase"
                                onclick="_new.on.click.order()" data-lang="Submit">Submit order</button>
                            <div class="mt-5 mb-5 alert alert-order alert-normal" style="display: none;"></div>
                            <div class="p-0 pt-5 mb-5 alert alert-order alert-bulk" style="display: none;">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-7 gy-1">
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="text-center alert alert-order alert-confirm bg-light-danger"
                                style="display: none;">
                                <div class="mb-3">
                                    <i class="bi bi-exclamation-circle fs-3tx text-danger"></i>
                                </div>
                                <div class="text-center">
                            <h2 class="mb-3 fw-bold" data-lang="Rate alert">Rate alert</h2>
                                    <div class="mb-3 opacity-25 separator separator-dashed border-danger"></div>
                            <div class="mb-9 text-dark" data-lang="Service prices have increased">Service
                                        prices have increased. Please confirm the new price before ordering</div>
                                    <div class="flex-wrap d-flex flex-center">
                                        <a href="javascript:;" class="m-2 btn btn-danger"
                                data-lang="Button confirm" onclick="_new.on.click.confirmRate()">Ok, I
                                            got it</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="border card">
                        <div class="card-body">
                            <div class="mb-5 text-center div-choose-service">
                                <p class="mb-0 fs-2 fw-bolder text-primary ls-1" id="svc-display-id">—</p>
                                <p class="mb-0 fs-4 fw-semibold" id="svc-display-name">—</p>
                            </div>
                            <div id="advanced-setting" class="mt-2 mb-3" style="display: none;"></div>
                            @if ($data['showAverageTime'] ?? false)
                                <div id="avg-time-container" class="" style="display:none">
                                    <label class="form-label" data-lang="Average time">Average time</label>
                                    <input type="text" id="ipt-average-time" class="form-control form-control-solid"
                                        disabled="">
                                    <small class="form-text text-muted fst-italic"><span
                                            data-lang="Average time description">The average time is
                                            based on 10 latest completed orders per 1000 quantity</span></small>
                                </div>
                            @endif
                            <div class="p-5 mt-3 border border-dashed border-3 div-description" style="">
                                <ol>
                                    <li data-list="bullet"><span class="ql-ui"
                                            contenteditable="false"></span>Recommended quantity to order is 30 50 100 200
                                        300 500 1000</li>
                                    <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>Số lượng
                                        nên đặt hàng là 30 50 100 200 300 500 1000</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-quantity-discount" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="py-4 modal-header">
                        <h4 class="modal-title" data-lang="Special Discount">Special Discount</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table align-middle table-row-dashed fs-7 gy-2">
                                <thead>
                                    <tr class="text-start text-muted bg-light fw-bold fs-7 text-uppercase gs-0">
                                    <th data-lang="Quantity">Quantity</th>
                                    <th data-lang="Discount">Discount</th>
                                    <th data-lang="New rate">New rate</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal UID Alert --}}
            <div class="modal fade" id="modal-uid-msg" tabindex="-1" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered rounded-4">
                    <div class="modal-content">
                        <div class="py-4 text-white modal-header bg-danger">
                            <h4 class="text-white modal-title ls-1" data-lang="message.Alert">Thông báo</h4>
                        </div>
                        <div class="py-10 modal-body fs-4" style="word-break: break-word;"></div>
                        <div class="py-4 text-center modal-footer">
                            <button type="button" class="px-4 btn btn-sm btn-danger rounded-4"
                                data-bs-dismiss="modal">Real</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                var LABEL_FEATURES = [],
                    SERVICES = @json($data['services']);
            </script>
        </div>
        <!--end::Post-->
    </div>

    {{-- Announcement Modal: hiển thị khi NEWS == 0 (user chưa đọc) --}}
    @if ($data['announcement']['showModal'])
        <div class="modal fade" tabindex="-1" id="modal-notification" data-bs-backdrop="static"
            data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-600px">
                <div class="modal-content">
                    <div class="modal-body ql-editor">
                        {!! $data['announcement']['content'] !!}
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal"
                            data-lang="button::Read">Read</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>_new.init();</script>
@endpush

@push('scripts')
    <script>
        (function ($) {
            var platform = $('#sl-platform');
            if (!platform.length || typeof $.fn.select2 !== 'function') return;

            var selected = platform.val();
            if (platform.hasClass('select2-hidden-accessible')) platform.select2('destroy');

            function renderPlatform(option) {
                if (!option.element) return option.text;

                var style = option.element.getAttribute('style') || '';
                if (style.indexOf('display:none') !== -1 || style.indexOf('display: none') !== -1) return null;

                var content = option.element.getAttribute('data-content');
                return content
                    ? $('<span>').attr('title', option.element.getAttribute('title') || option.text).html(content)
                    : option.text;
            }

            platform.select2({
                minimumResultsForSearch: -1,
                templateResult: renderPlatform,
                templateSelection: renderPlatform,
                width: '100%'
            }).val(selected).trigger('change.select2');
        })(jQuery);
    </script>
@endpush

