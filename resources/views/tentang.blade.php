@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')

<style>
:root {
    --coffee-black: #1c1b18;
    --dark-brown: #3e2723;
    --mocha: #8b5e3c;
    --latte: #efe6d8;
}

.about-hero {
    background: linear-gradient(
        rgba(28,27,24,.75),
        rgba(28,27,24,.75)
    ),
    url('/images/about-coffee.jpg') center/cover no-repeat;
    border-radius: 24px;
    padding: 80px 30px;
    box-shadow: 0 20px 50px rgba(0,0,0,.6);
}

.about-card {
    background: #2a1d18;
    border-radius: 20px;
    box-shadow: 0 14px 36px rgba(0,0,0,.45);
}

.about-icon {
    width: 56px;
    height: 56px;
    background: var(--mocha);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: var(--latte);
}

/* 🔥 TEKS DESKRIPSI TERANG */
.text-desc {
    color: rgba(239, 230, 216, 0.9);
    line-height: 1.7;
}
</style>

<div class="container py-5">

    {{-- HERO --}}
    <div class="about-hero text-center text-light mb-5">
        <h1 class="fw-bold mb-3">Tentang Kami</h1>
        <p class="lead mb-0 text-desc">
            Menyajikan kopi terbaik dengan cita rasa, cerita, dan kehangatan
        </p>
    </div>

    {{-- CERITA --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            <h3 class="fw-bold mb-3">Cerita di Balik Secangkir Kopi</h3>
            <p class="text-desc">
                Website ini lahir dari kecintaan kami terhadap kopi.
                Kami percaya bahwa kopi bukan hanya minuman,
                tetapi sebuah pengalaman — dari aroma biji kopi,
                proses seduh, hingga momen kebersamaan.
            </p>
            <p class="text-desc">
                Kami menghadirkan pilihan kopi terbaik dari Nusantara
                maupun mancanegara, diproses dengan standar kualitas tinggi
                agar setiap tegukan memberikan kepuasan maksimal.
            </p>
        </div>
    </div>

    {{-- NILAI --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="about-card p-4 h-100 text-center">
                <div class="about-icon mx-auto mb-3">☕</div>
                <h5 class="fw-semibold mb-2">Kualitas Terbaik</h5>
                <p class="text-desc mb-0">
                    Kami memilih biji kopi terbaik dengan proses roasting
                    yang terjaga untuk rasa yang konsisten.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="about-card p-4 h-100 text-center">
                <div class="about-icon mx-auto mb-3">🌱</div>
                <h5 class="fw-semibold mb-2">Sumber Terpercaya</h5>
                <p class="text-desc mb-0">
                    Mendukung petani lokal dan sumber kopi berkelanjutan
                    demi masa depan kopi yang lebih baik.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="about-card p-4 h-100 text-center">
                <div class="about-icon mx-auto mb-3">🤎</div>
                <h5 class="fw-semibold mb-2">Pelayanan Jujur</h5>
                <p class="text-desc mb-0">
                    Kepuasan pelanggan adalah prioritas utama kami
                    dalam setiap transaksi.
                </p>
            </div>
        </div>
    </div>

    {{-- VISI --}}
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="about-card p-4 p-lg-5 text-center">
                <h4 class="fw-bold mb-3">Visi Kami</h4>
                <p class="text-desc mb-0">
                    Menjadi platform coffee shop online yang terpercaya,
                    menghadirkan produk kopi berkualitas tinggi
                    serta pengalaman berbelanja yang nyaman dan aman
                    bagi para pecinta kopi di seluruh Indonesia.
                </p>
            </div>
        </div>
    </div>

</div>

@endsection
