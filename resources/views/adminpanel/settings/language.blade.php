@extends('adminpanel.layouts.app')
@section('title', 'Settings')
@section('content')
    <div class="content flex-row-fluid" id="kt_content">

        @include('adminpanel.settings.partials.header')

        <div class="d-flex flex-wrap flex-stack mb-6">
            <h3 class="fw-bold my-2" data-lang="Language">Ngôn ngữ</h3>
        </div>

        <div class="row g-6">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <label class="form-label" data-lang="Current language by country">Ngôn ngữ hiện tại theo quốc gia</label>
                        @php
                            $langToFlag = ['vi' => 'vn', 'en' => 'us', 'zh' => 'cn', 'ar' => 'sa', 'ko' => 'kr', 'ja' => 'jp'];
                        @endphp
                        <select id="sl-current-language" class="form-select form-select-solid sl-current-language"
                            data-allow-clear="false" data-hide-search="true">
                            <option value="">Chọn ngôn ngữ</option>
                            @foreach($languages as $lang)
                                @php
                                    // Ưu tiên flag từ DB, fallback về map, rồi dùng code gốc
                                    if (!empty($lang->flag)) {
                                        $iconClass = $lang->flag; // e.g. "fi fi-us"
                                    } else {
                                        $flagCode  = $langToFlag[$lang->code] ?? $lang->code;
                                        $iconClass = 'fi fi-' . $flagCode;
                                    }
                                @endphp
                                <option value="{{ $lang->code }}" data-icon="{{ $iconClass }}">{{ $lang->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <label class="form-label" data-lang="New language by country">Ngôn ngữ mới theo quốc gia</label>
                        <select id="sl-new-language" class="form-select form-select-solid sl-new-language"
                            data-allow-clear="false" data-hide-search="false">
                            <option value="">Chọn ngôn ngữ</option>
                            <option value="af" data-icon="fi fi-af">Afghanistan</option>
                            <option value="al" data-icon="fi fi-al">Albania</option>
                            <option value="dz" data-icon="fi fi-dz">Algeria</option>
                            <option value="as" data-icon="fi fi-as">American Samoa</option>
                            <option value="ad" data-icon="fi fi-ad">Andorra</option>
                            <option value="ao" data-icon="fi fi-ao">Angola</option>
                            <option value="ai" data-icon="fi fi-ai">Anguilla</option>
                            <option value="aq" data-icon="fi fi-aq">Antarctica</option>
                            <option value="ag" data-icon="fi fi-ag">Antigua and Barbuda</option>
                            <option value="ar" data-icon="fi fi-ar">Argentina</option>
                            <option value="am" data-icon="fi fi-am">Armenia</option>
                            <option value="aw" data-icon="fi fi-aw">Aruba</option>
                            <option value="au" data-icon="fi fi-au">Australia</option>
                            <option value="at" data-icon="fi fi-at">Austria</option>
                            <option value="az" data-icon="fi fi-az">Azerbaijan</option>
                            <option value="bs" data-icon="fi fi-bs">Bahamas</option>
                            <option value="bh" data-icon="fi fi-bh">Bahrain</option>
                            <option value="bd" data-icon="fi fi-bd">Bangladesh</option>
                            <option value="bb" data-icon="fi fi-bb">Barbados</option>
                            <option value="by" data-icon="fi fi-by">Belarus</option>
                            <option value="be" data-icon="fi fi-be">Belgium</option>
                            <option value="bz" data-icon="fi fi-bz">Belize</option>
                            <option value="bj" data-icon="fi fi-bj">Benin</option>
                            <option value="bm" data-icon="fi fi-bm">Bermuda</option>
                            <option value="bt" data-icon="fi fi-bt">Bhutan</option>
                            <option value="bo" data-icon="fi fi-bo">Bolivia</option>
                            <option value="ba" data-icon="fi fi-ba">Bosnia and Herzegovina</option>
                            <option value="bw" data-icon="fi fi-bw">Botswana</option>
                            <option value="br" data-icon="fi fi-br">Brazil</option>
                            <option value="io" data-icon="fi fi-io">British Indian Ocean Territory</option>
                            <option value="vg" data-icon="fi fi-vg">British Virgin Islands</option>
                            <option value="bn" data-icon="fi fi-bn">Brunei</option>
                            <option value="bg" data-icon="fi fi-bg">Bulgaria</option>
                            <option value="bf" data-icon="fi fi-bf">Burkina Faso</option>
                            <option value="bi" data-icon="fi fi-bi">Burundi</option>
                            <option value="kh" data-icon="fi fi-kh">Cambodia</option>
                            <option value="cm" data-icon="fi fi-cm">Cameroon</option>
                            <option value="ca" data-icon="fi fi-ca">Canada</option>
                            <option value="cv" data-icon="fi fi-cv">Cape Verde</option>
                            <option value="ky" data-icon="fi fi-ky">Cayman Islands</option>
                            <option value="cf" data-icon="fi fi-cf">Central African Republic</option>
                            <option value="td" data-icon="fi fi-td">Chad</option>
                            <option value="cl" data-icon="fi fi-cl">Chile</option>
                            <option value="cn" data-icon="fi fi-cn">China</option>
                            <option value="cx" data-icon="fi fi-cx">Christmas Island</option>
                            <option value="cc" data-icon="fi fi-cc">Cocos Islands</option>
                            <option value="co" data-icon="fi fi-co">Colombia</option>
                            <option value="km" data-icon="fi fi-km">Comoros</option>
                            <option value="ck" data-icon="fi fi-ck">Cook Islands</option>
                            <option value="cr" data-icon="fi fi-cr">Costa Rica</option>
                            <option value="hr" data-icon="fi fi-hr">Croatia</option>
                            <option value="cu" data-icon="fi fi-cu">Cuba</option>
                            <option value="cw" data-icon="fi fi-cw">Curacao</option>
                            <option value="cy" data-icon="fi fi-cy">Cyprus</option>
                            <option value="cz" data-icon="fi fi-cz">Czech Republic</option>
                            <option value="cd" data-icon="fi fi-cd">Democratic Republic of the Congo</option>
                            <option value="dk" data-icon="fi fi-dk">Denmark</option>
                            <option value="dj" data-icon="fi fi-dj">Djibouti</option>
                            <option value="dm" data-icon="fi fi-dm">Dominica</option>
                            <option value="do" data-icon="fi fi-do">Dominican Republic</option>
                            <option value="tl" data-icon="fi fi-tl">East Timor</option>
                            <option value="ec" data-icon="fi fi-ec">Ecuador</option>
                            <option value="eg" data-icon="fi fi-eg">Egypt</option>
                            <option value="sv" data-icon="fi fi-sv">El Salvador</option>
                            <option value="gq" data-icon="fi fi-gq">Equatorial Guinea</option>
                            <option value="er" data-icon="fi fi-er">Eritrea</option>
                            <option value="ee" data-icon="fi fi-ee">Estonia</option>
                            <option value="et" data-icon="fi fi-et">Ethiopia</option>
                            <option value="fk" data-icon="fi fi-fk">Falkland Islands</option>
                            <option value="fo" data-icon="fi fi-fo">Faroe Islands</option>
                            <option value="fj" data-icon="fi fi-fj">Fiji</option>
                            <option value="fi" data-icon="fi fi-fi">Finland</option>
                            <option value="fr" data-icon="fi fi-fr">France</option>
                            <option value="pf" data-icon="fi fi-pf">French Polynesia</option>
                            <option value="ga" data-icon="fi fi-ga">Gabon</option>
                            <option value="gm" data-icon="fi fi-gm">Gambia</option>
                            <option value="ge" data-icon="fi fi-ge">Georgia</option>
                            <option value="de" data-icon="fi fi-de">Germany</option>
                            <option value="gh" data-icon="fi fi-gh">Ghana</option>
                            <option value="gi" data-icon="fi fi-gi">Gibraltar</option>
                            <option value="gr" data-icon="fi fi-gr">Greece</option>
                            <option value="gl" data-icon="fi fi-gl">Greenland</option>
                            <option value="gd" data-icon="fi fi-gd">Grenada</option>
                            <option value="gu" data-icon="fi fi-gu">Guam</option>
                            <option value="gt" data-icon="fi fi-gt">Guatemala</option>
                            <option value="gg" data-icon="fi fi-gg">Guernsey</option>
                            <option value="gn" data-icon="fi fi-gn">Guinea</option>
                            <option value="gw" data-icon="fi fi-gw">Guinea-Bissau</option>
                            <option value="gy" data-icon="fi fi-gy">Guyana</option>
                            <option value="ht" data-icon="fi fi-ht">Haiti</option>
                            <option value="hn" data-icon="fi fi-hn">Honduras</option>
                            <option value="hk" data-icon="fi fi-hk">Hong Kong</option>
                            <option value="hu" data-icon="fi fi-hu">Hungary</option>
                            <option value="is" data-icon="fi fi-is">Iceland</option>
                            <option value="in" data-icon="fi fi-in">India</option>
                            <option value="id" data-icon="fi fi-id">Indonesia</option>
                            <option value="ir" data-icon="fi fi-ir">Iran</option>
                            <option value="iq" data-icon="fi fi-iq">Iraq</option>
                            <option value="ie" data-icon="fi fi-ie">Ireland</option>
                            <option value="im" data-icon="fi fi-im">Isle of Man</option>
                            <option value="il" data-icon="fi fi-il">Israel</option>
                            <option value="it" data-icon="fi fi-it">Italy</option>
                            <option value="ci" data-icon="fi fi-ci">Ivory Coast</option>
                            <option value="jm" data-icon="fi fi-jm">Jamaica</option>
                            <option value="jp" data-icon="fi fi-jp">Japan</option>
                            <option value="je" data-icon="fi fi-je">Jersey</option>
                            <option value="jo" data-icon="fi fi-jo">Jordan</option>
                            <option value="kz" data-icon="fi fi-kz">Kazakhstan</option>
                            <option value="ke" data-icon="fi fi-ke">Kenya</option>
                            <option value="ki" data-icon="fi fi-ki">Kiribati</option>
                            <option value="xk" data-icon="fi fi-xk">Kosovo</option>
                            <option value="kw" data-icon="fi fi-kw">Kuwait</option>
                            <option value="kg" data-icon="fi fi-kg">Kyrgyzstan</option>
                            <option value="la" data-icon="fi fi-la">Laos</option>
                            <option value="lv" data-icon="fi fi-lv">Latvia</option>
                            <option value="lb" data-icon="fi fi-lb">Lebanon</option>
                            <option value="ls" data-icon="fi fi-ls">Lesotho</option>
                            <option value="lr" data-icon="fi fi-lr">Liberia</option>
                            <option value="ly" data-icon="fi fi-ly">Libya</option>
                            <option value="li" data-icon="fi fi-li">Liechtenstein</option>
                            <option value="lt" data-icon="fi fi-lt">Lithuania</option>
                            <option value="lu" data-icon="fi fi-lu">Luxembourg</option>
                            <option value="mo" data-icon="fi fi-mo">Macau</option>
                            <option value="mk" data-icon="fi fi-mk">Macedonia</option>
                            <option value="mg" data-icon="fi fi-mg">Madagascar</option>
                            <option value="mw" data-icon="fi fi-mw">Malawi</option>
                            <option value="my" data-icon="fi fi-my">Malaysia</option>
                            <option value="mv" data-icon="fi fi-mv">Maldives</option>
                            <option value="ml" data-icon="fi fi-ml">Mali</option>
                            <option value="mt" data-icon="fi fi-mt">Malta</option>
                            <option value="mh" data-icon="fi fi-mh">Marshall Islands</option>
                            <option value="mr" data-icon="fi fi-mr">Mauritania</option>
                            <option value="mu" data-icon="fi fi-mu">Mauritius</option>
                            <option value="yt" data-icon="fi fi-yt">Mayotte</option>
                            <option value="mx" data-icon="fi fi-mx">Mexico</option>
                            <option value="fm" data-icon="fi fi-fm">Micronesia</option>
                            <option value="md" data-icon="fi fi-md">Moldova</option>
                            <option value="mc" data-icon="fi fi-mc">Monaco</option>
                            <option value="mn" data-icon="fi fi-mn">Mongolia</option>
                            <option value="me" data-icon="fi fi-me">Montenegro</option>
                            <option value="ms" data-icon="fi fi-ms">Montserrat</option>
                            <option value="ma" data-icon="fi fi-ma">Morocco</option>
                            <option value="mz" data-icon="fi fi-mz">Mozambique</option>
                            <option value="mm" data-icon="fi fi-mm">Myanmar</option>
                            <option value="na" data-icon="fi fi-na">Namibia</option>
                            <option value="nr" data-icon="fi fi-nr">Nauru</option>
                            <option value="np" data-icon="fi fi-np">Nepal</option>
                            <option value="nl" data-icon="fi fi-nl">Netherlands</option>
                            <option value="an" data-icon="fi fi-an">Netherlands Antilles</option>
                            <option value="nc" data-icon="fi fi-nc">New Caledonia</option>
                            <option value="nz" data-icon="fi fi-nz">New Zealand</option>
                            <option value="ni" data-icon="fi fi-ni">Nicaragua</option>
                            <option value="ne" data-icon="fi fi-ne">Niger</option>
                            <option value="ng" data-icon="fi fi-ng">Nigeria</option>
                            <option value="nu" data-icon="fi fi-nu">Niue</option>
                            <option value="kp" data-icon="fi fi-kp">North Korea</option>
                            <option value="mp" data-icon="fi fi-mp">Northern Mariana Islands</option>
                            <option value="no" data-icon="fi fi-no">Norway</option>
                            <option value="om" data-icon="fi fi-om">Oman</option>
                            <option value="pk" data-icon="fi fi-pk">Pakistan</option>
                            <option value="pw" data-icon="fi fi-pw">Palau</option>
                            <option value="ps" data-icon="fi fi-ps">Palestine</option>
                            <option value="pa" data-icon="fi fi-pa">Panama</option>
                            <option value="pg" data-icon="fi fi-pg">Papua New Guinea</option>
                            <option value="py" data-icon="fi fi-py">Paraguay</option>
                            <option value="pe" data-icon="fi fi-pe">Peru</option>
                            <option value="ph" data-icon="fi fi-ph">Philippines</option>
                            <option value="pn" data-icon="fi fi-pn">Pitcairn</option>
                            <option value="pl" data-icon="fi fi-pl">Poland</option>
                            <option value="pt" data-icon="fi fi-pt">Portugal</option>
                            <option value="qa" data-icon="fi fi-qa">Qatar</option>
                            <option value="cg" data-icon="fi fi-cg">Republic of the Congo</option>
                            <option value="re" data-icon="fi fi-re">Reunion</option>
                            <option value="ro" data-icon="fi fi-ro">Romania</option>
                            <option value="ru" data-icon="fi fi-ru">Russia</option>
                            <option value="rw" data-icon="fi fi-rw">Rwanda</option>
                            <option value="bl" data-icon="fi fi-bl">Saint Barthelemy</option>
                            <option value="sh" data-icon="fi fi-sh">Saint Helena</option>
                            <option value="kn" data-icon="fi fi-kn">Saint Kitts and Nevis</option>
                            <option value="lc" data-icon="fi fi-lc">Saint Lucia</option>
                            <option value="mf" data-icon="fi fi-mf">Saint Martin</option>
                            <option value="pm" data-icon="fi fi-pm">Saint Pierre and Miquelon</option>
                            <option value="vc" data-icon="fi fi-vc">Saint Vincent and the Grenadines</option>
                            <option value="ws" data-icon="fi fi-ws">Samoa</option>
                            <option value="sm" data-icon="fi fi-sm">San Marino</option>
                            <option value="st" data-icon="fi fi-st">Sao Tome and Principe</option>
                            <option value="sa" data-icon="fi fi-sa">Saudi Arabia</option>
                            <option value="sn" data-icon="fi fi-sn">Senegal</option>
                            <option value="rs" data-icon="fi fi-rs">Serbia</option>
                            <option value="sc" data-icon="fi fi-sc">Seychelles</option>
                            <option value="sl" data-icon="fi fi-sl">Sierra Leone</option>
                            <option value="sg" data-icon="fi fi-sg">Singapore</option>
                            <option value="sx" data-icon="fi fi-sx">Sint Maarten</option>
                            <option value="sk" data-icon="fi fi-sk">Slovakia</option>
                            <option value="si" data-icon="fi fi-si">Slovenia</option>
                            <option value="sb" data-icon="fi fi-sb">Solomon Islands</option>
                            <option value="so" data-icon="fi fi-so">Somalia</option>
                            <option value="za" data-icon="fi fi-za">South Africa</option>
                            <option value="kr" data-icon="fi fi-kr">South Korea</option>
                            <option value="ss" data-icon="fi fi-ss">South Sudan</option>
                            <option value="es" data-icon="fi fi-es">Spain</option>
                            <option value="lk" data-icon="fi fi-lk">Sri Lanka</option>
                            <option value="sd" data-icon="fi fi-sd">Sudan</option>
                            <option value="sr" data-icon="fi fi-sr">Suriname</option>
                            <option value="sj" data-icon="fi fi-sj">Svalbard and Jan Mayen</option>
                            <option value="sz" data-icon="fi fi-sz">Swaziland</option>
                            <option value="se" data-icon="fi fi-se">Sweden</option>
                            <option value="ch" data-icon="fi fi-ch">Switzerland</option>
                            <option value="sy" data-icon="fi fi-sy">Syria</option>
                            <option value="tw" data-icon="fi fi-tw">Taiwan</option>
                            <option value="tj" data-icon="fi fi-tj">Tajikistan</option>
                            <option value="tz" data-icon="fi fi-tz">Tanzania</option>
                            <option value="th" data-icon="fi fi-th">Thailand</option>
                            <option value="tg" data-icon="fi fi-tg">Togo</option>
                            <option value="tk" data-icon="fi fi-tk">Tokelau</option>
                            <option value="to" data-icon="fi fi-to">Tonga</option>
                            <option value="tt" data-icon="fi fi-tt">Trinidad and Tobago</option>
                            <option value="tn" data-icon="fi fi-tn">Tunisia</option>
                            <option value="tr" data-icon="fi fi-tr">Turkey</option>
                            <option value="tm" data-icon="fi fi-tm">Turkmenistan</option>
                            <option value="tc" data-icon="fi fi-tc">Turks and Caicos Islands</option>
                            <option value="tv" data-icon="fi fi-tv">Tuvalu</option>
                            <option value="vi" data-icon="fi fi-vi">U.S. Virgin Islands</option>
                            <option value="ug" data-icon="fi fi-ug">Uganda</option>
                            <option value="ua" data-icon="fi fi-ua">Ukraine</option>
                            <option value="ae" data-icon="fi fi-ae">United Arab Emirates</option>
                            <option value="gb" data-icon="fi fi-gb">United Kingdom</option>
                            <option value="uy" data-icon="fi fi-uy">Uruguay</option>
                            <option value="uz" data-icon="fi fi-uz">Uzbekistan</option>
                            <option value="vu" data-icon="fi fi-vu">Vanuatu</option>
                            <option value="va" data-icon="fi fi-va">Vatican</option>
                            <option value="ve" data-icon="fi fi-ve">Venezuela</option>
                            <option value="wf" data-icon="fi fi-wf">Wallis and Futuna</option>
                            <option value="eh" data-icon="fi fi-eh">Western Sahara</option>
                            <option value="ye" data-icon="fi fi-ye">Yemen</option>
                            <option value="zm" data-icon="fi fi-zm">Zambia</option>
                            <option value="zw" data-icon="fi fi-zw">Zimbabwe</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 div-language" style="display: none">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <div class="card-toolbar">
                            <div class="div-button div-button-0">
                                <button type="button" class="btn btn-primary btn-sm me-2"
                                    onclick="_lang.save(document.querySelector('.sl-current-language').value)"
                                    data-lang="button::Update">Cập nhật</button>
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="_lang.confirmDelete(document.querySelector('.sl-current-language').value)"
                                    data-lang="button::Delete">Xóa</button>
                            </div>
                            <div class="div-button div-button-1">
                                <button type="button" class="btn btn-primary btn-sm"
                                    onclick="_lang.save(document.querySelector('.sl-new-language').value)"
                                    data-lang="button::Save as New">Lưu bản mới</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle gs-5 gy-1 table-language"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal xác nhận xóa --}}
    <div class="modal fade" id="modal-lang-delete" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning py-4">
                    <h4 class="modal-title text-white">Xác nhận</h4>
                </div>
                <div class="modal-body py-10 fs-4" id="modal-lang-delete-body"></div>
                <div class="modal-footer py-4">
                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-sm btn-warning px-4" id="btn-lang-delete-ok">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const _lang = (() => {
            const LOAD_URL = '{{ route("admin.settings.language.load", ":code") }}';
            const SAVE_URL = '{{ route("admin.settings.language.save") }}';
            const DEL_URL  = '{{ route("admin.settings.language.delete", ":code") }}';
            const CSRF     = '{{ csrf_token() }}';

            let $divLang, $btnGrp0, $btnGrp1, $title, $table, modal, _delCode;

            function init() {
                $divLang = document.querySelector('.div-language');
                $btnGrp0 = document.querySelector('.div-button-0');
                $btnGrp1 = document.querySelector('.div-button-1');
                $title   = document.querySelector('.div-language .card-title');
                $table   = document.querySelector('.table-language');

                const el = document.getElementById('modal-lang-delete');
                if (el) modal = new bootstrap.Modal(el, { backdrop: 'static' });

                document.getElementById('btn-lang-delete-ok').addEventListener('click', () => {
                    if (modal) modal.hide();
                    doDelete(_delCode);
                });
            }

            function getLabel(selectId, code) {
                const $sel = jQuery('#' + selectId);
                return {
                    name: $sel.find('option[value="' + code + '"]').text().trim(),
                    icon: $sel.find('option[value="' + code + '"]').data('icon') || ''
                };
            }

            function renderTable(data) {
                const groups = {};
                Object.keys(data).forEach(key => {
                    const dot = key.indexOf('.'), dbl = key.indexOf('::');
                    let sep = -1;
                    if (dot !== -1 && dbl !== -1) sep = Math.min(dot, dbl);
                    else if (dot !== -1) sep = dot;
                    else if (dbl !== -1) sep = dbl;
                    const g = sep !== -1 ? key.substring(0, sep) : 'other';
                    if (!groups[g]) groups[g] = [];
                    groups[g].push({ key, value: data[key] });
                });

                let html = '';
                Object.keys(groups).forEach(g => {
                    html += `<tbody><tr><td colspan="2" class="bg-light"><h4 class="fst-italic mb-0">${g}</h4></td></tr>`;
                    groups[g].forEach(item => {
                        if (typeof item.value === 'object') return;
                        const v = String(item.value).replace(/"/g, '&quot;');
                        html += `<tr>
                            <td><span class="ms-5 text-muted fs-7">${item.key}</span></td>
                            <td><input type="text" class="form-control form-control-solid form-control-sm"
                                data-key="${item.key}" value="${v}" placeholder="${v}"></td>
                        </tr>`;
                    });
                    html += '</tbody>';
                });
                return html;
            }

            function collectData() {
                const data = {};
                $table.querySelectorAll('input[data-key]').forEach(el => {
                    data[el.dataset.key] = el.value;
                });
                return data;
            }

            function showPanel(code, selectId, isNew) {
                if (!code) { $divLang.style.display = 'none'; return; }
                const lbl = getLabel(selectId, code);
                showFullScreenLoader();
                fetch(LOAD_URL.replace(':code', code), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(result => {
                    hideFullScreenLoader();
                    if (!result.success) { showToast('Có lỗi xảy ra khi tải dữ liệu', 'error'); return; }
                    $title.innerHTML = lbl.icon ? `<span class="${lbl.icon} me-2"></span>${lbl.name}` : lbl.name;
                    $table.innerHTML = renderTable(result.data);
                    $divLang.style.display = '';
                    $btnGrp0.style.display = isNew ? 'none' : '';
                    $btnGrp1.style.display = isNew ? '' : 'none';
                    $divLang.scrollIntoView({ behavior: 'smooth', block: 'start' });
                })
                .catch(() => { hideFullScreenLoader(); showToast('Có lỗi xảy ra khi tải dữ liệu', 'error'); });
            }

            function save(code) {
                if (!code) { showToast('Vui lòng chọn ngôn ngữ', 'warning'); return; }
                const isNew = $btnGrp1.style.display !== 'none';
                const lbl   = getLabel(isNew ? 'sl-new-language' : 'sl-current-language', code);
                showFullScreenLoader();
                fetch(SAVE_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                    body: JSON.stringify({ code, name: lbl.name, flag: lbl.icon, data: collectData() })
                })
                .then(r => r.json())
                .then(result => {
                    hideFullScreenLoader();
                    if (result.success) {
                        showToast('Lưu ngôn ngữ thành công', 'success');
                        if (isNew) {
                            // Thêm option vào select "Ngôn ngữ hiện tại"
                            const $cur = jQuery('#sl-current-language');
                            if ($cur.find('option[value="' + code + '"]').length === 0) {
                                const newOption = new Option(lbl.name, code, false, false);
                                $(newOption).attr('data-icon', lbl.icon);
                                $cur.append(newOption).trigger('change.select2');
                            }

                            // Reset cả 2 select về trạng thái ban đầu
                            jQuery('#sl-new-language').val('').trigger('change.select2');
                            jQuery('#sl-current-language').val('').trigger('change.select2');

                            // Ẩn panel
                            $divLang.style.display = 'none';
                        }
                    } else {
                        showToast('Có lỗi xảy ra khi lưu', 'error');
                    }
                })
                .catch(() => { hideFullScreenLoader(); showToast('Có lỗi xảy ra khi lưu', 'error'); });
            }

            function confirmDelete(code) {
                if (!code) return;
                _delCode = code;
                const lbl = getLabel('sl-current-language', code);
                document.getElementById('modal-lang-delete-body').innerHTML =
                    `Bạn có chắc muốn xóa ngôn ngữ <strong>${lbl.name}</strong>?<br>
                    <span class="text-muted fs-6">Hành động này không thể hoàn tác.</span>`;
                if (modal) modal.show();
            }

            function doDelete(code) {
                if (!code) return;
                showFullScreenLoader();
                fetch(DEL_URL.replace(':code', code), {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(result => {
                    hideFullScreenLoader();
                    if (result.success) {
                        showToast('Xóa ngôn ngữ thành công', 'success');
                        setTimeout(() => location.reload(), 1200);
                    } else {
                        showToast('Có lỗi xảy ra khi xóa', 'error');
                    }
                })
                .catch(() => { hideFullScreenLoader(); showToast('Có lỗi xảy ra khi xóa', 'error'); });
            }

            function formatSelect(item) {
                if (!item.id) return item.text;
                const icon = $(item.element).data('icon') || '';
                return $(`<span>${icon ? `<span class="${icon} me-2"></span>` : ''}${item.text}</span>`);
            }

            document.addEventListener('DOMContentLoaded', () => {
                init();

                if (window.jQuery && window.jQuery.fn.select2) {
                    jQuery('#sl-current-language').select2({
                        templateResult: formatSelect, templateSelection: formatSelect,
                        allowClear: false, minimumResultsForSearch: Infinity,
                        width: '100%', escapeMarkup: m => m
                    }).on('change', function () { showPanel(this.value, 'sl-current-language', false); });

                    jQuery('#sl-new-language').select2({
                        templateResult: formatSelect, templateSelection: formatSelect,
                        allowClear: false, minimumResultsForSearch: 0,
                        width: '100%', escapeMarkup: m => m
                    }).on('change', function () { showPanel(this.value, 'sl-new-language', true); });
                }
            });

            return { save, confirmDelete };
        })();

        // Backward compat
        var _settings = _settings || {};
        _settings.on = { click: { saveLanguage: _lang.save, deleteLanguage: _lang.confirmDelete }, change: {} };
    </script>
@endsection


