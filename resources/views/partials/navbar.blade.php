<nav class="navbar navbar-expand-lg bg-white sticky-top blibli-navbar">
    <div class="container-fluid px-4 align-items-center">

        {{-- BRAND --}}
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-primary"
           href="{{ route('home') }}">
            <i class="bi bi-bag-check-fill fs-3"></i>
            <span class="fs-5">Ilham STORE</span>
        </a>

        {{-- KATEGORI --}}
        <button class="btn btn-light border ms-2 d-none d-lg-flex align-items-center gap-2 blibli-category-btn">
            <i class="bi bi-grid"></i>
            <span class="fw-medium">Kategori</span>
        </button>

        {{-- MOBILE TOGGLE --}}
        <button class="navbar-toggler ms-2" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            {{-- SEARCH --}}
            <form class="mx-lg-4 my-3 my-lg-0 flex-grow-1"
                  action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group blibli-search">
                    <input type="text"
                           name="q"
                           class="form-control border-0"
                           placeholder="Cari produk, merek, atau toko"
                           value="{{ request('q') }}">
                    <button class="btn btn-primary px-4">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            {{-- RIGHT MENU --}}
            <ul class="navbar-nav align-items-center gap-2 ms-lg-auto">

                @auth
                    {{-- NOTIF --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                                  style="font-size:10px;">0</span>
                        </a>
                    </li>
                    {{-- Wishlist --}} <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart fs-5"></i> @if(auth()->user()->wishlists()->count() > 0) <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size:10px;"> {{ auth()->user()->wishlists()->count() }}
                        </span>
                        @endif
                    </a>
                </li>

                    {{-- CART --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative"
                           href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                            @php $cartCount = auth()->user()->cart?->items()->count() ?? 0; @endphp
                            @if($cartCount > 0)
                                <span class="badge bg-primary rounded-pill position-absolute top-0 start-100 translate-middle"
                                      style="font-size:10px;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- USER --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                           data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}"
                                 class="rounded-circle"
                                 width="32" height="32">
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    Pesanan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    {{-- LOGIN & REGISTER --}}
                    <li class="nav-item">
                        <a class="btn btn-outline-primary px-4"
                           href="{{ route('login') }}">
                            Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary px-4"
                           href="{{ route('register') }}">
                            Daftar
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

{{-- STYLE BLIBLI NAVBAR --}}
<style>
.blibli-navbar {
    height: 72px;
    border-bottom: 1px solid #e5e7eb;
    z-index: 999;
}

.blibli-search {
    border: 1px solid #e5e7eb;
    border-radius: 999px;
    overflow: hidden;
}

.blibli-search input {
    padding: 10px 16px;
    font-size: 14px;
}

.blibli-search button {
    border-radius: 0;
}

.blibli-category-btn {
    height: 40px;
    border-radius: 8px;
    font-size: 14px;
}

.navbar .nav-link {
    color: #111827;
}

.navbar .nav-link:hover {
    color: #2563eb;
}
</style>
