<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q', '');

        $products = Product::where('status', 'active')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('short_description', 'like', "%{$q}%")
                      ->orWhere('sku', 'like', "%{$q}%");
            })
            ->with('categories', 'variations')
            ->paginate(20)
            ->withQueryString();

        return view('products.index', [
            'products'   => $products,
            'categories' => \App\Models\Category::orderBy('name')->get(),
            'searchQuery' => $q,
        ]);
    }

    public function autocomplete(Request $request)
    {
        $q = $request->input('q', '');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $products = Product::where('status', 'active')
            ->where('name', 'like', "%{$q}%")
            ->select('name', 'slug', 'featured_image', 'price')
            ->limit(6)
            ->get()
            ->map(fn($p) => [
                'name'  => $p->name,
                'url'   => route('products.show', $p->slug),
                'image' => $p->featured_image,
                'price' => $p->price ? '$' . number_format($p->price, 2) : null,
            ]);

        return response()->json($products);
    }
}
