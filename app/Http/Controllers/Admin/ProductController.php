<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('categories');

        if ($search = $request->search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($category = $request->category) {
            $query->whereHas('categories', fn($q) => $q->where('slug', $category));
        }

        $products = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.form', ['product' => null, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:products',
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
            'price'             => 'nullable|numeric|min:0',
            'sku'               => 'nullable|string|max:100',
            'stock_status'      => 'required|in:instock,outofstock',
            'product_type'      => 'required|in:simple,variable',
            'featured_image'    => 'nullable|image|max:2048',
            'is_featured'       => 'boolean',
            'is_active'         => 'boolean',
            'categories'        => 'array',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = '/storage/' . $request->file('featured_image')->store('products', 'public');
        } else {
            unset($data['featured_image']);
        }

        $product = Product::create(collect($data)->except('categories')->toArray());

        if (!empty($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load('categories');
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
            'price'             => 'nullable|numeric|min:0',
            'sku'               => 'nullable|string|max:100',
            'stock_status'      => 'required|in:instock,outofstock',
            'product_type'      => 'required|in:simple,variable',
            'featured_image'    => 'nullable|image|max:2048',
            'is_featured'       => 'boolean',
            'is_active'         => 'boolean',
            'categories'        => 'array',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($request->hasFile('featured_image')) {
            // Delete old uploaded image if it's a local file
            if ($product->featured_image && str_starts_with($product->featured_image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $product->featured_image));
            }
            $data['featured_image'] = '/storage/' . $request->file('featured_image')->store('products', 'public');
        } else {
            // Keep existing image if no new file uploaded
            unset($data['featured_image']);
        }

        $product->update(collect($data)->except('categories')->toArray());

        $product->categories()->sync($data['categories'] ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Product updated!');
    }

    public function destroy(Product $product)
    {
        $product->categories()->detach();
        $product->variations()->delete();
        $product->images()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
    }
}
