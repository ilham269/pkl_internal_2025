<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Tampilkan Dashboard Admin
     */
    public function index()
    {
        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock' => Product::where('stock', '<=', 5)->count(),
            'total_products' => Product::count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('sold')
            ->take(6)
            ->get();

        $revenueChart = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->take(7)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'topProducts',
            'revenueChart'
        ));
    }
    public function dashboard()
    {
        // Hitung statistik utama
        $stats = [
            // Total pendapatan dari semua pesanan yang sudah selesai (status 'completed' atau 'delivered')
            'total_revenue' => Order::whereIn('status', ['completed', 'delivered'])
                ->sum('total_amount'),

            // Total semua pesanan
            'total_orders' => Order::count(),

            // Pesanan yang perlu diproses (status 'pending' atau 'processing')
            'pending_orders' => Order::whereIn('status', ['pending', 'processing'])->count(),

            // Produk dengan stok menipis (misal stok <= 10)
            'low_stock' => Product::where('stock', '<=', 10)->count(),
        ];

        // Ambil 8 pesanan terbaru beserta relasi user
        $recentOrders = Order::with('user')
            ->latest()
            ->take(8)
            ->get();

        // Tambahkan accessor sementara jika belum ada di model Order
        // Kita tambahkan properti dinamis untuk status_color dan order_number
        $recentOrders->each(function ($order) {
            // Warna badge berdasarkan status
            $order->status_color = match ($order->status) {
                'pending'     => 'warning',
                'processing'  => 'info',
                'shipped'     => 'primary',
                'delivered'   => 'success',
                'completed'   => 'success',
                'cancelled'   => 'danger',
                default       => 'secondary',
            };

            // Jika belum ada kolom order_number, buat otomatis
            if (!$order->order_number) {
                $order->order_number = 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
            }
        });

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
