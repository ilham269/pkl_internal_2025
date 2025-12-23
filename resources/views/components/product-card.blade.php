@props(['product'])

<style>
    .blibli-product-card {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        transition: transform .2s ease, box-shadow .2s ease;
        background: #fff;
    }

    .blibli-product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,.06);
    }

    .blibli-product-img {
        aspect-ratio: 1 / 1;
        object-fit: cover;
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

    .blibli-discount {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 6px;
        border-radius: 6px;
    }
</style>

<div class="blibli-product-card h-100">

    {{-- IMAGE --}}
    <div class="position-relative overflow-hidden rounded-top">
        <img src="{{ $product->image_url }}"
             class="w-100 blibli-product-img"
             alt="{{ $product->name }}">

        @if($product->has_discount)
            <span class="badge bg-danger position-absolute top-0 start-0 m-2 blibli-discount">
                -{{ $product->discount_percentage }}%
            </span>
        @endif
    </div>

    {{-- BODY --}}
    <div class="p-3 d-flex flex-column h-100">

        {{-- CATEGORY --}}
        <small class="text-muted mb-1">
            {{ $product->category->name }}
        </small>

        {{-- TITLE --}}
        <a href="{{ route('catalog.show', $product->slug) }}"
           class="text-decoration-none text-dark blibli-title mb-2">
            {{ $product->name }}
        </a>

        {{-- PRICE --}}
        <div class="mt-auto">
            @if($product->has_discount)
                <div class="blibli-price">
                    {{ $product->formatted_price }}
                </div>
                <div class="blibli-old-price">
                    {{ $product->formatted_original_price }}
                </div>
            @else
                <div class="blibli-price">
                    {{ $product->formatted_price }}
                </div>
            @endif
        </div>
    </div>
</div>
