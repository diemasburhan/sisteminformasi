@extends('layouts.admin')

@section('title', 'Manajemen Bidang Keahlian - Admin LPKIA')
@section('page_title', 'Bidang Keahlian (Expertise) Dosen')

@section('content')

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; align-items: start;">
        
        <!-- Left: List of Expertises -->
        <div class="table-card" style="margin-bottom: 0;">
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nama Keahlian</th>
                            <th>Kategori Filter (Beranda)</th>
                            <th style="width: 120px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expertises as $exp)
                            <tr>
                                <td style="font-weight: 600; color: var(--text-dark);">
                                    {{ $exp->name }}
                                </td>
                                <td>
                                    @if($exp->category === 'dev')
                                        <span class="badge" style="background-color: #DBEAFE; color: #1E40AF;"><i class="fa-solid fa-code"></i> Software Engineering (dev)</span>
                                    @elseif($exp->category === 'data')
                                        <span class="badge" style="background-color: #D1FAE5; color: #065F46;"><i class="fa-solid fa-chart-line"></i> Data Science (data)</span>
                                    @elseif($exp->category === 'gov')
                                        <span class="badge" style="background-color: #F5E6FF; color: #7C3AED;"><i class="fa-solid fa-shield-halved"></i> IT Governance (gov)</span>
                                    @else
                                        <span class="badge" style="background-color: #F3F4F6; color: #374151;"><i class="fa-solid fa-tags"></i> Lainnya (other)</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <div class="table-actions" style="justify-content: center;">
                                        <a href="{{ route('admin.expertises.index', ['edit' => $exp->id]) }}" class="action-link" title="Edit Keahlian" style="color: var(--primary);">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.expertises.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus keahlian ini? Dosen yang memiliki keahlian ini tidak akan lagi memilikinya.')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" class="action-link delete" title="Hapus Keahlian">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                    Belum ada data bidang keahlian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Add or Edit Form -->
        <div class="editor-main-area" style="min-height: auto; padding: 25px; border-radius: var(--border-radius-lg); border: 1px solid var(--border-color); background-color: var(--bg-white); box-shadow: var(--shadow-sm);">
            <h3 style="font-size: 1.25rem; color: var(--primary-dark); margin-bottom: 20px; font-weight: 700;">
                {{ $editingExpertise ? 'Edit Bidang Keahlian' : 'Tambah Keahlian Baru' }}
            </h3>

            <form action="{{ $editingExpertise ? route('admin.expertises.update', $editingExpertise->id) : route('admin.expertises.store') }}" method="POST">
                @csrf
                @if($editingExpertise)
                    @method('PUT')
                @endif

                <!-- Nama Keahlian -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="name" style="font-weight: 700; color: var(--primary-dark); display: block; margin-bottom: 8px;">Nama Keahlian</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Machine Learning" value="{{ old('name', $editingExpertise->name ?? '') }}" required style="width: 100%; height: 42px;">
                    @error('name')
                        <span style="color: var(--danger); font-size: 0.8rem; font-weight: 600; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kategori Beranda -->
                <div class="form-group" style="margin-bottom: 25px;">
                    <label for="category" style="font-weight: 700; color: var(--primary-dark); display: block; margin-bottom: 8px;">Kategori Filter Beranda</label>
                    <select name="category" id="category" class="form-control" required style="width: 100%; height: 42px; padding: 6px 12px;">
                        <option value="dev" {{ (old('category', $editingExpertise->category ?? '') === 'dev') ? 'selected' : '' }}>Software Engineering (dev)</option>
                        <option value="data" {{ (old('category', $editingExpertise->category ?? '') === 'data') ? 'selected' : '' }}>Data Science & Analytics (data)</option>
                        <option value="gov" {{ (old('category', $editingExpertise->category ?? '') === 'gov') ? 'selected' : '' }}>IT Governance (gov)</option>
                        <option value="other" {{ (old('category', $editingExpertise->category ?? '') === 'other') ? 'selected' : '' }}>Lainnya / Sembunyikan dari tab khusus (other)</option>
                    </select>
                    <p style="font-size: 0.78rem; color: var(--text-light); margin-top: 5px; line-height: 1.4;">
                        Menentukan di tab mana bidang keahlian ini akan dikelompokkan pada filter dosen halaman utama.
                    </p>
                    @error('category')
                        <span style="color: var(--danger); font-size: 0.8rem; font-weight: 600; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 10px; justify-content: flex-end; border-top: 1px solid var(--border-color); padding-top: 20px;">
                    @if($editingExpertise)
                        <a href="{{ route('admin.expertises.index') }}" class="btn btn-outline" style="height: 40px; line-height: 24px;">Batal</a>
                    @endif
                    <button type="submit" class="btn btn-primary" style="height: 40px;">
                        {{ $editingExpertise ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>

    </div>

@endsection
