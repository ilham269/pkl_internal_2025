<?php

use Illuminate\Support\Facades\Route;

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

