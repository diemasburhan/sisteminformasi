@extends('layouts.admin')

@section('title', 'Manajemen Struktur Organisasi - Admin LPKIA')
@section('page_title', 'Struktur Organisasi Program Studi')

@section('content')

    <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
        <a href="{{ route('admin.org-members.create') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-plus"></i> Tambah Anggota Baru
        </a>
    </div>

    <div class="table-card">
        <div class="table-toolbar">
            <div></div> <!-- Spacer -->

            <!-- Search Form -->
            <form action="{{ route('admin.org-members.index') }}" method="GET" class="table-filters">
                <input type="text" name="search" class="form-control table-search" placeholder="Cari nama atau jabatan..." value="{{ request('search') }}" style="height: 38px;">
                <button type="submit" class="btn btn-primary btn-sm" style="height: 38px;">Cari</button>

                @if(request('search'))
                    <a href="{{ route('admin.org-members.index') }}" class="btn btn-outline btn-sm" style="height: 38px;" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px; text-align: center;">Urutan</th>
                        <th style="width: 80px; text-align: center;">Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan / Peran</th>
                        <th>NIP</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: var(--text-muted);">
                                {{ $member->sort_order }}
                            </td>
                            <td style="text-align: center;">
                                @if($member->photo)
                                    <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 1px solid var(--border-color);">
                                @else
                                    <div style="width: 48px; height: 48px; border-radius: 50%; background-color: #E2E8F0; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: var(--text-light);">
                                        <i class="fa-solid fa-user-tie fa-2x"></i>
                                    </div>
                                @endif
                            </td>
                            <td style="font-weight: 600;">
                                <a href="{{ route('admin.org-members.edit', $member->id) }}" style="color: var(--primary);">
                                    {{ $member->name }}
                                </a>
                            </td>
                            <td>
                                <span class="badge" style="background-color: #F1F5F9; color: var(--text-dark); font-weight: 700;">
                                    {{ $member->role }}
                                </span>
                            </td>
                            <td style="font-family: monospace; font-size: 0.85rem;">
                                {{ $member->nip ?: '-' }}
                            </td>
                            <td style="text-align: center;">
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ route('admin.org-members.edit', $member->id) }}" class="action-link" title="Edit Anggota">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.org-members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota struktur ini?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" class="action-link delete" title="Hapus Anggota">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                Belum ada anggota struktur organisasi terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($members->hasPages())
            <div style="padding: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
                {{ $members->links() }}
            </div>
        @endif
    </div>

@endsection
