{{-- ================================================
FILE: resources/views/partials/product-card.blade.php
THEME: Coffee / Mocha Marketplace
================================================ --}}

<style>
/* ================= COFFEE CARD ================= */
.product-card {
  border-radius: 20px;
  overflow: hidden;
  background: #fff;
  transition: all .25s ease;
}

.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 16px 40px rgba(75,46,43,.15);
}

/* DARK MODE */
body.dark-coffee .product-card {
  background: #2a2421;
  color: #f5efe6;
}

/* IMAGE */
.product-card img {
  background: linear-gradient(135deg, #ede4d8, #f8f3ed);
}

/* BADGE DISCOUNT */
.badge-discount {
  position: absolute;
  top: 10px;
  left: 10px;
  background: linear-gradient(135deg, #7b4a2e, #4b2e2b);
  color: #fff;
  font-size: 11px;
  font-weight: 700;
  padding: 5px 10px;
  border-radius: 999px;
}

/* SIGNATURE BADGE */
.badge-signature {
  position: absolute;
  bottom: 10px;
  left: 10px;
  background: #4b2e2b;
  color: #fff;
  font-size: 11px;
  padding: 4px 10px;
  border-radius: 999px;
}

/* PRICE */
.price-main {
  color: #7b4a2e;
  font-weight: 800;
}

/* BUTTON */
.btn-coffee {
  background: linear-gradient(135deg, #7b4a2e, #4b2e2b);
  border: none;
  border-radius: 999px;
  font-weight: 600;
}

/* TAG */
.coffee-tag {
  background: #ede4d8;
  color: #4b2e2b;
  font-size: 10px;
  font-weight: 700;
  padding: 3px 8px;
  border-radius: 999px;
}

/* RATING */
.rating-stars i {
  color: #f59e0b;
}
/* WISHLIST BUTTON */
.wishlist-btn {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  backdrop-filter: blur(6px);
  background: rgba(255,255,255,.75);
  border: 1px solid rgba(255,255,255,.4);
  box-shadow: 0 6px 16px rgba(75,46,43,.25);
  transition: .3s;
}


</style>

<div class="card product-card h-100 border-0 shadow-sm">

    {{-- IMAGE --}}
    <div class="position-relative">
        <a href="{{ route('catalog.show', $product->slug) }}">
            <img src="{{ $product->image_url }}"
                 class="card-img-top"
                 alt="{{ $product->name }}"
                 style="height: 200px; object-fit: cover;">
        </a>

        {{-- DISCOUNT --}}
        @if($product->has_discount)
            <span class="badge-discount">
                -{{ $product->discount_percentage }}%
            </span>
        @endif

        {{-- SIGNATURE --}}
        @if($product->is_signature ?? false)
            <span class="badge-signature">
                🔥 Signature
            </span>
        @endif

        {{-- WISHLIST --}}
        @auth
        <button type="button"
            onclick="toggleWishlist({{ $product->id }})"
            class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 rounded-circle wishlist-btn-{{ $product->id }}">
            <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
        </button>
        @endauth
    </div>

    {{-- BODY --}}
    <div class="card-body d-flex flex-column">

        {{-- CATEGORY --}}
        <small class="text-muted mb-1">
            {{ $product->category->name }}
        </small>

        {{-- NAME --}}
        <h6 class="mb-1">
            <a href="{{ route('catalog.show', $product->slug) }}"
               class="text-decoration-none text-dark stretched-link">
                {{ Str::limit($product->name, 40) }}
            </a>
        </h6>

        {{-- RATING --}}
        <div class="rating-stars small mb-2">
            @for($i=1;$i<=5;$i++)
                <i class="bi {{ $i <= round($product->rating ?? 4) ? 'bi-star-fill' : 'bi-star' }}"></i>
            @endfor
        </div>

        {{-- TAG INFO --}}
        <div class="d-flex gap-1 mb-2">
            <span class="coffee-tag">{{ $product->bean_type ?? 'Arabica' }}</span>
            <span class="coffee-tag">{{ $product->roast_level ?? 'Medium' }}</span>
        </div>

        {{-- PRICE --}}
        <div class="mt-auto">
            @if($product->has_discount)
                <small class="text-muted text-decoration-line-through">
                    {{ $product->formatted_original_price }}
                </small>
            @endif
            <div class="price-main">
                {{ $product->formatted_price }}
            </div>
        </div>

        {{-- STOCK --}}
        @if($product->stock <= 5 && $product->stock > 0)
            <small class="text-warning mt-1">
                <i class="bi bi-exclamation-triangle"></i>
                Sisa {{ $product->stock }}
            </small>
        @elseif($product->stock == 0)
            <small class="text-danger mt-1">
                <i class="bi bi-x-circle"></i> Stok Habis
            </small>
        @endif
    </div>
    

    {{-- FOOTER --}}
    <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-3">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">

            <button type="submit"
                class="btn btn-coffee btn-sm w-100"
                @if($product->stock == 0) disabled @endif>
                <i class="bi bi-cart-plus me-1"></i>
                {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah Keranjang' }}
            </button>
        </form>
    </div>

</div>
