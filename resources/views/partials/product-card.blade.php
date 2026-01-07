{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
     STYLE: Marketplace Blibli-like
     ================================================ --}}

<style>
/* ================= PRODUCT CARD ================= */
.blibli-card {
  border: 1px solid #e5e7eb;
  border-radius: 18px; /* FIX */
  background: #ffffff;
  transition: all .25s ease;
  overflow: hidden;
}

.blibli-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 18px 40px rgba(0,0,0,.08);
}

/* ================= IMAGE ================= */
.blibli-img-wrapper {
  position: relative;
  aspect-ratio: 1 / 1;
  overflow: hidden;
  background: #f9fafb;
}

.blibli-img-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform .35s ease;
}

.blibli-card:hover .blibli-img-wrapper img {
  transform: scale(1.05);
}

/* ================= BADGE ================= */
.badge-discount {
  position: absolute;
  top: 12px;
  left: 12px;
  background: linear-gradient(135deg, #ef4444, #dc2626);
  color: #fff;
  font-size: 11px;
  font-weight: 700;
  padding: 5px 7px;
  border-radius: 8px;
}

/* ================= WISHLIST ================= */
.wishlist-btn {
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  background: #ffffff;
  box-shadow: 0 4px 12px rgba(0,0,0,.12);
  transition: .25s;
}

.wishlist-btn:hover {
  transform: scale(1.08);
}

/* ================= TITLE ================= */
.blibli-title {
  font-size: 14px;
  line-height: 1.45;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  min-height: 42px;
}

/* ================= PRICE ================= */
.blibli-price {
  font-size: 17px;
  font-weight: 800;
  color: #1f2937;
}

.blibli-old-price {
  font-size: 12px;
  color: #9ca3af;
  text-decoration: line-through;
}

/* ================= STOCK ================= */
.stock-warning {
  font-size: 12px;
  font-weight: 600;
}

/* ================= BUTTON ================= */
.blibli-card .btn-primary {
  border-radius: 14px;
  font-weight: 600;
  padding: 10px;
  transition: .25s;
}

.blibli-card .btn-primary:hover {
  transform: translateY(-1px);
  box-shadow: 0 8px 18px rgba(47,128,237,.35);
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
        class="btn position-absolute top-0 end-0 m-2 wishlist-btn wishlist-btn-{{ $product->id }}">
        <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart text-secondary' }}"></i>
      </button>
    @endauth
  </div>

  {{-- BODY --}}
  <div class="p-3 d-flex flex-column flex-grow-1">

    <small class="text-muted mb-1">
      {{ $product->category->name }}
    </small>

    <a href=""
      class="text-decoration-none text-dark blibli-title mb-2">
      {{ $product->name }}
    </a>

    <div class="mt-auto">
      @if($product->has_discount)
        <div class="blibli-old-price">
          {{ $product->formatted_original_price }}
        </div>
      @endif

      <div class="blibli-price">
        {{ $product->formatted_price }}
      </div>

      {{-- STOCK --}}
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

