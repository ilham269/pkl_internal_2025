{{-- resources/views/profile/partials/update-password-form.blade.php --}}

<p class="text-muted small">Gunakan password yang kuat demi keamanan akun.</p>

<form method="POST" action="{{ route('profile.password.update') }}">
    @csrf
    @method('PUT')

    {{-- Current Password --}}
    <div class="mb-3">
        <label class="form-label">Password Saat Ini</label>
        <input type="password"
               name="current_password"
               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">

        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- New Password --}}
    <div class="mb-3">
        <label class="form-label">Password Baru</label>
        <input type="password"
               name="password"
               class="form-control @error('password', 'updatePassword') is-invalid @enderror">

        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Confirm --}}
    <div class="mb-3">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password"
               name="password_confirmation"
               class="form-control">
    </div>

    <button class="btn btn-primary">Update Password</button>

    @if (session('status') === 'password-updated')
        <span class="text-success small ms-2">Password berhasil diperbarui</span>
    @endif
</form>
