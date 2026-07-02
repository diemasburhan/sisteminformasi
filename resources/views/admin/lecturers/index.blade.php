@extends('layouts.admin')

@section('title', 'Manajemen Dosen - Admin LPKIA')
@section('page_title', 'Dosen Ahli & Pengajar')

@section('content')

    <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
        <a href="{{ route('admin.lecturers.create') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-plus"></i> Tambah Dosen Baru
        </a>
    </div>

    <div class="table-card">
        <div class="table-toolbar">
            <div></div> <!-- Spacer -->

            <!-- Search and Filter Form -->
            <form action="{{ route('admin.lecturers.index') }}" method="GET" class="table-filters">
                <input type="text" name="search" class="form-control table-search" placeholder="Cari nama dosen..." value="{{ request('search') }}" style="height: 38px;">
                
                <select name="expertise" class="form-control" style="width: 220px; height: 38px; padding: 6px 12px; font-size: 0.85rem;" onchange="this.form.submit()">
                    <option value="">Semua Bidang Keahlian</option>
                    <option value="data" {{ request('expertise') === 'data' ? 'selected' : '' }}>Data Science & Analytics</option>
                    <option value="dev" {{ request('expertise') === 'dev' ? 'selected' : '' }}>Software Engineering</option>
                    <option value="gov" {{ request('expertise') === 'gov' ? 'selected' : '' }}>IT Governance</option>
                </select>

                @if(request('search') || request('expertise'))
                    <a href="{{ route('admin.lecturers.index') }}" class="btn btn-outline btn-sm" style="height: 38px;" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px; text-align: center;">Foto</th>
                        <th>Nama Dosen</th>
                        <th>Keahlian</th>
                        <th>Tanggal Terdaftar</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lecturers as $lecturer)
                        <tr>
                            <td style="text-align: center;">
                                @if($lecturer->photo)
                                    <img src="{{ asset($lecturer->photo) }}" alt="{{ $lecturer->name }}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 1px solid var(--border-color);">
                                @else
                                    <div style="width: 48px; height: 48px; border-radius: 50%; background-color: #E2E8F0; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: var(--text-light);">
                                        <i class="fa-solid fa-user-circle fa-2x"></i>
                                    </div>
                                @endif
                            </td>
                            <td style="font-weight: 600;">
                                <a href="{{ route('admin.lecturers.edit', $lecturer->id) }}" style="color: var(--primary);">
                                    {{ $lecturer->name }}
                                </a>
                            </td>
                            <td>
                                @if($lecturer->expertise === 'data')
                                    <span class="badge" style="background-color: #D1FAE5; color: #065F46;"><i class="fa-solid fa-chart-line"></i> Data Science & Analytics</span>
                                @elseif($lecturer->expertise === 'dev')
                                    <span class="badge" style="background-color: #DBEAFE; color: #1E40AF;"><i class="fa-solid fa-code"></i> Software Engineering</span>
                                @else
                                    <span class="badge" style="background-color: #F5E6FF; color: #7C3AED;"><i class="fa-solid fa-shield-halved"></i> IT Governance</span>
                                @endif
                            </td>
                            <td style="font-size: 0.82rem; color: var(--text-muted);">
                                {{ $lecturer->created_at->format('d M Y') }}
                            </td>
                            <td style="text-align: center;">
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ route('admin.lecturers.edit', $lecturer->id) }}" class="action-link" title="Edit Dosen">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.lecturers.destroy', $lecturer->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dosen ini?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" class="action-link delete" title="Hapus Dosen">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                Belum ada data dosen terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($lecturers->hasPages())
            <div style="padding: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
                {{ $lecturers->links() }}
            </div>
        @endif
    </div>

@endsection
