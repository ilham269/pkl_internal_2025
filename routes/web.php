<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('tentang', function () {
    return view('tentang');
});

Route::get('/sapa/{nama}', function ($nama) {

    return "Hallo nama saya adalah $nama.";
});
Route::get('/hitung/{angka1}/{angka2}', function ($angka1, $angka2) {

    $hasil = $angka1 + $angka2;
    return "Hasil dari $angka1 + $angka2 adalah $hasil.";
});
Route::get('/kategori/{nama?}', function ($nama="semua") {

    return "Anda manampilkan kategori $nama.";
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ========================================
// FILE: routes/web.php (tambahan untuk admin)
// ========================================

// ================================================
// ROUTE KHUSUS ADMIN
// ================================================
// middleware(['auth', 'admin']) = Harus login DAN harus admin
// prefix('admin')               = Semua URL diawali /admin
// name('admin.')                = Semua nama route diawali admin.
// ================================================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

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
    });
