{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
     STYLE: Marketplace Blibli-like
     ================================================ --}}

<style>
    .blibli-card {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #fff;
        transition: all .2s ease;
    }

    .blibli-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,.06);
    }

    .blibli-img-wrapper {
        position: relative;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        border-radius: 14px 14px 0 0;
        background: #f9fafb;
    }

    .blibli-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-discount {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ef4444;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 6px;
        border-radius: 6px;
    }

    .blibli-title {
        font-size: 14px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 40px;
    }

    .blibli-price {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }

    .blibli-old-price {
        font-size: 12px;
        color: #9ca3af;
        text-decoration: line-through;
    }

    .wishlist-btn {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
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
                    class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle wishlist-btn wishlist-btn-{{ $product->id }}">
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
                <small class="text-warning d-block mt-1">
                    Stok tinggal {{ $product->stock }}
                </small>
            @elseif($product->stock == 0)
                <small class="text-danger d-block mt-1">
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
