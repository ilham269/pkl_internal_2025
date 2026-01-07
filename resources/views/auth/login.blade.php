{{-- ========================================
FILE: resources/views/auth/login.blade.php
FINAL VERSION – APP STYLE LOGIN
======================================== --}}

@extends('layouts.app')

<style>
/* ================= BRAND ================= */
:root {
  --brand: #2f80ed; /* 🎨 GANTI WARNA BRAND DI SINI */
  --brand-soft: #e6f4ff;
  --bg-light: #ffffff;
  --bg-dark: #0b1e33;
  --text-light: #ffffff;
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
  overflow-x: hidden;
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
.login-card {
  border-radius: 22px;
  background: var(--bg-light);
  box-shadow: 0 20px 40px rgba(0,0,0,.15);
  animation: fadeUp .6s ease;
}

/* ================= HEADER ================= */
.login-header {
  background: linear-gradient(135deg, var(--brand), #56ccf2);
  border-radius: 22px 22px 0 0;
}

/* ================= FLOATING INPUT ================= */
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

.toggle-password:hover {
  opacity: 1;
}

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

/* ================= GOOGLE ================= */
.btn-outline-danger {
  border-radius: 16px;
}

/* ================= MOBILE / PWA ================= */
@media (max-width: 576px) {
  .login-card {
    min-height: 100vh;
    border-radius: 0;
  }
}

/* ================= ANIMATION ================= */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes shake {
  0%,100% { transform: translateX(0); }
  25% { transform: translateX(-6px); }
  75% { transform: translateX(6px); }
}

.shake {
  animation: shake .4s;
}

/* ================= DARK TOGGLE ================= */
.dark-toggle {
  position: absolute;
  top: 16px;
  right: 20px;
  font-size: 18px;
  cursor: pointer;
}
</style>

@section('content')
<div class="page container position-relative">
  <div class="dark-toggle" onclick="toggleTheme()">🌙</div>

  <div class="row justify-content-center">
    <div class="col-md-6">

      <div class="card login-card {{ $errors->any() ? 'shake' : '' }}">
        <div class="card-header login-header text-white text-center">
          <h4 class="mb-0">Login</h4>
        </div>

        <div class="card-body p-4">

          @if ($errors->has('throttle'))
            <div class="alert alert-danger">
              Terlalu banyak percobaan login.
            </div>
          @endif

          <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- EMAIL --}}
            <div class="form-floating mb-3">
              <input type="email"
                class="form-control @error('email') is-invalid @enderror"
                name="email"
                placeholder="Email"
                value="{{ old('email') }}"
                required>
              <label>Email</label>
            </div>

            {{-- PASSWORD --}}
            <div class="form-floating mb-3 password-wrapper">
              <input type="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password"
                placeholder="Password"
                required>
              <label>Password</label>
              <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>

            {{-- REMEMBER --}}
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="remember">
              <label class="form-check-label">Ingat Saya</label>
            </div>

            <div class="d-grid mb-3">
              <button class="btn btn-primary btn-lg">Login</button>
            </div>

            <div class="text-center mb-3">
              <a href="{{ route('password.request') }}">Lupa Password?</a>
            </div>

            <hr>

            <div class="d-grid mb-3">
              <a href="{{ route('auth.google') }}" class="btn btn-outline-danger">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" class="me-2">
                Login dengan Google
              </a>
            </div>

            <p class="text-center mb-0">
              Belum punya akun?
              <a href="{{ route('register') }}" class="fw-bold">Daftar</a>
            </p>

          </form>
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

function togglePassword() {
  const input = document.getElementById('password');
  input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endsection
