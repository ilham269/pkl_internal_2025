<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Cart;


class CheckoutController extends Controller
{
    /**
     * Halaman checkout
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->cart || $user->cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kosong');
        }



        $cartItems = $user->cart->items;

        $subtotal = $cartItems->sum(
            fn($item) =>
            $item->product?->price ?? 0 * $item->quantity
        );

        $shippingCost = 10000; // contoh ongkir

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'shippingCost'

        ));
    }

    /**
     * Proses checkout → simpan order
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->cart || $user->cart->items->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        $request->validate([
            'shipping_name'    => 'required|string|max:100',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'notes'            => 'nullable|string|max:255',
        ]);

        $cartItems = $user->cart->items;

        $subtotal = $cartItems->sum(
            fn($item) =>
            $item->product?->price ?? 0 * $item->quantity
        );

        $shippingCost = 10000;

        // buat order
        $order = Order::create([
            'user_id'          => $user->id,
            'order_number'     => 'ORD-' . time(),
            'total_amount'     => $subtotal + $shippingCost,
            'shipping_cost'    => $shippingCost,
            'status'           => 'pending',
            'shipping_name'    => $request->shipping_name,
            'shipping_phone'   => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'notes'            => $request->notes,
        ]);

        // simpan item order

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id'   => $item->product_id,
                'product_name' => $item->product->name,
                'price'        => $item->product->price,
                'quantity'     => $item->quantity,
                'subtotal'     => $item->product->price * $item->quantity, // ← tambah ini
            ]);
        }
        // kosongkan cart
        $user->cart->items()->delete();

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat dengan nomor ' . $order->order_number);
    }
    public function direct(Request $request)
    {
        $user = Auth::user();

        // Cek apakah produk sudah ada di cart
        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            // Jika sudah ada → update qty
            $cart->update([
                'quantity' => $cart->quantity + $request->quantity
            ]);
        } else {
            // Jika belum → buat baru
            Cart::create([
                'user_id'    => $user->id,
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        // Redirect langsung ke checkout
        return redirect()->route('checkout.index');
    }
}
