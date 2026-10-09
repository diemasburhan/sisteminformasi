@extends('layouts.admin')

@section('content')

<div class="content-header">
    <h1>Tambah Foto SI Galeri</h1>
</div>

<div class="content">

    <div class="card">

        <div class="card-header">
            <h3>Tambah Foto</h3>
        </div>

        <div class="card-body">

            {{-- Error Validation --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- Form --}}
            <form
                action="{{ route('admin.galleries.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                {{-- Judul --}}
                <div class="form-group">
                    <label for="title">Judul Foto</label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="{{ old('title') }}"
                        placeholder="Masukkan judul foto"
                        required
                    >
                </div>


                {{-- Deskripsi --}}
                <div class="form-group">
                    <label for="description">Deskripsi</label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="4"
                        placeholder="Masukkan deskripsi foto"
                    >{{ old('description') }}</textarea>
                </div>


                {{-- Kategori --}}
                <div class="form-group">
                    <label for="category">Kategori</label>

                    <select
                        name="category"
                        id="category"
                        class="form-control"
                        required
                    >
                        <option value="">-- Pilih Kategori --</option>

                        <option
                            value="Kegiatan SI"
                            {{ old('category') == 'Kegiatan SI' ? 'selected' : '' }}
                        >
                            Kegiatan SI
                        </option>

                        <option
                            value="HIMA SI"
                            {{ old('category') == 'HIMA SI' ? 'selected' : '' }}
                        >
                            HIMA SI
                        </option>

                        <option
                            value="Kampus"
                            {{ old('category') == 'Kampus' ? 'selected' : '' }}
                        >
                            Kampus
                        </option>

                        <option
                            value="Santai"
                            {{ old('category') == 'Santai' ? 'selected' : '' }}
                        >
                            Santai
                        </option>

                        <option
                            value="Cerita Mahasiswa"
                            {{ old('category') == 'Cerita Mahasiswa' ? 'selected' : '' }}
                        >
                            Cerita Mahasiswa
                        </option>
                    </select>
                </div>


                {{-- Status --}}
                <div class="form-group">
                    <label for="status">Status</label>

                    <select
                        name="status"
                        id="status"
                        class="form-control"
                        required
                    >
                        <option value="">-- Pilih Status --</option>

                        <option
                            value="published"
                            {{ old('status') == 'published' ? 'selected' : '' }}
                        >
                            Published
                        </option>

                        <option
                            value="draft"
                            {{ old('status') == 'draft' ? 'selected' : '' }}
                        >
                            Draft
                        </option>
                    </select>
                </div>


                {{-- Foto --}}
                <div class="form-group">
                    <label for="image">Foto</label>

                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="form-control"
                        accept="image/jpeg,image/png,image/jpg,image/gif"
                        required
                    >

                    <small style="color:#777;">
                        Format: JPG, JPEG, PNG, GIF.
                    </small>
                </div>


                {{-- Tombol --}}
                <div style="margin-top:20px;">

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
                        <i class="fa-solid fa-upload"></i>
                        Simpan Foto
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection