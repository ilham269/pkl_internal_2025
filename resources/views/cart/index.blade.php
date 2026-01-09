{{-- ================================================
FILE: resources/views/cart/index.blade.php
FUNGSI: Halaman keranjang belanja (UI Improved)
LOGIC: TIDAK DIUBAH
================================================ --}}

@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')

<style>
    /* ====== GLOBAL DARK COFFEE THEME ====== */
    body {
        background: radial-gradient(circle at top, #2a1c15, #0e0b09);
        color: #f5efe6;
    }

    .cart-title {
        font-weight: 700;
        letter-spacing: .5px;
    }

    /* ====== CARD STYLE ====== */
    .cart-card {
        background: rgba(255,255,255,0.96);
        border-radius: 14px;
        overflow: hidden;
    }

    .summary-card {
        background: linear-gradient(180deg, #2b1e16, #1a120d);
        border-radius: 16px;
        color: #f5efe6;
    }

    /* ====== TABLE ====== */
    .table thead {
        background: #f7f4f1;
    }

    .table th {
        font-size: .9rem;
        letter-spacing: .4px;
        text-transform: uppercase;
    }

    .product-name {
        font-weight: 600;
        color: #2d1b12;
    }

    .product-category {
        font-size: .8rem;
        color: #8b6b55;
    }

    /* ====== QUANTITY INPUT ====== */
    .qty-input {
        border-radius: 8px;
        border: 1px solid #c7b7a6;
    }

    /* ====== PRICE ====== */
    .price {
        font-weight: 600;
        color: #3b2418;
    }

    .subtotal {
        font-weight: 700;
        color: #000;
    }

    /* ====== BUTTONS ====== */
    .btn-checkout {
        background: linear-gradient(135deg, #9c6b43, #7b4a2e);
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        padding: 12px;
    }

    .btn-checkout:hover {
        opacity: .9;
    }

    .btn-continue {
        border-radius: 10px;
        border: 1px solid #9c6b43;
        color: #9c6b43;
    }

    .btn-continue:hover {
        background: rgba(156,107,67,.1);
    }

    /* ====== EMPTY CART ====== */
    .empty-cart {
        background: rgba(0,0,0,.45);
        border-radius: 20px;
        padding: 60px 30px;
    }
</style>

<div class="container py-5">

    <h2 class="cart-title mb-4">
        <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
    </h2>

    @if($cart && $cart->items->count())
    <div class="row g-4">

        {{-- CART ITEMS --}}
        <div class="col-lg-8">
            <div class="cart-card shadow-lg">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th style="width:45%">Produk</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item->product->image_url }}"
                                         class="rounded-3 me-3"
                                         width="64" height="64"
                                         style="object-fit:cover">
                                    <div>
                                        <a href="{{ route('catalog.show', $item->product->slug) }}"
                                           class="product-name text-decoration-none">
                                            {{ Str::limit($item->product->name, 45) }}
                                        </a>
                                        <div class="product-category">
                                            {{ $item->product->category->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center price">
                                {{ $item->product->formatted_price }}
                            </td>

                            <td class="text-center">
                                <form action="{{ route('cart.update', $item->id) }}"
                                      method="POST"
                                      class="d-inline-flex">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number"
                                           name="quantity"
                                           value="{{ $item->quantity }}"
                                           min="1"
                                           max="{{ $item->product->stock }}"
                                           class="form-control form-control-sm qty-input text-center"
                                           style="width:70px"
                                           onchange="this.form.submit()">
                                </form>
                            </td>

                            <td class="text-end subtotal">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>

                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Hapus item ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="col-lg-4">
            <div class="summary-card shadow-lg p-4">
                <h5 class="mb-4 fw-bold">Ringkasan Belanja</h5>

                <div class="d-flex justify-content-between mb-2">
                    <span>Total Harga ({{ $cart->items->sum('quantity') }} barang)</span>
                    <span>Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                </div>

                <hr class="border-light opacity-25">

                <div class="d-flex justify-content-between mb-4 fs-5 fw-bold">
                    <span>Total</span>
                    <span class="text-info">
                        Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                    </span>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn btn-checkout w-100 mb-2">
                    <i class="bi bi-credit-card me-2"></i>Checkout
                </a>

                <a href="{{ route('catalog.index') }}" class="btn btn-continue w-100">
                    <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                </a>
            </div>
        </div>

    </div>

    @else
    {{-- EMPTY CART --}}
    <div class="text-center empty-cart">
        <i class="bi bi-cart-x display-3 text-muted"></i>
        <h4 class="mt-3">Keranjang Kosong</h4>
        <p class="text-muted">Belum ada produk di keranjang belanja kamu</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-checkout mt-3">
            <i class="bi bi-bag me-2"></i>Mulai Belanja
        </a>
    </div>
    @endif

</div>
@endsection
