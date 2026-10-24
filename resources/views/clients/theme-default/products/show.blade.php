@extends('clients.theme-default.layouts.app')
@section('title', $product->name)

@section('content')
    <div class="content flex-column-fluid" id="kt_content">
        @include('clients.theme-default.layouts.toolbar', ['title' => $product->name])
        <div class="post" id="kt_post">

            <div class="row g-5 mb-10">
                {{-- Image --}}
                <div class="col-lg-4">
                    @if ($product->thumbnail)
                        <img src="{{ $product->thumbnail }}" width="100%" style="border-radius:0.475rem"
                            alt="{{ $product->name }}">
                    @endif
                </div>

                {{-- Info --}}
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <span class="text-gray-900 fs-1 fw-bold">{{ $product->name }}</span>
                            </div>

                            <div class="fw-semibold fs-5 mb-4 text-success">
                                <i class="bi bi-box-seam fs-3 me-2" style="line-height:1.3"></i>
                                <span data-lang="label::In stock">In stock</span>
                            </div>

                            @if ($product->category)
                                <div class="fw-semibold fs-6 mb-4">
                                    <i class="bi bi-bookmark fs-3 me-2" style="line-height:1.3"></i>
                                    <a class="text-gray-900" href="/products?category={{ $product->product_category_id }}">
                                        {{ $product->category->name }}
                                    </a>
                                </div>
                            @endif

                            <div class="mb-4">
                                @php
                                    $price = (float) $product->price * ($exRate ?? 1);
                                    $priceStr = rtrim(rtrim(number_format($price, 6, '.', ''), '0'), '.');
                                @endphp
                                <span class="fw-bolder fs-1">{{ $sym ?? '$' }}{{ $priceStr }}</span>
                            </div>

                            <div class="separator border-2 mb-4"></div>

                            <div class="fw-semibold fs-7 mb-4">
                                <i class="bi bi-1-circle fs-4 me-2"></i>
                                <span data-lang="Quantity">Quantity</span>
                            </div>

                            <div class="fw-semibold fs-6 mb-4 mw-250px">
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline"
                                        onclick="_products.on.click.quantity(-1, {{ $product->min ?? 1 }}, {{ $product->max ?? 999 }})">-</button>
                                    <input type="text" id="ipt-quantity" class="form-control text-center"
                                        value="{{ $product->min ?? 1 }}" inputmode="numeric"
                                        onkeyup="_products.on.keyup.quantity({{ $product->min ?? 1 }}, {{ $product->max ?? 999 }})">
                                    <button type="button" class="btn btn-outline"
                                        onclick="_products.on.click.quantity(1, {{ $product->min ?? 1 }}, {{ $product->max ?? 999 }})">+</button>
                                </div>
                            </div>

                            <div class="separator border-2 mb-4"></div>

                            <button type="button" id="btn-buy" class="btn btn-primary"
                                onclick="_products.on.click.buy({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ (float) $product->price }}')"
                                data-lang="button::Buy now">Buy now</button>

                            <div class="div-result-bulk mt-5 d-none"></div>
                            <script>
                                var PRODUCT_TYPE = @json($product->process_type ?: 'Manual');
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="mt-10">
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-info" data-lang="Information"
                            role="tab">Information</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-policy" data-lang="Warranty policy"
                            role="tab">Warranty policy</a>
                    </li>
                </ul>
                <div class="tab-content tab-description-product">
                    <div class="tab-pane fade active show" id="tab-info" role="tabpanel">
                        {!! $product->description ?? '' !!}
                    </div>
                    <div class="tab-pane fade" id="tab-policy" role="tabpanel">
                        {!! $product->warranty_policy ?? '' !!}
                    </div>
                </div>
            </div>

            {{-- Modal confirm --}}
            <div class="modal fade" tabindex="-1" id="modal-confirm" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered mw-600px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" data-lang="Confirm order">Confirm order</h3>
                        </div>
                        <div class="modal-body">
                            <div class="mb-5 div-confirm"></div>
                            <div class="form-check form-check-custom form-check-solid mb-3">
                                <input class="form-check-input cb-agree" type="checkbox" value=""
                                    onchange="this.checked ? this.nextElementSibling.className='form-check-label' : ''">
                                <label class="form-check-label text-danger fw-bold" data-lang="I agree with the warranty policy">I
                                    agree with the warranty policy</label>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary btn-confirm btn-sm"
                                    data-lang="button::Confirm">Confirm</button>
                                <button type="button" class="btn btn-light btn-sm ms-3" data-bs-dismiss="modal"
                                    data-lang="button::Close">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal alert success --}}
            <div class="modal fade" tabindex="-1" id="modal-alert" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered rounded-4">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white py-4">
                            <h4 class="modal-title text-white ls-1" data-lang="message.Alert">Thông báo</h4>
                        </div>
                        <div class="modal-body py-10 fs-4" style="word-break:break-word"></div>
                        <div class="modal-footer text-center py-4">
                            <button type="button" class="btn btn-sm btn-success px-4 rounded-4" data-bs-dismiss="modal"
                                data-lang="Read">Read</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

