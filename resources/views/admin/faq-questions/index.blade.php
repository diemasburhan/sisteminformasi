@extends('layouts.admin')

@section('title', 'Pertanyaan FAQ - Admin LPKIA')
@section('page_title', 'Pertanyaan FAQ Pengunjung')

@section('content')

    <!-- Quick Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
        <div style="background: white; border-radius: 12px; padding: 18px; border: 1px solid var(--border-color, #e2e8f0); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Total Pertanyaan</div>
                <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin-top: 4px;">{{ $stats['total'] }}</div>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                <i class="fa-solid fa-comments"></i>
            </div>
        </div>

        <div style="background: white; border-radius: 12px; padding: 18px; border: 1px solid var(--border-color, #e2e8f0); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Status Baru</div>
                <div style="font-size: 1.6rem; font-weight: 800; color: #ef4444; margin-top: 4px;">{{ $stats['baru'] }}</div>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                <i class="fa-solid fa-bell"></i>
            </div>
        </div>

        <div style="background: white; border-radius: 12px; padding: 18px; border: 1px solid var(--border-color, #e2e8f0); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Sedang Diproses</div>
                <div style="font-size: 1.6rem; font-weight: 800; color: #f59e0b; margin-top: 4px;">{{ $stats['diproses'] }}</div>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #fffbeb; color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                <i class="fa-solid fa-spinner"></i>
            </div>
        </div>

        <div style="background: white; border-radius: 12px; padding: 18px; border: 1px solid var(--border-color, #e2e8f0); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Selesai</div>
                <div style="font-size: 1.6rem; font-weight: 800; color: #10b981; margin-top: 4px;">{{ $stats['selesai'] }}</div>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                <i class="fa-solid fa-check-double"></i>
            </div>
        </div>
    </div>

    <!-- Table Card containing Lists and Filters -->
    <div class="table-card">
        
        <!-- Toolbar with search and filters -->
        <div class="table-toolbar" style="flex-wrap: wrap; gap: 12px;">
            <form action="{{ route('admin.faq-questions.index') }}" method="GET" class="table-filters" style="display: flex; flex-wrap: wrap; gap: 10px; width: 100%;">
                
                <input type="text" name="search" class="form-control" placeholder="Cari nama, NIM, WA, atau pertanyaan..." value="{{ request('search') }}" style="flex: 1; min-width: 220px; height: 38px;">
                
                <select name="visitor_type" class="form-control" style="width: 170px; height: 38px;" onchange="this.form.submit()">
                    <option value="">Semua Pengunjung</option>
                    <option value="MAHASISWA_AKTIF" {{ request('visitor_type') === 'MAHASISWA_AKTIF' ? 'selected' : '' }}>Mahasiswa Aktif</option>
                    <option value="CALON_MAHASISWA" {{ request('visitor_type') === 'CALON_MAHASISWA' ? 'selected' : '' }}>Ingin Mendaftar</option>
                </select>

                <select name="status" class="form-control" style="width: 140px; height: 38px;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Baru" {{ request('status') === 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>

                <select name="level" class="form-control" style="width: 130px; height: 38px;" onchange="this.form.submit()">
                    <option value="">Semua Tingkat</option>
                    <option value="1" {{ request('level') === '1' ? 'selected' : '' }}>Tingkat 1</option>
                    <option value="2" {{ request('level') === '2' ? 'selected' : '' }}>Tingkat 2</option>
                    <option value="3" {{ request('level') === '3' ? 'selected' : '' }}>Tingkat 3</option>
                    <option value="4" {{ request('level') === '4' ? 'selected' : '' }}>Tingkat 4</option>
                </select>

                @if(request('search') || request('visitor_type') || request('status') || request('level'))
                    <a href="{{ route('admin.faq-questions.index') }}" class="btn btn-outline btn-sm" style="height: 38px; display: inline-flex; align-items: center;" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
            {{-- EXPORT EXCEL --}}
        <a href="{{ route('admin.faq-questions.export') }}"
           style="
                display:inline-flex;
                align-items:center;
                justify-content:center;
                gap:8px;
                padding:10px 16px;
                background:#16a34a;
                color:#fff;
                border-radius:8px;
                text-decoration:none;
                font-weight:600;
                font-size:14px;
                white-space:nowrap;
                height:38px;
                box-sizing:border-box;
           ">
            <i class="fa-solid fa-file-excel"></i>
            Export Excel
        </a>

        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 150px;">Status Pengunjung</th>
                        <th style="width: 200px;">Identitas</th>
                        <th style="width: 80px; text-align: center;">Tingkat</th>
                        <th>Pertanyaan</th>
                        <th style="width: 110px; text-align: center;">Status</th>
                        <th style="width: 140px;">Waktu</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $q)
                        <tr style="{{ $q->status === 'Baru' ? 'background-color: #fff9f9;' : '' }}">
                            <td>
                                @if($q->visitor_type === 'MAHASISWA_AKTIF')
                                    <span style="display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;">
                                        <i class="fa-solid fa-user-graduate"></i> Mahasiswa Aktif
                                    </span>
                                @else
                                    <span style="display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff;">
                                        <i class="fa-solid fa-id-card"></i> Ingin Mendaftar
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;">{{ $q->name }}</div>
                                @if($q->visitor_type === 'MAHASISWA_AKTIF')
                                    <div style="font-size: 0.8rem; color: #64748b; font-family: monospace;">NIM: {{ $q->nim }}</div>
                                @else
                                    <div style="font-size: 0.8rem; color: #059669;">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $q->whatsapp) }}" target="_blank" style="color: #059669; text-decoration: none;" title="Chat via WhatsApp">
                                            <i class="fa-brands fa-whatsapp"></i> {{ $q->whatsapp }}
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if($q->level)
                                    <span style="font-weight: 600; color: #334155;">Tingkat {{ $q->level }}</span>
                                @else
                                    <span style="color: #cbd5e1;">-</span>
                                @endif
                            </td>
                            <td>
                                <div style="color: #1e293b; font-size: 0.88rem; max-width: 380px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $q->question }}
                                </div>
                                @if($q->admin_notes)
                                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px; font-style: italic;">
                                        <i class="fa-solid fa-note-sticky"></i> {{ \Illuminate\Support\Str::limit($q->admin_notes, 50) }}
                                    </div>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if($q->status === 'Baru')
                                    <span style="display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 0.72rem; font-weight: 700; background: #fee2e2; color: #dc2626;">Baru</span>
                                @elseif($q->status === 'Diproses')
                                    <span style="display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 0.72rem; font-weight: 700; background: #fef3c7; color: #d97706;">Diproses</span>
                                @else
                                    <span style="display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 0.72rem; font-weight: 700; background: #d1fae5; color: #059669;">Selesai</span>
                                @endif
                            </td>
                            <td style="font-size: 0.8rem; color: #64748b;">
                                {{ $q->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="openDetailModal({{ json_encode($q) }})" title="Lihat Detail & Tindak Lanjut" style="padding: 4px 8px; font-size: 0.8rem;">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>
                                    
                                    <form action="{{ route('admin.faq-questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus Pertanyaan" style="padding: 4px 8px; font-size: 0.8rem; background: #ef4444; border-color: #ef4444; color: white;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fa-solid fa-inbox fa-3x" style="margin-bottom: 12px; display: block; opacity: 0.5;"></i>
                                Belum ada pertanyaan yang masuk dari pengunjung FAQ MinSI.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($questions->hasPages())
            <div style="padding: 15px 20px; border-top: 1px solid var(--border-color, #e2e8f0);">
                {{ $questions->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Detail Pertanyaan -->
    <div id="faqDetailModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 99999; backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
        <div style="background: white; width: 100%; max-width: 600px; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); animation: fadeIn 0.2s ease;">
            
            <div style="padding: 20px 24px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span id="modalVisitorBadge"></span>
                    <h3 style="margin: 0; font-size: 1.15rem; color: #0f172a;" id="modalSenderName">Detail Pertanyaan</h3>
                </div>
                <button type="button" onclick="closeDetailModal()" style="background: none; border: none; font-size: 1.3rem; color: #94a3b8; cursor: pointer;">&times;</button>
            </div>

            <div style="padding: 24px; max-height: 75vh; overflow-y: auto;">
                
                <!-- Identitas Pengirim Box -->
                <div style="background: #f1f5f9; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 0.88rem;">
                        <div>
                            <span style="color: #64748b; font-size: 0.78rem; text-transform: uppercase; font-weight: 600; display: block;">Status Pengunjung:</span>
                            <strong id="modalVisitorType" style="color: #1e293b;">-</strong>
                        </div>
                        <div>
                            <span style="color: #64748b; font-size: 0.78rem; text-transform: uppercase; font-weight: 600; display: block;">Waktu Pengiriman:</span>
                            <span id="modalCreatedAt" style="color: #1e293b; font-weight: 500;">-</span>
                        </div>
                        <div id="modalNimContainer" style="display: none;">
                            <span style="color: #64748b; font-size: 0.78rem; text-transform: uppercase; font-weight: 600; display: block;">NIM Mahasiswa:</span>
                            <strong id="modalNim" style="color: #1e293b; font-family: monospace;">-</strong>
                        </div>
                        <div id="modalLevelContainer" style="display: none;">
                            <span style="color: #64748b; font-size: 0.78rem; text-transform: uppercase; font-weight: 600; display: block;">Tingkat Perkuliahan:</span>
                            <strong id="modalLevel" style="color: #1e293b;">-</strong>
                        </div>
                        <div id="modalWaContainer" style="display: none; grid-column: span 2;">
                            <span style="color: #64748b; font-size: 0.78rem; text-transform: uppercase; font-weight: 600; display: block;">Nomor WhatsApp:</span>
                            <a id="modalWaLink" href="#" target="_blank" style="color: #059669; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; margin-top: 2px;">
                                <i class="fa-brands fa-whatsapp fa-lg"></i> <span id="modalWhatsapp">-</span> (Klik untuk chat langsung)
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Isi Pertanyaan -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 700; color: #0f172a; margin-bottom: 8px; font-size: 0.9rem;">
                        <i class="fa-solid fa-circle-question" style="color: #2563eb;"></i> Isi Pertanyaan:
                    </label>
                    <div id="modalQuestionText" style="background: white; border: 1px solid #cbd5e1; border-radius: 10px; padding: 16px; font-size: 0.92rem; color: #1e293b; line-height: 1.6; white-space: pre-wrap;">
                        -
                    </div>
                </div>

                <!-- Form Update Status & Catatan -->
                <form id="modalUpdateForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    
                    <div style="margin-bottom: 16px;">
                        <label for="modalStatusSelect" style="display: block; font-weight: 700; color: #0f172a; margin-bottom: 6px; font-size: 0.88rem;">Ubah Status Pertanyaan:</label>
                        <select name="status" id="modalStatusSelect" class="form-control" style="width: 100%; height: 42px; border-radius: 8px;">
                            <option value="Baru">🔴 Baru</option>
                            <option value="Diproses">🟡 Diproses (Sedang ditindaklanjuti)</option>
                            <option value="Selesai">🟢 Selesai (Sudah dijawab / ditangani)</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="modalAdminNotes" style="display: block; font-weight: 700; color: #0f172a; margin-bottom: 6px; font-size: 0.88rem;">Catatan Tindak Lanjut Admin:</label>
                        <textarea name="admin_notes" id="modalAdminNotes" rows="3" class="form-control" placeholder="Tuliskan catatan internal, misal: 'Sudah dihubungi via WA tgl 5/10'..." style="width: 100%; border-radius: 8px; padding: 10px; font-size: 0.88rem;"></textarea>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" onclick="closeDetailModal()" class="btn btn-outline" style="padding: 8px 16px;">Tutup</button>
                        <button type="submit" class="btn btn-primary" style="padding: 8px 20px; font-weight: 600;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openDetailModal(item) {
        document.getElementById('modalSenderName').textContent = item.name;
        document.getElementById('modalQuestionText').textContent = item.question;
        document.getElementById('modalCreatedAt').textContent = new Date(item.created_at).toLocaleString('id-ID');
        document.getElementById('modalStatusSelect').value = item.status;
        document.getElementById('modalAdminNotes').value = item.admin_notes || '';

        // Action URL
        document.getElementById('modalUpdateForm').action = "/admin/faq-questions/" + item.id;

        // Visitor Type Badge & Details
        const badge = document.getElementById('modalVisitorBadge');
        const vType = document.getElementById('modalVisitorType');
        const nimBox = document.getElementById('modalNimContainer');
        const levelBox = document.getElementById('modalLevelContainer');
        const waBox = document.getElementById('modalWaContainer');

        if (item.visitor_type === 'MAHASISWA_AKTIF') {
            badge.innerHTML = '<span style="padding: 3px 8px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; background: #eff6ff; color: #2563eb;">MAHASISWA</span>';
            vType.textContent = 'Mahasiswa Aktif';
            
            nimBox.style.display = 'block';
            document.getElementById('modalNim').textContent = item.nim;

            levelBox.style.display = 'block';
            document.getElementById('modalLevel').textContent = 'Tingkat ' + (item.level || '-');

            waBox.style.display = 'none';
        } else {
            badge.innerHTML = '<span style="padding: 3px 8px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; background: #faf5ff; color: #7e22ce;">CALON MAHASISWA</span>';
            vType.textContent = 'Ingin Mendaftar (Calon Mahasiswa)';

            nimBox.style.display = 'none';
            levelBox.style.display = 'none';

            waBox.style.display = 'block';
            const cleanWa = (item.whatsapp || '').replace(/[^0-9]/g, '');
            document.getElementById('modalWhatsapp').textContent = item.whatsapp;
            document.getElementById('modalWaLink').href = 'https://wa.me/' + cleanWa;
        }

        const modal = document.getElementById('faqDetailModal');
        modal.style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('faqDetailModal').style.display = 'none';
    }

    // Close on click outside
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('faqDetailModal');
        if (e.target === modal) {
            closeDetailModal();
        }
    });
</script>
@endsection
