@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold">
            Tambah Produk Baru
        </div>

        <div class="card-body">
            <form action="{{ route('admin.products.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           required>
                </div>

                {{-- Kategori --}}
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Harga --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number"
                               name="price"
                               class="form-control"
                               value="{{ old('price') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Diskon</label>
                        <input type="number"
                               name="discount_price"
                               class="form-control"
                               value="{{ old('discount_price') }}">
                    </div>
                </div>

                {{-- Stok --}}
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number"
                           name="stock"
                           class="form-control"
                           value="{{ old('stock') }}"
                           required>
                </div>

                {{-- 🔥 WEIGHT (INI YANG WAJIB) --}}
                <div class="mb-3">
                    <label class="form-label">
                        Berat Produk <small class="text-muted">(gram)</small>
                    </label>
                    <input type="number"
                           name="weight"
                           class="form-control"
                           value="{{ old('weight') }}"
                           placeholder="Contoh: 500"
                           required>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description') }}</textarea>
                </div>

                {{-- Status --}}
                <div class="form-check mb-2">
                    <input class="form-check-input"
                           type="checkbox"
                           name="is_active"
                           value="1"
                           checked>
                    <label class="form-check-label">
                        Produk Aktif
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input"
                           type="checkbox"
                           name="is_featured"
                           value="1">
                    <label class="form-check-label">
                        Produk Unggulan
                    </label>
                </div>

                {{-- Gambar --}}
                <div class="mb-4">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file"
                           name="images[]"
                           class="form-control"
                           multiple>
                </div>

                <button class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Produk
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
