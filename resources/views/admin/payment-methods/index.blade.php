@extends('admin.layouts.app')
@section('title', 'Payment methods')
@section('content')

<div class="content flex-row-fluid" id="kt_content" data-payment-methods-page data-announcement-enabled="{{ ($config->announcement_payment_status ?? false) ? 1 : 0 }}" data-announcement-content="{{ base64_encode($config->announcement_payment ?? '') }}">
   <span class="title d-none">Methods</span>
   <div class="div-form mb-5" style="display: none;">
      <div class="d-flex flex-wrap flex-stack mb-6">
         <h3 class="fw-bold my-2 div-title"></h3>
         <div class="d-flex flex-wrap my-2">
            <button class="btn btn-warning btn-sm btn-verify btn-verify-3" data-bs-toggle="modal" data-bs-target="#modal-verify-perfectmoney" style="display: none;" data-lang="How to verify?">Hướng dẫn xác thực</button>
            <button class="btn btn-warning btn-sm btn-verify btn-verify-4" data-bs-toggle="modal" data-bs-target="#modal-verify-payeer" style="display: none;" data-lang="How to verify?">Hướng dẫn xác thực</button>
            <button class="btn btn-warning btn-sm btn-verify btn-verify-14" data-bs-toggle="modal" data-bs-target="#modal-verify-cryptomus" style="display: none;" data-lang="How to verify?">Hướng dẫn xác thực</button>
            <button class="btn btn-warning btn-sm btn-verify btn-verify-27" data-bs-toggle="modal" data-bs-target="#modal-config-xendit" style="display: none;" data-lang="How to config?">Hướng dẫn cấu hình</button>
            <button class="btn btn-warning btn-sm btn-verify btn-verify-28" data-bs-toggle="modal" data-bs-target="#modal-config-xendit" style="display: none;" data-lang="How to config?">Hướng dẫn cấu hình</button>
            <button class="btn btn-warning btn-sm btn-verify btn-verify-32" data-bs-toggle="modal" data-bs-target="#modal-config-bhratpe" style="display: none;" data-lang="How to config?">Hướng dẫn cấu hình</button>
         </div>
      </div>
      <div class="card mb-5">
         <div class="card-body">
            <div class="row g-5 mb-5">
               <div class="col-lg-4">
                  <label class="required form-label" data-lang="Method">Phương thức</label>
                  <select class="form-select form-select-solid sl-pma" onchange="_payments.on.change.method(this.value)">
                     @foreach ($paymentMethodTemplates as $template)
                     <option value="{{ $template['legacy_id'] }}" data-icon="{{ $template['icon'] }}" data-currency="{{ $template['currency'] }}">{{ $template['name'] }}{{ $template['currency'] ? ' (' . $template['currency'] . ')' : '' }}</option>
                     @endforeach
                  </select>

               </div>
               <div class="col-lg-8">
                  <label class="required form-label" data-lang="Name">Tên</label>
                  <input type="text" class="form-control form-control-solid ipt-pm-method-name">
               </div>
            </div>
            <div class="mb-5">
               <label class="form-label" data-lang="Icon">Biểu tượng</label>
               <div class="input-group input-group-solid">
                  <span class="input-group-text icon-image"></span>
                  <input type="text" class="form-control ipt-pm-icon" placeholder="https://example.com/image.png" onkeyup="_payments.on.keyup.icon(this.value)">
               </div>
            </div>
            <div class="">
               <!-- My 1DG -->
               <!-- Casso -->
               <div class="div-options div-1 div-2 div-9 div-26 div-30 div-31" style="display: none;">
                  <div class="alert alert-warning">Đăng kí Casso tại <a target="_blank" href="https://my.casso.vn/">đây</a></div>
                  <div class="mb-5">
                     <label class="required form-label">Số tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-casso-account" placeholder="1028xxxxxx">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tên tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-casso-name" placeholder="NGUYEN VAN A">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Key bảo mật</label>
                     <input type="text" class="form-control form-control-solid ipt-casso-secretcode" placeholder="xxxxx">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tỉ giá chuyển đổi</label>
                     <input type="text" class="form-control form-control-solid ipt-casso-rate" value="26000">
                     <span class="text-muted">Tỉ giá chuyển đổi từ VNĐ sang USD</span>
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Webhook</label>
                     <div class="input-group input-group-solid border border-primary">
                        <input type="text" class="form-control fst-italic ipt-webhook ipt-casso-webhook" readonly="">
                        <button type="button" class="btn btn-primary" onclick="app_admin.copy('.ipt-casso-webhook')">Copy</button>
                     </div>
                  </div>
               </div>
               <!-- Perfectmoney -->
               <div class="div-options div-3" style="display: none;">
                  <div class="mb-5">
                     <label class="required form-label">Perfectmoney account</label>
                     <input type="text" class="form-control form-control-solid ipt-pm-account" placeholder="Uxxxxx">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Alternate Passphrase</label>
                     <input type="text" class="form-control form-control-solid ipt-pm-passphrase" placeholder="">
                  </div>
               </div>
               <!-- Payeer -->
               <div class="div-options div-4" style="display: none;">
                  <div class="mb-5">
                     <label class="required form-label">Merchant identifier</label>
                     <input type="text" class="form-control form-control-solid ipt-payeer-merchant" placeholder="Identifier of your merchant: 1688913048">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Secret key</label>
                     <input type="text" class="form-control form-control-solid ipt-payeer-key" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Success URL</label>
                     <input type="text" class="form-control form-control-solid" value="https://smmkay.com/api/payeer_success" readonly="">
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Fail URL</label>
                     <input type="text" class="form-control form-control-solid" value="https://smmkay.com/api/payeer_fail" readonly="">
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Status URL</label>
                     <input type="text" class="form-control form-control-solid" value="https://smmkay.com/api/payeer_status" readonly="">
                  </div>
               </div>
               <!-- ApiBank.Me -->
               <div class="div-options div-5" style="display: none;">
                  <div class="mb-5">
                     <label class="required form-label">Access token</label>
                     <input type="text" class="form-control form-control-solid ipt-apibank-token">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Chọn loại</label>
                     <select class="form-select form-select-solid sl-apibank-type" data-kt-select2="true" data-hide-search="true" onchange="_payments.on.change.apibank(this.value)">
                        <option value="momo">Momo</option>
                     </select>

                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Cú pháp nạp:</label>
                     <input type="text" class="form-control ipt-apibank-regex">
                     <span class="text-muted">Ví dụ: Cú pháp nạp là NAP thì khi khách chuyển tiền khách sẽ điền nội dung NAP+tên đăng nhập (NAPusername)</span>
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tỉ giá chuyển đổi:</label>
                     <input type="text" class="form-control form-control-solid ipt-apibank-rate" value="23000">
                     <span class="text-muted">Tỉ giá chuyển đổi từ VNĐ sang USD</span>
                  </div>
                  <div class="mb-5 div-momo">
                     <label class="required form-label">Số điện thoại (Tài khoản Momo)</label>
                     <input type="text" class="form-control form-control-solid ipt-apibank-momo-phone">
                  </div>
                  <div class="mb-5 div-bank" style="display: none;">
                     <label class="required form-label">Tên đăng nhập</label>
                     <input type="text" class="form-control form-control-solid ipt-apibank-bank-username">
                  </div>
                  <div class="mb-5 div-bank" style="display: none;">
                     <label class="required form-label">Mật khẩu</label>
                     <input type="text" class="form-control ipt-apibank-bank-password">
                  </div>
                  <div class="mb-5 div-bank" style="display: none;">
                     <label class="required form-label">Số tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-apibank-bank-accountNumber">
                  </div>
               </div>
               <!-- Vietcombank -->
               <div class="div-options div-6" style="display: none;">
                  <div class="mb-5">
                     <label class="required form-label">Tài khoản đăng nhập trên Web</label>
                     <input type="text" class="form-control form-control-solid ipt-vietcombank-user" placeholder="tài khoản">
                     <span class="text-muted">Bật cho phép đăng nhập trên Web ở trên ứng dụng Vietcombank</span>
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Mật khẩu đăng nhập trên Web</label>
                     <input type="text" class="form-control form-control-solid ipt-vietcombank-pass" placeholder="mật khẩu">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Số tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-vietcombank-account" placeholder="003124xxxxx">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tên tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-vietcombank-name" placeholder="NGUYEN VAN A">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">API Key Captcha</label>
                     <input type="text" class="form-control form-control-solid ipt-vietcombank-captcha" placeholder="xxxxx">
                     <span class="text-muted">Lấy API Key tại đây: https://anycaptcha.com</span>
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tỉ giá chuyển đổi:</label>
                     <input type="text" class="form-control form-control-solid ipt-vietcombank-rate" value="23000">
                     <span class="text-muted">Tỉ giá chuyển đổi từ VNĐ sang USD</span>
                  </div>
               </div>
               <!-- UddoktaPay -->
               <div class="div-options div-7" style="display: none;">
                  <div class="mb-5">
                     <label class="required form-label">API Key</label>
                     <input type="text" class="form-control form-control-solid ipt-uddktapay-key" placeholder="982d381360a69d419689740d9f2e26ce36fb7a50">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">API Url</label>
                     <input type="text" class="form-control form-control-solid ipt-uddktapay-url" placeholder="https://sandbox.uddoktapay.com/api/checkout-v2">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Rate</label>
                     <input type="text" class="form-control form-control-solid ipt-uddktapay-rate" value="">
                  </div>
               </div>
               <!-- Momo -->
               <div class="div-options div-8" style="display: none;">
                  <div class="alert alert-warning">Đăng kí API Momo tại <a href="https://momosv3.apimienphi.com/">đây</a>. Lấy mã Signature và đăng ký Webhook tại <a target="_blank" href="https://momosv3.apimienphi.com/admin/logs/webhook">đây</a>.</div>
                  <div class="alert alert-warning">Lưu ý nạp tối thiểu 5,001 ₫.</div>
                  <div class="mb-5">
                     <label class="required form-label">Số điện thoại</label>
                     <input type="text" class="form-control form-control-solid ipt-momo-phone" placeholder="0987654321">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tỉ giá chuyển đổi:</label>
                     <input type="text" class="form-control form-control-solid ipt-momo-rate" value="24000">
                     <span class="text-muted">Tỉ giá chuyển đổi từ VNĐ sang USD</span>
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Signature</label>
                     <input type="text" class="form-control form-control-solid ipt-momo-signature" placeholder="5a462d9dexxxx">
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Webhook</label>
                     <div class="input-group input-group-solid border border-primary">
                        <input type="text" class="form-control fst-italic ipt-webhook ipt-momo-webhook" readonly="">
                        <button type="button" class="btn btn-primary" onclick="app_admin.copy('.ipt-momo-webhook')">Copy</button>
                     </div>
                  </div>
               </div>
               <!-- Web2m -->
               <div class="div-options div-web2m div-10 div-11 div-12 div-16" style="display: none;">
                  <div class="alert alert-warning">Đăng kí Web2m tại <a target="_blank" href="http://api.web2m.com/">đây</a></div>
                  <div class="mb-5">
                     <label class="required form-label ">Số tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-account" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tên tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-name" placeholder="NGUYEN VAN A">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label pass-web2m">Mật khẩu tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-password" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Token</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-token" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label rate-web2m">Tỉ giá chuyển đổi</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-rate" value="24000">
                     <span class="text-muted">Tỉ giá chuyển đổi từ VNĐ sang USD</span>
                  </div>
               </div>
               <div class="div-options div-13" style="display: none;">
                  <div class="alert alert-warning">Đăng kí Web2m tại <a target="_blank" href="http://api.web2m.com/">đây</a></div>
                  <div class="alert alert-warning">Lưu ý nạp tối thiểu 5,001 ₫.</div>
                  <div class="mb-5 div-web2m-account">
                     <label class="required form-label ">Số điện thoại</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-account" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Token</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-token" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label rate-web2m">Tỉ giá chuyển đổi</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-rate" value="24000">
                     <span class="text-muted">Tỉ giá chuyển đổi từ VNĐ sang USD</span>
                  </div>
               </div>
               <!-- Cryptomus -->
               <div class="div-options div-14" style="display: none;">
                  <div class="alert alert-warning">Đăng kí Cryptomus tại <a href="https://cryptomus.com/">đây</a>.</div>
                  <div class="alert alert-warning">Lưu ý nạp tối thiểu 10 USD.</div>
                  <div class="mb-5">
                     <label class="required form-label">Merchant ID</label>
                     <input type="text" class="form-control form-control-solid ipt-cryptomus-merchant" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Payment API Key</label>
                     <input type="text" class="form-control form-control-solid ipt-cryptomus-key" placeholder="">
                  </div>
               </div>
               <!-- FPayment -->
               <div class="div-options div-15" style="display: none;">
                  <div class="alert alert-warning">Đăng kí FPayment tại <a href="https://fpayment.co/client/register">đây</a>.</div>
                  <div class="mb-5">
                     <label class="required form-label">Address Wallet</label>
                     <input type="text" class="form-control form-control-solid ipt-fpayment-wallet" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Token Wallet</label>
                     <input type="text" class="form-control form-control-solid ipt-fpayment-token" placeholder="">
                  </div>
               </div>
               <!-- CoinPayments -->
               <div class="div-options div-17" style="display: none;">
                  <div class="alert alert-warning">Đăng kí CoinPayments tại <a href="https://www.coinpayments.net/register">đây</a>. Lấy Merchant ID và tạo IPN Secret tại <a href="https://www.coinpayments.net/acct-settings">đây</a>.</div>
                  <div class="mb-5">
                     <label class="required form-label">Merchant ID</label>
                     <input type="text" class="form-control form-control-solid ipt-coinpayments-merchant" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">IPN Secret</label>
                     <input type="text" class="form-control form-control-solid ipt-coinpayments-secret" placeholder="">
                  </div>
               </div>
               <!-- CoinBase -->
               <div class="div-options div-18" style="display: none;">
                  <div class="alert alert-warning">Đăng kí CoinBase tại <a href="https://beta.commerce.coinbase.com/sign-up">đây</a>.</div>
                  <div class="mb-5">
                     <label class="required form-label">Api Key</label>
                     <input type="text" class="form-control form-control-solid ipt-coinbase-key" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Shared Secret</label>
                     <input type="text" class="form-control form-control-solid ipt-coinbase-secret" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Webhook</label>
                     <div class="input-group input-group-solid border border-primary">
                        <input type="text" class="form-control fst-italic ipt-webhook ipt-coinbase-webhook" readonly="">
                        <button type="button" class="btn btn-primary" onclick="app_admin.copy('.ipt-coinbase-webhook')">Copy</button>
                     </div>
                  </div>
               </div>
               <!-- Web2m Webhook -->
               <div class="div-options div-19 div-20 div-21 div-22 div-29 div-37" style="display: none;">
                  <div class="alert alert-warning">Đăng kí Web2m tại <a target="_blank" href="http://api.web2m.com/">đây</a></div>
                  <div class="mb-5">
                     <label class="required form-label">Số tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-webhook-account" placeholder="1028xxxxxx">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tên tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-webhook-name" placeholder="NGUYEN VAN A">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Access Token</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-webhook-accesstoken" placeholder="xxxxx">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tỉ giá chuyển đổi</label>
                     <input type="text" class="form-control form-control-solid ipt-web2m-webhook-rate" value="24000">
                     <span class="text-muted">Tỉ giá chuyển đổi từ VNĐ sang USD</span>
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Webhook</label>
                     <div class="input-group input-group-solid border border-primary">
                        <input type="text" class="form-control fst-italic ipt-webhook ipt-web2m-webhook" readonly="">
                        <button type="button" class="btn btn-primary" onclick="app_admin.copy('.ipt-web2m-webhook')">Copy</button>
                     </div>
                  </div>
               </div>
               <!-- Sieuthicode Webhook -->
               <div class="div-options div-23 div-24 div-25 div-38" style="display: none;">
                  <div class="alert alert-warning">Đăng kí sieuthicode tại <a target="_blank" href="http://api.sieuthicode.net/">đây</a></div>
                  <div class="mb-5">
                     <label class="required form-label">Số tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-sieuthicode-webhook-account" placeholder="1028xxxxxx">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tên tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-sieuthicode-webhook-name" placeholder="NGUYEN VAN A">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Signature</label>
                     <input type="text" class="form-control form-control-solid ipt-sieuthicode-webhook-signature" placeholder="xxxxx">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tỉ giá chuyển đổi</label>
                     <input type="text" class="form-control form-control-solid ipt-sieuthicode-webhook-rate" value="24000">
                     <span class="text-muted">Tỉ giá chuyển đổi từ VNĐ sang USD</span>
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Webhook</label>
                     <div class="input-group input-group-solid border border-primary">
                        <input type="text" class="form-control fst-italic ipt-webhook ipt-sieuthicode-webhook" readonly="">
                        <button type="button" class="btn btn-primary" onclick="app_admin.copy('.ipt-sieuthicode-webhook')">Copy</button>
                     </div>
                  </div>
               </div>
               <!-- Xendit -->
               <div class="div-options div-27 div-28" style="display: none;">
                  <div class="mb-5">
                     <label class="required form-label">API Key</label>
                     <input type="text" class="form-control form-control-solid ipt-xendit-api-key" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Webhook Secret Key</label>
                     <input type="text" class="form-control form-control-solid ipt-xendit-secret" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Rate</label>
                     <input type="text" class="form-control form-control-solid ipt-xendit-rate" value="">
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Webhook</label>
                     <div class="input-group input-group-solid border border-primary">
                        <input type="text" class="form-control fst-italic ipt-webhook ipt-xendit-webhook" readonly="">
                        <button type="button" class="btn btn-primary" onclick="app_admin.copy('.ipt-xendit-webhook')">Copy</button>
                     </div>
                  </div>
               </div>
               <!-- BharatPe -->
               <div class="div-options div-32" style="display: none;">
                  <div class="mb-5">
                     <label class="required form-label">Merchant ID</label>
                     <input type="text" class="form-control form-control-solid ipt-bharatpe-merchant" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Token</label>
                     <input type="text" class="form-control form-control-solid ipt-bharatpe-token" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">QR URL</label>
                     <input type="text" class="form-control form-control-solid ipt-bharatpe-qr" value="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Rate</label>
                     <input type="text" class="form-control form-control-solid ipt-bharatpe-rate" value="">
                  </div>
               </div>
               <!-- FPayAz -->
               <div class="div-options div-33" style="display: none;">
                  <div class="alert alert-warning">Sign up and get key and secret key at <a target="_blank" href="https://fpayaz.com/">here</a></div>
                  <div class="mb-5">
                     <label class="required form-label">Key</label>
                     <input type="text" class="form-control form-control-solid ipt-fpayaz-key" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Secret key</label>
                     <input type="text" class="form-control form-control-solid ipt-fpayaz-secret" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="form-label" data-lang="QR Code URL">QR Code URL</label>
                     <input type="url" class="form-control form-control-solid ipt-fpayaz-qr-image" placeholder="https://example.com/binance-qr.png">
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Binance ID</label>
                     <input type="text" class="form-control form-control-solid ipt-fpayaz-binance-id" placeholder="Enter Binance ID">
                  </div>
               </div>
               <!-- Stripe -->
               <div class="div-options div-45" style="display: none;">
                  <div class="alert alert-warning">Sign up and get secret key and webhook secret at <a target="_blank" href="https://stripe.com/">here</a></div>
                  <div class="mb-5">
                     <label class="required form-label">Stripe Secret Key</label>
                     <input type="text" class="form-control form-control-solid ipt-stripe-secret_key" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Stripe Webhook Secret</label>
                     <input type="text" class="form-control form-control-solid ipt-stripe-webhook_secret" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Webhook</label>
                     <div class="input-group input-group-solid border border-primary">
                        <input type="text" class="form-control fst-italic ipt-webhook ipt-stripe-webhook" readonly="">
                        <button type="button" class="btn btn-primary" onclick="app_admin.copy('.ipt-stripe-webhook')">Copy</button>
                     </div>
                  </div>
               </div>
               <!-- Paypal -->
               <div class="div-options div-34" style="display: none;">
                  <div class="mb-5">
                     <label class="required form-label">Merchant Username</label>
                     <input type="text" class="form-control form-control-solid ipt-paypal-username" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Merchant Password</label>
                     <input type="text" class="form-control form-control-solid ipt-paypal-password" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Merchant Signature</label>
                     <input type="text" class="form-control form-control-solid ipt-paypal-signature" placeholder="">
                  </div>
               </div>
               <!-- Khalti Payment -->
               <div class="div-options div-35" style="display: none;">
                  <div class="mb-5">
                     <label class="required form-label">LIVE SECRET KEY</label>
                     <input type="text" class="form-control form-control-solid ipt-khalti-api-key" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Rate</label>
                     <input type="text" class="form-control form-control-solid ipt-khalti-rate" value="">
                  </div>
               </div>
               <!-- FPayAz -->
               <div class="div-options div-36" style="display: none;">
                  <div class="alert alert-warning">Đăng kí và lấy key tại <a target="_blank" href="https://elongpay.net/">đây</a></div>
                  <div class="mb-5">
                     <label class="required form-label">Key</label>
                     <input type="text" class="form-control form-control-solid ipt-elongpay-key" placeholder="">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Secret key</label>
                     <input type="text" class="form-control form-control-solid ipt-elongpay-secret" placeholder="">
                  </div>
                  <div class="col-lg-6">
                     <label class="required form-label">Tỉ giá chuyển đổi</label>
                     <div class="input-group input-group-solid">
                        <span class="input-group-text">1 USD =</span>
                        <input type="text" class="form-control form-control-solid ipt-elongpay-rate" value="26000">
                        <span class="input-group-text" onclick="_payments.on.click.getRate('VND')">VND</span>
                     </div>
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Webhook</label>
                     <div class="input-group input-group-solid border border-primary">
                        <input type="text" class="form-control fst-italic ipt-webhook ipt-elongpay-webhook" readonly="">
                        <button type="button" class="btn btn-primary" onclick="app_admin.copy('.ipt-elongpay-webhook')">Copy</button>
                     </div>
                  </div>
               </div>
               <!-- Pay2S Webhook -->
               <div class="div-options div-39 div-40 div-41 div-42 div-43 div-44" style="display: none;">
                  <div class="alert alert-warning">Đăng kí Pay2S tại <a target="_blank" href="http://pay2s.vn/">đây</a></div>
                  <div class="mb-5">
                     <label class="required form-label">Số tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-pay2s-account" placeholder="1028xxxxxx">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tên tài khoản</label>
                     <input type="text" class="form-control form-control-solid ipt-pay2s-name" placeholder="NGUYEN VAN A">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Access Token</label>
                     <input type="text" class="form-control form-control-solid ipt-pay2s-accesstoken" placeholder="xxxxx">
                  </div>
                  <div class="mb-5">
                     <label class="required form-label">Tỉ giá chuyển đổi</label>
                     <input type="text" class="form-control form-control-solid ipt-pay2s-rate" value="24000">
                     <span class="text-muted">Tỉ giá chuyển đổi từ VNĐ sang USD</span>
                  </div>
                  <div class="mb-5">
                     <label class="form-label">Webhook</label>
                     <div class="input-group input-group-solid border border-primary">
                        <input type="text" class="form-control fst-italic ipt-webhook ipt-pay2s-webhook" readonly="">
                        <button type="button" class="btn btn-primary" onclick="app_admin.copy('.ipt-pay2s-webhook')">Copy</button>
                     </div>
                  </div>
               </div>
            </div>
            <hr>
            <!-- Options -->
            <!-- MinMax -->
            <div class="mb-5">
               <label class="required form-label"><span data-lang="Set min/max">Thiết lập giới hạn số lượng nạp</span> (<span class="minmax-currency fw-bold">USD</span>)</label>
               <div class="input-group input-group-solid">
                  <span class="input-group-text" data-lang="Min">Tối thiểu</span>
                  <input type="text" class="form-control ipt-pm-min" data-inputmask="'mask': '9', 'repeat': 9, 'greedy' : false" value="0" inputmode="text">
                  <span class="input-group-text" data-lang="Max">Tối đa</span>
                  <input type="text" class="form-control ipt-pm-max" data-inputmask="'mask': '9', 'repeat': 9, 'greedy' : false" value="0" inputmode="text">
               </div>
               <span class="text-muted fst-italic" data-lang="minmax-note">* Điền 0 cho không giới hạn.</span>
            </div>
            <!-- MinMax Transactions -->
            <div class="mb-5">
               <div class="row g-5">
                  <div class="col-sm-6">
                     <label class="required form-label" data-lang="Maximum transactions in 1 day">Số giao dịch tối đa trong 1 ngày</label>
                     <input type="text" class="form-control form-control-solid ipt-pm-max-transactions" data-inputmask="'mask': '9', 'repeat': 9, 'greedy' : false" value="0" inputmode="text">
                  </div>
                  <div class="col-sm-6">
                     <label class="required form-label" data-lang="Maximum total funds received in 1 day">Tổng số tiền nhận được tối đa trong 1 ngày</label>
                     <div class="input-group input-group-solid">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control ipt-pm-max-total-funds" data-inputmask="'mask': '9', 'repeat': 9, 'greedy' : false" value="0" inputmode="text">
                     </div>
                  </div>
                  <span class="text-muted fst-italic" data-lang="maximum-note">* Điền 0 cho không giới hạn. Khi đạt tới giới hạn tối đa, phương thức sẽ ẩn cho tới khi reset vào lúc 00:00 UTC Time.</span>
               </div>
            </div>
            <!-- Bonus -->
            <div class="mb-5">
               <div class="form-check form-switch form-check-custom form-check-solid me-10">
                  <input class="form-check-input cb-pm-bonus" type="checkbox" onchange="_payments.on.change.bonus(this.checked)">
                  <label class="form-check-label" data-lang="Bonus">Thưởng</label>
               </div>
            </div>
            <div class="mb-5 div-bonus" style="display: none;">
               <div class="div-bonus-data"></div>
               <button type="button" class="btn btn-secondary btn-sm" onclick="_payments.on.click.addBonusData()" data-page="/services" data-lang="Add condition">Thêm điều kiện</button>
            </div>
            <div class="mb-5">
               <label class="required form-label" data-lang="Details">Chi tiết</label>

               <div class="txa-pm-method-details h-250px"></div>
            </div>
         </div>
         <!--end::Body-->
      </div>
      <button type="button" class="btn btn-primary btn-new w-100" onclick="_payments.on.click.add(0)" data-lang="button::Add">Thêm</button>
      <button type="button" class="btn btn-primary btn-update w-100" style="display: none;" data-lang="button::Update">Cập nhật</button>
   </div>
   <div class="d-flex flex-wrap flex-stack">
      <h3 class="fw-bold my-2" data-lang="List">Danh sách</h3>
      <div class="d-flex flex-wrap my-2">
         <button class="btn btn-primary btn-sm" onclick="_payments.on.click.showFormAdd()" data-lang="Add method">Thêm phương thức</button>
      </div>
   </div>
   <div class="pt-5 pb-3 text-muted text-end show-all-methods" onclick="_payments.on.click.showAll(this.querySelector('i'), this.querySelector('i').className.includes('collapse'))">
      <span class="fst-italic pointer" data-lang="Show/hide inactive methods">Hiện/Ẩn các phương thức đã vô hiệu hóa</span>
      <i class="bi bi-arrows-expand fs-4 ms-2"></i>
   </div>
   <div class="card shadow-sm">
      <div class="card-body p-0">
         <div class="table-responsive">
            <table class="table table-hover align-middle table-row-dashed fs-7 gy-1 gs-5 mb-0" id="table-payment-methods">
               <thead>
                  <tr class="text-start bg-secondary text-muted fw-bold fs-7 text-uppercase gs-0">
                     <th></th>
                     <th>ID</th>
                     <th data-lang="Method">Phương thức</th>
                     <th data-lang="Name">Tên</th>
                     <th data-lang="Currency">Tiền tệ</th>
                     <th></th>
                     <th data-lang="Status">Trạng thái</th>
                     <th witdh="1"></th>
                  </tr>
               </thead>
               <tbody class="ui-sortable">
                  @forelse ($paymentMethods as $paymentMethod)
                  @php
                  $methodConfig = $paymentMethod->parsed_config;
                  $currency = $paymentMethod->currency ?: ($methodConfig['currency'] ?? 'USD');
                  $icon = $paymentMethod->image_url ?: ($methodConfig['icon'] ?? null);
                  $displayName = $paymentMethod->name ?: ($methodConfig['name'] ?? '');
                  $accountName = $paymentMethod->account_name ?: ($methodConfig['account_name'] ?? null);
                  @endphp
                  <tr class="row-{{ $paymentMethod->id }} {{ $paymentMethod->status ? '' : 'text-muted ' }}status-{{ $paymentMethod->status ? 1 : 0 }}" data-id="{{ $paymentMethod->id }}">
                     <td width="1"><i class="fas fa-bars ui-sortable-handle"></i></td>
                     <td>{{ $paymentMethod->id }}</td>
                     <td class="text-nowrap">
                        @if ($icon)
                        <img src="{{ $icon }}" class="w-20px me-2" alt="">
                        @endif
                        {{ $paymentMethod->config_name ?: ($methodConfig['method_name'] ?? $displayName) }}
                     </td>
                     <td>
                        <span class="fw-semibold">
                           {{ $displayName }}
                           @if ($paymentMethod->bonus)
                           <i class="fa-solid fa-percent text-warning ms-2" data-bs-toggle="tooltip" title="Bonus"></i>
                           @endif
                        </span>
                        @if ($accountName)
                        <p class="fs-8 mb-0 mt-1">{{ $accountName }}</p>
                        @endif
                     </td>
                     <td class="text-nowrap">
                        {{ $currency }}
                        @if ((int) $paymentMethod->min !== 0 || (int) $paymentMethod->max !== 0)
                        <p class="fs-8 mb-0 mt-1" data-bs-toggle="tooltip" title="Min-max">{{ number_format((int) $paymentMethod->min, 0, '.', '') }} - {{ number_format((int) $paymentMethod->max, 0, '.', '') }}</p>
                        @endif
                     </td>
                     <td></td>
                     <td>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                           <input class="form-check-input h-20px w-30px" type="checkbox" value="{{ $paymentMethod->id }}" {{ $paymentMethod->status ? 'checked' : '' }} onchange="_payments.on.change.status(this.value, this.checked)">
                        </div>
                     </td>
                     <td witdh="1" class="text-end">
                        <a href="javascript:;" class="btn btn-icon btn-light-secondary btn-circle btn-sm w-25px h-25px" onclick="_payments.on.click.showFormEdit({{ $paymentMethod->id }})">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil w-10px h-10px" viewBox="0 0 16 16">
                              <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                           </svg></a>
                     </td>
                  </tr>
                  @empty
                  <tr>
                     <td colspan="8" class="text-center text-muted py-8">No payment methods found.</td>
                  </tr>
                  @endforelse
               </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="d-flex flex-wrap flex-stack my-6">
      <h3 class="fw-bold my-2"><span data-lang="Group">Nhóm</span> <span class="fs-6 text-gray-500 fw-semibold ms-1" data-lang="Random method from group">Phương thức ngẫu nhiên từ nhóm</span></h3>
      <div class="d-flex flex-wrap my-2">
         <button class="btn btn-primary btn-sm" onclick="_payments.on.click.showFormAddGroup()" data-lang="Add group">Thêm nhóm</button>
      </div>
   </div>
   <div class="div-form-group mb-6" style="display: none;">
      <div class="card">
         <div class="card-body">
            <div class="row g-6 mb-5">
               <div class="col-md-3">
                  <label class="required form-label" data-lang="Name">Tên</label>
                  <input type="text" class="form-control form-control-solid ipt-group-name">
               </div>
               <div class="col-md-9">
                  <label class="required form-label" data-lang="Select methods">Chọn các phương thức</label>
                  <select class="form-select form-select-solid sl-pm" multiple="">
                     @foreach ($paymentMethods as $paymentMethod)
                     <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                     @endforeach
                  </select>

               </div>
            </div>
            <button type="button" class="btn btn-primary btn-new-group w-100" onclick="_payments.on.click.addGroup(0)" data-lang="button::Add">Thêm</button>
            <button type="button" class="btn btn-primary btn-update-group w-100" style="display: none;" data-lang="button::Update">Cập nhật</button>
         </div>
      </div>
   </div>
   <div class="card shadow-sm">
      <div class="card-body p-0">
         <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-7 gy-2 gs-5 mb-0">
               <thead>
                  <tr class="text-start bg-secondary text-muted fw-bold fs-7 text-uppercase gs-0">
                     <th data-lang="Name">Tên</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  @forelse ($paymentMethodGroups as $group)
                  <tr data-id="{{ $group->id }}">
                     <td class="fw-bold">
                        <a href="javascript:;" class="btn btn-icon btn-light-secondary btn-circle btn-sm w-25px h-25px" onclick="_payments.on.click.showFormEditGroup({{ $group->id }})"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil w-10px h-10px" viewBox="0 0 16 16">
                              <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                           </svg></a>
                        {{ $group->name }}
                     </td>
                     <td class="text-muted">{{ count($group->methods ?? []) }} methods</td>
                  </tr>
                  @empty
                  <tr>
                     <td colspan="2" class="text-center text-muted py-5">No payment method groups found.</td>
                  </tr>
                  @endforelse
               </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="d-flex flex-wrap flex-stack my-6">
      <h3 class="fw-bold my-2" data-lang="Announcement">Thông báo</h3>
      <div class="d-flex flex-wrap my-2">
         <label class="form-check form-switch form-check-custom form-check-solid">
            <input class="form-check-input cb-announcement-payment" type="checkbox" onchange="_payments.on.change.enableAnnouncement(this.checked);" {{ ($config->announcement_payment_status ?? false) ? 'checked' : '' }}>
            <span class="form-check-label" data-lang="Show">Hiển thị</span>
         </label>
      </div>
   </div>
   <div class="card shadow-sm div-announcement">
      <div class="card-body p-0">

         <div class="quill-announcement h-250px">{!! $config->announcement_payment ?? '' !!}</div>
      </div>
   </div>
   <div class="modal fade" tabindex="-1" id="modal-verify-perfectmoney">
      <div class="modal-dialog modal-lg modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h3 class="modal-title">Perfect Money - Website Verification</h3>
               <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                  <span class="svg-icon svg-icon-1">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                     </svg>
                  </span>
               </div>
            </div>
            <div class="modal-body lh-lg fs-6">
               <ol>
                  <li>Login and go to Add Website: <a target="_blank" href="https://perfectmoney.com/site_add.html">https://perfectmoney.com/site_add.html</a></li>
                  <li>Enter your site URL: <span class="text-danger">https://smmkay.com</span> and click <span class="text-danger">Add</span></li>
                  <li>
                     Get a file name from next instruction like this: <span class="text-danger">xxxxx.txt</span>
                     <div class="bg-light p-4 border rounded my-3 fs-7">
                        Please, create empty text file <strong>xxxxx.txt</strong> and place it into the root of smmkay.com.<br><br>
                        Verification system will check if this URL exists: https://smmkay.com/xxxxx.txt
                     </div>
                  </li>
                  <li>
                     Enter file name and click Create file:
                     <div class="row align-items-center mt-2">
                        <div class="col-auto">
                           <label for="inputPassword6" class="col-form-label">File name:</label>
                        </div>
                        <div class="col-auto">
                           <input type="text" class="form-control form-control-solid form-control-sm ipt-file-perfectmoney" placeholder="xxxxx.txt" value="">
                        </div>
                        <div class="col-auto">
                           <button type="button" class="btn btn-primary btn-sm" onclick="_payments.on.click.createFileVerify('perfectmoney', document.querySelector('.ipt-file-perfectmoney').value.trim())">Create file</button>
                        </div>
                     </div>
                  </li>
                  <li>After create file successfully. Back to perfectmoney site and click <span class="text-danger">I've uploaded xxxxx.txt to my website. Continue verification.</span></li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" tabindex="-1" id="modal-verify-payeer">
      <div class="modal-dialog modal-lg modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h3 class="modal-title">Payeer - Website Verification</h3>
               <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                  <span class="svg-icon svg-icon-1">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                     </svg>
                  </span>
               </div>
            </div>
            <div class="modal-body lh-lg fs-6">
               <ol>
                  <li>Login and go to ADD MERCHANT: <a target="_blank" href="https://payeer.com/en/account/api/">https://payeer.com/en/account/api/</a></li>
                  <li>Enter all infomation and save <span class="text-danger">Secret key</span></li>
                  <li>
                     Get a file name from next instruction like this: <span class="text-danger">payeer_xxxxx.txt</span>
                     <div class="bg-light p-4 border rounded my-3 fs-7">
                        Domain Not Confirmed: smmkay.com<br>
                        <ol>
                           <li>Download <strong>payeer_xxxxx.txt</strong></li>
                           <li>Place to the root of the website: https://smmkay.com/payeer_xxxxx.txt</li>
                           <li>Click button "Confirm"</li>
                        </ol>
                     </div>
                  </li>
                  <li>
                     Enter file name and click Create file:
                     <div class="row align-items-center mt-2">
                        <div class="col-auto">
                           <label for="inputPassword6" class="col-form-label">File name:</label>
                        </div>
                        <div class="col-auto">
                           <input type="text" class="form-control form-control-solid form-control-sm ipt-file-payeer" placeholder="payeer_xxxxx.txt" value="">
                        </div>
                        <div class="col-auto">
                           <button type="button" class="btn btn-primary btn-sm" onclick="_payments.on.click.createFileVerify('payeer', document.querySelector('.ipt-file-payeer').value.trim())">Create file</button>
                        </div>
                     </div>
                  </li>
                  <li>After create file successfully. Back to payeer site and click <span class="text-danger">CONFIRM</span></li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" tabindex="-1" id="modal-verify-cryptomus">
      <div class="modal-dialog modal-lg modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h3 class="modal-title">Cryptomus - Website Verification</h3>
               <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                  <span class="svg-icon svg-icon-1">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                     </svg>
                  </span>
               </div>
            </div>
            <div class="modal-body lh-lg fs-6">
               <ol>
                  <li>Login and Create Merchant by follows instruction: <a target="_blank" href="https://doc.cryptomus.com/getting-started/getting-api-keys/">https://doc.cryptomus.com/getting-started/getting-api-keys/</a></li>
                  <li>Enter your site URL: <span class="text-danger">https://smmkay.com</span> and Description(Optional) in step 2</li>
                  <li>Select method <span class="text-danger">Using an HTML</span> in step 3</li>
                  <li>
                     Get a file name in step 3 like this: <span class="text-danger">cryptomus_xxxxxxxx.html</span>
                     <div class="bg-light p-4 border rounded my-3 fs-7">
                        Confirm domain
                        <ol>
                           <li>Download the HTML file</li>
                           <li>Upload the file to the root folder of the site.<br> The file should be available at: https://smmkay.com/cryptomus_xxxxxxxx.html</li>
                           <li>Check that the domain is confirmed</li>
                        </ol>
                     </div>
                  </li>
                  <li>
                     Enter file name and click Create file:
                     <div class="row align-items-center mt-2">
                        <div class="col-auto">
                           <label for="inputPassword6" class="col-form-label">File name:</label>
                        </div>
                        <div class="col-auto">
                           <input type="text" class="form-control form-control-solid form-control-sm ipt-file-cryptomus" placeholder="cryptomus_xxxxxxxx.html" value="">
                        </div>
                        <div class="col-auto">
                           <button type="button" class="btn btn-primary btn-sm" onclick="_payments.on.click.createFileVerify('cryptomus', document.querySelector('.ipt-file-cryptomus').value.trim())">Create file</button>
                        </div>
                     </div>
                  </li>
                  <li>After create file successfully. Back to cryptomus site and click <span class="text-danger">CHECK</span></li>
                  <li>Wait for Project Moderation can takes up to 12 hours.</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" tabindex="-1" id="modal-config-xendit">
      <div class="modal-dialog modal-lg modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h3 class="modal-title">Xendit - Webhook Configuration</h3>
               <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                  <span class="svg-icon svg-icon-1">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                     </svg>
                  </span>
               </div>
            </div>
            <div class="modal-body lh-lg fs-6">
               <ol>
                  <li>Login and Create Api Keys: <a target="_blank" href="https://dashboard.xendit.co/settings/developers#api-keys">https://dashboard.xendit.co/settings/developers#api-keys</a></li>
                  <li>Click Genenate secret key button -&gt; Enter API key name -&gt; Add Write permission for Money-in Products -&gt; Click Generate key -&gt; Copy key</li>
                  <li>Back to Admin Payment Method Setup -&gt; Paste Key to API Key Input</li>
                  <li>Create Webhook Verification Token: <a target="_blank" href="https://dashboard.xendit.co/settings/developers#webhooks">https://dashboard.xendit.co/settings/developers#webhooks</a></li>
                  <li>Click View Webhook Verification Token -&gt; Copy token</li>
                  <li>Back to Admin Payment Method Setup -&gt; Paste Webhook Verification Token to Webhook Secret Key Input</li>
                  <li>Copy Webhook URL</li>
                  <li>Back to Xendit Webhooks Dashboard: <a target="_blank" href="https://dashboard.xendit.co/settings/developers#webhooks">https://dashboard.xendit.co/settings/developers#webhooks</a>. Scroll down to bottom and paste url to Invoices paid input -&gt; Click Test and Save button</li>
                  <li>Done!</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" tabindex="-1" id="modal-config-bhratpe">
      <div class="modal-dialog modal-lg modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h3 class="modal-title">BharatPe - Configuration</h3>
               <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                  <span class="svg-icon svg-icon-1">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                     </svg>
                  </span>
               </div>
            </div>
            <div class="modal-body lh-lg fs-6">
               <ol>
                  <li>Open the: <a target="_blank" href="https://enterprise.bharatpe.in/downloadqr">https://enterprise.bharatpe.in/downloadqr</a></li>
                  <li>Enter the page Inspector(fn+F12) and select the 'Application' tab.</li>
                  <li>Click 'TOKEN' in the 'Key' field and copy your token.<a target="_blank" href="https://i.imgur.com/Goy18RF.png">(screenshot 1)</a></li>
                  <li>Paste it in the 'Token' field.</li>
                  <li>Click 'USER INFO' in the 'Key' field and find the Merchant ID.<a target="_blank" href="https://i.imgur.com/DdrmDHS.png">(screenshot 2)</a></li>
                  <li>Paste it in the 'Merchant ID' field.</li>
                  <li>Copy the QR code image and paste it to the Details field.</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')
<script>
   $(document).ready(function() {
      _payments.init();
   });
</script>
@endpush
