{{-- resources/views/profile/partials/update-avatar-form.blade.php --}}

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="d-flex align-items-center gap-3">
        <img id="preview"
             src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/default-avatar.png') }}"
             class="rounded-circle border"
             width="100"
             height="100">

        <div class="flex-grow-1">
            <input type="file"
                   name="avatar"
                   class="form-control @error('avatar') is-invalid @enderror"
                   onchange="previewAvatar(event)">

            @error('avatar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <button class="btn btn-primary mt-3">Simpan Foto</button>
</form>

@if($user->avatar)
<form method="POST" action="{{ route('profile.avatar.destroy') }}" class="mt-2">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm">Hapus Foto</button>
</form>
@endif

<script>
function previewAvatar(event) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('preview').src = e.target.result;
    reader.readAsDataURL(event.target.files[0]);
}
</script>
