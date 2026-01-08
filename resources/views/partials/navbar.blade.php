<nav class="navbar navbar-expand-lg sticky-top blibli-navbar" id="coffeeNavbar">
    <div class="container-fluid px-4 align-items-center position-relative">

        {{-- STEAM --}}
        <div class="navbar-steam">
            <span></span><span></span>
        </div>

        {{-- BRAND --}}
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold"
           href="{{ route('home') }}">
            <i class="bi bi-cup-hot-fill fs-3"></i>
            <span class="fs-5">Ilham STORE</span>
        </a>

        {{-- KATEGORI --}}
        <form action="{{ route('catalog.index') }}">
            <button type="submit"
                class="btn ms-2 d-none d-lg-flex align-items-center gap-2 blibli-category-btn">
                <i class="bi bi-grid"></i>
                <span class="fw-medium">Kategori</span>
            </button>
        </form>

        {{-- MOBILE --}}
        <button class="navbar-toggler ms-2" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            {{-- SEARCH --}}
            <div class="position-relative mx-lg-4 my-3 my-lg-0 flex-grow-1">
                <form action="{{ route('catalog.index') }}" method="GET">
                    <div class="input-group blibli-search">
                        <input type="text"
                               name="q"
                               id="searchInput"
                               class="form-control border-0"
                               placeholder="Cari kopi, alat seduh, biji kopi…"
                               autocomplete="off"
                               value="{{ request('q') }}">
                        <button class="btn px-4">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                {{-- SEARCH SUGGEST --}}
                <div class="search-suggest d-none" id="searchSuggest">
                    <div class="suggest-item">☕ Arabica Gayo</div>
                    <div class="suggest-item">🌱 Robusta Lampung</div>
                    <div class="suggest-item">⚙️ Grinder Kopi Manual</div>
                    <div class="suggest-item">🔥 Dark Roast Beans</div>
                </div>
            </div>

            {{-- RIGHT MENU --}}
            <ul class="navbar-nav align-items-center gap-2 ms-lg-auto">

                @auth
                    {{-- NOTIF --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative">
                            <i class="bi bi-bell fs-5" style="color: #8b5e3c "></i>
                            <span class="badge rounded-pill position-absolute top-0 start-100 translate-middle">
                                0
                            </span>
                        </a>
                    </li>

                    {{-- WISHLIST --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart fs-5" style="color: #8b5e3c"></i>
                            @if(auth()->user()->wishlists()->count() > 0)
                                <span class="badge rounded-pill position-absolute top-0 start-100 translate-middle">
                                    {{ auth()->user()->wishlists()->count() }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- CART --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative cart-icon"
                           href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5" style="color: #8b5e3c "></i>
                            @php $cartCount = auth()->user()->cart?->items()->count() ?? 0; @endphp
                            @if($cartCount > 0)
                                <span class="badge rounded-pill position-absolute top-0 start-100 translate-middle">
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

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil Saya</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">Pesanan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-primary px-4" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary px-4" href="{{ route('register') }}">Daftar</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

{{-- ================= STYLE ================= --}}
<style>
:root {
    --latte-bg: rgba(247,239,230,.75);
    --dark-bg: rgba(20,14,10,.75);
    --coffee-mocha: #8b5e3c;
    --coffee-text: #e6d6c2;
    --border: rgba(255,255,255,.08);
}

.blibli-navbar {
    height: 72px;
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-bottom: 1px solid var(--border);
    transition: background .3s;
}
.blibli-navbar.dark { background: var(--dark-bg); }
.blibli-navbar.latte { background: var(--latte-bg); }

.navbar-brand { color: var(--coffee-text)!important; }
.navbar-brand i { color: var(--coffee-mocha); }

/* STEAM */
.navbar-steam {
    position: absolute;
    left: 50%;
    top: -18px;
    display: flex;
    gap: 10px;
    pointer-events: none;
}
.navbar-steam span {
    width: 8px;
    height: 30px;
    background: rgba(255,255,255,.35);
    border-radius: 50%;
    animation: steam 4s infinite;
}
.navbar-steam span:nth-child(2){animation-delay:1.5s}

@keyframes steam {
    0%{opacity:0;transform:translateY(10px)}
    50%{opacity:.6}
    100%{opacity:0;transform:translateY(-30px)}
}

/* SEARCH */
.blibli-search {
    background: rgba(255,255,255,.08);
    border-radius: 999px;
    border: 1px solid var(--border);
}
.blibli-search input {
    background: transparent;
    color: var(--coffee-text);
}
.blibli-search button {
    background: var(--coffee-mocha);
    color: #fff;
    border: none;
}

/* SUGGEST */
.search-suggest {
    position: absolute;
    top: 110%;
    width: 100%;
    background: rgba(20,14,10,.95);
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid var(--border);
}
.suggest-item {
    padding: 10px 14px;
    cursor: pointer;
    color: var(--coffee-text);
}
.suggest-item:hover {
    background: rgba(139,94,60,.25);
}

/* CART */
.cart-icon:hover {
    animation: bounce .5s;
    animation-timing-function: ease;
    color: white;
}
@keyframes bounce {
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(-4px)}
}

/* DROPDOWN */
.dropdown-menu {
    background: rgba(20,14,10,.95);
    backdrop-filter: blur(10px);
    border-radius: 12px;
}
.dropdown-item { color: var(--coffee-text); }
.dropdown-item:hover { background: rgba(139,94,60,.25); }
</style>

{{-- ================= SCRIPT ================= --}}
<script>
const navbar = document.getElementById('coffeeNavbar');
const theme = localStorage.getItem('coffee-theme') || 'dark';
navbar.classList.add(theme);

/* SEARCH SUGGEST */
const input = document.getElementById('searchInput');
const suggest = document.getElementById('searchSuggest');

input?.addEventListener('focus', ()=> suggest.classList.remove('d-none'));
input?.addEventListener('blur', ()=> setTimeout(()=>suggest.classList.add('d-none'),150));

</script>
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script>
const userId = @json(auth()->id());

if(userId){
    const pusher = new Pusher('{{ config("broadcasting.connections.pusher.key") }}', {
        cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
        encrypted: true
    });

    const channel = pusher.subscribe(`private-user.${userId}`);

    channel.bind('OrderNotification', function(data) {
        showNotif(data.message);
        incrementNotif();
    });
}

/* UI HANDLER */
function showNotif(msg){
    const toast = document.createElement('div');
    toast.className = 'coffee-toast';
    toast.innerHTML = `☕ ${msg}`;
    document.body.appendChild(toast);

    setTimeout(()=>toast.remove(),4000);
}

function incrementNotif(){
    const badge = document.querySelector('.bi-bell')?.nextElementSibling;
    if(badge){
        badge.textContent = parseInt(badge.textContent||0)+1;
        badge.classList.add('pulse');
    }
}
</script>

<style>
.coffee-toast{
    position:fixed;
    bottom:20px;
    right:20px;
    background:#1c1b18;
    color:#e6d6c2;
    padding:12px 18px;
    border-radius:14px;
    box-shadow:0 10px 30px rgba(0,0,0,.3);
    animation:slideIn .4s ease;
    z-index:9999;
}
@keyframes slideIn{
    from{opacity:0;transform:translateY(20px)}
    to{opacity:1}
}
.pulse{
    animation:pulse 1s infinite;
}
@keyframes pulse{
    0%{box-shadow:0 0 0 0 rgba(139,94,60,.6)}
    70%{box-shadow:0 0 0 10px transparent}
}
</style>

