@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="row">
    <div class="col-12">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-gray-800">Edit Produk</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- Card --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.products.update', $product->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
            {{-- photo --}}
            {{-- Gambar Produk Lama --}}
@if ($product->images->count())
    <div class="mb-4">
        <label class="form-label fw-semibold">Gambar Saat Ini</label>

        <div class="row g-3">
            @foreach ($product->images as $image)
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             class="img-fluid rounded">

                        <div class="card-body p-2 text-center">
                            <form action="{{ route('admin.product-images.destroy', $image->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus gambar ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger w-100">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif


                    {{-- Nama Produk --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $product->name) }}"
                               required>
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Harga & Stok --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number"
                                   name="price"
                                   class="form-control"
                                   value="{{ $product->price }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number"
                                   name="stock"
                                   class="form-control"
                                   value="{{ $product->stock }}">
                        </div>
                    </div>

                    {{-- Upload Gambar Baru --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tambah Gambar (Opsional)</label>
                        <input type="file"
                               name="images[]"
                               class="form-control"
                               multiple>
                        <small class="text-muted">
                            Jika tidak upload, gambar lama tetap
                        </small>
                    </div>

                    {{-- Action --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
