@extends('layouts.app')

@section('title', 'Informasi Kontak')

@section('content')

<style>
:root {
  --coffee-dark: #4b2e2b;
  --coffee-main: #7b4a2e;
  --coffee-soft: #a47148;
  --coffee-bg: #faf7f2;
}

.contact-card {
  border-radius: 24px;
  border: 1px solid rgba(75,46,43,.1);
  background: #fff;
}

.contact-icon {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: linear-gradient(135deg, #7b4a2e, #4b2e2b);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 20px;
}

.contact-item {
  display: flex;
  gap: 16px;
  align-items: center;
}

.contact-item p {
  margin: 0;
  color: #6b4a3b;
}

.map-frame {
  border-radius: 20px;
  border: none;
  width: 100%;
  height: 320px;
}

body.dark-coffee .contact-card {
  background: #2a2421;
  color: #f5efe6;
}

body.dark-coffee .contact-item p {
  color: #e0d6cc;
}
</style>

<div class="container py-5">

  <div class="text-center mb-5">
    <h2 class="fw-bold">☕ Informasi Kontak</h2>
    <p class="text-muted">
      Hubungi kami untuk pemesanan, kerja sama, atau sekadar bertanya soal kopi favoritmu.
    </p>
  </div>

  <div class="row g-4">

    {{-- INFO --}}
    <div class="col-lg-5">
      <div class="contact-card p-4 shadow-sm h-100">

        <div class="contact-item mb-4">
          <div class="contact-icon">
            <i class="bi bi-geo-alt"></i>
          </div>
          <div>
            <strong>Alamat</strong>
            <p>Jl. Kopi Nusantara No. 21, Bandung</p>
          </div>
        </div>

        <div class="contact-item mb-4">
          <div class="contact-icon">
            <i class="bi bi-telephone"></i>
          </div>
          <div>
            <strong>Telepon / WhatsApp</strong>
            <p>+62 812-3456-7890</p>
          </div>
        </div>

        <div class="contact-item mb-4">
          <div class="contact-icon">
            <i class="bi bi-envelope"></i>
          </div>
          <div>
            <strong>Email</strong>
            <p>support@kopimocha.id</p>
          </div>
        </div>

        <div class="contact-item">
          <div class="contact-icon">
            <i class="bi bi-clock"></i>
          </div>
          <div>
            <strong>Jam Operasional</strong>
            <p>Setiap Hari • 08.00 – 22.00</p>
          </div>
        </div>

      </div>
    </div>
    <div class="contact-card p-4 shadow-sm mt-4">
  <h5 class="mb-3">📩 Kirim Pesan</h5>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('kontak.kirim') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">No. Telepon (Opsional)</label>
      <input type="text" name="phone" class="form-control">
    </div>

    <div class="mb-3">
      <label class="form-label">Pesan</label>
      <textarea name="message" rows="4" class="form-control" required></textarea>
    </div>

    <button class="btn btn-checkout w-100">
      ☕ Kirim Pesan
    </button>
  </form>
</div>


    {{-- MAP --}}
    <div class="col-lg-7">
      <div class="contact-card p-3 shadow-sm h-100">
        <iframe
          class="map-frame"
          src="https://www.google.com/maps?q=bandung&output=embed"
          loading="lazy">
        </iframe>
      </div>
    </div>

  </div>
</div>

@endsection
