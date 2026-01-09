{{-- ========================================
FILE: resources/views/auth/login.blade.php
FINAL VERSION – COFFEE DARK PWA LOGIN
======================================== --}}

@extends('layouts.app')

<style>
/* ================= BRAND ================= */
:root {
  --mocha: #8b5e3c;
  --mocha-dark: #74492f;
  --bg: #0f0b08;
  --card-bg: rgba(20,14,10,.94);
  --text: #e6d6c2;
  --border: rgba(255,255,255,.08);
}

/* ================= GLOBAL ================= */
html, body {
  height: 100%;
}

body {
  background: #000000;
  color: var(--text);
  overflow-x: hidden;
}

/* ================= PAGE ================= */
.page {
  min-height: 100svh; /* PWA safe fullscreen */
  display: flex;
  align-items: center;
  justify-content: center;
  animation: pageEnter .6s ease;
}

@keyframes pageEnter {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ================= CARD ================= */
.login-card {
  width: 100%;
  border-radius: 24px;
  background: var(--card-bg);
  backdrop-filter: blur(14px);
  border: 1px solid var(--border);
  box-shadow: 0 30px 70px rgba(0,0,0,.6);
  overflow: hidden;
  animation: fadeUp .6s ease;
}

/* ================= HEADER ================= */
.login-header {
  position: relative;
  padding: 36px 24px 46px;
  background: linear-gradient(135deg, var(--mocha), var(--mocha-dark));
  text-align: center;
}

/* Coffee illustration */
.login-header::before {

  position: absolute;
  left: 50%;
  top: -30px;
  transform: translateX(-50%);
  font-size: 48px;
  filter: drop-shadow(0 10px 20px rgba(0,0,0,.4));
}

/* Steam */
.steam {
  position: absolute;
  top: -34px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 10px;
}
.steam span {
  width: 8px;
  height: 34px;
  background: rgba(255,255,255,.45);
  border-radius: 50%;
  animation: steam 4s infinite;
}
.steam span:nth-child(2){animation-delay:1.5s}

@keyframes steam {
  0%{opacity:0;transform:translateY(10px)}
  50%{opacity:.7}
  100%{opacity:0;transform:translateY(-30px)}
}

/* ================= FORM ================= */
.form-floating input {
  border-radius: 14px;
  background: rgba(255,255,255,.08);
  border: 1px solid var(--border);
  color: var(--text);
}

.form-floating label {
  color: rgba(230,214,194,.7);
}

.form-floating input:focus {
  background: rgba(255,255,255,.12);
  border-color: var(--mocha);
  box-shadow: 0 0 0 .2rem rgba(139,94,60,.35);
}

/* ================= PASSWORD ================= */
.password-wrapper { position: relative; }
.toggle-password {
  position: absolute;
  top: 50%;
  right: 16px;
  transform: translateY(-50%);
  cursor: pointer;
  opacity: .6;
}
.toggle-password:hover { opacity: 1; }

/* ================= CHECKBOX ================= */
.form-check-input {
  background: transparent;
  border-color: var(--mocha);
}
.form-check-input:checked {
  background: var(--mocha);
  border-color: var(--mocha);
}

/* ================= BUTTON ================= */
.btn-primary {
  background: var(--mocha);
  border: none;
  border-radius: 16px;
  padding: 14px;
  font-weight: 600;
  transition: .3s;
}

.btn-primary:hover {
  background: var(--mocha-dark);
  transform: translateY(-2px);
  box-shadow: 0 14px 34px rgba(139,94,60,.45);
}

/* ================= GOOGLE ================= */
.btn-outline-danger {
  border-radius: 16px;
  background: rgba(255,255,255,.06);
  border-color: rgba(255,255,255,.2);
  color: var(--text);
}
.btn-outline-danger:hover {
  background: rgba(255,255,255,.12);
}

/* ================= TEXT ================= */
a { color: var(--mocha); }
a:hover { color: var(--mocha-dark); }

/* ================= MOBILE ================= */
@media (max-width: 576px) {
  .login-card {
    min-height: 100svh;
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
.shake { animation: shake .4s; }
</style>

@section('content')
<div class="page container">
  <div class="row justify-content-center w-100">
    <div class="col-md-6 col-lg-5">

      <div class="card login-card {{ $errors->any() ? 'shake' : '' }}">
        <div class="login-header text-white">
          <div class="steam"><span></span><span></span></div>
          <h4 class="mb-0 fw-bold">COFFERANCIS</h4>
          <small class="opacity-75">Masuk & nikmati kopi terbaik</small>
        </div>

        <div class="card-body p-4">

          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-floating mb-3">
              <input type="email" name="email"
                     class="form-control"
                     placeholder="Email" required>
              <label>Email</label>
            </div>

            <div class="form-floating mb-3 password-wrapper">
              <input type="password" id="password"
                     name="password"
                     class="form-control"
                     placeholder="Password" required>
              <label>Password</label>
              <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>

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

            <hr class="border-light opacity-25">

            <div class="d-grid mb-3">
              <a href="{{ route('auth.google') }}" class="btn btn-outline-danger">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg"
                     width="18" class="me-2">
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
function togglePassword() {
  const input = document.getElementById('password');
  input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endsection
