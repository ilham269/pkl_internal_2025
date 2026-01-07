@extends('layouts.app')

<style>
/* ================= BRAND ================= */
:root {
  --brand: #2f80ed; /* 🎨 samakan dengan login */
  --brand-soft: #e6f4ff;
  --bg-light: #ffffff;
  --bg-dark: #0b1e33;
  --text-dark: #1f2937;
}

/* Dark mode */
[data-theme="dark"] {
  --bg-light: #0b1e33;
  --brand-soft: #081828;
  --text-dark: #e5e7eb;
}

/* ================= GLOBAL ================= */
body {
  background: linear-gradient(135deg, var(--brand-soft), var(--bg-light));
  min-height: 100vh;
}

/* ================= PAGE TRANSITION ================= */
.page {
  animation: pageEnter .6s ease;
}
@keyframes pageEnter {
  from { opacity: 0; transform: translateY(25px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ================= CARD ================= */
.register-card {
  border-radius: 22px;
  background: var(--bg-light);
  box-shadow: 0 20px 40px rgba(0,0,0,.15);
}

/* ================= HEADER ================= */
.register-header {
  background: linear-gradient(135deg, var(--brand), #56ccf2);
  border-radius: 22px 22px 0 0;
}

/* ================= INPUT ================= */
.form-floating input {
  border-radius: 14px;
}
.form-floating input:focus {
  border-color: var(--brand);
  box-shadow: 0 0 0 .2rem rgba(47,128,237,.25);
}

/* ================= PASSWORD TOGGLE ================= */
.password-wrapper {
  position: relative;
}
.toggle-password {
  position: absolute;
  top: 50%;
  right: 16px;
  transform: translateY(-50%);
  cursor: pointer;
  opacity: .6;
}
.toggle-password:hover { opacity: 1; }

/* ================= BUTTON ================= */
.btn-primary {
  background: var(--brand);
  border: none;
  border-radius: 16px;
  padding: 14px;
  font-weight: 600;
  transition: .3s;
}
.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(47,128,237,.35);
}

/* ================= MOBILE / PWA ================= */
@media (max-width: 576px) {
  .register-card {
    min-height: 100vh;
    border-radius: 0;
  }
}

/* ================= DARK TOGGLE ================= */
.dark-toggle {
  position: absolute;
  top: 16px;
  right: 20px;
  cursor: pointer;
}
</style>

@section('content')
<div class="page container position-relative">
  <div class="dark-toggle" onclick="toggleTheme()">🌙</div>

  <div class="row justify-content-center">
    <div class="col-md-6">

      <div class="card register-card">
        <div class="card-header register-header text-white text-center">
          <h4 class="mb-0">Buat Akun Baru</h4>
        </div>

        <div class="card-body p-4">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- NAME --}}
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                name="name"
                placeholder="Nama"
                value="{{ old('name') }}"
                required
                autofocus>
              <label>Nama Lengkap</label>
              @error('name')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            {{-- EMAIL --}}
            <div class="form-floating mb-3">
              <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                name="email"
                placeholder="Email"
                value="{{ old('email') }}"
                required>
              <label>Email</label>
              @error('email')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            {{-- PASSWORD --}}
            <div class="form-floating mb-3 password-wrapper">
              <input
                type="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password"
                placeholder="Password"
                required>
              <label>Password</label>
              <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
              @error('password')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div class="form-floating mb-4 password-wrapper">
              <input
                type="password"
                id="password_confirmation"
                class="form-control"
                name="password_confirmation"
                placeholder="Konfirmasi Password"
                required>
              <label>Konfirmasi Password</label>
              <span class="toggle-password" onclick="togglePassword('password_confirmation')">👁️</span>
            </div>

            {{-- REGISTER --}}
            <div class="d-grid mb-4">
              <button class="btn btn-primary btn-lg">
                Daftar
              </button>
            </div>
          </form>

          {{-- DIVIDER --}}
          <div class="position-relative my-4">
            <hr>
            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted">
              atau daftar dengan
            </span>
          </div>

          {{-- GOOGLE REGISTER --}}
          <div class="d-grid mb-3">
            <a href="{{ route('auth.google') }}" class="btn btn-outline-danger btn-lg">
              <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" class="me-2">
              Daftar dengan Google
            </a>
          </div>

          {{-- LOGIN LINK --}}
          <p class="text-center mb-0">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="fw-bold text-decoration-none">
              Login
            </a>
          </p>

        </div>
      </div>

    </div>
  </div>
</div>

<script>
function toggleTheme() {
  const html = document.documentElement;
  html.dataset.theme =
    html.dataset.theme === "dark" ? "light" : "dark";
}

function togglePassword(id) {
  const input = document.getElementById(id);
  input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endsection
