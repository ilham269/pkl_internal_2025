<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Pastikan keranjang tidak kosong
        $cart = auth()->user()->cart;
        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request, OrderService $orderService)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        try {
            $order = $orderService->createOrder(auth()->user(), $request->only(['name', 'phone', 'address']));

            // Redirect ke halaman pembayaran (akan dibuat besok)
            // Untuk sekarang, redirect ke detail order
            return redirect()->route('orders.show', $order)
                -> with('checkout_success', [
                'title' => 'Checkout berhasil',
                'message' => 'Pesanan kamu berhasil dibuat',
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function direct(Request $request)
    {
        // Validasi data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Ambil produk
            $product = \App\Models\Product::findOrFail($request->product_id);

            // Buat order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total'   => $product->price * $request->qty,
                'status'  => 'pending',
            ]);

            // Buat item order
            OrderItem::create([
                'order_id'  => $order->id,
                'product_id' => $product->id,
                'qty'       => $request->qty,
                'price'     => $product->price,
                'subtotal'  => $product->price * $request->qty,
            ]);

            DB::commit();

            // Redirect ke halaman detail / checkout
            return redirect()
                ->route('orders.show', $order->id)
                ->with('success', 'Berhasil checkout produk');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Checkout gagal');
        }
    }
}
