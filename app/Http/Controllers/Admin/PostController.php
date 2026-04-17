<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::latest();

        if ($search = $request->search) {
            $query->where('title', 'like', "%{$search}%");
        }
        if ($status = $request->status) {
            $query->where('status', $status);
        }

        $posts = $query->paginate(20)->withQueryString();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.form', ['post' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'slug'           => 'nullable|string|max:255|unique:posts',
            'content'        => 'nullable|string',
            'excerpt'        => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'status'         => 'required|in:published,draft',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = '/storage/' . $request->file('featured_image')->store('posts', 'public');
        } else {
            unset($data['featured_image']);
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post created!');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'slug'           => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'content'        => 'nullable|string',
            'excerpt'        => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'status'         => 'required|in:published,draft',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image && str_starts_with($post->featured_image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $post->featured_image));
            }
            $data['featured_image'] = '/storage/' . $request->file('featured_image')->store('posts', 'public');
        } else {
            unset($data['featured_image']);
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image && str_starts_with($post->featured_image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $post->featured_image));
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted!');
    }
}
