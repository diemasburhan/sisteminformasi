@extends('layouts.admin')

@section('title', 'SI Galeri')
@section('page_title', 'SI Galeri')

@section('content')

<div class="admin-page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <div>
        <h2 style="margin:0;">SI Galeri</h2>
        <p style="margin:5px 0 0; color:#777;">
            Kelola foto dan konten SI Galeri.
        </p>
    </div>

    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i>
        Tambah Foto
    </a>
</div>

<div class="admin-card">
    <div style="padding:20px;">
        @if(isset($galleries) && $galleries->count())

            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr)); gap:20px;">

                @foreach($galleries as $gallery)

                    <div style="border:1px solid #ddd; border-radius:12px; overflow:hidden; background:white;">

                        @if($gallery->image)
                            <img
                                src="{{ asset($gallery->image) }}"
                                alt="{{ $gallery->title }}"
                                style="width:100%; height:180px; object-fit:cover;"
                            >
                        @else
                            <div style="height:180px; display:flex; align-items:center; justify-content:center; background:#f1f1f1;">
                                <i class="fa-solid fa-image fa-2x"></i>
                            </div>
                        @endif

                        <div style="padding:15px;">
                            <h3 style="margin:0 0 8px;">
                                {{ $gallery->title }}
                            </h3>

                            <p style="font-size:14px; color:#777;">
                                {{ $gallery->category ?? 'Tanpa kategori' }}
                            </p>

                            <div style="display:flex; gap:8px; margin-top:15px;">

                                <a href="{{ route('admin.galleries.edit', $gallery->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-pen"></i>
                                    Edit
                                </a>

                                <form action="{{ route('admin.galleries.destroy', $gallery->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div style="text-align:center; padding:60px 20px;">
                <i class="fa-solid fa-images fa-3x"
                   style="color:#bbb; margin-bottom:15px;"></i>

                <h3>Belum ada foto</h3>

                <p style="color:#777;">
                    Belum ada konten yang ditambahkan ke SI Galeri.
                </p>

                <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Foto Pertama
                </a>
            </div>

        @endif
    </div>
</div>

@endsection