<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class ReviewController extends Controller
{


    public function index(Product $product)
    {
        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('reviews.index', compact('product', 'reviews'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cegah review dobel
        if ($product->reviews()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'Kamu sudah memberikan ulasan.');
        }

        $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        $hasPurchased = auth()->user()->orders()
            ->where('status', 'completed')
            ->whereHas('items', function ($q) use ($product) {
                $q->where('product_id', $product->id);
            })->exists();

        if (!$hasPurchased) {
            abort(403, 'Tidak berhak memberi ulasan.');
        }


        return back()->with('success', 'Ulasan berhasil dikirim.');
    }
}
