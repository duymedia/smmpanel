@extends('admin.layouts.app')
@section('title', 'Edit products')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
   <span class="title d-none">Edit</span>
   <div class="card shadow-sm mb-5 div-product">
      <div class="card-body">
         <div class="row g-5 mb-5 ">
            <div class="col-lg-2">
               <label class="required form-label" data-lang="">Dạng kết nối</label>
               <select class="form-select form-select-solid sl-product-add-type" data-kt-select2="true" data-hide-search="true" onchange="_products.on.change.addType(this.value)">
                  <option value="Manual" data-lang="">Thủ công</option>
                  <option value="Api">API</option>
               </select>
            </div>
            <div class="col-lg-10">
               <div class="row g-6 div-add-type div-add-type-api" style="display: none;">
                  <div class="col-lg-3">
                     <div class="div-type-api">
                        <label class="required form-label" data-page="/services" data-lang="">Nhà cung cấp</label>
                        <select class="form-select form-select-solid sl-provider" data-control="select2" data-placeholder="Chọn" onchange="_products.on.change.provider(this.value)">
                           <option></option>
                           <option value="74" data-rate="1" data-fixed-decimal="10">smmrio.com</option>
                           <option value="73" data-rate="1" data-fixed-decimal="10">180.93.37.176</option>
                           <option value="72" data-rate="1" data-fixed-decimal="4">fbfollows.net</option>
                           <option value="71" data-rate="1" data-fixed-decimal="3">g1618.com</option>
                           <option value="70" data-rate="1" data-fixed-decimal="10">smmasia.org</option>
                           <option value="69" data-rate="26" data-fixed-decimal="10">smmzone.vn</option>
                           <option value="68" data-rate="1" data-fixed-decimal="10">smmkay.com</option>
                           <option value="67" data-rate="1" data-fixed-decimal="10">daosmm.com</option>
                           <option value="66" data-rate="1" data-fixed-decimal="10">naplike.com</option>
                           <option value="65" data-rate="1" data-fixed-decimal="3">api.mysmm.vn</option>
                           <option value="64" data-rate="1" data-fixed-decimal="10">smmadb</option>
                           <option value="63" data-rate="1" data-fixed-decimal="4">apiv2.smm79.com</option>
                           <option value="62" data-rate="26500" data-fixed-decimal="10">tuongtacre.site</option>
                           <option value="61" data-rate="1" data-fixed-decimal="10">smm.baostar.net</option>
                           <option value="60" data-rate="1" data-fixed-decimal="10">smmasia.net</option>
                           <option value="59" data-rate="1" data-fixed-decimal="10">smmapir.com</option>
                           <option value="58" data-rate="1" data-fixed-decimal="10">apismmprovider.com</option>
                           <option value="57" data-rate="1" data-fixed-decimal="10">caspersmm.com</option>
                           <option value="56" data-rate="1" data-fixed-decimal="10">mainsmmbd.com</option>
                           <option value="55" data-rate="1" data-fixed-decimal="10">mualike.biz</option>
                           <option value="54" data-rate="1" data-fixed-decimal="10">smmseo.net</option>
                           <option value="53" data-rate="1" data-fixed-decimal="10">socialmedia.vn</option>
                           <option value="52" data-rate="1" data-fixed-decimal="4">liketrusted.com</option>
                           <option value="51" data-rate="1" data-fixed-decimal="10">smmko.com</option>
                           <option value="50" data-rate="1" data-fixed-decimal="10">likefbsieure.com</option>
                           <option value="49" data-rate="27000" data-fixed-decimal="4">api.subvip.top</option>
                           <option value="48" data-rate="27000" data-fixed-decimal="10">tuongtaccheo.com</option>
                           <option value="47" data-rate="1" data-fixed-decimal="10">smmhoster.com</option>
                           <option value="46" data-rate="1" data-fixed-decimal="10">tikprovider.com</option>
                           <option value="45" data-rate="28000" data-fixed-decimal="10">api.minsocial.vn</option>
                           <option value="44" data-rate="1" data-fixed-decimal="10">alosmm.com</option>
                           <option value="43" data-rate="1" data-fixed-decimal="10">2mediaking.world</option>
                           <option value="42" data-rate="1" data-fixed-decimal="10">api.tuongtac.pro</option>
                           <option value="41" data-rate="1" data-fixed-decimal="10">smmaudience.com</option>
                           <option value="40" data-rate="1" data-fixed-decimal="10">smmgen.com</option>
                           <option value="39" data-rate="1" data-fixed-decimal="10">techsmm.com</option>
                           <option value="38" data-rate="1" data-fixed-decimal="10">lastprovider.com</option>
                           <option value="37" data-rate="1" data-fixed-decimal="10">smmcora.org</option>
                           <option value="36" data-rate="1" data-fixed-decimal="10">bdsmmpanel.com</option>
                           <option value="35" data-rate="1" data-fixed-decimal="10">viieagency.com</option>
                           <option value="34" data-rate="1" data-fixed-decimal="10">n4socialmediaservice.com</option>
                           <option value="33" data-rate="1" data-fixed-decimal="3">smmaz.net</option>
                           <option value="32" data-rate="1" data-fixed-decimal="3">api.baostar.pro</option>
                           <option value="31" data-rate="1" data-fixed-decimal="3">dnoxsmm.com</option>
                           <option value="30" data-rate="1" data-fixed-decimal="3">sharegiare.xyz</option>
                           <option value="29" data-rate="1" data-fixed-decimal="3">smmsale.vn</option>
                           <option value="28" data-rate="1" data-fixed-decimal="3">mxh2ms.com</option>
                           <option value="27" data-rate="1" data-fixed-decimal="10">autolikez.com</option>
                           <option value="26" data-rate="1" data-fixed-decimal="3">likenhanh.pro</option>
                           <option value="25" data-rate="1" data-fixed-decimal="10">cheotuongtac.com</option>
                           <option value="24" data-rate="1" data-fixed-decimal="4">smmking.vip</option>
                           <option value="23" data-rate="1" data-fixed-decimal="10">sub6sao.com</option>
                           <option value="22" data-rate="1" data-fixed-decimal="10">iamprovider.com</option>
                           <option value="21" data-rate="1" data-fixed-decimal="10">smmbind.com</option>
                           <option value="20" data-rate="1" data-fixed-decimal="10">stablesmp.com</option>
                           <option value="19" data-rate="1" data-fixed-decimal="10">ridesmm.com</option>
                           <option value="18" data-rate="1" data-fixed-decimal="10">emsocialbooster.com</option>
                           <option value="17" data-rate="1" data-fixed-decimal="10">api.topclick.vn</option>
                           <option value="16" data-rate="1" data-fixed-decimal="10">api.at88.vn</option>
                           <option value="15" data-rate="1" data-fixed-decimal="3">boosterviews.com</option>
                           <option value="14" data-rate="1" data-fixed-decimal="10">addsmm.com</option>
                           <option value="13" data-rate="1" data-fixed-decimal="10">smm1s.com</option>
                           <option value="12" data-rate="1" data-fixed-decimal="10">subrevlvay.top</option>
                           <option value="11" data-rate="1" data-fixed-decimal="10">app.subme.vn</option>
                           <option value="10" data-rate="1" data-fixed-decimal="10">qualitypanel.org</option>
                           <option value="9" data-rate="1" data-fixed-decimal="10">lionfollow.com</option>
                           <option value="8" data-rate="1" data-fixed-decimal="10">new97.net</option>
                           <option value="7" data-rate="1" data-fixed-decimal="10">smmcost.com</option>
                           <option value="6" data-rate="1" data-fixed-decimal="10">safollow.com</option>
                           <option value="5" data-rate="1" data-fixed-decimal="10">1dg.me</option>
                           <option value="4" data-rate="1" data-fixed-decimal="10">attpanel.com</option>
                           <option value="3" data-rate="1" data-fixed-decimal="10">smmjob.com</option>
                           <option value="2" data-rate="1" data-fixed-decimal="3">smmtrusted.com</option>
                           <option value="1" data-rate="1" data-fixed-decimal="10">smmcoder.com</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-lg-9">
                     <div class="div-type-api"></div>
                  </div>
               </div>
               <div class="div-add-type div-add-type-manual div-cost-price" style="">
                  <label class="required form-label" data-lang="">Giá vốn</label>
                  <input type="number" class="form-control form-control-solid ipt-cost-price" onkeyup="_products.on.keyup.costPrice(this.value)">
               </div>
            </div>
            <div class="col-lg-12">
               <label class="required form-label" data-lang="">Trạng thái</label>
               <select class="form-select form-select-solid sl-status">
                  <option value="In stock" data-lang="">Còn hàng</option>
                  <option value="Out of stock" data-lang="">Hết hàng</option>
                  <option value="Inactive" data-lang="">Vô hiệu hóa</option>
               </select>
            </div>
         </div>
         <div class="row g-5">
            <div class="col-lg-12">
               <div class="mb-5">
                  <label class="required form-label" data-page="/categories" data-lang="">Tên</label>
                  <input type="text" class="form-control form-control-solid ipt-name">
               </div>
               <div class="mb-5 ">
                  <label class="required form-label" data-lang="">Slug</label>
                  <div class="input-group">
                     <input type="text" class="form-control form-control-soli ipt-slug" disabled="disabled">
                     <span class="input-group-text pointer" onclick="_products.on.click.editSlug()"><i class="fas fa-pencil"></i></span>
                  </div>
               </div>
            </div>
         </div>
         <div class="row g-5 ">
            <div class="col-lg-12">
               <div class="mb-5">
                  <label class="required form-label" data-page="/services" data-lang="">Danh mục</label>
                  <select class="form-select form-select-solid sl-category" data-control="select2" data-placeholder="Chọn">
                     <option></option>
                     @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="row">
                  <div class="col-lg-6">
                     <div class="mb-5">
                        <label class="form-label" data-lang="">Nhóm</label>
                        <select class="form-select form-select-solid sl-group" data-control="select2" onchange="document.querySelector('.div-group').style.display = this.value &gt; 0 ? '' : 'none';">
                           <option value="0">Không có nhóm</option>
                           @foreach($groups as $group)
                              <option value="{{ $group->id }}">{{ $group->id }} - {{ $group->name }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="mb-5 div-group" style="display: none;">
                        <label class="form-label" data-lang="">Tên nhãn</label>
                        <input type="text" class="form-control form-control-solid ipt-group-tag">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row g-5">
            <div class="col-lg-12">
               <div class="mb-5">
                  <label class="form-label"><span data-lang="">Hình ảnh</span> (460x215)</label>
                  <input type="text" class="form-control form-control-solid ipt-thumbnail" placeholder="Link hình ảnh" onkeyup="document.querySelector('.img-thumbnail').src = this.value" data-lang="Image link">
                  <span class="text-muted fst-italic"><span data-lang="">Hình ảnh tham khảo</span>: <a href="https://cdn.whoispanel.com/product_thumbnail/" target="_blank" data-lang="">Truy cập</a></span>
               </div>
               <div class="border border-2 border-dashed rounded-3 bg-light p-3 shadow-sm" style="max-width: 300px;">
                  <div class="d-flex align-items-center justify-content-center bg-white rounded-2 overflow-hidden" style="height: 180px;">
                     <img alt="" src="{{ $product->thumbnail ?: 'https://cdn.pixabay.com/photo/2021/01/05/06/40/icon-5889010_640.png' }}"
                        class="img-thumbnail w-100 h-100 p-0 border-0 object-fit-contain"
                        alt="{{ $product->name }}"
                        onerror="this.onerror=null;this.src='https://cdn.pixabay.com/photo/2021/01/05/06/40/icon-5889010_640.png';">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="card shadow-sm mb-5 card-sync">
      <div class="card-header div-add-type div-add-type-api" style="display: none;">
         <div class="card-title">
            <div class="form-check form-switch form-check-custom form-check-solid">
               <input class="form-check-input cb-product-sync" type="checkbox" onchange="_products.on.change.syncprice(this.checked)" disabled="disabled">
               <label class="form-check-label fs-3 fw-bold" data-lang="">Tự động đồng bộ</label>
            </div>
         </div>
      </div>
      <div class="card-body">
         <div class="row g-5 mb-5">
            <div class="col-lg-4">
               <label class="required form-label"><span data-page="/products" data-lang="Retail Rate">Giá bán lẻ</span> | <span class="form-text text-muted"></span></label>
               <div class="input-group input-group-solid">
                  <span class="input-group-text bg-secondary">$</span>
                  <input type="text" class="form-control ipt-product-price">
                  <input type="text" class="form-control border border-2 float-end text-end ipt-product-price-percent" value="110.00" onkeyup="_products.on.keyup.price_percent(this.value)" data-inputmask="'mask': '9{1,4}.9{1,2}', 'greedy': false, 'placeholder': '0'" inputmode="text">
                  <span class="input-group-text bg-secondary">%</span>
                  <input type="number" class="form-control ipt-product-cost-price d-none">
               </div>
            </div>
            <div class="col-lg-4">
               <label class="required form-label" data-page="/services" data-lang="Wholesale Rate - Child">Giá đại lý</label>
               <div class="input-group input-group-solid">
                  <span class="input-group-text bg-secondary">$</span>
                  <input type="number" class="form-control ipt-product-price-1">
                  <input type="text" class="form-control border border-2 float-end text-end ipt-product-price-1-percent" value="108.00" onkeyup="_products.on.keyup.price_percent(this.value)" data-inputmask="'mask': '9{1,4}.9{1,2}', 'greedy': false, 'placeholder': '0'" inputmode="text">
                  <span class="input-group-text bg-secondary">%</span>
               </div>
            </div>
            <div class="col-lg-4">
               <label class="required form-label" data-page="/services" data-lang="Wholesale Rate - Reseller">Giá nhà phân phối</label>
               <div class="input-group input-group-solid">
                  <span class="input-group-text bg-secondary">$</span>
                  <input type="number" class="form-control ipt-product-price-2">
                  <input type="text" class="form-control border border-2 float-end text-end ipt-product-price-2-percent" value="105.00" onkeyup="_products.on.keyup.price_percent(this.value)" data-inputmask="'mask': '9{1,4}.9{1,2}', 'greedy': false, 'placeholder': '0'" inputmode="text">
                  <span class="input-group-text bg-secondary">%</span>
               </div>
            </div>
         </div>
         <div class="row g-5">
            <div class="col-lg-12">
               <div class="">
                  <label class="required form-label"><span data-page="/services" data-lang="Min/Max">SL đặt hàng: Tối thiếu-Tối đa</span> | <span class="form-text text-muted"></span></label>
                  <div class="input-group input-group-solid">
                     <input type="text" class="form-control ipt-product-min" data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false" value="1" inputmode="text">
                     <span class="input-group-text bg-secondary">-</span>
                     <input type="text" class="form-control ipt-product-max" data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false" value="1" inputmode="text">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="card shadow-sm mb-5 div-add-type div-add-type-manual " style="">
      <div class="card-body">
         <div class="row g-6">
            <div class="col-lg-12">
               <label class="required form-label" data-lang="">Kiểu xử lý</label>
               <select class="form-select form-select-solid sl-type" data-control="select2" data-hide-search="true" onchange="_products.on.change.processType(this.value)">
                  <option value="Manual" data-lang="">Thủ công</option>
                  <option value="Auto" data-lang="Process by Auto">Tự động</option>
                  <option value="Service" data-lang="Process by Service">Kết hợp dịch vụ</option>
                  <option value="Veo3">Veo3</option>
                  <option value="NEW_VEO3">NEW_VEO3</option>
                  <option value="VEO2_QUALITY">VEO2_QUALITY</option>
                  <option value="VEO2_FAST">VEO2_FAST</option>
                  <option value="HAILUO_V2_768P_6S">HAILUO_V2_768P_6S</option>
                  <option value="HAILUO_V2_1080P_6S">HAILUO_V2_1080P_6S</option>
                  <option value="HAILUO_V2_768P_10S">HAILUO_V2_768P_10S</option>
                  <option value="KLING_1_6_5S">KLING_1_6_5S</option>
                  <option value="KLING_1_6_10S">KLING_1_6_10S</option>
                  <option value="KLING_2_1_5S">KLING_2_1_5S</option>
                  <option value="KLING_2_1_10S">KLING_2_1_10S</option>
                  <option value="AI_IMAGE_DEFAULT">AI_IMAGE_DEFAULT</option>
                  <option value="AI_VIDEO_DEFAULT">AI_VIDEO_DEFAULT</option>
                  <option value="AI_VOICE_DEFAULT">AI_VOICE_DEFAULT</option>
                  <option value="GG_IMAGE_3_5">GG_IMAGE_3_5</option>
                  <option value="GG_IMAGE_3_1">GG_IMAGE_3_1</option>
                  <option value="HAILUO_IMAGE_01">HAILUO_IMAGE_01</option>
                  <option value="KLING_COLORS_2_1">KLING_COLORS_2_1</option>
                  <option value="KLING_COLORS_2_0">KLING_COLORS_2_0</option>
                  <option value="KLING_COLORS_1_5">KLING_COLORS_1_5</option>
                  <option value="AI_IMAGE_OLD">AI_IMAGE_OLD</option>
                  <option value="AI_VIDEO_OLD">AI_VIDEO_OLD</option>
                  <option value="AI_VIDEO_VIETAUTO">AI_VIDEO_VIETAUTO</option>
                  <option value="AI_IMAGE_VIETAUTO">AI_IMAGE_VIETAUTO</option>
                  <option value="ANS">ANS</option>
               </select>
               <input type="hidden" class="ipt-inventory-api" value="0">
            </div>
            <div class="col-lg-12 div-process-type div-warehouse" style="display: none;">
               <label class="required form-label" data-lang="">Kho sản phẩm</label>
               <select class="form-select form-select-solid sl-warehouse" data-control="select2" data-hide-search="true">
                  <option value="0" data-page="common" data-lang="">Chọn</option>
                  @foreach($warehouses as $warehouse)
                     <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-lg-12 div-process-type div-service" style="display: none;">
               <div class="row g-6">
                  <div class="col-lg-8 col-12">
                     <select class="form-select form-select-solid sl-service" data-control="select2" data-placeholder="Chọn dịch vụ">
                        <option></option>
                        <option data-min="10" data-max="500000" value="1531" data-rate="0.1207">1531 - Facebook Post Reaction | Love ❤️ | Max 100k | Instant | No refill | 5k/Day - $0.1207 (Min-Max: 10 - 500000)</option>
                        <option data-min="10" data-max="300000" value="1538" data-rate="0.77">1538 - Facebook Profile Followers Max 30K | Super High Quality | Non Drop | Refill 30 Day | Instant Start | 5K - 10K/Day♻️ - $0.77 (Min-Max: 10 - 300000)</option>
                        <option data-min="10" data-max="30000" value="1539" data-rate="0.5388">1539 - Facebook Page Followers | Max 30K | Super High Quality | Non Drop | Refill 30 Day | Instant Start | 30K/Day♻️ - $0.5388 (Min-Max: 10 - 30000)</option>
                        <option data-min="10" data-max="100000" value="1540" data-rate="0.56">1540 - Facebook Page Likes + Followers | Max 1M | | High Quality | Low Drop | 30 Days ♻️ | Instant Start | Day 50K - $0.56 (Min-Max: 10 - 100000)</option>
                        <option data-min="10" data-max="30000" value="1541" data-rate="0.6889">1541 - Facebook Group Members | Max 30K | Super High Quality | Non Drop | Refill 30 Day | Instant Start | 30K/Day♻️ - $0.6889 (Min-Max: 10 - 30000)</option>
                        <option data-min="100" data-max="100000" value="1918" data-rate="0.1218">1918 - Facebook Group Member | Bot Data | Instant | 10K/Day - $0.1218 (Min-Max: 100 - 100000)</option>
                     </select>
                  </div>
                  <div class="col-lg-3 col-10">
                     <input type="number" class="form-control form-control-solid ipt-combo-service-quantity" placeholder="Số lượng">
                  </div>
                  <div class="col-lg-1 col-2">
                     <button type="button" class="btn btn-primary w-100" onclick="_products.on.click.comboService.add(document.querySelector('.sl-service').value.trim(), document.querySelector('.ipt-combo-service-quantity').value.trim(), document.querySelector('.sl-service').options[document.querySelector('.sl-service').selectedIndex].getAttribute('data-rate'), document.querySelector('.sl-service').options[document.querySelector('.sl-service').selectedIndex].getAttribute('data-min'), document.querySelector('.sl-service').options[document.querySelector('.sl-service').selectedIndex].getAttribute('data-max'))">+</button>
                  </div>
                  <div class="col-lg-12">
                     <div class="table-responsive">
                        <table class="table table-striped align-middle table-row-dashed gs-5 fs-6 gy-2 border table-combo-service">
                           <thead>
                              <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                 <td>Service ID</td>
                                 <td>Rate</td>
                                 <td>Quantity</td>
                                 <td>Cost price</td>
                                 <td></td>
                              </tr>
                           </thead>
                           <tbody></tbody>
                           <tfoot style="display: none;">
                              <tr>
                                 <td class="text-center text-gray-500 fw-bold fs-7 text-uppercase" colspan="3">Total cost price</td>
                                 <td class="fw-bolder"></td>
                              </tr>
                           </tfoot>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row g-5 mt-5 div-process-type div-params" style="">
            <div class="separator div-param div-require_text mt-5 border border-dashed" style=""></div>
            <div class="col-lg-12 div-param div-require_text" style="">
               <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input cb-param w-25px h-25px" type="checkbox" value="require_text" onchange="document.querySelector('.require-text-options').style.display=this.checked ? '' : 'none'">
                  <label class="form-check-label fs-5 fw-bold" data-lang="">Requirement</label>
               </div>
               <div class="row ps-lg-10 g-5 require-text-options mt-2" style="display: none;">
                  <div class="col-lg-12">
                     <div class="form-check form-check-custom form-check-solid form-check-success">
                        <input class="form-check-input cb-required w-20px h-20px" type="checkbox">
                        <label class="form-check-label" data-lang="">Required?</label>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Description</label>
                     <input type="text" class="form-control form-control-solid ipt-description" placeholder="Please input your requirement">
                  </div>
                  <div class="col-lg-12">
                     <div id="div-translated-description"></div>
                     <a class="btn btn-secondary btn-sm" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" data-lang="Add translated description">Add translated description</a>
                     <div class="dropdown-menu dropdown-menu-end">
                        <a href="javascript:;" class="dropdown-item ai-icon" onclick="_products.on.click.addTranslatedDescription('vn')">
                        <span class="rounded-1 fi fi-vn fs-4"></span>
                        <span class="ms-2">Vietnam</span>
                        </a>                        
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Min/max length input (0 for nolimit)</label>
                     <div class="input-group input-group-solid">
                        <input type="text" class="form-control ipt-require-text-min-length" data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false" value="0" inputmode="text">
                        <span class="input-group-text bg-secondary">-</span>
                        <input type="text" class="form-control ipt-require-text-max-length" data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false" value="0" inputmode="text">
                     </div>
                  </div>
               </div>
            </div>
            <div class="separator div-param div-prompt mt-5 border border-dashed" style="display: none;"></div>
            <div class="col-lg-12 div-param div-prompt" style="display: none;">
               <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input cb-param w-25px h-25px" type="checkbox" value="prompt" onchange="document.querySelector('.prompt-options').style.display=this.checked ? '' : 'none'">
                  <label class="form-check-label fs-5 fw-bold" data-lang="">Prompt (AI)</label>
               </div>
               <div class="row ps-lg-10 g-5 prompt-options mt-2" style="display: none;">
                  <div class="col-lg-12">
                     <div class="form-check form-check-custom form-check-solid form-check-success">
                        <input class="form-check-input cb-required w-20px h-20px" type="checkbox">
                        <label class="form-check-label" data-lang="">Required?</label>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Description</label>
                     <input type="text" class="form-control form-control-solid ipt-description" placeholder="Please input prompt">
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Min/max length input (0 for nolimit)</label>
                     <div class="input-group input-group-solid">
                        <input type="text" class="form-control ipt-prompt-min-length" data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false" value="0" inputmode="text">
                        <span class="input-group-text bg-secondary">-</span>
                        <input type="text" class="form-control ipt-prompt-max-length" data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false" value="0" inputmode="text">
                     </div>
                  </div>
               </div>
            </div>
            <div class="separator div-param div-images mt-5 border border-dashed" style="display: none;"></div>
            <div class="col-lg-12 div-param div-images" style="display: none;">
               <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input cb-param w-25px h-25px" type="checkbox" value="images" onchange="document.querySelector('.images-options').style.display=this.checked ? '' : 'none'">
                  <label class="form-check-label fs-5 fw-bold" data-lang="">Images (AI Image/Video)</label>
               </div>
               <div class="row ps-lg-10 g-5 images-options mt-2" style="display: none;">
                  <div class="col-lg-12">
                     <div class="form-check form-check-custom form-check-solid form-check-success">
                        <input class="form-check-input cb-required w-20px h-20px" type="checkbox">
                        <label class="form-check-label" data-lang="">Required?</label>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Description</label>
                     <input type="text" class="form-control form-control-solid ipt-description" placeholder="Please upload images">
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label">Min/max images upload</label>
                     <div class="input-group input-group-solid">
                        <input type="text" class="form-control ipt-images-min-upload" data-inputmask="'mask': '9', 'repeat': 1, 'greedy' : false" value="1" inputmode="text">
                        <span class="input-group-text bg-secondary">-</span>
                        <input type="text" class="form-control ipt-images-max-upload" data-inputmask="'mask': '9', 'repeat': 1, 'greedy' : false" value="1" inputmode="text">
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label">Min/max references upload</label>
                     <div class="input-group input-group-solid">
                        <input type="text" class="form-control ipt-references-min-upload" data-inputmask="'mask': '9', 'repeat': 1, 'greedy' : false" value="1" inputmode="text">
                        <span class="input-group-text bg-secondary">-</span>
                        <input type="text" class="form-control ipt-references-max-upload" data-inputmask="'mask': '9', 'repeat': 1, 'greedy' : false" value="1" inputmode="text">
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Structure upload</label>
                     <select class="form-select form-select-solid sl-images-structure sl-references-structure" data-control="select2" data-hide-search="true">
                        <option value="0">Array by AI Provider</option>
                        <option value="1">references</option>
                        <option value="111">references (vietauto)</option>
                        <option value="2">subjects</option>
                        <option value="222">subjects (vietauto)</option>
                        <option value="3">scenes</option>
                        <option value="4">styles</option>
                        <option value="5">faces</option>
                        <option value="888">images (vietauto)</option>
                        <option value="999">Default (AI Provider)</option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="separator div-param div-references mt-5 border border-dashed" style="display: none;"></div>
            <div class="col-lg-12 div-param div-references" style="display: none;">
               <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input cb-param w-25px h-25px" type="checkbox" value="references" onchange="document.querySelector('.references-options').style.display=this.checked ? '' : 'none'">
                  <label class="form-check-label fs-5 fw-bold" data-lang="">References (AI Image/Video)</label>
               </div>
               <div class="row ps-lg-10 g-5 references-options mt-2" style="display: none;">
                  <div class="col-lg-12">
                     <div class="form-check form-check-custom form-check-solid form-check-success">
                        <input class="form-check-input cb-required w-20px h-20px" type="checkbox">
                        <label class="form-check-label" data-lang="">Required?</label>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Description</label>
                     <input type="text" class="form-control form-control-solid ipt-description" placeholder="Please upload references">
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label">Min/max references upload</label>
                     <div class="input-group input-group-solid">
                        <input type="text" class="form-control ipt-references-min-upload" data-inputmask="'mask': '9', 'repeat': 1, 'greedy' : false" value="1" inputmode="text">
                        <span class="input-group-text bg-secondary">-</span>
                        <input type="text" class="form-control ipt-references-max-upload" data-inputmask="'mask': '9', 'repeat': 1, 'greedy' : false" value="1" inputmode="text">
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Structure upload</label>
                     <select class="form-select form-select-solid sl-references-structure" data-control="select2" data-hide-search="true">
                        <option value="0">Array by AI Provider</option>
                        <option value="1">references</option>
                        <option value="111">references (vietauto)</option>
                        <option value="2">subjects</option>
                        <option value="222">subjects (vietauto)</option>
                        <option value="3">scenes</option>
                        <option value="4">styles</option>
                        <option value="5">faces</option>
                        <option value="888">images (vietauto)</option>
                        <option value="999">Default (AI Provider)</option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="separator div-param div-dimension mt-5 border border-dashed" style="display: none;"></div>
            <div class="col-lg-12 div-param div-dimension" style="display: none;">
               <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input cb-param w-25px h-25px" type="checkbox" value="dimension" onchange="document.querySelector('.dimension-options').style.display=this.checked ? '' : 'none'">
                  <label class="form-check-label fs-5 fw-bold" data-lang="">Dimension (AI Image/Video)</label>
               </div>
               <div class="row ps-lg-10 g-5 dimension-options mt-2" style="display: none;">
                  <div class="col-lg-12">
                     <div class="form-check form-check-custom form-check-solid form-check-success">
                        <input class="form-check-input cb-required w-20px h-20px" type="checkbox">
                        <label class="form-check-label" data-lang="">Required?</label>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Description</label>
                     <input type="text" class="form-control form-control-solid ipt-description" placeholder="Please choose dimension">
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Choose dimension</label><a class="text-primary text-decoration-underline fs-8 ms-2" href="javascript:;" onclick="select_all('.sl-dimension')">Select all</a>
                     <select class="form-select form-select-solid sl-dimension" data-control="select2" data-close-on-select="false" data-placeholder="Select dimensions" data-allow-clear="true" multiple="">
                        <option value="2:3">2:3</option>
                        <option value="3:2">3:2</option>
                        <option value="1:1">1:1</option>
                        <option value="16:9">16:9</option>
                        <option value="9:16">9:16</option>
                     </select>
                        <span class="selection">
                           <span class="select2-selection select2-selection--multiple form-select form-select-solid sl-dimension" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
                              <ul class="select2-selection__rendered" id="select2-wgde-container"></ul>
                              <span class="select2-search select2-search--inline"><textarea class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-label="Search" aria-describedby="select2-wgde-container" placeholder="Select dimensions" style="width: 100%;"></textarea></span>
                           </span>
                        </span>
                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                     </span>
                  </div>
               </div>
            </div>
            <div class="separator div-param div-style mt-5 border border-dashed" style="display: none;"></div>
            <div class="col-lg-12 div-param div-style" style="display: none;">
               <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input cb-param w-25px h-25px" type="checkbox" value="style" onchange="document.querySelector('.style-options').style.display=this.checked ? '' : 'none'">
                  <label class="form-check-label fs-5 fw-bold" data-lang="">Style (AI Image)</label>
               </div>
               <div class="row ps-lg-10 g-5 style-options mt-2" style="display: none;">
                  <div class="col-lg-12">
                     <div class="form-check form-check-custom form-check-solid form-check-success">
                        <input class="form-check-input cb-required w-20px h-20px" type="checkbox">
                        <label class="form-check-label" data-lang="">Required?</label>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Description</label>
                     <input type="text" class="form-control form-control-solid ipt-description" placeholder="Please choose style image">
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Choose style</label><a class="text-primary text-decoration-underline fs-8 ms-2" href="javascript:;" onclick="select_all('.sl-style')">Select all</a>
                     <select class="form-select form-select-solid sl-style" data-control="select2" data-close-on-select="false" data-placeholder="Select style image" data-allow-clear="true" multiple="">
                        <option value="2d_to_3d">2d_to_3d</option>
                        <option value="chibi">chibi</option>
                        <option value="anime">anime</option>
                        <option value="comic">comic</option>
                        <option value="cartoon">cartoon</option>
                        <option value="restoration">restoration</option>
                        <option value="pencil_sketch">pencil_sketch</option>
                        <option value="pop_art">pop_art</option>
                        <option value="line_art">line_art</option>
                        <option value="webtoon">webtoon</option>
                        <option value="manga">manga</option>
                     </select>
                        <span class="selection">
                           <span class="select2-selection select2-selection--multiple form-select form-select-solid sl-style" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
                              <ul class="select2-selection__rendered" id="select2-fcw0-container"></ul>
                              <span class="select2-search select2-search--inline"><textarea class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-label="Search" aria-describedby="select2-fcw0-container" placeholder="Select style image" style="width: 100%;"></textarea></span>
                           </span>
                        </span>
                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                     </span>
                  </div>
               </div>
            </div>
            <div class="separator div-param div-speaker mt-5 border border-dashed" style="display: none;"></div>
            <div class="col-lg-12 div-param div-speaker" style="display: none;">
               <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input cb-param w-25px h-25px" type="checkbox" value="speaker" onchange="document.querySelector('.speaker-options').style.display=this.checked ? '' : 'none'">
                  <label class="form-check-label fs-5 fw-bold" data-lang="">Speaker</label>
               </div>
               <div class="row ps-lg-10 g-5 speaker-options mt-2" style="display: none;">
                  <div class="col-lg-12">
                     <div class="form-check form-check-custom form-check-solid form-check-success">
                        <input class="form-check-input cb-required w-20px h-20px" type="checkbox">
                        <label class="form-check-label" data-lang="">Required?</label>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Description</label>
                     <input type="text" class="form-control form-control-solid ipt-description" placeholder="Please choose speaker">
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Choose speaker</label><a class="text-primary text-decoration-underline fs-8 ms-2" href="javascript:;" onclick="select_all('.sl-speaker')">Select all</a>
                     <select class="form-select form-select-solid sl-speaker" data-control="select2" data-close-on-select="false" data-placeholder="Select style image" data-allow-clear="true" multiple=""></select>
                        <span class="selection">
                           <span class="select2-selection select2-selection--multiple form-select form-select-solid sl-speaker" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
                              <ul class="select2-selection__rendered" id="select2-42j4-container"></ul>
                              <span class="select2-search select2-search--inline"><textarea class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-label="Search" aria-describedby="select2-42j4-container" placeholder="Select style image" style="width: 100%;"></textarea></span>
                           </span>
                        </span>
                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                     </span>
                  </div>
               </div>
            </div>
            <div class="separator div-param div-speaker_profile mt-5 border border-dashed" style="display: none;"></div>
            <div class="col-lg-12 div-param div-speaker_profile" style="display: none;">
               <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input cb-param w-25px h-25px" type="checkbox" value="speaker_profile" onchange="document.querySelector('.speaker_profile-options').style.display=this.checked ? '' : 'none'">
                  <label class="form-check-label fs-5 fw-bold" data-lang="">Speaker profile</label>
               </div>
               <div class="row ps-lg-10 g-5 speaker_profile-options mt-2" style="display: none;">
                  <div class="col-lg-12">
                     <div class="form-check form-check-custom form-check-solid form-check-success">
                        <input class="form-check-input cb-required w-20px h-20px" type="checkbox">
                        <label class="form-check-label" data-lang="">Required?</label>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Description</label>
                     <input type="text" class="form-control form-control-solid ipt-description" placeholder="Please input speaker description">
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Min/max length input</label>
                     <div class="input-group input-group-solid">
                        <input type="text" class="form-control ipt-speaker-profile-min-length" data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false" value="0" inputmode="text">
                        <span class="input-group-text bg-secondary">-</span>
                        <input type="text" class="form-control ipt-speaker-profile-max-length" data-inputmask="'mask': '9', 'repeat': 10, 'greedy' : false" value="0" inputmode="text">
                     </div>
                  </div>
               </div>
            </div>
            <div class="separator div-param div-speed mt-5 border border-dashed" style="display: none;"></div>
            <div class="col-lg-12 div-param div-speed" style="display: none;">
               <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input cb-param w-25px h-25px" type="checkbox" value="speed" onchange="document.querySelector('.speed-options').style.display=this.checked ? '' : 'none'">
                  <label class="form-check-label fs-5 fw-bold" data-lang="">Speed</label>
               </div>
               <div class="row ps-lg-10 g-5 speed-options mt-2" style="display: none;">
                  <div class="col-lg-12">
                     <div class="form-check form-check-custom form-check-solid form-check-success">
                        <input class="form-check-input cb-required w-20px h-20px" type="checkbox">
                        <label class="form-check-label" data-lang="">Required?</label>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Description</label>
                     <input type="text" class="form-control form-control-solid ipt-description" placeholder="Please choose speed">
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Choose speed</label><a class="text-primary text-decoration-underline fs-8 ms-2" href="javascript:;" onclick="select_all('.sl-speed')">Select all</a>
                     <select class="form-select form-select-solid sl-speed" data-control="select2" data-close-on-select="false" data-placeholder="Select style image" data-allow-clear="true" multiple="">
                        <option value="0.25">0.25</option>
                        <option value="0.5">0.5</option>
                        <option value="0.75">0.75</option>
                        <option value="1">1</option>
                        <option value="1.05">1.05</option>
                        <option value="1.1">1.1</option>
                        <option value="1.15">1.15</option>
                        <option value="1.2">1.2</option>
                        <option value="1.3">1.3</option>
                        <option value="1.4">1.4</option>
                        <option value="1.5">1.5</option>
                        <option value="1.6">1.6</option>
                        <option value="1.7">1.7</option>
                        <option value="1.8">1.8</option>
                        <option value="1.9">1.9</option>
                        <option value="2">2</option>
                     </select>
                        <span class="selection">
                           <span class="select2-selection select2-selection--multiple form-select form-select-solid sl-speed" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
                              <ul class="select2-selection__rendered" id="select2-qnl1-container"></ul>
                              <span class="select2-search select2-search--inline"><textarea class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-label="Search" aria-describedby="select2-qnl1-container" placeholder="Select style image" style="width: 100%;"></textarea></span>
                           </span>
                        </span>
                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                     </span>
                  </div>
               </div>
            </div>
            <div class="separator div-param div-pause_duration mt-5 border border-dashed" style="display: none;"></div>
            <div class="col-lg-12 div-param div-pause_duration" style="display: none;">
               <div class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input cb-param w-25px h-25px" type="checkbox" value="pause_duration" onchange="document.querySelector('.pause_duration-options').style.display=this.checked ? '' : 'none'">
                  <label class="form-check-label fs-5 fw-bold" data-lang="">Pause Duration</label>
               </div>
               <div class="row ps-lg-10 g-5 pause_duration-options mt-2" style="display: none;">
                  <div class="col-lg-12">
                     <div class="form-check form-check-custom form-check-solid form-check-success">
                        <input class="form-check-input cb-required w-20px h-20px" type="checkbox">
                        <label class="form-check-label" data-lang="">Required?</label>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Description</label>
                     <input type="text" class="form-control form-control-solid ipt-description" placeholder="Please choose pause duration">
                  </div>
                  <div class="col-lg-12">
                     <label class="form-label" data-lang="">Choose pause duration</label><a class="text-primary text-decoration-underline fs-8 ms-2" href="javascript:;" onclick="select_all('.sl-pause_duration')">Select all</a>
                     <select class="form-select form-select-solid sl-pause_duration" data-control="select2" data-close-on-select="false" data-placeholder="Select style image" data-allow-clear="true" multiple="">
                        <option value="0.5">0.5</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                     </select>
                        <span class="selection">
                           <span class="select2-selection select2-selection--multiple form-select form-select-solid sl-pause_duration" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
                              <ul class="select2-selection__rendered" id="select2-fk42-container"></ul>
                              <span class="select2-search select2-search--inline"><textarea class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-label="Search" aria-describedby="select2-fk42-container" placeholder="Select style image" style="width: 100%;"></textarea></span>
                           </span>
                        </span>
                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                     </span>
                  </div>
               </div>
            </div>
            <input type="hidden" class="ipt-param-platform" value="nmh">
            <input type="hidden" class="ipt-param-using-for-creator" value="">
            <script>
               // click select all to choose all
               function select_all(element) {
                   const select = document.querySelector(element);
                   const options = select.querySelectorAll('option');
                   options.forEach(option => {
                       option.selected = true;
                   });
                   $(select).trigger('change'); // Trigger change event to update the select2
               }
            </script>
         </div>
      </div>
   </div>
   <div class="row g-5 mb-10">
      <div class="col-lg-6">
         <div class="d-flex flex-wrap flex-stack mb-3">
            <h3 class="fw-bold my-2"><span data-lang="">Chi tiết</span></h3>
         </div>
         <div class="card shadow-sm">
            <div class="card-body p-0">
               <div role="toolbar" class="ql-toolbar ql-snow">
                  <span class="ql-formats">
                     <button type="button" class="ql-bold" aria-pressed="false" aria-label="bold">
                        <svg viewBox="0 0 18 18">
                           <path class="ql-stroke" d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z"></path>
                           <path class="ql-stroke" d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z"></path>
                        </svg>
                     </button>
                     <button type="button" class="ql-italic" aria-pressed="false" aria-label="italic">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke" x1="7" x2="13" y1="4" y2="4"></line>
                           <line class="ql-stroke" x1="5" x2="11" y1="14" y2="14"></line>
                           <line class="ql-stroke" x1="8" x2="10" y1="14" y2="4"></line>
                        </svg>
                     </button>
                     <button type="button" class="ql-underline" aria-pressed="false" aria-label="underline">
                        <svg viewBox="0 0 18 18">
                           <path class="ql-stroke" d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3"></path>
                           <rect class="ql-fill" height="1" rx="0.5" ry="0.5" width="12" x="3" y="15"></rect>
                        </svg>
                     </button>
                     <button type="button" class="ql-strike" aria-pressed="false" aria-label="strike">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke ql-thin" x1="15.5" x2="2.5" y1="8.5" y2="9.5"></line>
                           <path class="ql-fill" d="M9.007,8C6.542,7.791,6,7.519,6,6.5,6,5.792,7.283,5,9,5c1.571,0,2.765.679,2.969,1.309a1,1,0,0,0,1.9-.617C13.356,4.106,11.354,3,9,3,6.2,3,4,4.538,4,6.5a3.2,3.2,0,0,0,.5,1.843Z"></path>
                           <path class="ql-fill" d="M8.984,10C11.457,10.208,12,10.479,12,11.5c0,0.708-1.283,1.5-3,1.5-1.571,0-2.765-.679-2.969-1.309a1,1,0,1,0-1.9.617C4.644,13.894,6.646,15,9,15c2.8,0,5-1.538,5-3.5a3.2,3.2,0,0,0-.5-1.843Z"></path>
                        </svg>
                     </button>
                  </span>
                  <span class="ql-formats">
                     <button type="button" class="ql-blockquote" aria-pressed="false" aria-label="blockquote">
                        <svg viewBox="0 0 18 18">
                           <rect class="ql-fill ql-stroke" height="3" width="3" x="4" y="5"></rect>
                           <rect class="ql-fill ql-stroke" height="3" width="3" x="11" y="5"></rect>
                           <path class="ql-even ql-fill ql-stroke" d="M7,8c0,4.031-3,5-3,5"></path>
                           <path class="ql-even ql-fill ql-stroke" d="M14,8c0,4.031-3,5-3,5"></path>
                        </svg>
                     </button>
                     <button type="button" class="ql-code-block" aria-pressed="false" aria-label="code-block">
                        <svg viewBox="0 0 18 18">
                           <polyline class="ql-even ql-stroke" points="5 7 3 9 5 11"></polyline>
                           <polyline class="ql-even ql-stroke" points="13 7 15 9 13 11"></polyline>
                           <line class="ql-stroke" x1="10" x2="8" y1="5" y2="13"></line>
                        </svg>
                     </button>
                  </span>
                  <span class="ql-formats">
                     <button type="button" class="ql-list" aria-pressed="false" value="ordered" aria-label="list: ordered">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke" x1="7" x2="15" y1="4" y2="4"></line>
                           <line class="ql-stroke" x1="7" x2="15" y1="9" y2="9"></line>
                           <line class="ql-stroke" x1="7" x2="15" y1="14" y2="14"></line>
                           <line class="ql-stroke ql-thin" x1="2.5" x2="4.5" y1="5.5" y2="5.5"></line>
                           <path class="ql-fill" d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z"></path>
                           <path class="ql-stroke ql-thin" d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156"></path>
                           <path class="ql-stroke ql-thin" d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109"></path>
                        </svg>
                     </button>
                     <button type="button" class="ql-list" aria-pressed="false" value="bullet" aria-label="list: bullet">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke" x1="6" x2="15" y1="4" y2="4"></line>
                           <line class="ql-stroke" x1="6" x2="15" y1="9" y2="9"></line>
                           <line class="ql-stroke" x1="6" x2="15" y1="14" y2="14"></line>
                           <line class="ql-stroke" x1="3" x2="3" y1="4" y2="4"></line>
                           <line class="ql-stroke" x1="3" x2="3" y1="9" y2="9"></line>
                           <line class="ql-stroke" x1="3" x2="3" y1="14" y2="14"></line>
                        </svg>
                     </button>
                     <button type="button" class="ql-align" aria-pressed="false" aria-label="align">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke" x1="3" x2="15" y1="9" y2="9"></line>
                           <line class="ql-stroke" x1="3" x2="13" y1="14" y2="14"></line>
                           <line class="ql-stroke" x1="3" x2="9" y1="4" y2="4"></line>
                        </svg>
                     </button>
                  </span>
                  <span class="ql-formats">
                     <span class="ql-color ql-picker ql-color-picker">
                        <span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-0">
                           <svg viewBox="0 0 18 18">
                              <line class="ql-color-label ql-stroke ql-transparent" x1="3" x2="15" y1="15" y2="15"></line>
                              <polyline class="ql-stroke" points="5.5 11 9 3 12.5 11"></polyline>
                              <line class="ql-stroke" x1="11.63" x2="6.38" y1="9" y2="9"></line>
                           </svg>
                        </span>
                        <span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-0"><span tabindex="0" role="button" class="ql-picker-item ql-primary"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#e60000" style="background-color: rgb(230, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ff9900" style="background-color: rgb(255, 153, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ffff00" style="background-color: rgb(255, 255, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#008a00" style="background-color: rgb(0, 138, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#0066cc" style="background-color: rgb(0, 102, 204);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#9933ff" style="background-color: rgb(153, 51, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffffff" style="background-color: rgb(255, 255, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#facccc" style="background-color: rgb(250, 204, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffebcc" style="background-color: rgb(255, 235, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffffcc" style="background-color: rgb(255, 255, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#cce8cc" style="background-color: rgb(204, 232, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#cce0f5" style="background-color: rgb(204, 224, 245);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ebd6ff" style="background-color: rgb(235, 214, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#bbbbbb" style="background-color: rgb(187, 187, 187);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#f06666" style="background-color: rgb(240, 102, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffc266" style="background-color: rgb(255, 194, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffff66" style="background-color: rgb(255, 255, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#66b966" style="background-color: rgb(102, 185, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#66a3e0" style="background-color: rgb(102, 163, 224);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#c285ff" style="background-color: rgb(194, 133, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#888888" style="background-color: rgb(136, 136, 136);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#a10000" style="background-color: rgb(161, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#b26b00" style="background-color: rgb(178, 107, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#b2b200" style="background-color: rgb(178, 178, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#006100" style="background-color: rgb(0, 97, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#0047b2" style="background-color: rgb(0, 71, 178);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#6b24b2" style="background-color: rgb(107, 36, 178);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#444444" style="background-color: rgb(68, 68, 68);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#5c0000" style="background-color: rgb(92, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#663d00" style="background-color: rgb(102, 61, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#666600" style="background-color: rgb(102, 102, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#003700" style="background-color: rgb(0, 55, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#002966" style="background-color: rgb(0, 41, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#3d1466" style="background-color: rgb(61, 20, 102);"></span></span>
                     </span>
                     <select class="ql-color" style="display: none;">
                        <option selected="selected"></option>
                        <option value="#e60000"></option>
                        <option value="#ff9900"></option>
                        <option value="#ffff00"></option>
                        <option value="#008a00"></option>
                        <option value="#0066cc"></option>
                        <option value="#9933ff"></option>
                        <option value="#ffffff"></option>
                        <option value="#facccc"></option>
                        <option value="#ffebcc"></option>
                        <option value="#ffffcc"></option>
                        <option value="#cce8cc"></option>
                        <option value="#cce0f5"></option>
                        <option value="#ebd6ff"></option>
                        <option value="#bbbbbb"></option>
                        <option value="#f06666"></option>
                        <option value="#ffc266"></option>
                        <option value="#ffff66"></option>
                        <option value="#66b966"></option>
                        <option value="#66a3e0"></option>
                        <option value="#c285ff"></option>
                        <option value="#888888"></option>
                        <option value="#a10000"></option>
                        <option value="#b26b00"></option>
                        <option value="#b2b200"></option>
                        <option value="#006100"></option>
                        <option value="#0047b2"></option>
                        <option value="#6b24b2"></option>
                        <option value="#444444"></option>
                        <option value="#5c0000"></option>
                        <option value="#663d00"></option>
                        <option value="#666600"></option>
                        <option value="#003700"></option>
                        <option value="#002966"></option>
                        <option value="#3d1466"></option>
                     </select>
                     <span class="ql-background ql-picker ql-color-picker">
                        <span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-1">
                           <svg viewBox="0 0 18 18">
                              <g class="ql-fill ql-color-label">
                                 <polygon points="6 6.868 6 6 5 6 5 7 5.942 7 6 6.868"></polygon>
                                 <rect height="1" width="1" x="4" y="4"></rect>
                                 <polygon points="6.817 5 6 5 6 6 6.38 6 6.817 5"></polygon>
                                 <rect height="1" width="1" x="2" y="6"></rect>
                                 <rect height="1" width="1" x="3" y="5"></rect>
                                 <rect height="1" width="1" x="4" y="7"></rect>
                                 <polygon points="4 11.439 4 11 3 11 3 12 3.755 12 4 11.439"></polygon>
                                 <rect height="1" width="1" x="2" y="12"></rect>
                                 <rect height="1" width="1" x="2" y="9"></rect>
                                 <rect height="1" width="1" x="2" y="15"></rect>
                                 <polygon points="4.63 10 4 10 4 11 4.192 11 4.63 10"></polygon>
                                 <rect height="1" width="1" x="3" y="8"></rect>
                                 <path d="M10.832,4.2L11,4.582V4H10.708A1.948,1.948,0,0,1,10.832,4.2Z"></path>
                                 <path d="M7,4.582L7.168,4.2A1.929,1.929,0,0,1,7.292,4H7V4.582Z"></path>
                                 <path d="M8,13H7.683l-0.351.8a1.933,1.933,0,0,1-.124.2H8V13Z"></path>
                                 <rect height="1" width="1" x="12" y="2"></rect>
                                 <rect height="1" width="1" x="11" y="3"></rect>
                                 <path d="M9,3H8V3.282A1.985,1.985,0,0,1,9,3Z"></path>
                                 <rect height="1" width="1" x="2" y="3"></rect>
                                 <rect height="1" width="1" x="6" y="2"></rect>
                                 <rect height="1" width="1" x="3" y="2"></rect>
                                 <rect height="1" width="1" x="5" y="3"></rect>
                                 <rect height="1" width="1" x="9" y="2"></rect>
                                 <rect height="1" width="1" x="15" y="14"></rect>
                                 <polygon points="13.447 10.174 13.469 10.225 13.472 10.232 13.808 11 14 11 14 10 13.37 10 13.447 10.174"></polygon>
                                 <rect height="1" width="1" x="13" y="7"></rect>
                                 <rect height="1" width="1" x="15" y="5"></rect>
                                 <rect height="1" width="1" x="14" y="6"></rect>
                                 <rect height="1" width="1" x="15" y="8"></rect>
                                 <rect height="1" width="1" x="14" y="9"></rect>
                                 <path d="M3.775,14H3v1H4V14.314A1.97,1.97,0,0,1,3.775,14Z"></path>
                                 <rect height="1" width="1" x="14" y="3"></rect>
                                 <polygon points="12 6.868 12 6 11.62 6 12 6.868"></polygon>
                                 <rect height="1" width="1" x="15" y="2"></rect>
                                 <rect height="1" width="1" x="12" y="5"></rect>
                                 <rect height="1" width="1" x="13" y="4"></rect>
                                 <polygon points="12.933 9 13 9 13 8 12.495 8 12.933 9"></polygon>
                                 <rect height="1" width="1" x="9" y="14"></rect>
                                 <rect height="1" width="1" x="8" y="15"></rect>
                                 <path d="M6,14.926V15H7V14.316A1.993,1.993,0,0,1,6,14.926Z"></path>
                                 <rect height="1" width="1" x="5" y="15"></rect>
                                 <path d="M10.668,13.8L10.317,13H10v1h0.792A1.947,1.947,0,0,1,10.668,13.8Z"></path>
                                 <rect height="1" width="1" x="11" y="15"></rect>
                                 <path d="M14.332,12.2a1.99,1.99,0,0,1,.166.8H15V12H14.245Z"></path>
                                 <rect height="1" width="1" x="14" y="15"></rect>
                                 <rect height="1" width="1" x="15" y="11"></rect>
                              </g>
                              <polyline class="ql-stroke" points="5.5 13 9 5 12.5 13"></polyline>
                              <line class="ql-stroke" x1="11.63" x2="6.38" y1="11" y2="11"></line>
                           </svg>
                        </span>
                        <span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-1"><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#000000" style="background-color: rgb(0, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#e60000" style="background-color: rgb(230, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ff9900" style="background-color: rgb(255, 153, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ffff00" style="background-color: rgb(255, 255, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#008a00" style="background-color: rgb(0, 138, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#0066cc" style="background-color: rgb(0, 102, 204);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#9933ff" style="background-color: rgb(153, 51, 255);"></span><span tabindex="0" role="button" class="ql-picker-item"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#facccc" style="background-color: rgb(250, 204, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffebcc" style="background-color: rgb(255, 235, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffffcc" style="background-color: rgb(255, 255, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#cce8cc" style="background-color: rgb(204, 232, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#cce0f5" style="background-color: rgb(204, 224, 245);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ebd6ff" style="background-color: rgb(235, 214, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#bbbbbb" style="background-color: rgb(187, 187, 187);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#f06666" style="background-color: rgb(240, 102, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffc266" style="background-color: rgb(255, 194, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffff66" style="background-color: rgb(255, 255, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#66b966" style="background-color: rgb(102, 185, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#66a3e0" style="background-color: rgb(102, 163, 224);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#c285ff" style="background-color: rgb(194, 133, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#888888" style="background-color: rgb(136, 136, 136);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#a10000" style="background-color: rgb(161, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#b26b00" style="background-color: rgb(178, 107, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#b2b200" style="background-color: rgb(178, 178, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#006100" style="background-color: rgb(0, 97, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#0047b2" style="background-color: rgb(0, 71, 178);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#6b24b2" style="background-color: rgb(107, 36, 178);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#444444" style="background-color: rgb(68, 68, 68);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#5c0000" style="background-color: rgb(92, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#663d00" style="background-color: rgb(102, 61, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#666600" style="background-color: rgb(102, 102, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#003700" style="background-color: rgb(0, 55, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#002966" style="background-color: rgb(0, 41, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#3d1466" style="background-color: rgb(61, 20, 102);"></span></span>
                     </span>
                     <select class="ql-background" style="display: none;">
                        <option value="#000000"></option>
                        <option value="#e60000"></option>
                        <option value="#ff9900"></option>
                        <option value="#ffff00"></option>
                        <option value="#008a00"></option>
                        <option value="#0066cc"></option>
                        <option value="#9933ff"></option>
                        <option selected="selected"></option>
                        <option value="#facccc"></option>
                        <option value="#ffebcc"></option>
                        <option value="#ffffcc"></option>
                        <option value="#cce8cc"></option>
                        <option value="#cce0f5"></option>
                        <option value="#ebd6ff"></option>
                        <option value="#bbbbbb"></option>
                        <option value="#f06666"></option>
                        <option value="#ffc266"></option>
                        <option value="#ffff66"></option>
                        <option value="#66b966"></option>
                        <option value="#66a3e0"></option>
                        <option value="#c285ff"></option>
                        <option value="#888888"></option>
                        <option value="#a10000"></option>
                        <option value="#b26b00"></option>
                        <option value="#b2b200"></option>
                        <option value="#006100"></option>
                        <option value="#0047b2"></option>
                        <option value="#6b24b2"></option>
                        <option value="#444444"></option>
                        <option value="#5c0000"></option>
                        <option value="#663d00"></option>
                        <option value="#666600"></option>
                        <option value="#003700"></option>
                        <option value="#002966"></option>
                        <option value="#3d1466"></option>
                     </select>
                  </span>
                  <span class="ql-formats">
                     <span class="ql-size ql-picker">
                        <span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-2">
                           <svg viewBox="0 0 18 18">
                              <polygon class="ql-stroke" points="7 11 9 13 11 11 7 11"></polygon>
                              <polygon class="ql-stroke" points="7 7 9 5 11 7 7 7"></polygon>
                           </svg>
                        </span>
                        <span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-2"><span tabindex="0" role="button" class="ql-picker-item" data-value="small"></span><span tabindex="0" role="button" class="ql-picker-item"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="large"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="huge"></span></span>
                     </span>
                     <select class="ql-size" style="display: none;">
                        <option value="small"></option>
                        <option selected="selected"></option>
                        <option value="large"></option>
                        <option value="huge"></option>
                     </select>
                  </span>
                  <span class="ql-formats">
                     <span class="ql-header ql-picker">
                        <span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-3">
                           <svg viewBox="0 0 18 18">
                              <polygon class="ql-stroke" points="7 11 9 13 11 11 7 11"></polygon>
                              <polygon class="ql-stroke" points="7 7 9 5 11 7 7 7"></polygon>
                           </svg>
                        </span>
                        <span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-3"><span tabindex="0" role="button" class="ql-picker-item" data-value="1"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="2"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="3"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="4"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="5"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="6"></span><span tabindex="0" role="button" class="ql-picker-item"></span></span>
                     </span>
                     <select class="ql-header" style="display: none;">
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option value="4"></option>
                        <option value="5"></option>
                        <option value="6"></option>
                        <option selected="selected"></option>
                     </select>
                  </span>
                  <span class="ql-formats">
                     <button type="button" class="ql-link" aria-pressed="false" aria-label="link">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke" x1="7" x2="11" y1="7" y2="11"></line>
                           <path class="ql-even ql-stroke" d="M8.9,4.577a3.476,3.476,0,0,1,.36,4.679A3.476,3.476,0,0,1,4.577,8.9C3.185,7.5,2.035,6.4,4.217,4.217S7.5,3.185,8.9,4.577Z"></path>
                           <path class="ql-even ql-stroke" d="M13.423,9.1a3.476,3.476,0,0,0-4.679-.36,3.476,3.476,0,0,0,.36,4.679c1.392,1.392,2.5,2.542,4.679.36S14.815,10.5,13.423,9.1Z"></path>
                        </svg>
                     </button>
                  </span>
               </div>
               <div class="txa-details bg-transparent h-300px ql-container ql-snow">
                  <div class="ql-editor" contenteditable="true">
                     <p>Zalo 0334713016 (admin)</p>
                  </div>
                  <div class="ql-tooltip ql-hidden"><a class="ql-preview" rel="noopener noreferrer" target="_blank" href="about:blank"></a><input type="text" data-formula="e=mc^2" data-link="https://quilljs.com" data-video="Embed URL"><a class="ql-action"></a><a class="ql-remove"></a></div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-6">
         <div class="d-flex flex-wrap flex-stack mb-3">
            <h3 class="fw-bold my-2"><span data-lang="">Chính sách bảo hành</span></h3>
         </div>
         <div class="card shadow-sm">
            <div class="card-body p-0">
               <div role="toolbar" class="ql-toolbar ql-snow">
                  <span class="ql-formats">
                     <button type="button" class="ql-bold" aria-pressed="false" aria-label="bold">
                        <svg viewBox="0 0 18 18">
                           <path class="ql-stroke" d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z"></path>
                           <path class="ql-stroke" d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z"></path>
                        </svg>
                     </button>
                     <button type="button" class="ql-italic" aria-pressed="false" aria-label="italic">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke" x1="7" x2="13" y1="4" y2="4"></line>
                           <line class="ql-stroke" x1="5" x2="11" y1="14" y2="14"></line>
                           <line class="ql-stroke" x1="8" x2="10" y1="14" y2="4"></line>
                        </svg>
                     </button>
                     <button type="button" class="ql-underline" aria-pressed="false" aria-label="underline">
                        <svg viewBox="0 0 18 18">
                           <path class="ql-stroke" d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3"></path>
                           <rect class="ql-fill" height="1" rx="0.5" ry="0.5" width="12" x="3" y="15"></rect>
                        </svg>
                     </button>
                     <button type="button" class="ql-strike" aria-pressed="false" aria-label="strike">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke ql-thin" x1="15.5" x2="2.5" y1="8.5" y2="9.5"></line>
                           <path class="ql-fill" d="M9.007,8C6.542,7.791,6,7.519,6,6.5,6,5.792,7.283,5,9,5c1.571,0,2.765.679,2.969,1.309a1,1,0,0,0,1.9-.617C13.356,4.106,11.354,3,9,3,6.2,3,4,4.538,4,6.5a3.2,3.2,0,0,0,.5,1.843Z"></path>
                           <path class="ql-fill" d="M8.984,10C11.457,10.208,12,10.479,12,11.5c0,0.708-1.283,1.5-3,1.5-1.571,0-2.765-.679-2.969-1.309a1,1,0,1,0-1.9.617C4.644,13.894,6.646,15,9,15c2.8,0,5-1.538,5-3.5a3.2,3.2,0,0,0-.5-1.843Z"></path>
                        </svg>
                     </button>
                  </span>
                  <span class="ql-formats">
                     <button type="button" class="ql-blockquote" aria-pressed="false" aria-label="blockquote">
                        <svg viewBox="0 0 18 18">
                           <rect class="ql-fill ql-stroke" height="3" width="3" x="4" y="5"></rect>
                           <rect class="ql-fill ql-stroke" height="3" width="3" x="11" y="5"></rect>
                           <path class="ql-even ql-fill ql-stroke" d="M7,8c0,4.031-3,5-3,5"></path>
                           <path class="ql-even ql-fill ql-stroke" d="M14,8c0,4.031-3,5-3,5"></path>
                        </svg>
                     </button>
                     <button type="button" class="ql-code-block" aria-pressed="false" aria-label="code-block">
                        <svg viewBox="0 0 18 18">
                           <polyline class="ql-even ql-stroke" points="5 7 3 9 5 11"></polyline>
                           <polyline class="ql-even ql-stroke" points="13 7 15 9 13 11"></polyline>
                           <line class="ql-stroke" x1="10" x2="8" y1="5" y2="13"></line>
                        </svg>
                     </button>
                  </span>
                  <span class="ql-formats">
                     <button type="button" class="ql-list" aria-pressed="false" value="ordered" aria-label="list: ordered">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke" x1="7" x2="15" y1="4" y2="4"></line>
                           <line class="ql-stroke" x1="7" x2="15" y1="9" y2="9"></line>
                           <line class="ql-stroke" x1="7" x2="15" y1="14" y2="14"></line>
                           <line class="ql-stroke ql-thin" x1="2.5" x2="4.5" y1="5.5" y2="5.5"></line>
                           <path class="ql-fill" d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z"></path>
                           <path class="ql-stroke ql-thin" d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156"></path>
                           <path class="ql-stroke ql-thin" d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109"></path>
                        </svg>
                     </button>
                     <button type="button" class="ql-list" aria-pressed="false" value="bullet" aria-label="list: bullet">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke" x1="6" x2="15" y1="4" y2="4"></line>
                           <line class="ql-stroke" x1="6" x2="15" y1="9" y2="9"></line>
                           <line class="ql-stroke" x1="6" x2="15" y1="14" y2="14"></line>
                           <line class="ql-stroke" x1="3" x2="3" y1="4" y2="4"></line>
                           <line class="ql-stroke" x1="3" x2="3" y1="9" y2="9"></line>
                           <line class="ql-stroke" x1="3" x2="3" y1="14" y2="14"></line>
                        </svg>
                     </button>
                     <button type="button" class="ql-align" aria-pressed="false" aria-label="align">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke" x1="3" x2="15" y1="9" y2="9"></line>
                           <line class="ql-stroke" x1="3" x2="13" y1="14" y2="14"></line>
                           <line class="ql-stroke" x1="3" x2="9" y1="4" y2="4"></line>
                        </svg>
                     </button>
                  </span>
                  <span class="ql-formats">
                     <span class="ql-color ql-picker ql-color-picker">
                        <span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-4">
                           <svg viewBox="0 0 18 18">
                              <line class="ql-color-label ql-stroke ql-transparent" x1="3" x2="15" y1="15" y2="15"></line>
                              <polyline class="ql-stroke" points="5.5 11 9 3 12.5 11"></polyline>
                              <line class="ql-stroke" x1="11.63" x2="6.38" y1="9" y2="9"></line>
                           </svg>
                        </span>
                        <span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-4"><span tabindex="0" role="button" class="ql-picker-item ql-primary"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#e60000" style="background-color: rgb(230, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ff9900" style="background-color: rgb(255, 153, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ffff00" style="background-color: rgb(255, 255, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#008a00" style="background-color: rgb(0, 138, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#0066cc" style="background-color: rgb(0, 102, 204);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#9933ff" style="background-color: rgb(153, 51, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffffff" style="background-color: rgb(255, 255, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#facccc" style="background-color: rgb(250, 204, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffebcc" style="background-color: rgb(255, 235, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffffcc" style="background-color: rgb(255, 255, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#cce8cc" style="background-color: rgb(204, 232, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#cce0f5" style="background-color: rgb(204, 224, 245);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ebd6ff" style="background-color: rgb(235, 214, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#bbbbbb" style="background-color: rgb(187, 187, 187);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#f06666" style="background-color: rgb(240, 102, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffc266" style="background-color: rgb(255, 194, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffff66" style="background-color: rgb(255, 255, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#66b966" style="background-color: rgb(102, 185, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#66a3e0" style="background-color: rgb(102, 163, 224);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#c285ff" style="background-color: rgb(194, 133, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#888888" style="background-color: rgb(136, 136, 136);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#a10000" style="background-color: rgb(161, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#b26b00" style="background-color: rgb(178, 107, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#b2b200" style="background-color: rgb(178, 178, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#006100" style="background-color: rgb(0, 97, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#0047b2" style="background-color: rgb(0, 71, 178);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#6b24b2" style="background-color: rgb(107, 36, 178);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#444444" style="background-color: rgb(68, 68, 68);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#5c0000" style="background-color: rgb(92, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#663d00" style="background-color: rgb(102, 61, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#666600" style="background-color: rgb(102, 102, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#003700" style="background-color: rgb(0, 55, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#002966" style="background-color: rgb(0, 41, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#3d1466" style="background-color: rgb(61, 20, 102);"></span></span>
                     </span>
                     <select class="ql-color" style="display: none;">
                        <option selected="selected"></option>
                        <option value="#e60000"></option>
                        <option value="#ff9900"></option>
                        <option value="#ffff00"></option>
                        <option value="#008a00"></option>
                        <option value="#0066cc"></option>
                        <option value="#9933ff"></option>
                        <option value="#ffffff"></option>
                        <option value="#facccc"></option>
                        <option value="#ffebcc"></option>
                        <option value="#ffffcc"></option>
                        <option value="#cce8cc"></option>
                        <option value="#cce0f5"></option>
                        <option value="#ebd6ff"></option>
                        <option value="#bbbbbb"></option>
                        <option value="#f06666"></option>
                        <option value="#ffc266"></option>
                        <option value="#ffff66"></option>
                        <option value="#66b966"></option>
                        <option value="#66a3e0"></option>
                        <option value="#c285ff"></option>
                        <option value="#888888"></option>
                        <option value="#a10000"></option>
                        <option value="#b26b00"></option>
                        <option value="#b2b200"></option>
                        <option value="#006100"></option>
                        <option value="#0047b2"></option>
                        <option value="#6b24b2"></option>
                        <option value="#444444"></option>
                        <option value="#5c0000"></option>
                        <option value="#663d00"></option>
                        <option value="#666600"></option>
                        <option value="#003700"></option>
                        <option value="#002966"></option>
                        <option value="#3d1466"></option>
                     </select>
                     <span class="ql-background ql-picker ql-color-picker">
                        <span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-5">
                           <svg viewBox="0 0 18 18">
                              <g class="ql-fill ql-color-label">
                                 <polygon points="6 6.868 6 6 5 6 5 7 5.942 7 6 6.868"></polygon>
                                 <rect height="1" width="1" x="4" y="4"></rect>
                                 <polygon points="6.817 5 6 5 6 6 6.38 6 6.817 5"></polygon>
                                 <rect height="1" width="1" x="2" y="6"></rect>
                                 <rect height="1" width="1" x="3" y="5"></rect>
                                 <rect height="1" width="1" x="4" y="7"></rect>
                                 <polygon points="4 11.439 4 11 3 11 3 12 3.755 12 4 11.439"></polygon>
                                 <rect height="1" width="1" x="2" y="12"></rect>
                                 <rect height="1" width="1" x="2" y="9"></rect>
                                 <rect height="1" width="1" x="2" y="15"></rect>
                                 <polygon points="4.63 10 4 10 4 11 4.192 11 4.63 10"></polygon>
                                 <rect height="1" width="1" x="3" y="8"></rect>
                                 <path d="M10.832,4.2L11,4.582V4H10.708A1.948,1.948,0,0,1,10.832,4.2Z"></path>
                                 <path d="M7,4.582L7.168,4.2A1.929,1.929,0,0,1,7.292,4H7V4.582Z"></path>
                                 <path d="M8,13H7.683l-0.351.8a1.933,1.933,0,0,1-.124.2H8V13Z"></path>
                                 <rect height="1" width="1" x="12" y="2"></rect>
                                 <rect height="1" width="1" x="11" y="3"></rect>
                                 <path d="M9,3H8V3.282A1.985,1.985,0,0,1,9,3Z"></path>
                                 <rect height="1" width="1" x="2" y="3"></rect>
                                 <rect height="1" width="1" x="6" y="2"></rect>
                                 <rect height="1" width="1" x="3" y="2"></rect>
                                 <rect height="1" width="1" x="5" y="3"></rect>
                                 <rect height="1" width="1" x="9" y="2"></rect>
                                 <rect height="1" width="1" x="15" y="14"></rect>
                                 <polygon points="13.447 10.174 13.469 10.225 13.472 10.232 13.808 11 14 11 14 10 13.37 10 13.447 10.174"></polygon>
                                 <rect height="1" width="1" x="13" y="7"></rect>
                                 <rect height="1" width="1" x="15" y="5"></rect>
                                 <rect height="1" width="1" x="14" y="6"></rect>
                                 <rect height="1" width="1" x="15" y="8"></rect>
                                 <rect height="1" width="1" x="14" y="9"></rect>
                                 <path d="M3.775,14H3v1H4V14.314A1.97,1.97,0,0,1,3.775,14Z"></path>
                                 <rect height="1" width="1" x="14" y="3"></rect>
                                 <polygon points="12 6.868 12 6 11.62 6 12 6.868"></polygon>
                                 <rect height="1" width="1" x="15" y="2"></rect>
                                 <rect height="1" width="1" x="12" y="5"></rect>
                                 <rect height="1" width="1" x="13" y="4"></rect>
                                 <polygon points="12.933 9 13 9 13 8 12.495 8 12.933 9"></polygon>
                                 <rect height="1" width="1" x="9" y="14"></rect>
                                 <rect height="1" width="1" x="8" y="15"></rect>
                                 <path d="M6,14.926V15H7V14.316A1.993,1.993,0,0,1,6,14.926Z"></path>
                                 <rect height="1" width="1" x="5" y="15"></rect>
                                 <path d="M10.668,13.8L10.317,13H10v1h0.792A1.947,1.947,0,0,1,10.668,13.8Z"></path>
                                 <rect height="1" width="1" x="11" y="15"></rect>
                                 <path d="M14.332,12.2a1.99,1.99,0,0,1,.166.8H15V12H14.245Z"></path>
                                 <rect height="1" width="1" x="14" y="15"></rect>
                                 <rect height="1" width="1" x="15" y="11"></rect>
                              </g>
                              <polyline class="ql-stroke" points="5.5 13 9 5 12.5 13"></polyline>
                              <line class="ql-stroke" x1="11.63" x2="6.38" y1="11" y2="11"></line>
                           </svg>
                        </span>
                        <span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-5"><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#000000" style="background-color: rgb(0, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#e60000" style="background-color: rgb(230, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ff9900" style="background-color: rgb(255, 153, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ffff00" style="background-color: rgb(255, 255, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#008a00" style="background-color: rgb(0, 138, 0);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#0066cc" style="background-color: rgb(0, 102, 204);"></span><span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#9933ff" style="background-color: rgb(153, 51, 255);"></span><span tabindex="0" role="button" class="ql-picker-item"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#facccc" style="background-color: rgb(250, 204, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffebcc" style="background-color: rgb(255, 235, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffffcc" style="background-color: rgb(255, 255, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#cce8cc" style="background-color: rgb(204, 232, 204);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#cce0f5" style="background-color: rgb(204, 224, 245);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ebd6ff" style="background-color: rgb(235, 214, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#bbbbbb" style="background-color: rgb(187, 187, 187);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#f06666" style="background-color: rgb(240, 102, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffc266" style="background-color: rgb(255, 194, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#ffff66" style="background-color: rgb(255, 255, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#66b966" style="background-color: rgb(102, 185, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#66a3e0" style="background-color: rgb(102, 163, 224);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#c285ff" style="background-color: rgb(194, 133, 255);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#888888" style="background-color: rgb(136, 136, 136);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#a10000" style="background-color: rgb(161, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#b26b00" style="background-color: rgb(178, 107, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#b2b200" style="background-color: rgb(178, 178, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#006100" style="background-color: rgb(0, 97, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#0047b2" style="background-color: rgb(0, 71, 178);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#6b24b2" style="background-color: rgb(107, 36, 178);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#444444" style="background-color: rgb(68, 68, 68);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#5c0000" style="background-color: rgb(92, 0, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#663d00" style="background-color: rgb(102, 61, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#666600" style="background-color: rgb(102, 102, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#003700" style="background-color: rgb(0, 55, 0);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#002966" style="background-color: rgb(0, 41, 102);"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="#3d1466" style="background-color: rgb(61, 20, 102);"></span></span>
                     </span>
                     <select class="ql-background" style="display: none;">
                        <option value="#000000"></option>
                        <option value="#e60000"></option>
                        <option value="#ff9900"></option>
                        <option value="#ffff00"></option>
                        <option value="#008a00"></option>
                        <option value="#0066cc"></option>
                        <option value="#9933ff"></option>
                        <option selected="selected"></option>
                        <option value="#facccc"></option>
                        <option value="#ffebcc"></option>
                        <option value="#ffffcc"></option>
                        <option value="#cce8cc"></option>
                        <option value="#cce0f5"></option>
                        <option value="#ebd6ff"></option>
                        <option value="#bbbbbb"></option>
                        <option value="#f06666"></option>
                        <option value="#ffc266"></option>
                        <option value="#ffff66"></option>
                        <option value="#66b966"></option>
                        <option value="#66a3e0"></option>
                        <option value="#c285ff"></option>
                        <option value="#888888"></option>
                        <option value="#a10000"></option>
                        <option value="#b26b00"></option>
                        <option value="#b2b200"></option>
                        <option value="#006100"></option>
                        <option value="#0047b2"></option>
                        <option value="#6b24b2"></option>
                        <option value="#444444"></option>
                        <option value="#5c0000"></option>
                        <option value="#663d00"></option>
                        <option value="#666600"></option>
                        <option value="#003700"></option>
                        <option value="#002966"></option>
                        <option value="#3d1466"></option>
                     </select>
                  </span>
                  <span class="ql-formats">
                     <span class="ql-size ql-picker">
                        <span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-6">
                           <svg viewBox="0 0 18 18">
                              <polygon class="ql-stroke" points="7 11 9 13 11 11 7 11"></polygon>
                              <polygon class="ql-stroke" points="7 7 9 5 11 7 7 7"></polygon>
                           </svg>
                        </span>
                        <span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-6"><span tabindex="0" role="button" class="ql-picker-item" data-value="small"></span><span tabindex="0" role="button" class="ql-picker-item"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="large"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="huge"></span></span>
                     </span>
                     <select class="ql-size" style="display: none;">
                        <option value="small"></option>
                        <option selected="selected"></option>
                        <option value="large"></option>
                        <option value="huge"></option>
                     </select>
                  </span>
                  <span class="ql-formats">
                     <span class="ql-header ql-picker">
                        <span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-7">
                           <svg viewBox="0 0 18 18">
                              <polygon class="ql-stroke" points="7 11 9 13 11 11 7 11"></polygon>
                              <polygon class="ql-stroke" points="7 7 9 5 11 7 7 7"></polygon>
                           </svg>
                        </span>
                        <span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-7"><span tabindex="0" role="button" class="ql-picker-item" data-value="1"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="2"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="3"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="4"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="5"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="6"></span><span tabindex="0" role="button" class="ql-picker-item"></span></span>
                     </span>
                     <select class="ql-header" style="display: none;">
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option value="4"></option>
                        <option value="5"></option>
                        <option value="6"></option>
                        <option selected="selected"></option>
                     </select>
                  </span>
                  <span class="ql-formats">
                     <button type="button" class="ql-link" aria-pressed="false" aria-label="link">
                        <svg viewBox="0 0 18 18">
                           <line class="ql-stroke" x1="7" x2="11" y1="7" y2="11"></line>
                           <path class="ql-even ql-stroke" d="M8.9,4.577a3.476,3.476,0,0,1,.36,4.679A3.476,3.476,0,0,1,4.577,8.9C3.185,7.5,2.035,6.4,4.217,4.217S7.5,3.185,8.9,4.577Z"></path>
                           <path class="ql-even ql-stroke" d="M13.423,9.1a3.476,3.476,0,0,0-4.679-.36,3.476,3.476,0,0,0,.36,4.679c1.392,1.392,2.5,2.542,4.679.36S14.815,10.5,13.423,9.1Z"></path>
                        </svg>
                     </button>
                  </span>
               </div>
               <div class="txa-warranty-policy bg-transparent h-300px ql-container ql-snow">
                  <div class="ql-editor ql-blank" contenteditable="true">
                     <p><br></p>
                  </div>
                  <div class="ql-tooltip ql-hidden"><a class="ql-preview" rel="noopener noreferrer" target="_blank" href="about:blank"></a><input type="text" data-formula="e=mc^2" data-link="https://quilljs.com" data-video="Embed URL"><a class="ql-action"></a><a class="ql-remove"></a></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12">
         <button type="button" class="btn btn-primary w-100" onclick="_products.on.click.updateProduct('{{ $product->id }}')" data-lang="button::Update">Cập nhật</button>
      </div>
   </div>
   <script>const MY_1DG = false, MY_1DG_PRIVATE = false, PARAMS_BY_TYPE = {"Manual":["require_text"],"Auto":["require_text"],"Service":["require_text"],"Veo3":["prompt"],"NEW_VEO3":["prompt","images"],"VEO2_QUALITY":["prompt","images"],"VEO2_FAST":["prompt","images"],"HAILUO_V2_768P_6S":["prompt","images"],"HAILUO_V2_1080P_6S":["prompt","images"],"HAILUO_V2_768P_10S":["prompt","images"],"KLING_1_6_5S":["prompt","images"],"KLING_1_6_10S":["prompt","images"],"KLING_2_1_5S":["prompt","images"],"KLING_2_1_10S":["prompt","images"],"AI_IMAGE_DEFAULT":["prompt","images","dimension","style"],"AI_VIDEO_DEFAULT":["prompt","images","dimension"],"AI_VOICE_DEFAULT":["prompt","speed","pause_duration","speaker","speaker_profile"],"GG_IMAGE_3_5":["prompt","images","dimension"],"GG_IMAGE_3_1":["prompt","images","dimension"],"HAILUO_IMAGE_01":["prompt","images","dimension"],"KLING_COLORS_2_1":["prompt","dimension"],"KLING_COLORS_2_0":["prompt","dimension"],"KLING_COLORS_1_5":["prompt","dimension"],"AI_IMAGE_OLD":["prompt","images","dimension"],"AI_VIDEO_OLD":["prompt","images","references","dimension"],"AI_VIDEO_VIETAUTO":["prompt","images","references","dimension"],"AI_IMAGE_VIETAUTO":["prompt","images","dimension"],"ANS":["require_text"]};</script>
   <script>
      var INFO_PRODUCT = @json($productInfo);
   </script>
</div>
@endsection
@push('scripts')
   <script>$(document).ready(function () { _products.init(); });</script>
@endpush
