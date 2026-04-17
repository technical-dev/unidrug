<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->withCount('children', 'products')
            ->orderBy('sort_order')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->with('children')
            ->firstOrFail();

        $products = $category->products()
            ->where('status', 'active')
            ->with('categories', 'variations')
            ->latest()
            ->paginate(12);

        $childCategories = $category->children()
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        return view('categories.show', compact('category', 'products', 'childCategories'));
    }
}
