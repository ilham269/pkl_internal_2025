@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- SWIPER CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<style>
/* ================= COFFEE THEME ================= */
:root {
    --coffee-black: #1c1b18;
    --dark-brown: #3e2723;
    --mocha: #8b5e3c;
    --latte: #efe6d8;
}

body {
    background-color: var(--coffee-black);
    color: var(--latte);
}

/* ===== HERO ===== */
.heroSwiper {
    width: 100%;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 14px 40px rgba(0,0,0,.5);
}

.hero-img {
    width: 100%;
    height: 320px;
    object-fit: cover;
    filter: brightness(.85) contrast(1.05);
}

.swiper-pagination {
    text-align: right;
    padding-right: 16px;
    padding-bottom: 10px;
}

.swiper-pagination-bullet {
    background: var(--latte);
    opacity: .4;
}

.swiper-pagination-bullet-active {
    background: var(--mocha);
    opacity: 1;
}

/* ===== SECTION ===== */
.section-title {
    font-weight: 700;
    color: var(--latte);
}

/* ===== CATEGORY ===== */
.category-card {
    background: var(--dark-brown);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,.05);
    transition: all .25s ease;
    color: var(--latte);
}

.category-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 36px rgba(0,0,0,.5);
}

/* ===== PRODUCT CARD GLOBAL ===== */
.card {
    background: #2a1d18;
    border: none;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,.4);
    color: var(--latte);
}

/* ===== PROMO ===== */
.promo-card {
    border-radius: 20px;
    background: linear-gradient(135deg, var(--mocha), var(--dark-brown));
    color: var(--latte);
    box-shadow: 0 16px 40px rgba(0,0,0,.5);
}

/* ===== BUTTON ===== */
.btn-dark {
    background-color: var(--coffee-black);
    border-color: var(--coffee-black);
}

.btn-dark:hover {
    background-color: var(--dark-brown);
    border-color: var(--dark-brown);
}

.btn-light {
    background-color: var(--latte);
    color: var(--dark-brown);
    border: none;
}

/* ===== LINK ===== */
a {
    color: #c89b6d;
}

a:hover {
    color: #f3d5b5;
}

/* ===== IMAGE ===== */
img {
    border-radius: 14px;
}
</style>

{{-- HERO --}}
<section class="mb-5">
    <div class="container-fluid px-lg-5">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="https://www.static-src.com/siva/asset/12_2025/carousel-desktop-NVIDIA-PC-Des.jpg?w=1200" class="hero-img">
                </div>
                <div class="swiper-slide">
                    <img src="https://www.static-src.com/siva/asset/12_2025/Homepage_Desktop_Asics-gelnimbus28.jpg?w=1200" class="hero-img">
                </div>
                <div class="swiper-slide">
                    <img src="https://www.static-src.com/siva/asset/12_2025/NPI-iPad-Pro-M5-dw2000x500.jpg?w=1200" class="hero-img">
                </div>
                <div class="swiper-slide">
                    <img src="https://www.static-src.com/siva/asset/12_2025/royco-blm-nov24-homepage-web.jpg?w=1200" class="hero-img">
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
                       class="text-decoration-none">
                        <div class="category-card text-center h-100 p-3">
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
            <a href="{{ route('catalog.index') }}" class="fw-semibold text-decoration-none">
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
                <div class="promo-card p-4 h-100">
                    <h4 class="fw-bold">Flash Sale</h4>
                    <p>Diskon hingga 50% untuk produk pilihan</p>
                    <a href="{{route('promo.index')}}" class="btn btn-dark btn-sm fw-semibold">
                        Lihat Promo
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="promo-card p-4 h-100">
                    <h4 class="fw-bold">Member Baru?</h4>
                    <p>Dapatkan voucher Rp 50.000</p>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm fw-semibold">
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
