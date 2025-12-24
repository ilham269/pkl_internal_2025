@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Edit Produk</h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <form action="{{ route('', $product->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ================= GAMBAR LAMA ================= --}}
                @if ($product->images->count())
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Gambar Saat Ini</label>

                        <div class="row g-3">
                            @foreach ($product->images as $image)
                                <div class="col-md-3">
                                    <div class="card border-0 shadow-sm">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             class="img-fluid rounded">

                                        <div class="card-body p-2">
                                            <form action="{{ route('admin.product-images.destroy', $image->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus gambar ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm w-100">
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

                {{-- ================= NAMA ================= --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Produk</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $product->name) }}"
                           required>
                </div>

                {{-- ================= KATEGORI ================= --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ================= HARGA ================= --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Harga (Rp)</label>
                        <input type="number"
                               name="price"
                               class="form-control"
                               value="{{ old('price', $product->price) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Harga Diskon (Opsional)</label>
                        <input type="number"
                               name="discount_price"
                               class="form-control"
                               value="{{ old('discount_price', $product->discount_price) }}">
                    </div>
                </div>

                {{-- ================= STOK & BERAT ================= --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Stok</label>
                        <input type="number"
                               name="stock"
                               class="form-control"
                               value="{{ old('stock', $product->stock) }}"
                               required>
                    </div>

                    {{-- 🔥 WEIGHT (WAJIB) --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Berat Produk <small class="text-muted">(gram)</small>
                        </label>
                        <input type="number"
                               name="weight"
                               class="form-control"
                               value="{{ old('weight', $product->weight) }}"
                               required>
                    </div>
                </div>

                {{-- ================= DESKRIPSI ================= --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- ================= STATUS ================= --}}
                <div class="form-check mb-2">
                    <input class="form-check-input"
                           type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        Produk Aktif
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input"
                           type="checkbox"
                           name="is_featured"
                           value="1"
                           {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        Produk Unggulan
                    </label>
                </div>

                {{-- ================= UPLOAD GAMBAR BARU ================= --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Tambah Gambar Baru</label>
                    <input type="file"
                           name="images[]"
                           class="form-control"
                           multiple>
                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti gambar
                    </small>
                </div>

                {{-- ================= ACTION ================= --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Update Produk
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
