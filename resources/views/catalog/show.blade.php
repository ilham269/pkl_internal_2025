{{-- ================================================
 FILE: resources/views/catalog/show.blade.php
 THEME: Coffee / Mocha Premium Detail Page (FIXED)
 ================================================ --}}

@extends('layouts.app')

@section('title', $product->name)

@section('content')

<style>
:root {
  --coffee-dark: #4b2e2b;
  --coffee-main: #7b4a2e;
  --coffee-soft: #a47148;
  --coffee-bg: #faf7f2;
}

/* ================= DARK MODE ================= */
body.dark-coffee {
  background: #1f1b18;
  color: #f5efe6;
}

body.dark-coffee .coffee-card {
  background: #2a2421;
  color: #f5efe6;
}

/* ================= GLOBAL ================= */
body {
  background: var(--coffee-bg);
}

.coffee-card {
  border-radius: 24px;
  border: 1px solid rgba(75,46,43,.08);
}

/* ================= IMAGE ================= */
.main-image {
  height: 420px;
  object-fit: contain;
  background: linear-gradient(135deg, #ede4d8, #f8f3ed);
}

/* ================= BADGE ================= */
.badge-coffee {
  background: linear-gradient(135deg, #7b4a2e, #4b2e2b);
  color: #fff;
}

/* ================= PRICE ================= */
.price-main {
  color: var(--coffee-main);
  font-weight: 800;
}

/* ================= BUTTON ================= */
.btn-coffee {
  background: linear-gradient(135deg, #7b4a2e, #4b2e2b);
  border: none;
  border-radius: 999px;
  font-weight: 600;
  color: #fff;
}

/* ================= RATING ================= */
.rating-stars i {
  color: #f59e0b;
}

/* ================= TAG ================= */
.coffee-tag {
  background: #ede4d8;
  color: #4b2e2b;
  font-size: 11px;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 999px;
}

/* ================= DESCRIPTION ================= */
.product-description {
  color: #f5efe6;
  line-height: 1.8;
}

/* ================= RELATED ================= */
.related-scroll {
  display: flex;
  gap: 16px;
  overflow-x: auto;
  scroll-snap-type: x mandatory;
}

.related-scroll > div {
  scroll-snap-align: start;
  min-width: 220px;
}
</style>

<div class="container py-4">

{{-- DARK MODE TOGGLE --}}
<div class="text-end mb-3">
  <button onclick="toggleDark()" class="btn btn-sm btn-outline-secondary">
    🌙 Dark Coffee Mode
  </button>
</div>

<div class="row g-4">

{{-- IMAGE --}}
<div class="col-lg-6">
  <div class="card coffee-card shadow-sm overflow-hidden">
    <div class="position-relative">
      <img src="{{ $product->image_url }}" class="w-100 main-image">

      @if($product->is_signature ?? false)
        <span class="badge badge-coffee position-absolute top-0 end-0 m-3">
          🔥 Signature Coffee
        </span>
      @endif
    </div>
  </div>
</div>

{{-- INFO --}}
<div class="col-lg-6">
  <div class="card coffee-card shadow-sm">
    <div class="card-body p-4">

      <h2>{{ $product->name }}</h2>

      {{-- RATING --}}
      <div class="rating-stars mb-2">
        @for($i=1;$i<=5;$i++)
          <i class="bi {{ $i <= round($product->rating ?? 4) ? 'bi-star-fill' : 'bi-star' }}"></i>
        @endfor
        <small>({{ $product->reviews_count ?? 12 }} ulasan)</small>
      </div>

      {{-- TAG --}}
      <div class="d-flex gap-2 mb-3">
        <span class="coffee-tag">{{ $product->bean_type ?? 'Arabica' }}</span>
        <span class="coffee-tag">{{ $product->roast_level ?? 'Medium Roast' }}</span>
      </div>

      {{-- PRICE --}}
      <div class="h3 price-main mb-3">
        {{ $product->formatted_price }}
      </div>

      {{-- CART (FIX QUANTITY) --}}
      <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="1">

        <button class="btn btn-coffee w-100 btn-lg">
          <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
        </button>
      </form>

      <hr>

      {{-- DESCRIPTION --}}
      <p class="product-description">
        {!! nl2br(e($product->description)) !!}
      </p>

    </div>
  </div>
</div>
</div>

{{-- REVIEWS --}}
<div class="mt-5">
  <h5>⭐ Ulasan Pelanggan</h5>

  @forelse($product->reviews ?? [] as $review)
    <div class="coffee-card p-3 mb-3">
      <strong>{{ $review->user->name }}</strong>
      <div class="rating-stars small">
        @for($i=1;$i<=5;$i++)
          <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
        @endfor
      </div>
      <p class="small text-muted mb-0">{{ $review->comment }}</p>
    </div>
  @empty
    <p class="text-muted">Belum ada ulasan.</p>
  @endforelse
</div>

{{-- RELATED PRODUCTS --}}
<div class="mt-5">
  <h5>🛍 Produk Terkait</h5>

  <div class="related-scroll pb-3">
    @foreach($relatedProducts ?? [] as $related)
      <div>
        <x-product-card :product="$related" />
      </div>
    @endforeach
  </div>
</div>

</div>

<script>
function toggleDark() {
  document.body.classList.toggle('dark-coffee');
}
</script>

@endsection
