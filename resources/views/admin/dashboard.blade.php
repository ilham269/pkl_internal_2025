@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">

<style>
/* ================= GLOBAL STYLE ================= */
:root {
    --brand: #006eff;
    --radius: 18px;
}

body[data-theme="dark"] {
    background: #0f172a;
    color: #ffffff;
}

.card {
    border-radius: var(--radius);
    border: none;
    animation: fadeUp .4s ease;

}

.card-header {
    background: transparent;
    border-bottom: 1px solid #e5e7eb;
    font-weight: 600;
}

body[data-theme="dark"] .card {
    background: #020617;
    color: #ffffff;
}

.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 40px rgba(0,0,0,.12);
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Toggle */
.dark-toggle {
    position: fixed;
    top: 18px;
    right: 24px;
    font-size: 1.3rem;
    cursor: pointer;
    z-index: 1000;
}

</style>

{{-- ================= STATS ================= --}}
<div class="row g-4 mb-4">

@php
$statsUI = [
    ['title'=>'Total Pendapatan','value'=>'Rp '.number_format($stats['total_revenue'],0,',','.'),'icon'=>'cash-coin','color'=>'success'],
    ['title'=>'Perlu Diproses','value'=>$stats['pending_orders'],'icon'=>'box-seam','color'=>'warning'],
    ['title'=>'Stok Menipis','value'=>$stats['low_stock'],'icon'=>'exclamation-triangle','color'=>'danger'],
    ['title'=>'Total Produk','value'=>$stats['total_products'],'icon'=>'tags','color'=>'primary'],
];
@endphp

@foreach($statsUI as $s)
<div class="col-sm-6 col-xl-3">
    <div class="card shadow-sm hover-shadow h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted text-uppercase fw-semibold">{{ $s['title'] }}</small>
                <h4 class="fw-bold text-{{ $s['color'] }} mb-0">{{ $s['value'] }}</h4>
            </div>
            <div class="bg-{{ $s['color'] }} bg-opacity-10 p-3 rounded">
                <i class="bi bi-{{ $s['icon'] }} fs-3 text-{{ $s['color'] }}"></i>
            </div>
        </div>
    </div>
</div>
@endforeach
</div>

{{-- ================= MAIN ================= --}}
<div class="row g-4">

{{-- Revenue Chart --}}
<div class="col-lg-8">
    <div class="card shadow-sm h-100">
        <div class="card-header">Grafik Penjualan (7 Hari)</div>
        <div class="card-body">
            <canvas id="revenueChart" height="120"></canvas>
        </div>
    </div>
</div>

{{-- Recent Orders --}}
<div class="col-lg-4">
    <div class="card shadow-sm h-100">
        <div class="card-header">Pesanan Terbaru</div>
        <div class="list-group list-group-flush">
            @foreach($recentOrders as $order)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-bold text-primary">#{{ $order->order_number }}</div>
                    <small class="text-muted">{{ $order->user->name }}</small>
                </div>
                <div class="text-end">
                    <div class="fw-bold">Rp {{ number_format($order->total_amount,0,',','.') }}</div>
                    <span class="badge rounded-pill bg-{{ $order->payment_status=='paid'?'success':'secondary' }} bg-opacity-10 text-{{ $order->payment_status=='paid'?'success':'secondary' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('admin.orders.index') }}" class="fw-bold text-decoration-none">
                Lihat Semua Pesanan →
            </a>
        </div>
    </div>
</div>
</div>

{{-- ================= TOP PRODUCTS ================= --}}
<div class="card shadow-sm mt-4">
    <div class="card-header">Produk Terlaris</div>
    <div class="card-body">
        <div class="row g-4">
            @foreach($topProducts as $product)
            <div class="col-6 col-md-2 text-center">
                <div class="card hover-shadow p-2">
                    <img src="{{ $product->image_url }}" class="rounded mb-2" style="height:90px;object-fit:cover">
                    <h6 class="small text-truncate">{{ $product->name }}</h6>
                    <small class="text-muted">{{ $product->sold }} terjual</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const rawData = {!! json_encode($revenueChart) !!};
const labels = rawData.map(i => i.date);
const data = rawData.map(i => Number(i.total));

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels,
        datasets: [{
            data,
            borderColor: '#2f80ed',
            backgroundColor: 'rgba(47,128,237,.15)',
            borderWidth: 3,
            tension: .45,
            fill: true,
            pointRadius: 5,
            pointBackgroundColor: '#fff',
            pointBorderWidth: 2
        }]
    },
    options: {
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#020617',
                padding: 12,
                cornerRadius: 12
            }
        },
        interaction: { intersect:false, mode:'index' },
        animation: { duration:1200, easing:'easeOutQuart' },
        scales: {
            y: { ticks:{ callback:v=>'Rp '+new Intl.NumberFormat('id-ID').format(v)}},
            x: { grid:{display:false}}
        }
    }
});

/* Dark Mode */
function toggleTheme(){
    document.body.dataset.theme =
        document.body.dataset.theme === 'dark' ? 'light' : 'dark';
}
</script>
@endpush
