{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<style>
    /* Menghilangkan padding ekstra pada container utama jika ada */
    .content-wrapper { padding: 0 !important; }

    .card { border: none; border-radius: 12px; width: 100%; }
    .table-responsive { width: 100%; }

    /* CSS lainnya tetap sama seperti sebelumnya... */
</style>

<div class="container-fluid py-10"> {{-- Gunakan container-fluid untuk lebar maksimal --}}
    <div class="row">
        <div class="col-lg-12"> {{-- Pastikan col-12 agar memanjang ke kanan --}}

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show text-white mb-4" style="background-color: #2dce89;">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <div>
                        <h5 class="mb-0 text-dark fw-bold">Daftar Kategori</h5>
                        <p class="text-sm text-muted mb-0">Kelola kategori produk untuk toko Anda</p>
                    </div>
                    <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori Baru
                    </button>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 w-100"> {{-- Tambah w-100 --}}
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 40%">INFO KATEGORI</th>
                                    <th class="text-center py-3" style="width: 20%">TOTAL PRODUK</th>
                                    <th class="text-center py-3" style="width: 20%">STATUS</th>
                                    <th class="text-end pe-4 py-3" style="width: 20%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                @if($category->image)
                                                    <img src="{{ Storage::url($category->image) }}" class="category-icon shadow-sm me-3 border" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center border shadow-sm" style="width: 48px; height: 48px;">
                                                        <i class="bi bi-folder2 text-secondary fs-4"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark fs-6">{{ $category->name }}</div>
                                                    <small class="text-muted"><i class="bi bi-link-45deg"></i> {{ $category->slug }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 fw-semibold">
                                                {{ $category->products_count }} Produk
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($category->is_active)
                                                <span class="badge rounded-pill bg-success-subtle text-success border border-success px-3 py-2">Aktif</span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary px-3 py-2">Non-Aktif</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-sm btn-outline-warning border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $category->id }}">
                                                    <i class="bi bi-pencil-square fs-5"></i>
                                                </button>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus kategori?')">
                                                        <i class="bi bi-trash3 fs-5"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Tampilan saat kosong --}}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Pagination --}}
                <div class="card-footer bg-white border-0 py-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>



{{-- CREATE MODAL --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-folder-plus me-2 text-primary"></i>Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4 text-center bg-light p-3 rounded-3 border-dashed border">
                    <label class="form-label d-block fw-bold">Gambar Kategori</label>
                    <i class="bi bi-cloud-arrow-up fs-1 text-primary mb-2 d-block"></i>
                    <input type="file" name="image" class="form-control form-control-sm">
                    <small class="text-muted">Rekomendasi ratio 1:1, Maks 2MB</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="Contoh: Elektronik">
                </div>

                <div class="form-check form-switch bg-light p-3 rounded">
                    <div class="ps-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="create_active" value="1" checked>
                        <label class="form-check-label fw-bold" for="create_active">Publikasikan Kategori</label>
                        <small class="d-block text-muted">Kategori yang aktif akan muncul di halaman depan toko.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL per Loop --}}
@foreach($categories as $category)
<div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow"
              action="{{ route('admin.categories.update', $category->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                {{-- Preview & Upload --}}
                <div class="text-center mb-4 p-3 bg-light rounded-3 border border-dashed">
                    <label class="form-label fw-bold d-block mb-3">Gambar Cover</label>
                    <div class="position-relative d-inline-block mb-3">
                        @if($category->image)
                            <img src="{{ Storage::url($category->image) }}" class="rounded shadow-sm border" width="100" height="100" style="object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                                <i class="bi bi-image fs-1"></i>
                            </div>
                        @endif
                    </div>
                    <input type="file" name="image" class="form-control form-control-sm">
                    <small class="text-muted mt-2 d-block small text-xs italic text-danger">Kosongkan jika tidak ingin mengubah gambar.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="form-check form-switch bg-light p-3 rounded">
                    <div class="ps-4">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="edit_active_{{ $category->id }}" value="1" {{ $category->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="edit_active_{{ $category->id }}">Status Aktif</label>
                        <small class="d-block text-muted">Jika dinonaktifkan, kategori ini tidak akan muncul di web.</small>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
