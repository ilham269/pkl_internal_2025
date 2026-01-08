@extends('layouts.app')

@section('content')

<style>
:root {
  --coffee-dark: #4b2e2b;
  --coffee-main: #7b4a2e;
  --coffee-soft: #a47148;
  --coffee-cream: #f5efe6;
  --coffee-bg: #faf7f2;
}

/* ================= GLOBAL ================= */
body {
  background: var(--coffee-bg);
}

/* ================= SIDEBAR ================= */
.filter-card {
  border-radius: 22px;
  background: #fff;
  border: 1px solid rgba(75,46,43,.08);
}

.filter-title {
  font-weight: 700;
  color: var(--coffee-dark);
}

.filter-card .form-check-input:checked {
  background-color: var(--coffee-main);
  border-color: var(--coffee-main);
}

.filter-card input:focus,
.filter-card select:focus {
  border-color: var(--coffee-soft);
  box-shadow: 0 0 0 .15rem rgba(123,74,46,.25);
}

/* ================= BUTTON ================= */
.btn-coffee {
  background: linear-gradient(135deg, #7b4a2e, #4b2e2b);
  border: none;
  color: #fff;
  border-radius: 999px;
  font-weight: 600;
}

.btn-coffee:hover {
  box-shadow: 0 10px 22px rgba(75,46,43,.4);
  transform: translateY(-1px);
}

.btn-outline-coffee {
  border-radius: 999px;
  border: 1px solid var(--coffee-main);
  color: var(--coffee-main);
}

.btn-outline-coffee:hover {
  background: var(--coffee-main);
  color: #fff;
}

/* ================= HEADER ================= */
.catalog-header h4 {
  color: var(--coffee-dark);
}

/* ================= SORT ================= */
.sort-select {
  border-radius: 999px;
  border-color: var(--coffee-soft);
}

/* ================= EMPTY STATE ================= */
.empty-state img {
  opacity: .6;
}

/* ================= PAGINATION ================= */
.coffee-pagination .pagination {
  gap: 6px;
}

.coffee-pagination .page-item .page-link {
  border: none;
  min-width: 38px;
  height: 38px;
  border-radius: 999px;
  color: var(--coffee-dark);
  font-weight: 600;
  background: #fff;
  box-shadow: 0 4px 10px rgba(75,46,43,.12);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: .25s ease;
}

.coffee-pagination .page-item .page-link:hover {
  background: var(--coffee-soft);
  color: #fff;
  transform: translateY(-2px);
}

.coffee-pagination .page-item.active .page-link {
  background: linear-gradient(135deg, #7b4a2e, #4b2e2b);
  color: #fff;
  box-shadow: 0 10px 22px rgba(75,46,43,.45);
}

.coffee-pagination .page-item.disabled .page-link {
  opacity: .4;
  box-shadow: none;
  background: #eee;
  color: #999;
}

/* MOBILE CLEAN */
@media (max-width: 576px) {
  .coffee-pagination .page-item:not(.active):not(:first-child):not(:last-child) {
    display: none;
  }
}
</style>

<div class="container py-5">
  <div class="row g-4">

    {{-- SIDEBAR FILTER --}}
    <div class="col-lg-3">
      <div class="card filter-card shadow-sm sticky-top" style="top: 90px;">
        <div class="card-header bg-white border-0 pb-0">
          <h6 class="filter-title mb-0">☕ Filter Produk</h6>
        </div>

        <div class="card-body">
          <form action="{{ route('catalog.index') }}" method="GET">

            @if(request('q'))
              <input type="hidden" name="q" value="{{ request('q') }}">
            @endif

            {{-- KATEGORI --}}
            <div class="mb-4">
              <p class="fw-semibold mb-2 text-dark">Kategori</p>
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
              <p class="fw-semibold mb-2 text-dark">Rentang Harga</p>
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

            <button type="submit" class="btn btn-coffee btn-sm w-100">
              Terapkan Filter
            </button>

            <a href="{{ route('catalog.index') }}"
              class="btn btn-outline-coffee btn-sm w-100 mt-2">
              Reset Filter
            </a>

          </form>
        </div>
      </div>
    </div>

    {{-- PRODUCT GRID --}}
    <div class="col-lg-9">

      {{-- HEADER --}}
      <div class="catalog-header d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <h4 class="fw-semibold mb-0">☕ Katalog Kopi</h4>

        {{-- SORT --}}
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
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @forelse($products as $product)
          <div class="col">
            <x-product-card :product="$product" />
          </div>
        @empty
          <div class="col-12 text-center py-5 empty-state">
            <img src="{{ asset('images/empty-state.svg') }}" width="140" class="mb-3">
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
