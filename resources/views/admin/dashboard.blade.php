@extends('layouts.admin')


@section('title', 'Dashboard Admin')


@section('content')
<h1 class="mb-4">Dashboard Admin</h1>


<div class="row">
<div class="col-md-4">
<div class="card text-white bg-primary mb-3">
<div class="card-body">
<h5 class="card-title">Total User</h5>
<p class="card-text fs-3" > {{ date('d M Y') }}<p>
</div>
</div>
</div>


<div class="col-md-4">
<div class="card text-white bg-success mb-3">
<div class="card-body">
<h5 class="card-title">Total Produk</h5>
<p class="card-text fs-3">20</p>
</div>
</div>
</div>


<div class="col-md-4">
<div class="card text-white bg-warning mb-3">
<div class="card-body">
<h5 class="card-title">Transaksi</h5>
<p class="card-text fs-3">320</p>
</div>
</div>
</div>
</div>


<div class="card mt-4">
<div class="card-header">Aktivitas Terbaru</div>
<div class="card-body">
<ul>
<li>User baru mendaftar</li>
<li>Produk baru ditambahkan</li>
<li>Transaksi berhasil</li>
</ul>
</div>
</div>
@endsection
