@extends('layouts.app')

@section('content')

<div class="container py-8">
    <div class="row g-4">

        {{-- SIDEBAR FILTER --}}
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm sticky-top" style="top: 90px;">
                <div class="card-header bg-white fw-semibold border-bottom">
                    Filter Produk
                </div>

                <div class="card-body">
                    <form action="{{ route('catalog.index') }}" method="GET">
                        @if(request('q'))
                            <input type="hidden" name="q" value="{{ request('q') }}">
                        @endif

                        {{-- KATEGORI --}}
                        <div class="mb-5">
                            <p class="fw-semibold mb-2">Kategori</p>
                            <div class="d-flex flex-column gap-2">
                                @foreach($categories as $cat)
                                    <label class="d-flex align-items-center justify-content-between small">
                                        <span>
                                            <input type="radio"
                                                name="category"
                                                value="{{ $cat->slug }}"
                                                class="form-check-input me-2"
                                                {{ request('category') == $cat->slug ? 'checked' : '' }}
                                                onchange="this.form.submit()">
                                            {{ $cat->name }}
                                        </span>
                                        <span class="text-muted">({{ $cat->products_count }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- HARGA --}}
                        <div class="mb-4">
                            <p class="fw-semibold mb-2">Rentang Harga</p>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" name="min_price"
                                        class="form-control form-control-sm"
                                        placeholder="Min"
                                        value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price"
                                        class="form-control form-control-sm"
                                        placeholder="Max"
                                        value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('catalog.index') }}"
                           class="btn btn-outline-secondary btn-sm w-100 mt-2">
                            Reset Filter
                        </a>
                    </form>
                </div>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="col-lg-9">
            <div class="catalog-header d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">

                <h4 class="fw-semibold mb-0">Katalog Produk</h4>

                {{-- SORTING --}}
                <form method="GET" class="d-flex align-items-center gap-2">
                    @foreach(request()->except('sort') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <select name="sort"
                        class="form-select form-select-sm"
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
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @forelse($products as $product)
                    <div class="col">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="{{ asset('images/empty-state.svg') }}"
                             width="140"
                             class="mb-3 opacity-50">
                        <h6 class="fw-semibold">Produk tidak ditemukan</h6>
                        <p class="text-muted small">
                            Coba ubah filter atau kata kunci pencarian
                        </p>
                    </div>
                @endforelse
            </div>


            {{-- PAGINATION --}}



        </div>
    </div>
</div>
@endsection
