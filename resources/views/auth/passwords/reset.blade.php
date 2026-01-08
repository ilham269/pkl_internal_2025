@extends('layouts.app')

@section('content')
<style>
:root {
    --brand: #2f80ed;
    --bg-light: #f4f7fb;
    --bg-dark: #0f172a;
    --card-light: #ffffff;
    --card-dark: #020617;
    --text-light: #0f172a;
    --text-dark: #e5e7eb;
}

body.light { background: var(--bg-light); color: var(--text-light); }
body.dark  { background: var(--bg-dark);  color: var(--text-dark); }

/* Card */
.auth-card {
    background: var(--card-light);
    border-radius: 18px;
    animation: fadeSlide .6s ease forwards;
}
body.dark .auth-card { background: var(--card-dark); }

@keyframes fadeSlide {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Input icon */
.input-icon { position: relative; }
.input-icon span {
    position: absolute;
    top: 50%;
    left: 14px;
    transform: translateY(-50%);
    opacity: .6;
}
.input-icon input { padding-left: 42px; }

/* Button */
.btn-brand {
    background: var(--brand);
    border: none;
    border-radius: 14px;
    font-weight: 600;
    padding: 12px;
}
.btn-brand:hover { filter: brightness(1.05); }

/* Toggle */
.theme-toggle {
    position: absolute;
    top: 18px;
    right: 20px;
    cursor: pointer;
    font-size: 1.2rem;
}
</style>

<div class="container min-vh-100 d-flex align-items-center justify-content-center position-relative">
    <div class="theme-toggle" onclick="toggleTheme()">🌙</div>

    <div class="col-md-6 col-lg-5">
        <div class="auth-card shadow p-4">

            {{-- Ilustrasi --}}
            <div class="text-center mb-3">
                <img src="https://cdn-icons-png.flaticon.com/512/6195/6195700.png"
                     width="80" class="mb-2">
                <h5 class="fw-bold mb-0">Buat Password Baru</h5>
                <p class="text-muted small">
                    Masukkan password baru untuk akun kamu
                </p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- EMAIL --}}
                <div class="mb-3 input-icon">
                    <span>📧</span>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email address"
                           value="{{ $email ?? old('email') }}"
                           required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div class="mb-3 input-icon">
                    <span>🔒</span>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password baru"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- CONFIRM --}}
                <div class="mb-4 input-icon">
                    <span>🔐</span>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Konfirmasi password"
                           required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-brand text-white">
                        Reset Password
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
(function () {
    const saved = localStorage.getItem('theme');
    if (saved) {
        document.body.classList.add(saved);
    } else {
        document.body.classList.add(
            window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
        );
    }
})();

function toggleTheme() {
    document.body.classList.toggle('dark');
    document.body.classList.toggle('light');
    localStorage.setItem(
        'theme',
        document.body.classList.contains('dark') ? 'dark' : 'light'
    );
}
</script>
@endsection
