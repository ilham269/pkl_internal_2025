@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="row">
    <div class="col-12">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1 fw-bold">Tambah Produk Baru</h2>
                <small class="text-muted">
                    Lengkapi informasi produk dengan benar
                </small>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- INFORMASI PRODUK --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-semibold">
                    Informasi Produk
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Produk <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Contoh: Laptop ASUS ROG"
                               value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select name="category_id"
                                class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- HARGA & STOK --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-semibold">
                    Harga & Stok
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number"
                                   name="price"
                                   class="form-control"
                                   placeholder="1500000"
                                   value="{{ old('price') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number"
                                   name="stock"
                                   class="form-control"
                                   placeholder="10"
                                   value="{{ old('stock') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- MEDIA --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-semibold">
                    Media Produk
                </div>
                <div class="card-body">
                    <label class="form-label fw-semibold">Foto Produk</label>
                    <input type="file" name="images[]" class="form-control" multiple>
                    <small class="text-muted">
                        Bisa upload lebih dari satu gambar
                    </small>
                </div>
            </div>

            {{-- ACTION --}}
            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save"></i> Simpan Produk
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
