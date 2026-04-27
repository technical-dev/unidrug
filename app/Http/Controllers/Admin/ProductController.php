<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
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
            'group_slug'        => 'nullable|string|max:255',
            'variant_label'     => 'nullable|string|max:100',
            'group_sort'        => 'nullable|integer',
            'attribute_name'    => 'nullable|string|max:100',
            'variations'        => 'nullable|array',
            'variations.*.name' => 'required_with:variations|string|max:255',
            'variations.*.sku'  => 'nullable|string|max:100',
            'variations.*.price'=> 'required_with:variations|numeric|min:0',
            'variations.*.sale_price'      => 'nullable|numeric|min:0',
            'variations.*.attribute_name'  => 'nullable|string|max:255',
            'variations.*.attribute_value' => 'nullable|string|max:255',
            'variations.*.stock_status'    => 'nullable|in:instock,outofstock',
            'variations.*.stock_quantity'  => 'nullable|integer|min:0',
            'variations.*.sort_order'      => 'nullable|integer',
        ]);

        $data['group_slug'] = !empty($data['group_slug']) ? Str::slug($data['group_slug']) : null;
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = '/storage/' . $request->file('featured_image')->store('products', 'public');
        } else {
            unset($data['featured_image']);
        }

        $product = Product::create(collect($data)->except(['categories', 'variations'])->toArray());

        if (!empty($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }

        // Save variations
        if ($data['product_type'] === 'variable' && !empty($data['variations'])) {
            foreach ($data['variations'] as $index => $varData) {
                if (empty($varData['name'])) continue;

                $varImage = null;
                if ($request->hasFile("variation_images.{$index}")) {
                    $varImage = '/storage/' . $request->file("variation_images.{$index}")->store('products/variations', 'public');
                }

                $product->variations()->create([
                    'name'            => $varData['name'],
                    'sku'             => $varData['sku'] ?? null,
                    'price'           => $varData['price'],
                    'sale_price'      => $varData['sale_price'] ?? null,
                    'attribute_name'  => $varData['attribute_name'] ?? null,
                    'attribute_value' => $varData['attribute_value'] ?? null,
                    'stock_status'    => $varData['stock_status'] ?? 'instock',
                    'stock_quantity'  => $varData['stock_quantity'] ?? null,
                    'sort_order'      => $varData['sort_order'] ?? $index,
                    'image'           => $varImage,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load('categories', 'variations');
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
            'group_slug'        => 'nullable|string|max:255',
            'variant_label'     => 'nullable|string|max:100',
            'group_sort'        => 'nullable|integer',
            'attribute_name'    => 'nullable|string|max:100',
            'variations'        => 'nullable|array',
            'variations.*.id'   => 'nullable|integer',
            'variations.*.name' => 'required_with:variations|string|max:255',
            'variations.*.sku'  => 'nullable|string|max:100',
            'variations.*.price'=> 'required_with:variations|numeric|min:0',
            'variations.*.sale_price'      => 'nullable|numeric|min:0',
            'variations.*.attribute_name'  => 'nullable|string|max:255',
            'variations.*.attribute_value' => 'nullable|string|max:255',
            'variations.*.stock_status'    => 'nullable|in:instock,outofstock',
            'variations.*.stock_quantity'  => 'nullable|integer|min:0',
            'variations.*.sort_order'      => 'nullable|integer',
            'variations.*.existing_image'  => 'nullable|string',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['group_slug'] = !empty($data['group_slug']) ? Str::slug($data['group_slug']) : null;
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

        $product->update(collect($data)->except(['categories', 'variations'])->toArray());

        $product->categories()->sync($data['categories'] ?? []);

        // Handle variations
        $incomingVariations = $data['variations'] ?? [];
        $incomingIds = collect($incomingVariations)->pluck('id')->filter()->toArray();

        // Delete removed variations
        $product->variations()->whereNotIn('id', $incomingIds)->each(function ($v) {
            if ($v->image && str_starts_with($v->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $v->image));
            }
            $v->delete();
        });

        // If product is simple, delete all variations
        if ($data['product_type'] === 'simple') {
            $product->variations()->each(function ($v) {
                if ($v->image && str_starts_with($v->image, '/storage/')) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $v->image));
                }
                $v->delete();
            });
        } else {
            // Update or create variations
            foreach ($incomingVariations as $index => $varData) {
                if (empty($varData['name'])) continue;

                $varImage = $varData['existing_image'] ?? null;
                if ($request->hasFile("variation_images.{$index}")) {
                    // Delete old variation image if uploading new one
                    if ($varImage && str_starts_with($varImage, '/storage/')) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $varImage));
                    }
                    $varImage = '/storage/' . $request->file("variation_images.{$index}")->store('products/variations', 'public');
                }

                $variationData = [
                    'name'            => $varData['name'],
                    'sku'             => $varData['sku'] ?? null,
                    'price'           => $varData['price'],
                    'sale_price'      => !empty($varData['sale_price']) ? $varData['sale_price'] : null,
                    'attribute_name'  => $varData['attribute_name'] ?? null,
                    'attribute_value' => $varData['attribute_value'] ?? null,
                    'stock_status'    => $varData['stock_status'] ?? 'instock',
                    'stock_quantity'  => $varData['stock_quantity'] ?? null,
                    'sort_order'      => $varData['sort_order'] ?? $index,
                    'image'           => $varImage,
                ];

                if (!empty($varData['id'])) {
                    // Update existing
                    $variation = $product->variations()->find($varData['id']);
                    if ($variation) {
                        $variation->update($variationData);
                    }
                } else {
                    // Create new
                    $product->variations()->create($variationData);
                }
            }
        }

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
