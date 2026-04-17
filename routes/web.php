<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');
Route::post('/careers/apply', [PageController::class, 'applyJob'])->name('careers.apply');
Route::post('/services/request', [PageController::class, 'requestService'])->name('services.request');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

// Newsletter
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{key}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{key}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Checkout (Quote Request)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{quoteRequest}', [CheckoutController::class, 'success'])->name('checkout.success');

// Order Tracking
Route::get('/track-order', [CheckoutController::class, 'track'])->name('order.track');
Route::post('/track-order', [CheckoutController::class, 'trackLookup'])->name('order.track.lookup');

// SEO
Route::get('/sitemap.xml', function () {
    $products   = \App\Models\Product::where('status', 'active')->select('slug', 'updated_at')->get();
    $categories = \App\Models\Category::where('is_active', true)->select('slug', 'updated_at')->get();
    $posts      = \App\Models\Post::where('status', 'published')->select('slug', 'updated_at')->get();

    return response()->view('sitemap', compact('products', 'categories', 'posts'))
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

// ────────────────────────────────────────────
// Admin Panel
// ────────────────────────────────────────────
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BannerController as AdminBanner;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ExportController as AdminExport;
use App\Http\Controllers\Admin\JobApplicationController as AdminJobApplication;
use App\Http\Controllers\Admin\PostController as AdminPost;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\QuoteController as AdminQuote;
use App\Http\Controllers\Admin\QuotePdfController as AdminQuotePdf;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequest;
use App\Http\Controllers\Admin\SettingsController as AdminSettings;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriber;

Route::prefix('admin')->group(function () {
    // Auth
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Protected
    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminDashboard::class, 'index'])->name('admin.dashboard');

        // Products
        Route::resource('products', AdminProduct::class)->names('admin.products');

        // Categories
        Route::resource('categories', AdminCategory::class)->names('admin.categories');

        // Banners
        Route::resource('banners', AdminBanner::class)->names('admin.banners')->except('show');

        // Blog Posts
        Route::resource('posts', AdminPost::class)->names('admin.posts')->except('show');

        // Quotes
        Route::get('quotes', [AdminQuote::class, 'index'])->name('admin.quotes.index');
        Route::get('quotes/{quote}', [AdminQuote::class, 'show'])->name('admin.quotes.show');
        Route::patch('quotes/{quote}/status', [AdminQuote::class, 'updateStatus'])->name('admin.quotes.updateStatus');
        Route::delete('quotes/{quote}', [AdminQuote::class, 'destroy'])->name('admin.quotes.destroy');
        Route::get('quotes/{quote}/print', [AdminQuotePdf::class, 'printView'])->name('admin.quotes.print');

        // Subscribers
        Route::get('subscribers', [AdminSubscriber::class, 'index'])->name('admin.subscribers.index');
        Route::get('subscribers/export', [AdminSubscriber::class, 'export'])->name('admin.subscribers.export');
        Route::delete('subscribers/{subscriber}', [AdminSubscriber::class, 'destroy'])->name('admin.subscribers.destroy');

        // Job Applications
        Route::get('job-applications', [AdminJobApplication::class, 'index'])->name('admin.job-applications.index');
        Route::delete('job-applications/{jobApplication}', [AdminJobApplication::class, 'destroy'])->name('admin.job-applications.destroy');

        // Service Requests
        Route::get('service-requests', [AdminServiceRequest::class, 'index'])->name('admin.service-requests.index');
        Route::patch('service-requests/{serviceRequest}/status', [AdminServiceRequest::class, 'updateStatus'])->name('admin.service-requests.updateStatus');
        Route::delete('service-requests/{serviceRequest}', [AdminServiceRequest::class, 'destroy'])->name('admin.service-requests.destroy');

        // Exports
        Route::get('export/products', [AdminExport::class, 'products'])->name('admin.export.products');
        Route::get('export/quotes', [AdminExport::class, 'quotes'])->name('admin.export.quotes');

        // Settings
        Route::get('settings', [AdminSettings::class, 'edit'])->name('admin.settings.edit');
        Route::put('settings', [AdminSettings::class, 'update'])->name('admin.settings.update');
    });
});
