<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pages = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create-edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:draft,published,scheduled',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slug = Str::slug($request->title);
        $count = Page::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pages'), $filename);
            $imagePath = 'uploads/pages/' . $filename;
        }

        $page = Page::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'featured_image' => $imagePath,
            'status' => $request->status,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Create Page',
            'details' => 'Created static page: "' . $page->title . '" (ID: ' . $page->id . ')'
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dibuat.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.create-edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:draft,published,scheduled',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $page->featured_image;
        if ($request->hasFile('featured_image')) {
            if ($page->featured_image && file_exists(public_path($page->featured_image))) {
                @unlink(public_path($page->featured_image));
            }

            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pages'), $filename);
            $imagePath = 'uploads/pages/' . $filename;
        }

        $slug = $page->slug;
        if ($page->title !== $request->title) {
            $slug = Str::slug($request->title);
            $count = Page::where('slug', 'like', $slug . '%')->where('id', '!=', $page->id)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
        }

        $page->update([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'featured_image' => $imagePath,
            'status' => $request->status,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Update Page',
            'details' => 'Updated static page: "' . $page->title . '" (ID: ' . $page->id . ')'
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);

        if ($page->featured_image && file_exists(public_path($page->featured_image))) {
            @unlink(public_path($page->featured_image));
        }

        $title = $page->title;
        $page->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Delete Page',
            'details' => 'Deleted static page: "' . $title . '"'
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }

    // Auto-save endpoint via AJAX for Pages
    public function autoSave(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
        ]);

        $id = $request->id;

        if ($id) {
            $page = Page::findOrFail($id);
            $page->update([
                'title' => $request->title,
                'content' => $request->content,
                'status' => $request->status,
            ]);
        } else {
            $slug = Str::slug($request->title);
            $count = Page::where('slug', 'like', $slug . '%')->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            $page = Page::create([
                'title' => $request->title,
                'slug' => $slug,
                'content' => $request->content,
                'status' => 'draft',
            ]);
            $id = $page->id;
        }

        return response()->json([
            'success' => true,
            'id' => $id,
            'message' => 'Draf halaman berhasil disimpan secara otomatis pada ' . date('H:i:s')
        ]);
    }

    // Bulk actions for Pages
    public function bulkAction(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if (empty($ids) || !is_array($ids)) {
            return redirect()->route('admin.pages.index')->with('error', 'Pilih halaman terlebih dahulu.');
        }

        if ($action === 'delete') {
            $pages = Page::whereIn('id', $ids)->get();
            foreach ($pages as $page) {
                if ($page->featured_image && file_exists(public_path($page->featured_image))) {
                    @unlink(public_path($page->featured_image));
                }
                $page->delete();
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => 'Bulk Delete Pages',
                'details' => 'Deleted ' . count($ids) . ' static pages'
            ]);

            return redirect()->route('admin.pages.index')->with('success', count($ids) . ' halaman berhasil dihapus.');
        } elseif ($action === 'publish') {
            Page::whereIn('id', $ids)->update([
                'status' => 'published',
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => 'Bulk Publish Pages',
                'details' => 'Published ' . count($ids) . ' static pages'
            ]);

            return redirect()->route('admin.pages.index')->with('success', count($ids) . ' halaman berhasil diterbitkan.');
        }

        return redirect()->route('admin.pages.index');
    }
}
