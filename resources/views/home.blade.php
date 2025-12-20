@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<style>
    body {
        background-color: #f9fafb;
    }

    .hero-blibli {
        background: linear-gradient(135deg, #0d6efd, #2563eb);
        border-radius: 0 0 32px 32px;
    }

    .hero-title {
        font-weight: 800;
        line-height: 1.2;
    }

    .section-title {
        font-weight: 700;
    }

    .category-card {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,.06);
    }

    .promo-card {
        border-radius: 16px;
        overflow: hidden;
    }
</style>

{{-- HERO --}}
<section class="hero-blibli text-white py-5 mb-5">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title display-5 mb-3">
                    Belanja Online Mudah & Terpercaya
                </h1>
                <p class="fs-5 opacity-75 mb-4">
                    Temukan produk pilihan dengan harga terbaik.
                    Pengiriman cepat & aman ke seluruh Indonesia.
                </p>
                <a href="{{ route('catalog.index') }}"
                   class="btn btn-light btn-lg fw-semibold px-4">
                    <i class="bi bi-bag me-2"></i>Mulai Belanja
                </a>
            </div>

            <div class="col-lg-6 d-none d-lg-flex justify-content-center">
                <img src="https://www.apple.com/v/iphone/home/cg/images/overview/select/iphone_17pro__0s6piftg70ym_large.jpg"
                     class="img-fluid"
                     style="max-height:380px;">
            </div>
        </div>
    </div>
</section>

{{-- KATEGORI --}}
<section class="mb-5">
    <div class="container-fluid px-lg-5">
        <h4 class="section-title mb-4">Kategori Populer</h4>

        <div class="row row-cols-3 row-cols-md-4 row-cols-lg-6 g-4">
            @foreach($categories as $category)
                <div class="col">
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
                       class="text-decoration-none text-dark">
                        <div class="category-card bg-white text-center h-100 p-3">
                            <img src="{{ $category->image_url }}"
                                 class="rounded-circle mb-3"
                                 width="72" height="72"
                                 style="object-fit:cover;">
                            <div class="fw-semibold small">
                                {{ $category->name }}
                            </div>
                            <small class="text-muted">
                                {{ $category->products_count }} produk
                            </small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PRODUK UNGGULAN --}}
<section class="mb-5">
    <div class="container-fluid px-lg-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="section-title mb-0">Produk Unggulan</h4>
            <a href="{{ route('catalog.index') }}"
               class="text-primary fw-semibold text-decoration-none">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4">
            @foreach($featuredProducts as $product)
                <div class="col">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PROMO --}}
<section class="mb-5">
    <div class="container-fluid px-lg-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="promo-card bg-warning text-dark p-4 h-100">
                    <h4 class="fw-bold">Flash Sale</h4>
                    <p class="mb-3">Diskon hingga 50% untuk produk pilihan</p>
                    <a href="#" class="btn btn-dark btn-sm fw-semibold">
                        Lihat Promo
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="promo-card bg-info text-white p-4 h-100">
                    <h4 class="fw-bold">Member Baru?</h4>
                    <p class="mb-3">
                        Dapatkan voucher Rp 50.000 untuk pembelian pertama
                    </p>
                    <a href="{{ route('register') }}"
                       class="btn btn-light btn-sm fw-semibold">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PRODUK TERBARU --}}
<section class="mb-5">
    <div class="container-fluid px-lg-5">
        <h4 class="section-title mb-4 text-center">
            Produk Terbaru
        </h4>

        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4">
            @foreach($latestProducts as $product)
                <div class="col">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
