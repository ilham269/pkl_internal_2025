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

/* ===== AUTO THEME ===== */
body.light {
    background: var(--bg-light);
    color: var(--text-light);
}
body.dark {
    background: var(--bg-dark);
    color: var(--text-dark);
}

/* ===== CARD ===== */
.auth-card {
    background: var(--card-light);
    border-radius: 18px;
    animation: fadeSlide 0.6s ease forwards;
}
body.dark .auth-card {
    background: var(--card-dark);
}

@keyframes fadeSlide {
    from {
        opacity: 0;
        transform: translateY(25px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== INPUT ICON ===== */
.input-icon {
    position: relative;
}
.input-icon span {
    position: absolute;
    top: 50%;
    left: 14px;
    transform: translateY(-50%);
    opacity: 0.6;
}
.input-icon input {
    padding-left: 42px;
}

/* ===== BUTTON ===== */
.btn-brand {
    background: var(--brand);
    border: none;
    border-radius: 14px;
    font-weight: 600;
    padding: 12px;
}
.btn-brand:hover {
    filter: brightness(1.05);
}

/* ===== TOGGLE ===== */
.theme-toggle {
    position: absolute;
    top: 18px;
    right: 20px;
    cursor: pointer;
    font-size: 1.2rem;
}
</style>

<div class="container min-vh-100 d-flex align-items-center justify-content-center position-relative">

    {{-- Theme Toggle --}}
    <div class="theme-toggle" onclick="toggleTheme()">🌙</div>

    <div class="col-md-6 col-lg-5">
        <div class="auth-card shadow p-4">

            {{-- Ilustrasi --}}
            <div class="text-center mb-3">
                <img src="https://cdn-icons-png.flaticon.com/512/6195/6195699.png"
                     width="80"
                     class="mb-2">
                <h5 class="fw-bold mb-0">Reset Password</h5>
                <p class="text-muted small">
                    Kami akan mengirim link reset ke email kamu
                </p>
            </div>

            @if (session('status'))
                <div class="alert alert-success text-center small">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- EMAIL --}}
                <div class="mb-4 input-icon">
                    <span>📧</span>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email address"
                           value="{{ old('email') }}"
                           required autofocus>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- BUTTON --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-brand text-white">
                        Send Reset Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
/* ===== AUTO THEME ===== */
(function () {
    const saved = localStorage.getItem('theme');
    if (saved) {
        document.body.classList.add(saved);
    } else {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.body.classList.add(prefersDark ? 'dark' : 'light');
    }
})();

function toggleTheme() {
    if (document.body.classList.contains('dark')) {
        document.body.classList.replace('dark', 'light');
        localStorage.setItem('theme', 'light');
    } else {
        document.body.classList.replace('light', 'dark');
        localStorage.setItem('theme', 'dark');
    }
}
</script>
@endsection
