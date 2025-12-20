@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f9fafb;
    }

    .filter-box {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }

    .filter-title {
        font-size: 14px;
        font-weight: 600;
    }

    .catalog-title {
        font-weight: 700;
    }

    .sort-select {
        width: 180px;
    }

    .product-col {
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .product-col:hover {
        transform: translateY(-4px);
    }
</style>

<div class="container-fluid px-lg-5 py-4">

    <div class="row g-4">

        {{-- SIDEBAR FILTER --}}
        <div class="col-lg-3">
            <div class="bg-white p-4 filter-box">
                <h6 class="filter-title mb-4">Filter Produk</h6>

                <form action="{{ route('catalog.index') }}" method="GET">
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif

                    {{-- KATEGORI --}}
                    <div class="mb-4">
                        <div class="filter-title mb-2">Kategori</div>
                        @foreach($categories as $cat)
                            <div class="form-check mb-1">
                                <input class="form-check-input"
                                       type="radio"
                                       name="category"
                                       value="{{ $cat->slug }}"
                                       {{ request('category') == $cat->slug ? 'checked' : '' }}
                                       onchange="this.form.submit()">
                                <label class="form-check-label small">
                                    {{ $cat->name }}
                                    <span class="text-muted">({{ $cat->products_count }})</span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    {{-- HARGA --}}
                    <div class="mb-4">
                        <div class="filter-title mb-2">Rentang Harga</div>
                        <div class="d-flex gap-2">
                            <input type="number" name="min_price"
                                   class="form-control form-control-sm"
                                   placeholder="Min"
                                   value="{{ request('min_price') }}">
                            <input type="number" name="max_price"
                                   class="form-control form-control-sm"
                                   placeholder="Max"
                                   value="{{ request('max_price') }}">
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 btn-sm">
                        Terapkan Filter
                    </button>

                    <a href="{{ route('catalog.index') }}"
                       class="btn btn-light w-100 btn-sm mt-2">
                        Reset
                    </a>
                </form>
            </div>
        </div>

        {{-- PRODUCT LIST --}}
        <div class="col-lg-9">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="catalog-title mb-0">
                    Katalog Produk
                </h4>

                <form method="GET">
                    @foreach(request()->except('sort') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <select name="sort"
                            class="form-select form-select-sm sort-select"
                            onchange="this.form.submit()">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                            Terbaru
                        </option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                            Harga Terendah
                        </option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                            Harga Tertinggi
                        </option>
                    </select>
                </form>
            </div>

            {{-- GRID --}}
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4">
                @forelse($products as $product)
                    <div class="col product-col">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="{{ asset('images/empty-state.svg') }}"
                             width="160"
                             class="mb-3 opacity-50">
                        <h6 class="fw-semibold">Produk tidak ditemukan</h6>
                        <p class="text-muted small">
                            Coba ubah filter atau kata kunci pencarian.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
