<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Menampilkan semua galeri
     */
    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);

        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Form tambah galeri
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Simpan galeri baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'required|in:Kegiatan SI,HIMA SI,Kampus,Santai,Cerita Mahasiswa',
            'status' => 'required|in:draft,published',
        ]);

        // Buat slug
        $slug = Str::slug($request->title);

        $count = Gallery::where('slug', 'like', $slug . '%')->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        // Upload gambar
        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/gallery'),
                $filename
            );

            $imagePath = 'uploads/gallery/' . $filename;
        }

        // Simpan ke database
        $gallery = Gallery::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
            'category' => $request->category,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        // Catat aktivitas admin
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Create Gallery',
            'details' => 'Created gallery: "' . $gallery->title . '" (ID: ' . $gallery->id . ')'
        ]);

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    /**
     * Form edit galeri
     */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);

        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update galeri
     */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'required|in:Kegiatan SI,HIMA SI,Kampus,Santai,Cerita Mahasiswa',
            'status' => 'required|in:draft,published',
        ]);

        // Slug
        $slug = $gallery->slug;

        if ($gallery->title !== $request->title) {
            $slug = Str::slug($request->title);

            $count = Gallery::where('slug', 'like', $slug . '%')
                ->where('id', '!=', $gallery->id)
                ->count();

            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
        }

        // Pertahankan gambar lama
        $imagePath = $gallery->image;

        // Kalau upload gambar baru
        if ($request->hasFile('image')) {

            // Hapus gambar lama
            if (
                $gallery->image &&
                file_exists(public_path($gallery->image))
            ) {
                @unlink(public_path($gallery->image));
            }

            $file = $request->file('image');

            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/gallery'),
                $filename
            );

            $imagePath = 'uploads/gallery/' . $filename;
        }

        // Update database
        $gallery->update([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        // Catat aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Update Gallery',
            'details' => 'Updated gallery: "' . $gallery->title . '" (ID: ' . $gallery->id . ')'
        ]);

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * Hapus galeri
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // Hapus file gambar
        if (
            $gallery->image &&
            file_exists(public_path($gallery->image))
        ) {
            @unlink(public_path($gallery->image));
        }

        $title = $gallery->title;
        $galleryId = $gallery->id;

        $gallery->delete();

        // Catat aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Delete Gallery',
            'details' => 'Deleted gallery: "' . $title . '" (ID: ' . $galleryId . ')'
        ]);

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }
}