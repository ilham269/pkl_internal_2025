<footer class="bg-light pt-5 pb-4 mt-5"
        style="border-top:1px solid #e5e7eb;">
    <div class="container">

        <div class="row g-4">
            {{-- Brand --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-bag-heart-fill fs-4"></i>
                    TokoOnline
                </h5>
                <p class="text-muted small">
                    Toko online terpercaya dengan berbagai produk berkualitas.
                    Belanja mudah, aman, dan nyaman untuk semua kebutuhan Anda.
                </p>

                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-muted fs-5 footer-social"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-muted fs-5 footer-social"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-muted fs-5 footer-social"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-muted fs-5 footer-social"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            {{-- Menu --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-semibold mb-3">Menu</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="{{ route('catalog.index') }}" class="footer-link">
                            Katalog Produk
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Tentang Kami</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Kontak</a>
                    </li>
                </ul>
            </div>

            {{-- Bantuan --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-semibold mb-3">Bantuan</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="footer-link">FAQ</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Cara Belanja</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Kebijakan Privasi</a></li>
                </ul>
            </div>

            {{-- Kontak --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="fw-semibold mb-3">Hubungi Kami</h6>
                <ul class="list-unstyled small text-muted">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt me-2 text-primary"></i>
                        Jl. Rancamanyar No. 24, Bandung
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone me-2 text-primary"></i>
                        082312630553
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope me-2 text-primary"></i>
                        ilhm282@gmail.com
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4">

        {{-- Bottom --}}
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-muted small mb-0">
                    © {{ date('Y') }} TokoOnline. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <img src="{{ asset('images/payment-methods.png') }}"
                     alt="Payment Methods"
                     height="28">
            </div>
        </div>
    </div>
</footer>

{{-- Footer helper style --}}
<style>
    .footer-link {
        color: #6b7280;
        text-decoration: none;
    }

    .footer-link:hover {
        color: #0d6efd;
    }

    .footer-social:hover {
        color: #0d6efd !important;
    }
</style>
