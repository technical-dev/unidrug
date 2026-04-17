<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cart) {}

    /**
     * Show the cart page.
     */
    public function index()
    {
        $items = $this->cart->getItems();
        $total = $this->cart->total();

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id'   => 'required|exists:products,id',
            'variation_id' => 'nullable|exists:product_variations,id',
            'quantity'     => 'integer|min:1|max:9999',
        ]);

        $this->cart->add(
            $request->product_id,
            $request->quantity ?? 1,
            $request->variation_id
        );

        $product = Product::find($request->product_id);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => "{$product->name} added to quote cart",
                'count'   => $this->cart->count(),
            ]);
        }

        return back()->with('success', "{$product->name} added to quote cart!");
    }

    /**
     * Update item quantity.
     */
    public function update(Request $request, string $key)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:9999',
        ]);

        $this->cart->update($key, $request->quantity);

        if ($request->wantsJson()) {
            return response()->json([
                'count' => $this->cart->count(),
                'total' => $this->cart->total(),
            ]);
        }

        return back()->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart.
     */
    public function remove(string $key)
    {
        $this->cart->remove($key);

        if (request()->wantsJson()) {
            return response()->json([
                'count' => $this->cart->count(),
                'total' => $this->cart->total(),
            ]);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        $this->cart->clear();

        return back()->with('success', 'Cart cleared.');
    }

    /**
     * Get cart count (for AJAX).
     */
    public function count()
    {
        return response()->json(['count' => $this->cart->count()]);
    }
}
