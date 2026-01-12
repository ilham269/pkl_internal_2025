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

}
