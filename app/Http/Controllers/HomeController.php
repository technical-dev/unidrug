<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('status', 'active')
            ->where('is_featured', true)
            ->with('categories', 'variations')
            ->latest()
            ->limit(8)
            ->get();

        $topCategories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $latestPosts = Post::where('status', 'published')
            ->latest()
            ->limit(3)
            ->get();

        return view('home.index', compact('banners', 'featuredProducts', 'topCategories', 'latestPosts'));
    }
}
