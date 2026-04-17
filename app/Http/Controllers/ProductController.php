<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'active')
            ->with('categories', 'variations');

        // Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Sorting
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->latest();
                break;
        }

        // Fetch all matching products
        $allProducts = $query->get();

        // Group by group_slug: keep only the first product per group
        $seen = [];
        $filtered = $allProducts->filter(function ($product) use (&$seen) {
            if ($product->group_slug) {
                if (isset($seen[$product->group_slug])) {
                    return false; // skip subsequent group members
                }
                $seen[$product->group_slug] = true;
            }
            return true;
        })->values();

        // Manual pagination on the de-duped collection
        $page = $request->input('page', 1);
        $perPage = 12;
        $total = $filtered->count();
        $items = $filtered->forPage($page, $perPage);

        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $items, $total, $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Preload group members for displayed products
        $groupSlugs = $items->pluck('group_slug')->filter()->unique()->values()->toArray();
        $groupedProducts = [];
        if (!empty($groupSlugs)) {
            $allGroupMembers = Product::whereIn('group_slug', $groupSlugs)
                ->where('status', 'active')
                ->orderBy('group_sort')
                ->get();
            foreach ($allGroupMembers as $gp) {
                $groupedProducts[$gp->group_slug][] = $gp;
            }
        }

        return view('products.index', compact('products', 'groupedProducts'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with('variations', 'images', 'categories')
            ->firstOrFail();

        $relatedProducts = Product::where('status', 'active')
            ->where('id', '!=', $product->id)
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->with('categories', 'variations')
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
