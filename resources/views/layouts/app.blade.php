{{-- ================================================
FILE: resources/views/layouts/app.blade.php
FUNGSI: Master layout MOCKA / COFFEE DARK
================================================ --}}

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    <title>@yield('title', 'Toko Online') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online kopi terpercaya')">

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ================= MOCKA GLOBAL STYLE ================= --}}
    <style>
        :root {
            --mocha: #8b5e3c;
            --mocha-dark: #74492f;

            /* DARK COFFEE (BUKAN HITAM) */
            --bg-dark: #120d0a;
            --bg-soft: #1a1410;
            --bg-card: #201814;

            --text-main: #e6d6c2;
            --text-muted: #bfae9b;
            --border: rgba(255,255,255,.08);
        }

        html, body {
            height: 100%;
            margin: 0;
            background: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
        }

        /* ================= MAIN ================= */
        main {
            min-height: 100vh;
            background: linear-gradient(
                to bottom,
                var(--bg-dark),
                var(--bg-soft)
            );
        }

        /* ================= CONTAINER ================= */
        .container,
        .container-fluid {
            background: transparent;
        }

        /* ================= CARD ================= */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-main);
            box-shadow: 0 15px 40px rgba(0,0,0,.6);
        }

        /* ================= ALERT ================= */
        .alert {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-main);
        }

        .alert-success { border-left: 4px solid #4ade80; }
        .alert-danger { border-left: 4px solid #f87171; }

        /* ================= LINK ================= */
        a {
            color: var(--mocha);
            text-decoration: none;
        }

        a:hover {
            color: var(--mocha-dark);
        }

        /* ================= BUTTON ================= */
        .btn-primary {
            background: var(--mocha);
            border: none;
        }

        .btn-primary:hover {
            background: var(--mocha-dark);
        }

        .btn-outline-primary {
            border-color: var(--mocha);
            color: var(--mocha);
        }

        .btn-outline-primary:hover {
            background: var(--mocha);
            color: #fff;
        }

        /* ================= FORM ================= */
        input, textarea, select {
            background: rgba(255,255,255,.07) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-main) !important;
        }

        input::placeholder {
            color: var(--text-muted);
        }

        /* ================= FOOTER ================= */
        footer {
            background: #0e0a08;
            border-top: 1px solid var(--border);
            color: var(--text-muted);
        }
    </style>

    @stack('styles')
</head>
<body>

    

    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- FLASH MESSAGE --}}
    <div class="container mt-3">
        @include('partials.flash-messages')
    </div>

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    @stack('scripts')

    {{-- ================= WISHLIST SCRIPT ================= --}}
    <script>
        async function toggleWishlist(productId) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch(`/wishlist/toggle/${productId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                });

                if (response.status === 401) {
                    window.location.href = "/login";
                    return;
                }

                const data = await response.json();

                if (data.status === "success") {
                    updateWishlistUI(productId, data.added);
                    updateWishlistCounter(data.count);
                }
            } catch (error) {
                console.error(error);
            }
        }

        function updateWishlistUI(productId, isAdded) {
            document.querySelectorAll(`.wishlist-btn-${productId}`).forEach(btn => {
                const icon = btn.querySelector("i");
                icon.className = isAdded
                    ? "bi bi-heart-fill text-danger"
                    : "bi bi-heart text-secondary";
            });
        }

        function updateWishlistCounter(count) {
            const badge = document.getElementById("wishlist-count");
            if (badge) {
                badge.innerText = count;
                badge.style.display = count > 0 ? "inline-block" : "none";
            }
        }
    </script>

</body>
</html>
