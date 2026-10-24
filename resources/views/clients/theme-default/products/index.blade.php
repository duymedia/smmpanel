@extends('clients.theme-default.layouts.app')
@section('title', 'Products')

@section('content')
    <div class="content flex-column-fluid" id="kt_content">
        @include('clients.theme-default.layouts.toolbar', ['title' => 'Products', 'langKey' => 'menu::Products'])
        <div class="post" id="kt_post">

            <div class="card mb-10">
                <div class="card-body">
                    <form class="row g-5" onsubmit="event.preventDefault(); _products.on.click.search();">
                        <div class="col-md-4 col-12">
                            <select id="sl-category" class="form-select form-select-solid"
                                onchange="_products.on.change.category(this.value)" data-kt-select2="true"
                                data-control="select2" data-hide-search="true">
                                <option value="0" data-lang="All category">All category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (string) request('cat', request('category')) === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="input-group input-group-solid">
                                <input type="text" id="ipt-keyword" class="form-control" placeholder="Keyword"
                                    data-lang="Keyword" value="{{ request('search', request('keyword')) }}">
                                <button type="submit" id="btn-search" class="btn btn-primary"
                                    data-lang="button::Search">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="div-products">
                @forelse ($products as $groupId => $groupProducts)
                    @php $group = $groups[$groupId] ?? null; @endphp
                    <div class="row g-5 mb-5">
                        @if ($group)
                            <h4 class="ls-1">{{ $group->name }}</h4>
                            <div class="separator border-3 border-secondary my-2"></div>
                        @endif
                        @foreach ($groupProducts as $product)
                            <div class="col-xxl-2 col-lg-3 col-md-6">
                                <div class="card">
                                    @if ($product->thumbnail)
                                        <a href="/products/{{ $product->slug }}">
                                            <img src="{{ $product->thumbnail }}" class="card-img-top"
                                                style="height:160px;object-fit:cover" alt="{{ $product->name }}">
                                        </a>
                                    @endif
                                    <div class="card-body px-3 py-4">
                                        <p class="mb-1">{{ $product->name }}</p>
                                        <p class="m-0 fw-bolder">
                                            @php
                                                $price = (float) $product->price * ($exRate ?? 1);
                                                $priceStr = rtrim(rtrim(number_format($price, 6, '.', ''), '0'), '.');
                                            @endphp
                                            {{ $sym ?? '$' }}{{ $priceStr }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <div class="text-center text-muted py-10">
                        <i class="bi bi-inbox fs-2x d-block mb-2"></i>
                        <span data-lang="No products found">No products found</span>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection

