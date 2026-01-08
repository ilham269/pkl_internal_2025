{{-- =========================================================
 FILE: resources/views/partials/product-card.blade.php
 THEME: Coffee / Mocha Marketplace Card
 UPGRADE: Glass Wishlist + Rating Stars
 ========================================================= --}}

<style>
:root {
  --coffee-dark: #4b2e2b;
  --coffee-main: #7b4a2e;
  --coffee-soft: #a47148;
  --coffee-bg: #faf7f2;
}

/* ================= CARD ================= */
.blibli-card {
  border-radius: 22px;
  background: var(--coffee-bg);
  border: 1px solid rgba(75,46,43,.08);
  transition: all .35s ease;
  overflow: hidden;
}

.blibli-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 25px 45px rgba(75,46,43,.18);
}

/* ================= IMAGE ================= */
.blibli-img-wrapper {
  position: relative;
  aspect-ratio: 1 / 1;
  background: linear-gradient(135deg, #ede4d8, #f8f3ed);
  overflow: hidden;
}

.blibli-img-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform .45s ease;
}

.blibli-card:hover img {
  transform: scale(1.08);
}

/* ================= BADGE ================= */
.badge-discount {
  position: absolute;
  top: 14px;
  left: 14px;
  background: linear-gradient(135deg, #7b4a2e, #4b2e2b);
  color: #fff;
  font-size: 11px;
  font-weight: 700;
  padding: 6px 12px;
  border-radius: 999px;
}

/* ================= WISHLIST (GLASS) ================= */
.wishlist-btn {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  backdrop-filter: blur(6px);
  background: rgba(255,255,255,.75);
  border: 1px solid rgba(255,255,255,.4);
  box-shadow: 0 6px 16px rgba(75,46,43,.25);
  transition: .3s;
}

.wishlist-btn:hover {
  transform: scale(1.1);
}

/* ================= TEXT ================= */
.product-category {
  font-size: 11px;
  font-weight: 600;
  color: var(--coffee-soft);
  text-transform: uppercase;
  letter-spacing: .5px;
}

.blibli-title {
  font-size: 14px;
  font-weight: 600;
  color: var(--coffee-dark);
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  min-height: 42px;
}

/* ================= RATING ================= */
.coffee-rating {
  font-size: 12px;
  color: #f59e0b;
  display: flex;
  align-items: center;
  gap: 4px;
}

.coffee-rating span {
  color: #78350f;
  font-weight: 600;
}

.coffee-rating small {
  color: #9ca3af;
}

/* ================= PRICE ================= */
.blibli-price {
  font-size: 18px;
  font-weight: 800;
  color: var(--coffee-main);
}

.blibli-old-price {
  font-size: 12px;
  color: #a8a29e;
  text-decoration: line-through;
}

/* ================= STOCK ================= */
.stock-warning {
  font-size: 12px;
  font-weight: 600;
}

/* ================= BUTTON ================= */
.blibli-card .btn-primary {
  background: linear-gradient(135deg, #7b4a2e, #4b2e2b);
  border: none;
  border-radius: 999px;
  padding: 10px;
  font-weight: 600;
  transition: all .3s ease;
}

.blibli-card .btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(75,46,43,.45);
}

.blibli-card .btn-primary:disabled {
  background: #d6ccc2;
}
</style>

<div class="blibli-card h-100 d-flex flex-column">

  {{-- IMAGE --}}
  <div class="blibli-img-wrapper">
    <a href="">
      <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
    </a>

    @if($product->has_discount)
      <span class="badge-discount">
        -{{ $product->discount_percentage }}%
      </span>
    @endif

    @auth
      <button type="button"
        onclick="toggleWishlist({{ $product->id }})"
        class="btn position-absolute top-0 end-0 m-2 wishlist-btn">
        <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart text-secondary' }}"></i>
      </button>
    @endauth
  </div>

  {{-- BODY --}}
  <div class="p-3 d-flex flex-column flex-grow-1">

    <small class="product-category mb-1">
      {{ $product->category->name }}
    </small>

    <a href="" class="text-decoration-none blibli-title mb-1">
      {{ $product->name }}
    </a>

    {{-- RATING --}}
    <div class="coffee-rating mb-2">
      <i class="bi bi-star-fill"></i>
      <span>{{ number_format($product->rating ?? 0, 1) }}</span>
      <small>({{ $product->reviews_count ?? 0 }})</small>
    </div>

    <div class="mt-auto">
      @if($product->has_discount)
        <div class="blibli-old-price">
          {{ $product->formatted_original_price }}
        </div>
      @endif

      <div class="blibli-price">
        {{ $product->formatted_price }}
      </div>

      @if($product->stock <= 5 && $product->stock > 0)
        <small class="text-warning stock-warning d-block mt-1">
          Stok tinggal {{ $product->stock }}
        </small>
      @elseif($product->stock == 0)
        <small class="text-danger stock-warning d-block mt-1">
          Stok Habis
        </small>
      @endif
    </div>
  </div>

  {{-- FOOTER --}}
  <div class="p-3 pt-0">
    <form action="{{ route('cart.add') }}" method="POST">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
      <input type="hidden" name="quantity" value="1">

      <button type="submit"
        class="btn btn-primary btn-sm w-100"
        @if($product->stock == 0) disabled @endif>
        <i class="bi bi-cart-plus me-1"></i>
        {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah Keranjang' }}
      </button>
    </form>
  </div>

</div>
