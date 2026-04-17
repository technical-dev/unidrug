<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariation;

class CartService
{
    /**
     * Get all cart items with product data.
     */
    public function getItems(): array
    {
        $cart = session('cart', []);
        $items = [];

        foreach ($cart as $key => $item) {
            $product = Product::find($item['product_id']);
            if (!$product) continue;

            $variation = null;
            if (!empty($item['variation_id'])) {
                $variation = ProductVariation::find($item['variation_id']);
            }

            $price = $variation ? (float) $variation->price : (float) $product->price;

            $items[] = [
                'key'           => $key,
                'product'       => $product,
                'variation'     => $variation,
                'quantity'      => $item['quantity'],
                'price'         => $price,
                'subtotal'      => $price * $item['quantity'],
                'variation_id'  => $item['variation_id'] ?? null,
            ];
        }

        return $items;
    }

    /**
     * Add a product to the cart.
     */
    public function add(int $productId, int $quantity = 1, ?int $variationId = null): void
    {
        $cart = session('cart', []);
        $key = $productId . '-' . ($variationId ?? 0);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'product_id'   => $productId,
                'variation_id' => $variationId,
                'quantity'     => $quantity,
            ];
        }

        session(['cart' => $cart]);
    }

    /**
     * Update quantity for a cart item.
     */
    public function update(string $key, int $quantity): void
    {
        $cart = session('cart', []);

        if (isset($cart[$key])) {
            if ($quantity <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = $quantity;
            }
        }

        session(['cart' => $cart]);
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(string $key): void
    {
        $cart = session('cart', []);
        unset($cart[$key]);
        session(['cart' => $cart]);
    }

    /**
     * Clear the entire cart.
     */
    public function clear(): void
    {
        session()->forget('cart');
    }

    /**
     * Get total item count.
     */
    public function count(): int
    {
        return collect(session('cart', []))->sum('quantity');
    }

    /**
     * Get cart total.
     */
    public function total(): float
    {
        return collect($this->getItems())->sum('subtotal');
    }
}
