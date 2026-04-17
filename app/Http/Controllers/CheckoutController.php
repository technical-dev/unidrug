<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cart) {}

    /**
     * Show checkout / quote request form.
     */
    public function index()
    {
        $items = $this->cart->getItems();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('success', 'Your cart is empty.');
        }

        $total = $this->cart->total();

        return view('checkout.index', compact('items', 'total'));
    }

    /**
     * Process the order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:50',
            'company'        => 'nullable|string|max:255',
            'city'           => 'required|string|max:255',
            'address'        => 'required|string|max:500',
            'building'       => 'nullable|string|max:255',
            'floor'          => 'nullable|string|max:50',
            'payment_method' => 'required|in:cod,bank_transfer',
            'delivery_notes' => 'nullable|string|max:2000',
            'message'        => 'nullable|string|max:2000',
        ]);

        $items = $this->cart->getItems();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('success', 'Your cart is empty.');
        }

        // Build item snapshot
        $snapshot = [];
        foreach ($items as $item) {
            $snapshot[] = [
                'product_name'   => $item['product']->name,
                'product_id'     => $item['product']->id,
                'variation'      => $item['variation'] ? ($item['variation']->attribute_value ?? $item['variation']->name) : null,
                'variation_id'   => $item['variation_id'],
                'quantity'       => $item['quantity'],
                'price'          => $item['price'],
                'subtotal'       => $item['subtotal'],
                'image'          => $item['product']->featured_image,
            ];
        }

        // Generate unique tracking token
        $trackingToken = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));

        $quote = QuoteRequest::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'phone'           => $validated['phone'],
            'company'         => $validated['company'] ?? null,
            'city'            => $validated['city'],
            'address'         => $validated['address'],
            'building'        => $validated['building'] ?? null,
            'floor'           => $validated['floor'] ?? null,
            'message'         => $validated['message'] ?? null,
            'payment_method'  => $validated['payment_method'],
            'delivery_notes'  => $validated['delivery_notes'] ?? null,
            'items'           => $snapshot,
            'estimated_total' => $this->cart->total(),
            'status'          => 'pending',
            'tracking_token'  => $trackingToken,
        ]);

        $this->cart->clear();

        return redirect()->route('checkout.success', $quote);
    }

    /**
     * Order success page.
     */
    public function success(QuoteRequest $quoteRequest)
    {
        return view('checkout.success', compact('quoteRequest'));
    }

    /**
     * Track order page.
     */
    public function track()
    {
        return view('checkout.track');
    }

    /**
     * Look up order by reference + email.
     */
    public function trackLookup(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
            'email'     => 'required|email',
        ]);

        // Extract numeric ID from reference like "ORD-00005"
        $ref = $request->reference;
        $ref = preg_replace('/[^0-9]/', '', $ref);

        $order = QuoteRequest::where('id', (int) $ref)
            ->where('email', $request->email)
            ->first();

        if (!$order) {
            return back()->withInput()->withErrors(['reference' => 'No order found with that reference and email.']);
        }

        return view('checkout.track', compact('order'));
    }
}
