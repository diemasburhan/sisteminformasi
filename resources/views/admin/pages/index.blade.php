@extends('layouts.admin')

@section('title', 'Manajemen Halaman - Admin LPKIA')
@section('page_title', 'Semua Halaman Statis')

@section('content')

    <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
        <a href="{{ route('admin.pages.create') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-plus"></i> Buat Halaman Baru
        </a>
    </div>

    <!-- Table Card containing Lists, Filters, and Bulk Options -->
    <div class="table-card">
        
        <!-- Toolbar with search, filters and bulk actions form -->
        <div class="table-toolbar">
            
            <!-- Bulk actions Form -->
            <form action="{{ route('admin.pages.bulk') }}" method="POST" id="bulkForm" class="bulk-actions-form">
                @csrf
                <select name="action" class="form-control" style="width: 180px; height: 38px; padding: 6px 12px; font-size: 0.85rem;" required>
                    <option value="">Pilih Aksi Masal...</option>
                    <option value="publish">Terbitkan Halaman</option>
                    <option value="delete">Hapus Halaman</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm" style="height: 38px;">Terapkan</button>
            </form>

            <!-- Search and Filter Form -->
            <form action="{{ route('admin.pages.index') }}" method="GET" class="table-filters">
                <input type="text" name="search" class="form-control table-search" placeholder="Cari judul halaman..." value="{{ request('search') }}" style="height: 38px;">
                
                <select name="status" class="form-control" style="width: 140px; height: 38px; padding: 6px 12px; font-size: 0.85rem;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                </select>

                @if(request('search') || request('status'))
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline btn-sm" style="height: 38px;" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" style="cursor: pointer;">
                        </th>
                        <th>Judul Halaman</th>
                        <th>Tautan Slug</th>
                        <th>Tanggal Dibuat</th>
                        <th style="text-align: center;">Status</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" name="ids[]" value="{{ $page->id }}" form="bulkForm" class="page-checkbox" style="cursor: pointer;">
                            </td>
                            <td style="font-weight: 600;">
                                <a href="{{ route('admin.pages.edit', $page->id) }}" style="color: var(--primary); hover: underline;">
                                    {{ $page->title }}
                                </a>
                            </td>
                            <td style="font-size: 0.85rem; font-family: monospace;">
                                /page/{{ $page->slug }}
                            </td>
                            <td style="font-size: 0.82rem; color: var(--text-muted);">
                                {{ $page->created_at->format('d M Y H:i') }}
                            </td>
                            <td style="text-align: center;">
                                @if($page->status === 'published')
                                    <span class="badge badge-success"><i class="fa-solid fa-circle-check"></i> Published</span>
                                @elseif($page->status === 'draft')
                                    <span class="badge badge-warning"><i class="fa-solid fa-circle-pause"></i> Draft</span>
                                @else
                                    <span class="badge" style="background-color: #E0E7FF; color: #4338CA;"><i class="fa-solid fa-clock"></i> Scheduled</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="action-link" title="Edit Halaman">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman statis ini?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" class="action-link delete" title="Hapus Halaman">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                <i class="fa-solid fa-folder-open fa-2x" style="display: block; margin-bottom: 10px;"></i>
                                Tidak ada halaman statis ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginations rendering -->
        <div style="padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color);">
            <div style="font-size: 0.85rem; color: var(--text-muted);">
                Menampilkan {{ $pages->firstItem() ?? 0 }} - {{ $pages->lastItem() ?? 0 }} dari total {{ $pages->total() }} halaman.
            </div>
            <div class="pagination-links">
                {{ $pages->links() }}
            </div>
        </div>

    </div>

@endsection

@section('scripts')
<script>
    // Selection operations helper
    const selectAll = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.page-checkbox');
    const bulkForm = document.getElementById('bulkForm');

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
    });

    bulkForm.addEventListener('submit', function(e) {
        const checkedCount = document.querySelectorAll('.page-checkbox:checked').length;
        if (checkedCount === 0) {
            e.preventDefault();
            showToast('Harap pilih minimal satu halaman terlebih dahulu.', 'danger');
        }
    });
</script>
@endsection
