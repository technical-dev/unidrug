<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->paginate(20);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.form', ['banner' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url'  => 'nullable|string|max:255',
            'image'       => 'nullable|image|max:2048',
            'sort_order'  => 'integer',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('banners', 'public');
        } else {
            unset($data['image']);
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created!');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.form', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url'  => 'nullable|string|max:255',
            'image'       => 'nullable|image|max:2048',
            'sort_order'  => 'integer',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($banner->image && str_starts_with($banner->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $banner->image));
            }
            $data['image'] = '/storage/' . $request->file('image')->store('banners', 'public');
        } else {
            unset($data['image']);
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated!');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && str_starts_with($banner->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $banner->image));
        }
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted!');
    }
}
