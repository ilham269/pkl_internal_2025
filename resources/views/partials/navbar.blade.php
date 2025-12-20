<nav class="navbar navbar-expand-lg bg-white sticky-top"
     style="border-bottom:1px solid #e5e7eb;">
    <div class="container-fluid px-4">

        {{-- Brand --}}
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center gap-2"
           href="{{ route('home') }}">
            <i class="bi bi-bag-heart-fill fs-4"></i>
            TokoOnline
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            {{-- Search --}}
            <form class="mx-lg-auto my-3 my-lg-0"
                  style="max-width:520px;width:100%;"
                  action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group rounded-pill overflow-hidden border">
                    <input type="text"
                           name="q"
                           class="form-control border-0 px-4"
                           placeholder="Cari produk di TokoOnline…"
                           value="{{ request('q') }}">
                    <button class="btn btn-primary px-4" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            {{-- Right Menu --}}
            <ul class="navbar-nav ms-lg-auto align-items-center gap-lg-2">

                <li class="nav-item">
                    <a class="nav-link fw-medium"
                       href="{{ route('catalog.index') }}">
                        Katalog
                    </a>
                </li>

                @auth
                    {{-- Wishlist --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative"
                           href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart fs-5"></i>
                            @if(auth()->user()->wishlists()->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle
                                             badge rounded-pill bg-danger"
                                      style="font-size:10px;">
                                    {{ auth()->user()->wishlists()->count() }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Cart --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative"
                           href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                            @php
                                $cartCount = auth()->user()->cart?->items()->count() ?? 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle
                                             badge rounded-pill bg-primary"
                                      style="font-size:10px;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- User --}}
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                           href="#"
                           data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}"
                                 class="rounded-circle"
                                 width="32" height="32"
                                 alt="{{ auth()->user()->name }}">
                            <span class="d-none d-lg-inline fw-medium">
                                {{ auth()->user()->name }}
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="bi bi-bag me-2"></i> Pesanan Saya
                                </a>
                            </li>

                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-primary"
                                       href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                                    </a>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm px-3"
                           href="{{ route('register') }}">
                            Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
