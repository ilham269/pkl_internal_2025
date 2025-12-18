{{-- resources/views/profile/partials/delete-user-form.blade.php --}}

<p class="text-muted small">
    Setelah akun dihapus, semua data akan hilang permanen.
</p>

<form method="POST" action="{{ route('profile.destroy') }}">
    @csrf
    @method('DELETE')

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password"
               name="password"
               class="form-control @error('password', 'userDeletion') is-invalid @enderror">

        @error('password', 'userDeletion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button class="btn btn-danger">Hapus Akun</button>
</form>
