<footer id="coffeeFooter" class="footer-coffee glass">

    {{-- Steam --}}
    <div class="coffee-steam" id="coffeeSteam">
        <span></span><span></span><span></span>
    </div>

    {{-- Toggle --}}
    <button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">
        ☀️
    </button>

    <div class="container pt-5 pb-4">
        <div class="row g-4">

            {{-- Brand + Newsletter --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="footer-brand d-flex align-items-center gap-2">
                    <i class="bi bi-cup-hot-fill"></i> COFFERANCIS
                </h5>

                <p class="footer-text small">
                    Kopi Nusantara pilihan, diseduh dengan sepenuh hati.
                </p>

                {{-- Newsletter --}}
                <form action="{{ route('newsletter.store') }}" method="POST" class="newsletter mt-3">
                    @csrf
                    <label class="small fw-semibold mb-2 d-block">
                        ☕ Coffee Newsletter
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="email" name="email" class="form-control" placeholder="Email kamu" required>
                        <button class="btn btn-coffee" type="submit">
                            Langganan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Menu --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-title">Menu</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('catalog.index') }}" class="footer-link">Katalog</a></li>
                    <li><a href="#" class="footer-link">Tentang</a></li>
                    <li><a href="#" class="footer-link">Kontak</a></li>
                </ul>
            </div>

            {{-- Jam Buka --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-title">Jam Buka</h6>
                <ul class="list-unstyled small footer-text">
                    <li>Senin – Jumat</li>
                    <li class="fw-semibold">08.00 – 22.00</li>
                    <li class="mt-2">Sabtu – Minggu</li>
                    <li class="fw-semibold">09.00 – 23.00</li>
                </ul>
            </div>

            {{-- Maps --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="footer-title">Lokasi Café</h6>
                <div class="map-wrap">
                    <iframe
                        src="https://www.google.com/maps?q=Bandung&output=embed"
                        loading="lazy">
                    </iframe>
                </div>
            </div>

        </div>

        <hr class="footer-divider my-4">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="footer-text small mb-0">
                    © {{ date('Y') }} CoffeeStore — Brewed with love ☕
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <div class="d-flex justify-content-center justify-content-md-end gap-3">
                    <a href="#" class="footer-social"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="footer-social"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="footer-social"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- ================= STYLE ================= --}}
<style>
:root {
    --latte-bg: rgba(247,239,230,.75);
    --latte-text: #5a3e2b;
    --dark-bg: rgba(20,14,10,.75);
    --dark-text: #e6d6c2;
    --accent: #8b5e3c;
}

.footer-coffee {
    position: relative;
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    transition: background .3s, color .3s;
}

.footer-coffee.latte {
    background: var(--latte-bg);
    color: var(--latte-text);
}

.footer-coffee.dark {
    background: var(--dark-bg);
    color: var(--dark-text);
}

/* TYPO */
.footer-brand { font-weight: 700; color: var(--accent); }
.footer-title { font-weight: 600; margin-bottom: .75rem; }
.footer-text { opacity: .85; }

/* LINK */
.footer-link {
    color: inherit;
    text-decoration: none;
    display: inline-block;
    margin-bottom: .4rem;
    transition: .2s;
}
.footer-link:hover { color: var(--accent); transform: translateX(3px); }

/* NEWSLETTER */
.newsletter input { border-radius: 20px 0 0 20px; }
.btn-coffee {
    background: var(--accent);
    color: #fff;
    border-radius: 0 20px 20px 0;
}

/* MAP */
.map-wrap {
    border-radius: 14px;
    overflow: hidden;
    height: 160px;
}

/* SOCIAL */
.footer-social {
    font-size: 1.3rem;
    color: inherit;
    transition: .2s;
}
.footer-social:hover { color: var(--accent); transform: translateY(-3px); }

/* TOGGLE */
.theme-toggle {
    position: absolute;
    top: 14px;
    right: 14px;
    border: none;
    background: var(--accent);
    color: #fff;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    cursor: pointer;
}

/* STEAM */
.coffee-steam {
    position: absolute;
    top: -35px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 12px;
}
.coffee-steam span {
    width: 10px;
    height: 40px;
    background: rgba(255,255,255,.4);
    border-radius: 50%;
    animation: steam 4s infinite;
}
.coffee-steam span:nth-child(2){animation-delay:1s}
.coffee-steam span:nth-child(3){animation-delay:2s}

@keyframes steam {
    0% { opacity:0; transform:translateY(10px) scale(1);}
    50% { opacity:.6;}
    100% { opacity:0; transform:translateY(-40px) scale(1.4);}
}
</style>

{{-- ================= SCRIPT ================= --}}
<script>
const footer = document.getElementById('coffeeFooter');
const toggle = document.getElementById('themeToggle');
const steam = document.getElementById('coffeeSteam');

const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
let theme = localStorage.getItem('coffee-theme') || (systemDark ? 'dark' : 'latte');

setTheme(theme);

toggle.onclick = () => {
    theme = theme === 'dark' ? 'latte' : 'dark';
    localStorage.setItem('coffee-theme', theme);
    setTheme(theme);
};

function setTheme(mode) {
    footer.classList.remove('latte','dark');
    footer.classList.add(mode);
    toggle.textContent = mode === 'dark' ? '🌙' : '☀️';
}

// Steam follow scroll
window.addEventListener('scroll', () => {
    steam.style.transform = `translate(-50%, ${window.scrollY * 0.05}px)`;
});
</script>
