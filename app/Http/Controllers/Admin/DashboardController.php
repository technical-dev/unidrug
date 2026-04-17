<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\Subscriber;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products'        => Product::count(),
            'categories'      => Category::count(),
            'quotes_pending'  => QuoteRequest::where('status', 'pending')->count(),
            'quotes_total'    => QuoteRequest::count(),
            'subscribers'     => Subscriber::where('is_active', true)->count(),
            'posts'           => Post::where('status', 'publish')->count(),
        ];

        $recentQuotes = QuoteRequest::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentQuotes'));
    }
}
