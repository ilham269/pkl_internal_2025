{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('content')

<style>
:root {
  --bg-light: #f5f5f7;
  --bg-dark: #0f0f10;

  --card-light: #ffffff;
  --card-dark: #1c1c1e;

  --text-light: #1d1d1f;
  --text-dark: #f5f5f7;

  --border-light: rgba(0,0,0,.08);
  --border-dark: rgba(255,255,255,.08);

  --accent: #7b4a2e;
}

/* ================= BASE ================= */
body {
  background: var(--bg-light);
  color: var(--text-light);
  font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text",
               "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}

/* ================= DARK MODE ================= */
body.dark-coffee {
  background: var(--bg-dark);
  color: var(--text-dark);
}

/* ================= PAGE TITLE ================= */
.page-title {
  font-size: 28px;
  font-weight: 600;
  letter-spacing: -.02em;
}

/* ================= CARD ================= */
.apple-card {
  background: var(--card-light);
  border-radius: 18px;
  border: 1px solid var(--border-light);
  padding: 26px 28px;
}

body.dark-coffee .apple-card {
  background: var(--card-dark);
  border-color: var(--border-dark);
}

/* ================= SECTION HEADER ================= */
.section-header {
  font-size: 15px;
  font-weight: 600;
  margin-bottom: 18px;
  letter-spacing: -.01em;
}

/* ================= BUTTON ================= */
.btn-minimal {
  background: none;
  border: 1px solid var(--border-light);
  border-radius: 999px;
  padding: 8px 18px;
  font-size: 14px;
}

body.dark-coffee .btn-minimal {
  border-color: var(--border-dark);
  color: var(--text-dark);
}

.btn-accent {
  background: var(--accent);
  border: none;
  border-radius: 999px;
  padding: 10px 22px;
  color: #fff;
  font-weight: 500;
}

/* ================= DANGER ================= */
.danger-card {
  border-radius: 18px;
  padding: 26px 28px;
  border: 1px solid rgba(220,53,69,.3);
  background: #fff;
}

body.dark-coffee .danger-card {
  background: #1c1c1e;
}
</style>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      {{-- HEADER --}}
      <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="page-title">Profil</h1>

        <a href="{{ route('home') }}" class="btn btn-minimal">
          Kembali ke Beranda
        </a>
      </div>

      {{-- ALERT --}}
      @if (session('success'))
        <div class="alert alert-success rounded-4 mb-4">
          {{ session('success') }}
        </div>
      @endif

      {{-- FOTO PROFIL --}}
      <div class="apple-card mb-4">
        <div class="section-header">Foto Profil</div>
        @include('profile.partials.update-avatar-form')
      </div>

      {{-- INFORMASI PROFIL --}}
      <div class="apple-card mb-4">
        <div class="section-header">Informasi Profil</div>
        @include('profile.partials.update-profile-information-form')
      </div>

      {{-- PASSWORD --}}
      <div class="apple-card mb-4">
        <div class="section-header">Keamanan Akun</div>
        @include('profile.partials.update-password-form')
      </div>

      {{-- CONNECTED --}}
      <div class="apple-card mb-4">
        <div class="section-header">Akun Terhubung</div>
        @include('profile.partials.connected-accounts')
      </div>

      {{-- DELETE --}}
      <div class="danger-card mt-5">
        <div class="section-header text-danger">Hapus Akun</div>
        @include('profile.partials.delete-user-form')
      </div>

    </div>
  </div>
</div>

@endsection
