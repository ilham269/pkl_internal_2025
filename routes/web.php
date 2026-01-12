<?php
// ========================================
// FILE: routes/web.php
// FUNGSI: Mendefinisikan semua URL route aplikasi
// ========================================

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;



// Admin Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\MidtransNotificationController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;


use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;


// ================================================
// ROUTE PUBLIK (Bisa diakses siapa saja)
// ================================================
// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');


// ulasan produk
Route::get('/products/{product}/reviews', [ReviewController::class, 'index'])
    ->name('reviews.index');

Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');


//kontak
Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');
Route::post('/kontak/kirim', [ContactController::class, 'store'])->name('kontak.kirim');



Route::get('/kontak', function () {
    return view('pages.kontak');
})->name('kontak');

Route::get('/tentang', function () {
    return view('pages.tentang');
})->name('tentang');


Route::post('/checkout/direct', [CheckoutController::class, 'direct'])
    ->name('checkout.direct')
    ->middleware('auth');



Route::post('/newsletter', [NewsletterController::class, 'store'])
    ->name('newsletter.store');

//promo
Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');



//admin

Route::get('/admin', [AdminController::class, 'index']);


// Pastikan name('products.show') ada di sini
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


// home page
Route::get('/', [HomeController::class, 'index'])->name('home');
// ↑ Halaman utama, tidak perlu login

// Katalog Produk
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/product/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

// ↑ Halaman katalog dan detail produk, tidak perlu login

// ================================================
// HALAMAN YANG BUTUH LOGIN (Customer)
// ================================================
Route::middleware('auth')->group(function () {
    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Pesanan Saya
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
});

Route::middleware('auth')->group(function () {
    // ... routes lainnya

    // Payment Routes
    Route::get('/orders/{order}/pay', [PaymentController::class, 'show'])
        ->name('orders.pay');
    Route::get('/orders/{order}/success', [PaymentController::class, 'success'])
        ->name('orders.success');
    Route::get('/orders/{order}/pending', [PaymentController::class, 'pending'])
        ->name('orders.pending');
});
// Midtrans Notification Route (tidak perlu login)
// ============================================================
// MIDTRANS WEBHOOK
// Route ini HARUS public (tanpa auth middleware)
// Karena diakses oleh SERVER Midtrans, bukan browser user
// ============================================================
Route::post('midtrans/notification', [MidtransNotificationController::class, 'handle'])->name('midtrans.notification');



// ================================================
// HALAMAN ADMIN (Butuh Login + Role Admin)
// ================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Produk CRUD
    Route::resource('products', AdminProductController::class);

    // Kategori CRUD
    Route::resource('categories', AdminCategoryController::class);

    // Manajemen Pesanan
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Laporan Penjualan
    Route::get('/reports/sales', [AdminReportController::class, 'sales'])
        ->name('reports.sales');

    Route::get('/reports/sales/export', [AdminReportController::class, 'exportSales'])
        ->name('reports.export-sales');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Manajemen Pengguna
    Route::get('/user', [AdminController::class, 'index'])->name('users.index');
    Route::delete('/user/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    // Manajemen Kategori
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});





Route::get('/mockup', function () {
    return view('mockup');
});

// modul hari 1
Route::get('/tentang', function () {
    return view('tentang');
});

// Latihan 1
Route::get('/sapa/{nama}', function ($nama) {
    return "Halo, $nama! Selamat datang di Toko Online.";
});

// Latihan 2
Route::get('/kategori/{nama?}', function ($nama = 'Semua') {
    return "Menampilkan kategori: $nama";
})->name('kategori.detail');

// Latihan 3
Route::get('/produk/{id}', function ($id = 'belum-ada') {
    return "Detail produk dengan ID: $id";
})->name('produk.detail');
// end modul hari 1


// ================================================
// AUTH ROUTES
// ================================================
// Auth::routes() adalah "shortcut" yang membuat banyak route sekaligus:
// - GET  /login           → Tampilkan form login
// - POST /login           → Proses login
// - POST /logout          → Proses logout
// - GET  /register        → Tampilkan form register
// - POST /register        → Proses register
// - GET  /password/reset  → Tampilkan form lupa password
// - POST /password/email  → Kirim email reset password
// - dll...
// ================================================

// ================================================
// ROUTE YANG MEMERLUKAN LOGIN
// ================================================
// middleware('auth') = Harus login dulu untuk akses
// Jika belum login, otomatis redirect ke /login
// ================================================
Route::middleware('auth')->group(function () {
    // Semua route di dalam group ini HARUS LOGIN

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
    // ↑ ->name('home') = Memberi nama route
    // Kegunaan: route('home') akan menghasilkan URL /home

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});


// ================================================
// ROUTE KHUSUS ADMIN
// ================================================
// middleware(['auth', 'admin']) = Harus login DAN harus admin
// prefix('admin')               = Semua URL diawali /admin
// name('admin.')                = Semua nama route diawali admin.
// ================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // /admin/dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');
    // ↑ Nama lengkap route: admin.dashboard
    // ↑ URL: /admin/dashboard

    // CRUD Produk: /admin/products, /admin/products/create, dll
    Route::resource('/products', AdminProductController::class);
    // ↑ resource() membuat 7 route sekaligus:
    // - GET    /admin/products          → index   (admin.products.index)
    // - GET    /admin/products/create   → create  (admin.products.create)
    // - POST   /admin/products          → store   (admin.products.store)
    // - GET    /admin/products/{id}     → show    (admin.products.show)
    // - GET    /admin/products/{id}/edit→ edit    (admin.products.edit)
    // - PUT    /admin/products/{id}     → update  (admin.products.update)
    // - DELETE /admin/products/{id}     → destroy (admin.products.destroy)

    // CRUD Kategori: /admin/categories, /admin/categories/create, dll
    Route::resource('categories', CategoryController::class)->except(['show']); // Kategori biasanya tidak butuh show detail page
    // Produk
    Route::resource('products', ProductController::class);
});

// login dengan Google OAuth (Socialite) - modul hari 4
Route::controller(GoogleController::class)->group(function () {
    // ================================================
    // ROUTE 1: REDIRECT KE GOOGLE
    // ================================================
    // URL: /auth/google
    // Dipanggil saat user klik tombol "Login dengan Google"
    // ================================================
    Route::get('/auth/google', 'redirect')
        ->name('auth.google');

    // ================================================
    // ROUTE 2: CALLBACK DARI GOOGLE
    // ================================================
    // URL: /auth/google/callback
    // Dipanggil oleh Google setelah user klik "Allow"
    // URL ini HARUS sama dengan yang didaftarkan di Google Console!
    // ================================================
    Route::get('/auth/google/callback', 'callback')
        ->name('auth.google.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');

Auth::routes();
