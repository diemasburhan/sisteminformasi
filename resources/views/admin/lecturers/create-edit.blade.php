@extends('layouts.admin')

@section('title', isset($lecturer) ? 'Edit Dosen - Admin LPKIA' : 'Tambah Dosen Baru - Admin LPKIA')
@section('page_title', isset($lecturer) ? 'Edit Data Dosen' : 'Tambah Dosen Baru')

@section('content')

    <div style="max-width: 600px; margin: 0 auto;">
        <div class="editor-main-area" style="min-height: auto;">
            <form action="{{ isset($lecturer) ? route('admin.lecturers.update', $lecturer->id) : route('admin.lecturers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($lecturer))
                    @method('PUT')
                @endif

                <!-- Nama Dosen -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="name" style="font-weight: 700; color: var(--primary-dark); display: block; margin-bottom: 8px;">Nama Lengkap & Gelar</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Dr. Ahmad Sudrajat, M.T." value="{{ old('name', $lecturer->name ?? '') }}" required style="width: 100%; height: 42px;">
                    @error('name')
                        <span style="color: var(--danger); font-size: 0.8rem; font-weight: 600; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Bidang Keahlian -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="expertise" style="font-weight: 700; color: var(--primary-dark); display: block; margin-bottom: 8px;">Bidang Keahlian (Expertise)</label>
                    <select name="expertise" id="expertise" class="form-control" required style="width: 100%; height: 42px; padding: 6px 12px; font-size: 0.9rem;">
                        <option value="">Pilih Bidang Keahlian...</option>
                        <option value="data" {{ old('expertise', $lecturer->expertise ?? '') === 'data' ? 'selected' : '' }}>Data Science & Analytics</option>
                        <option value="dev" {{ old('expertise', $lecturer->expertise ?? '') === 'dev' ? 'selected' : '' }}>Software Engineering</option>
                        <option value="gov" {{ old('expertise', $lecturer->expertise ?? '') === 'gov' ? 'selected' : '' }}>IT Governance</option>
                    </select>
                    @error('expertise')
                        <span style="color: var(--danger); font-size: 0.8rem; font-weight: 600; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Upload Foto -->
                <div class="form-group" style="margin-bottom: 30px;">
                    <label style="font-weight: 700; color: var(--primary-dark); display: block; margin-bottom: 8px;">Foto Profil</label>
                    
                    @if(isset($lecturer) && $lecturer->photo)
                        <div style="margin-bottom: 15px;">
                            <img src="{{ asset($lecturer->photo) }}" alt="{{ $lecturer->name }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color);">
                            <p style="font-size: 0.8rem; color: var(--text-light); margin-top: 2px;">Foto saat ini</p>
                        </div>
                    @endif

                    <div class="image-upload-box" id="uploadBox">
                        <i class="fa-solid fa-cloud-arrow-up image-upload-icon"></i>
                        <div class="image-upload-text">Klik untuk memilih berkas gambar (PNG, JPG, max 2MB)</div>
                        <input type="file" name="photo_file" id="photoFile" style="position: absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;" accept="image/*">
                    </div>
                    <div id="fileFeedback" style="font-size: 0.82rem; color: var(--success); font-weight: 600; margin-top: 8px; display: none;"></div>
                    @error('photo_file')
                        <span style="color: var(--danger); font-size: 0.8rem; font-weight: 600; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 10px; justify-content: flex-end; border-top: 1px solid var(--border-color); padding-top: 20px;">
                    <a href="{{ route('admin.lecturers.index') }}" class="btn btn-outline" style="height: 40px; line-height: 24px;">Batal</a>
                    <button type="submit" class="btn btn-primary" style="height: 40px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    const photoInput = document.getElementById('photoFile');
    const uploadBox = document.getElementById('uploadBox');
    const feedback = document.getElementById('fileFeedback');

    photoInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            feedback.innerText = `Terpilih: ${file.name} (${(file.size/1024/1024).toFixed(2)} MB)`;
            feedback.style.display = 'block';
            uploadBox.style.borderColor = 'var(--success)';
            uploadBox.style.backgroundColor = 'rgba(16, 185, 129, 0.02)';
        }
    });

    // Drag and Drop enhancements
    uploadBox.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadBox.classList.add('dragover');
    });
    uploadBox.addEventListener('dragleave', () => {
        uploadBox.classList.remove('dragover');
    });
    uploadBox.addEventListener('drop', () => {
        uploadBox.classList.remove('dragover');
    });
</script>
@endsection
