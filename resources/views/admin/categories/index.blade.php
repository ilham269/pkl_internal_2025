@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<style>
    /* Konsistensi Design System */
    .card { border: none; border-radius: 12px; }
    .card-header { border-bottom: 1px solid #f0f2f5; }

    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #6c757d;
        border-top: none;
    }

    .category-icon {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.2s;
    }

    .category-icon:hover { transform: scale(1.1); }

    .badge-pill {
        padding: 0.5em 0.8em;
        border-radius: 50rem;
        font-weight: 600;
    }

    /* Modal Styling agar konsisten dengan Product */
    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.2);
    }

    .modal-header {
        border-bottom: 1px solid #f0f2f5;
        background-color: #fff;
        border-radius: 15px 15px 0 0;
    }

    .modal-footer {
        border-top: 1px solid #f0f2f5;
        background-color: #f8f9fa;
        border-radius: 0 0 15px 15px;
    }

    .form-label { color: #344767; }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12" >
            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show text-white" role="alert" style="background-color: #2dce89;">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 text-dark fw-bold">Daftar Kategori</h5>
                        <p class="text-sm text-muted mb-0">Kelola kategori produk untuk toko Anda</p>
                    </div>
                    <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Baru
                    </button>
                </div>

                <div class="card-body p-0 text-center">
                    <div class="table-responsive ">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Info Kategori</th>
                                    <th class="">Total Produk</th>
                                    <th class="">Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if($category->image)
                                                    <img src="{{ Storage::url($category->image) }}" class="category-icon shadow-sm me-3 border">
                                                @else
                                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center border shadow-sm" style="width: 45px; height: 45px;">
                                                        <i class="bi bi-folder2 text-secondary"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $category->name }}</div>
                                                    <small class="text-muted"><i class="bi bi-link-45deg"></i> {{ $category->slug }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="">
                                            <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2">
                                                {{ $category->products_count }} Produk
                                            </span>
                                        </td>
                                        <td class="">
                                            @if($category->is_active)
                                                <span class="badge badge-pill bg-success-subtle text-success border border-success">Aktif</span>
                                            @else
                                                <span class="badge badge-pill bg-secondary-subtle text-secondary border border-secondary">Non-Aktif</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-warning border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $category->id }}"
                                                        title="Edit">
                                                    <i class="bi bi-pencil-square fs-5"></i>
                                                </button>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Menghapus kategori akan berdampak pada produk terkait. Lanjutkan?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Hapus">
                                                        <i class="bi bi-trash3 fs-5"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <img src="https://illustrations.popsy.co/gray/box.svg" width="100" class="mb-3 opacity-50">
                                            <p class="text-muted">Belum ada kategori yang tersedia.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3 border-0">
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
