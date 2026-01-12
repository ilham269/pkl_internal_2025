@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h4 class="fw-bold mb-4">
        Ulasan Produk – {{ $product->name }}
    </h4>

    {{-- FORM ULASAN --}}
    @auth
        @if(!$product->reviews->where('user_id', auth()->id())->count())
        <div class="card p-4 mb-4">
            <form action="{{ route('reviews.store', $product) }}" method="POST">
                @csrf

                <label class="fw-bold mb-2">Rating</label>
                <select name="rating" class="form-select mb-3" required>
                    <option value="">Pilih Rating</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}">{{ $i }} ⭐</option>
                    @endfor
                </select>

                <label class="fw-bold mb-2">Ulasan</label>
                <textarea name="comment" class="form-control mb-3"
                          rows="3"
                          placeholder="Tulis pengalamanmu..."></textarea>

                <button class="btn btn-dark">
                    Kirim Ulasan
                </button>
            </form>
        </div>
        @else
            <div class="alert alert-info">
                Kamu sudah memberikan ulasan untuk produk ini.
            </div>
        @endif
    @else
        <div class="alert alert-warning">
            Silakan login untuk memberikan ulasan.
        </div>
    @endauth

    {{-- DAFTAR REVIEW --}}
    @foreach($reviews as $review)
        <div class="border-bottom pb-3 mb-3">
            <div class="d-flex justify-content-between">
                <strong>{{ $review->user->name }}</strong>
                <span>{{ $review->rating }} ⭐</span>
            </div>

            <p class="mb-1">{{ $review->comment }}</p>

            <small class="text-muted">
                {{ $review->created_at->diffForHumans() }}
            </small>
        </div>
    @endforeach

    {{ $reviews->links() }}

</div>
@endsection
