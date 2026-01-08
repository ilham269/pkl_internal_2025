@extends('layouts.app')

@section('title', 'Promo Spesial')

@section('content')
<div class="container py-5">

    {{-- HERO PROMO --}}
    <div class="card border-0 shadow-sm mb-5 overflow-hidden">
        <div class="row g-0 align-items-center">
            <div class="col-md-6 p-5">
                <span class="badge bg-danger mb-3">PROMO TERBATAS</span>
                <h1 class="fw-bold mb-3">
                    Diskon Hingga <span class="text-danger">50%</span>
                </h1>
                <p class="text-muted mb-4">
                    Nikmati penawaran terbaik untuk produk pilihan.
                    Jangan lewatkan promo spesial hari ini!
                </p>
                <a href="{{ route('products.index') }}" class="btn btn-danger btn-lg">
                    Belanja Sekarang
                </a>
            </div>
            <div class="col-md-6">
                <img src="https://images.unsplash.com/photo-1607082349566-1870d8f24a3a"
                     class="img-fluid h-100 w-100 object-fit-cover"
                     alt="Promo Banner">
            </div>
        </div>
    </div>

    {{-- LIST PROMO --}}
    <div class="row g-4">
        @foreach($promos as $promo)
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm promo-card">
                <div class="position-relative">
                    <img src="{{ $promo->image }}"
                         class="card-img-top"
                         style="height: 200px; object-fit: cover;">

                    <span class="badge bg-danger position-absolute top-0 start-0 m-3">
                        -{{ $promo->discount }}%
                    </span>
                </div>

                <div class="card-body">
                    <h5 class="fw-bold">{{ $promo->title }}</h5>
                    <p class="text-muted small mb-3">
                        {{ $promo->description }}
