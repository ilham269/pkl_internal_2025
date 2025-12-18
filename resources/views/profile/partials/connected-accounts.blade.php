{{-- resources/views/profile/partials/connected-accounts.blade.php --}}

<div class="d-flex justify-content-between align-items-center border p-3 rounded">
    <div>
        <strong>Google</strong><br>
        @if($user->google_id)
            <span class="text-success">Terhubung</span>
        @else
            <span class="text-muted">Belum terhubung</span>
        @endif
    </div>

    @if($user->google_id)
        <form method="POST" action="{{ route('profile.google.unlink') }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">Putuskan</button>
        </form>
    @else
        <a href="{{ route('auth.google') }}" class="btn btn-outline-primary btn-sm">
            Hubungkan
        </a>
    @endif
</div>
