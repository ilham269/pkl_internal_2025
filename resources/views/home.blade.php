@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- SWIPER CDN (SATU FILE) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<style>
    body {
        background-color: #f9fafb;
    }

    /* ===== HERO BLIBLI STYLE ===== */
    .heroSwiper {
        width: 100%;
        border-radius: 24px;
        overflow: hidden;
    }

    .hero-img {
        width: 100%;
        height: 320px;
        object-fit: cover;
    }

    .swiper-pagination {
        text-align: right;
        padding-right: 16px;
        padding-bottom: 10px;
    }

    .swiper-pagination-bullet {
        background: #fff;
        opacity: .6;
    }

    .swiper-pagination-bullet-active {
        opacity: 1;
    }

    /* ===== SECTION STYLE ===== */
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

{{-- HERO BANNER (MIRIP BLIBLI) --}}
<section class="mb-5">
    <div class="container-fluid px-lg-5">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <img src="https://www.static-src.com/siva/asset/12_2025/carousel-desktop-NVIDIA-PC-Des.jpg?w=1200"
                         class="hero-img">
                </div>

                <div class="swiper-slide">
                    <img src="https://www.static-src.com/siva/asset/12_2025/Homepage_Desktop_Asics-gelnimbus28.jpg?w=1200"
                                 class="img-fluid hero-img">
                </div>

                <div class="swiper-slide">
                    <img src="https://www.static-src.com/siva/asset/12_2025/NPI-iPad-Pro-M5-dw2000x500.jpg?w=1200"
                         class="hero-img">
                </div>
                <div class="swiper-slide">
                    <img src="https://www.static-src.com/siva/asset/12_2025/royco-blm-nov24-homepage-web.jpg?w=1200"
                         class="hero-img">
                </div>

            </div>

            <div class="swiper-pagination"></div>
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

{{-- SWIPER JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
new Swiper(".heroSwiper", {
    loop: true,
    autoplay: {
        delay: 4500,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});
</script>

@endsection
