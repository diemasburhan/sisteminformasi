<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('is_slider') && $request->is_slider == '1') {
            $query->where('is_slider', true);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create-edit', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published,scheduled',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $slug = Str::slug($request->title);
        $count = Post::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts'), $filename);
            $imagePath = 'uploads/posts/' . $filename;
        }

        $publishedAt = $request->published_at;
        if ($request->status === 'published' && !$publishedAt) {
            $publishedAt = now();
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'featured_image' => $imagePath,
            'status' => $request->status,
            'published_at' => $publishedAt,
            'is_slider' => $request->has('is_slider'),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Create Post',
            'details' => 'Created post: "' . $post->title . '" (ID: ' . $post->id . ')'
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dibuat.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('admin.posts.create-edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published,scheduled',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $imagePath = $post->featured_image;
        if ($request->hasFile('featured_image')) {
            // Delete old file
            if ($post->featured_image && file_exists(public_path($post->featured_image))) {
                @unlink(public_path($post->featured_image));
            }

            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts'), $filename);
            $imagePath = 'uploads/posts/' . $filename;
        }

        $publishedAt = $request->published_at;
        if ($request->status === 'published' && !$publishedAt) {
            $publishedAt = $post->published_at ?? now();
        }

        // Keep original slug unless title changed
        $slug = $post->slug;
        if ($post->title !== $request->title) {
            $slug = Str::slug($request->title);
            $count = Post::where('slug', 'like', $slug . '%')->where('id', '!=', $post->id)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
        }

        $post->update([
            'title' => $request->title,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'featured_image' => $imagePath,
            'status' => $request->status,
            'published_at' => $publishedAt,
            'is_slider' => $request->has('is_slider'),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Update Post',
            'details' => 'Updated post: "' . $post->title . '" (ID: ' . $post->id . ')'
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->featured_image && file_exists(public_path($post->featured_image))) {
            @unlink(public_path($post->featured_image));
        }

        $title = $post->title;
        $post->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Delete Post',
            'details' => 'Deleted post: "' . $title . '"'
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dihapus.');
    }

    // Auto-save endpoint via AJAX
    public function autoSave(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
        ]);

        $id = $request->id;
        $publishedAt = $request->published_at;

        if ($id) {
            $post = Post::findOrFail($id);
            $post->update([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'content' => $request->content,
                'status' => $request->status,
                'published_at' => $publishedAt,
            ]);
        } else {
            // Create a draft post
            $slug = Str::slug($request->title);
            $count = Post::where('slug', 'like', $slug . '%')->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            $post = Post::create([
                'title' => $request->title,
                'slug' => $slug,
                'category_id' => $request->category_id,
                'user_id' => Auth::id(),
                'content' => $request->content,
                'status' => 'draft',
                'published_at' => null,
            ]);
            $id = $post->id;
        }

        return response()->json([
            'success' => true,
            'id' => $id,
            'message' => 'Draf berhasil disimpan secara otomatis pada ' . date('H:i:s')
        ]);
    }

    // Bulk actions (Delete & Publish)
    public function bulkAction(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if (empty($ids) || !is_array($ids)) {
            return redirect()->route('admin.posts.index')->with('error', 'Pilih postingan terlebih dahulu.');
        }

        if ($action === 'delete') {
            $posts = Post::whereIn('id', $ids)->get();
            foreach ($posts as $post) {
                if ($post->featured_image && file_exists(public_path($post->featured_image))) {
                    @unlink(public_path($post->featured_image));
                }
                $post->delete();
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => 'Bulk Delete Posts',
                'details' => 'Deleted ' . count($ids) . ' posts'
            ]);

            return redirect()->route('admin.posts.index')->with('success', count($ids) . ' postingan berhasil dihapus.');
        } elseif ($action === 'publish') {
            Post::whereIn('id', $ids)->update([
                'status' => 'published',
                'published_at' => now()
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => 'Bulk Publish Posts',
                'details' => 'Published ' . count($ids) . ' posts'
            ]);

            return redirect()->route('admin.posts.index')->with('success', count($ids) . ' postingan berhasil diterbitkan.');
        }

        return redirect()->route('admin.posts.index');
    }
}
