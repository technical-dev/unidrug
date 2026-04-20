<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BundleController extends Controller
{
    public function index(Request $request)
    {
        $query = Bundle::withCount('products');

        if ($search = $request->search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $bundles = $query->latest()->paginate(20)->withQueryString();

        return view('admin.bundles.index', compact('bundles'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')->orderBy('name')->get();
        return view('admin.bundles.form', ['bundle' => null, 'products' => $products]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'slug'           => 'nullable|string|max:255|unique:bundles',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|max:2048',
            'bundle_price'   => 'required|numeric|min:0',
            'is_active'      => 'boolean',
            'sort_order'     => 'nullable|integer',
            'starts_at'      => 'nullable|date',
            'ends_at'        => 'nullable|date|after_or_equal:starts_at',
            'products'       => 'required|array|min:2',
            'products.*'     => 'exists:products,id',
            'quantities'     => 'nullable|array',
            'quantities.*'   => 'nullable|integer|min:1',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('bundles', 'public');
        } else {
            unset($data['image']);
        }

        // Calculate original price from products
        $productIds = $data['products'];
        $quantities = $data['quantities'] ?? [];
        $selectedProducts = Product::whereIn('id', $productIds)->get();
        $originalPrice = 0;
        foreach ($selectedProducts as $p) {
            $qty = (int) ($quantities[$p->id] ?? 1);
            $originalPrice += ((float)($p->sale_price ?: $p->price) ?: 0) * $qty;
        }
        $data['original_price'] = $originalPrice;

        $bundle = Bundle::create(collect($data)->except(['products', 'quantities'])->toArray());

        // Sync products with quantities
        $syncData = [];
        foreach ($productIds as $pid) {
            $syncData[$pid] = ['quantity' => (int) ($quantities[$pid] ?? 1)];
        }
        $bundle->products()->sync($syncData);

        return redirect()->route('admin.bundles.index')->with('success', 'Bundle created!');
    }

    public function edit(Bundle $bundle)
    {
        $products = Product::where('status', 'active')->orderBy('name')->get();
        $bundle->load('products');
        return view('admin.bundles.form', compact('bundle', 'products'));
    }

    public function update(Request $request, Bundle $bundle)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'slug'           => 'nullable|string|max:255|unique:bundles,slug,' . $bundle->id,
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|max:2048',
            'bundle_price'   => 'required|numeric|min:0',
            'is_active'      => 'boolean',
            'sort_order'     => 'nullable|integer',
            'starts_at'      => 'nullable|date',
            'ends_at'        => 'nullable|date|after_or_equal:starts_at',
            'products'       => 'required|array|min:2',
            'products.*'     => 'exists:products,id',
            'quantities'     => 'nullable|array',
            'quantities.*'   => 'nullable|integer|min:1',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($bundle->image) {
                $oldPath = str_replace('/storage/', '', $bundle->image);
                Storage::disk('public')->delete($oldPath);
            }
            $data['image'] = '/storage/' . $request->file('image')->store('bundles', 'public');
        } else {
            unset($data['image']);
        }

        // Calculate original price from products
        $productIds = $data['products'];
        $quantities = $data['quantities'] ?? [];
        $selectedProducts = Product::whereIn('id', $productIds)->get();
        $originalPrice = 0;
        foreach ($selectedProducts as $p) {
            $qty = (int) ($quantities[$p->id] ?? 1);
            $originalPrice += ((float)($p->sale_price ?: $p->price) ?: 0) * $qty;
        }
        $data['original_price'] = $originalPrice;

        $bundle->update(collect($data)->except(['products', 'quantities'])->toArray());

        // Sync products with quantities
        $syncData = [];
        foreach ($productIds as $pid) {
            $syncData[$pid] = ['quantity' => (int) ($quantities[$pid] ?? 1)];
        }
        $bundle->products()->sync($syncData);

        return redirect()->route('admin.bundles.index')->with('success', 'Bundle updated!');
    }

    public function destroy(Bundle $bundle)
    {
        // Delete image
        if ($bundle->image) {
            $oldPath = str_replace('/storage/', '', $bundle->image);
            Storage::disk('public')->delete($oldPath);
        }

        $bundle->products()->detach();
        $bundle->delete();

        return redirect()->route('admin.bundles.index')->with('success', 'Bundle deleted!');
    }
}
