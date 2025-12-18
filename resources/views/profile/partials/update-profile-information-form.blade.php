{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}

<p class="text-muted small">Perbarui informasi profil dan email kamu.</p>

<form method="POST" action="{{ route('profile.update') }}">
    
    @method('PATCH')

    {{-- Nama --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text"
               id="name"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name) }}"
               required>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email"
               id="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email) }}"
               required>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>
@endif

    </div>

    {{-- Phone --}}
    <div class="mb-3">
        <label for="phone" class="form-label">Nomor Telepon</label>
        <input type="tel"
               id="phone"
               name="phone"
               class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone', $user->phone) }}"
               placeholder="08xxxxxxxxxx">

        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Address --}}
    <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <textarea id="address"
                  name="address"
                  rows="3"
                  class="form-control @error('address') is-invalid @enderror">{{ old('address', $user->address) }}</textarea>

        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button class="btn btn-primary">Simpan Perubahan</button>
</form>


