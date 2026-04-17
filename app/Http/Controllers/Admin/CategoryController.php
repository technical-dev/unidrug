<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products', 'children')
            ->with('parent')
            ->orderBy('name')
            ->paginate(30);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.categories.form', ['category' => null, 'parents' => $parents]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'parent_id'   => 'nullable|exists:categories,id',
            'is_active'   => 'boolean',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('categories', 'public');
        } else {
            unset($data['image']);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created!');
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.form', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'parent_id'   => 'nullable|exists:categories,id',
            'is_active'   => 'boolean',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            // Delete old uploaded image if it's a local file
            if ($category->image && str_starts_with($category->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $category->image));
            }
            $data['image'] = '/storage/' . $request->file('image')->store('categories', 'public');
        } else {
            // Keep existing image if no new file uploaded
            unset($data['image']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated!');
    }

    public function destroy(Category $category)
    {
        $category->products()->detach();
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted!');
    }
}
