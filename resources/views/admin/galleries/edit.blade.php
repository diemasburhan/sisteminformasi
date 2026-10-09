@extends('layouts.admin')

@section('content')

<div class="content-header">
    <h1>Edit SI Galeri</h1>
</div>

<div class="content">

    <div class="card">

        <div class="card-header">
            <h3>Edit Foto Galeri</h3>
        </div>

        <div class="card-body">

            {{-- Error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- Success --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


            <form
                action="{{ route('admin.galleries.update', $gallery->id) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')


                {{-- JUDUL --}}
                <div class="form-group">

                    <label for="title">
                        Judul Foto
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="{{ old('title', $gallery->title) }}"
                        required
                    >

                </div>


                {{-- DESKRIPSI --}}
                <div class="form-group">

                    <label for="description">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="5"
                    >{{ old('description', $gallery->description) }}</textarea>

                </div>


                {{-- KATEGORI --}}
                <div class="form-group">

                    <label for="category">
                        Kategori
                    </label>

                    <select
                        name="category"
                        id="category"
                        class="form-control"
                        required
                    >

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        <option
                            value="Kegiatan SI"
                            {{ old('category', $gallery->category) == 'Kegiatan SI' ? 'selected' : '' }}
                        >
                            Kegiatan SI
                        </option>

                        <option
                            value="HIMA SI"
                            {{ old('category', $gallery->category) == 'HIMA SI' ? 'selected' : '' }}
                        >
                            HIMA SI
                        </option>

                        <option
                            value="Kampus"
                            {{ old('category', $gallery->category) == 'Kampus' ? 'selected' : '' }}
                        >
                            Kampus
                        </option>

                        <option
                            value="Santai"
                            {{ old('category', $gallery->category) == 'Santai' ? 'selected' : '' }}
                        >
                            Santai
                        </option>

                        <option
                            value="Cerita Mahasiswa"
                            {{ old('category', $gallery->category) == 'Cerita Mahasiswa' ? 'selected' : '' }}
                        >
                            Cerita Mahasiswa
                        </option>

                    </select>

                </div>


                {{-- STATUS --}}
                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="form-control"
                        required
                    >

                        <option
                            value="published"
                            {{ old('status', $gallery->status) == 'published' ? 'selected' : '' }}
                        >
                            Published
                        </option>

                        <option
                            value="draft"
                            {{ old('status', $gallery->status) == 'draft' ? 'selected' : '' }}
                        >
                            Draft
                        </option>

                    </select>

                </div>


                {{-- FOTO SEKARANG --}}
                <div class="form-group">

                    <label>
                        Foto Saat Ini
                    </label>

                    @if ($gallery->image)

                        <div style="
                            margin-top:10px;
                            margin-bottom:20px;
                        ">

                            <img
                                src="{{ asset($gallery->image) }}"
                                alt="{{ $gallery->title }}"
                                style="
                                    width:300px;
                                    max-width:100%;
                                    height:200px;
                                    object-fit:cover;
                                    border-radius:10px;
                                    border:1px solid #ddd;
                                    display:block;
                                "
                            >

                        </div>

                    @else

                        <p style="color:#777;">
                            Tidak ada foto.
                        </p>

                    @endif

                </div>


                {{-- GANTI FOTO --}}
                <div class="form-group">

                    <label for="image">
                        Ganti Foto
                    </label>

                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="form-control"
                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                    >

                    <small style="color:#777;">
                        Kosongkan jika tidak ingin mengganti foto.
                    </small>

                </div>


                {{-- BUTTON --}}
                <div style="
                    margin-top:25px;
                    display:flex;
                    gap:10px;
                ">

                    <a
                        href="{{ route('admin.galleries.index') }}"
                        class="btn btn-secondary"
                    >
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fa-solid fa-save"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection