{{-- resources/views/orders/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')

<style>
/* ================= COFFEE DARK TEXT ================= */
:root {
    --coffee-dark: #2b1b12;
    --coffee-main: #7b4a2e;
    --coffee-soft: #9a7b62;
    --coffee-muted: #8a6f5c;
    --coffee-bg-soft: #f3eee9;
}

/* GLOBAL TEXT */
body {
    color: var(--coffee-dark);
}

/* CARD */
.card {
    background: #fff;
}

/* TITLE */
.order-title {
    color: var(--coffee-dark);
}

/* MUTED */
.text-muted {
    color: var(--coffee-muted) !important;
}

/* TABLE */
.table th {
    color: var(--coffee-dark);
}

.table td {
    color: #3a2a20;
}

/* PRICE */
.price-muted {
    color: var(--coffee-soft);
}

.text-primary {
    color: var(--coffee-main) !important;
}

/* SHIPPING */
.shipping-box {
    background: var(--coffee-bg-soft);
}

.shipping-box i {
    color: var(--coffee-soft);
}

/* BUTTON PAY */
.btn-pay {
    background: linear-gradient(135deg, #7b4a2e, #4b2e2b);
    border: none;
    color: #f5efe6;
}

.btn-pay:hover {
    background: linear-gradient(135deg, #8c5a38, #5a342f);
}
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- BACK --}}
            <div class="mb-4">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali ke Pesanan Saya
                </a>
            </div>

            <div class="card shadow-sm border-0">

                {{-- HEADER --}}
                <div class="card-header bg-white py-4 border-bottom">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div>
                            <h1 class="h3 fw-bold mb-1 order-title">
                                Order #{{ $order->order_number }}
                            </h1>
                            <p class="text-muted mb-0">
                                <i class="bi bi-calendar3"></i>
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        {{-- STATUS --}}
                        <div class="mt-3 mt-md-0">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-warning text-dark',
                                    'processing' => 'bg-info text-white',
                                    'shipped' => 'bg-primary text-white',
                                    'delivered' => 'bg-success text-white',
                                    'cancelled' => 'bg-danger text-white',
                                ];
                                $badgeClass = $statusClasses[$order->status] ?? 'bg-secondary text-white';
                            @endphp

                            <span class="badge rounded-pill px-4 py-2 fs-6 {{ $badgeClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">

                    {{-- ITEMS --}}
                    <div class="p-4 p-md-5">
                        <h5 class="fw-bold mb-4">Produk yang Dipesan</h5>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td class="fw-medium">
                                            {{ $item->product_name }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="text-end price-muted">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end fw-bold">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    @if($order->shipping_cost > 0)
                                    <tr>
                                        <td colspan="3" class="text-end">Ongkos Kirim</td>
                                        <td class="text-end">
                                            Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold fs-5">TOTAL BAYAR</td>
                                        <td class="text-end fw-bold fs-5 text-primary">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- SHIPPING --}}
                    <div class="p-4 p-md-5 shipping-box border-top border-bottom">
                        <h5 class="fw-bold mb-3">Alamat Pengiriman</h5>
                        <p class="fw-bold mb-1">{{ $order->shipping_name }}</p>
                        <p class="text-muted mb-1">
                            <i class="bi bi-telephone"></i> {{ $order->shipping_phone }}
                        </p>
                        <p class="text-muted mb-0">
                            <i class="bi bi-geo-alt"></i> {{ $order->shipping_address }}
                        </p>
                    </div>
                </div>

                {{-- PAY --}}
                @if(isset($snapToken) && $order->status === 'pending')
                <div class="card-footer bg-white py-5 text-center">
                    <p class="text-muted mb-4">
                        Selesaikan pembayaran Anda sebelum batas waktu berakhir.
                    </p>
                    <button id="pay-button"
                        class="btn btn-pay btn-lg px-5 py-3 rounded-3 fw-bold">
                        💳 Bayar Sekarang
                    </button>
                </div>
                @endif
                    @foreach($order->items as $item)
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        {{ $item->product->name }}
        <br>
        <small>Qty: {{ $item->quantity }}</small>
    </div>

    @if($order->status === 'completed')
        <a href="{{ route('reviews.index', $item->product) }}"
           class="btn btn-sm btn-outline-dark">
            Beri Ulasan
        </a>
    @endif
</div>
@endforeach

            </div>
        </div>
    </div>
</div>

@if(isset($snapToken))
@push('scripts')
<script src="{{ config('midtrans.snap_url') }}"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const payButton = document.getElementById('pay-button');

    if (payButton) {
        payButton.addEventListener('click', function () {
            payButton.disabled = true;
            payButton.innerHTML =
                '<span class="spinner-border spinner-border-sm"></span> Memproses...';

            window.snap.pay('{{ $snapToken }}', {
                onSuccess: () => window.location.href = '{{ route("orders.success", $order) }}',
                onPending: () => window.location.href = '{{ route("orders.pending", $order) }}',
                onError: () => {
                    alert('Pembayaran gagal!');
                    payButton.disabled = false;
                    payButton.innerHTML = '💳 Bayar Sekarang';
                },
                onClose: () => {
                    payButton.disabled = false;
                    payButton.innerHTML = '💳 Bayar Sekarang';
                }
            });
        });
    }
});
</script>
@endpush
@endif
@endsection
`
