@extends('layouts.admin')

@section('title', isset($post) ? 'Edit Postingan - Admin LPKIA' : 'Tambah Postingan Baru - Admin LPKIA')
@section('page_title', isset($post) ? 'Edit Postingan' : 'Buat Postingan Baru')

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Styling overrides for Editor */
    .form-group.title-group {
        margin-bottom: 25px;
    }
    .form-control.title-input {
        font-size: 1.6rem;
        font-weight: 800;
        border: none;
        border-bottom: 2px solid var(--border-color);
        border-radius: 0;
        padding: 10px 0;
        color: var(--primary);
    }
    .form-control.title-input:focus {
        border-bottom-color: var(--secondary);
        box-shadow: none;
    }
</style>
@endsection

@section('content')

    <!-- Auto-save notification feedback indicator -->
    <div id="autosaveIndicator" style="display: none; font-size: 0.8rem; color: var(--success); font-weight: 600; margin-bottom: 15px; text-align: right;">
        <i class="fa-solid fa-spinner fa-spin"></i> Menyimpan draf secara otomatis...
    </div>

    <!-- Main Form -->
    <form action="{{ isset($post) ? route('admin.posts.update', $post->id) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" id="postEditorForm">
        @csrf
        @if(isset($post))
            @method('PUT')
        @endif
        
        <!-- Post ID for AJAX autosave -->
        <input type="hidden" name="post_id" id="postIdInput" value="{{ $post->id ?? '' }}">

        <div class="editor-layout">
            <!-- Left Panel: Main Workspace Area -->
            <div class="editor-main-area">
                <div class="form-group title-group">
                    <label class="form-label" style="font-size: 1rem; color: var(--primary);">Judul Konten</label>
                    <input type="text" name="title" id="postTitle" class="form-control title-input" placeholder="Masukkan Judul Postingan Menarik di Sini..." required value="{{ old('title', $post->title ?? '') }}">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-size: 0.9rem;">Konten Postingan</label>
                    <!-- Quill Container -->
                    <div id="quillEditor" style="height: 350px;">
                        {!! old('content', $post->content ?? '') !!}
                    </div>
                    <!-- Hidden Input to store HTML -->
                    <input type="hidden" name="content" id="postContentInput">
                </div>
            </div>

            <!-- Right Panel: Sidebar Properties Area -->
            <div class="editor-sidebar-area">
                
                <!-- Status & Publish Actions -->
                <div class="editor-sidebar-widget">
                    <div class="editor-widget-title">Penerbitan (Publish)</div>
                    
                    <div class="form-group">
                        <label class="form-label">Status Postingan</label>
                        <select name="status" id="postStatus" class="form-control" required onchange="toggleScheduledDate()">
                            <option value="draft" {{ (old('status', $post->status ?? '') === 'draft') ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ (old('status', $post->status ?? '') === 'published') ? 'selected' : '' }}>Published</option>
                            <option value="scheduled" {{ (old('status', $post->status ?? '') === 'scheduled') ? 'selected' : '' }}>Scheduled</option>
                        </select>
                    </div>

                    <!-- Scheduled Date -->
                    <div class="form-group" id="scheduledDateGroup" style="display: {{ (old('status', $post->status ?? '') === 'scheduled') ? 'block' : 'none' }};">
                        <label class="form-label">Tanggal Terbit Terjadwal</label>
                        <input type="datetime-local" name="published_at" id="publishedAt" class="form-control" value="{{ isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '' }}">
                    </div>

                    <!-- Is Slider Checkbox -->
                    <div class="form-group" style="margin-top: 15px; border-top: 1px solid var(--border-color); padding-top: 15px;">
                        <label style="display: flex; align-items: center; cursor: pointer; font-size: 0.95rem;">
                            <input type="checkbox" name="is_slider" value="1" {{ old('is_slider', $post->is_slider ?? false) ? 'checked' : '' }} style="margin-right: 10px; width: 18px; height: 18px;">
                            <strong>Tampilkan di Slider Utama</strong>
                        </label>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px;">Centang ini untuk menampilkan postingan ini di slider halaman utama (direkomendasikan memiliki Gambar Utama).</p>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Simpan Konten
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" id="btnLivePreview" style="width: 100%;">
                            <i class="fa-solid fa-eye"></i> Live Preview
                        </button>
                    </div>
                </div>

                <!-- Category selection -->
                <div class="editor-sidebar-widget">
                    <div class="editor-widget-title">Kategori</div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Pilih Kategori Postingan</label>
                        <select name="category_id" id="postCategoryId" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (old('category_id', $post->category_id ?? '') == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Featured Image Upload -->
                <div class="editor-sidebar-widget">
                    <div class="editor-widget-title">Gambar Utama (Featured Image)</div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <!-- Custom Drag & Drop Box -->
                        <div class="image-upload-box" id="imageDropZone" onclick="triggerFileInput()">
                            <i class="fa-solid fa-cloud-arrow-up image-upload-icon"></i>
                            <div class="image-upload-text">Klik atau seret file gambar ke sini (JPG, PNG, max 2MB)</div>
                            <input type="file" name="featured_image" id="featuredImageFile" style="display: none;" accept="image/*" onchange="previewImage(this)">
                            
                            @if(isset($post) && $post->featured_image)
                                <img src="{{ asset($post->featured_image) }}" class="image-upload-preview" id="imagePreviewElement">
                            @else
                                <img class="image-upload-preview" id="imagePreviewElement" style="display: none;">
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <!-- Side-out Live Preview Drawer Panel -->
    <div class="preview-backdrop" id="previewBackdrop"></div>
    <div class="preview-modal" id="previewDrawer">
        <div class="preview-header">
            <h3><i class="fa-solid fa-magnifying-glass-chart"></i> Live Preview Mode</h3>
            <button type="button" class="btn btn-sm btn-danger btn-icon" id="btnClosePreview">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="preview-body">
            <h2 id="previewTitle" style="font-size: 2.2rem; font-weight: 800; color: var(--primary); margin-bottom: 20px; line-height: 1.3;">Judul Postingan</h2>
            <div id="previewMetadata" style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
                <span><i class="fa-solid fa-folder"></i> <span id="previewCategoryText">Akademik</span></span> &nbsp;|&nbsp; 
                <span><i class="fa-solid fa-user-pen"></i> Oleh: Anda</span> &nbsp;|&nbsp; 
                <span><i class="fa-solid fa-clock"></i> Baru saja</span>
            </div>
            
            <div id="previewImageContainer" style="display: none; margin-bottom: 30px;">
                <img id="previewFeaturedImg" src="" style="width: 100%; max-height: 280px; object-fit: cover; border-radius: 8px;">
            </div>

            <div class="page-body-content" id="previewContentBody">
                <!-- Quill HTML rendered here -->
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Initialize Quill Editor
    const quill = new Quill('#quillEditor', {
        theme: 'snow',
        placeholder: 'Mulai ketik isi postingan berita LPKIA di sini...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'link'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['clean']
            ]
        }
    });

    // Handle form submit to map quill editor output to hidden input field
    const form = document.getElementById('postEditorForm');
    const contentInput = document.getElementById('postContentInput');

    form.addEventListener('submit', function() {
        contentInput.value = quill.root.innerHTML;
    });

    // Toggle Scheduled date display
    function toggleScheduledDate() {
        const status = document.getElementById('postStatus').value;
        const group = document.getElementById('scheduledDateGroup');
        if (status === 'scheduled') {
            group.style.display = 'block';
        } else {
            group.style.display = 'none';
        }
    }

    // Trigger Hidden Input File Click
    function triggerFileInput() {
        document.getElementById('featuredImageFile').click();
    }

    // Preview Uploaded Image
    function previewImage(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreviewElement');
                preview.src = e.target.result;
                preview.style.display = 'block';
                
                // Show in live preview image as well
                const livePreviewImg = document.getElementById('previewFeaturedImg');
                livePreviewImg.src = e.target.result;
                document.getElementById('previewImageContainer').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }

    // Setup Drag and Drop events
    const dropZone = document.getElementById('imageDropZone');
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
        }, false);
    });

    dropZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        const fileInput = document.getElementById('featuredImageFile');
        
        fileInput.files = files;
        previewImage(fileInput);
        showToast('Gambar berhasil ditempel ke zona unggah.', 'success');
    });

    // Live Preview Drawer logic
    const btnPreview = document.getElementById('btnLivePreview');
    const btnClosePreview = document.getElementById('btnClosePreview');
    const previewDrawer = document.getElementById('previewDrawer');
    const backdrop = document.getElementById('previewBackdrop');

    btnPreview.addEventListener('click', () => {
        // Populate preview content
        document.getElementById('previewTitle').innerText = document.getElementById('postTitle').value || 'Judul Postingan Anda';
        
        const catSelect = document.getElementById('postCategoryId');
        const selectedCatText = catSelect.options[catSelect.selectedIndex]?.text || 'Kategori';
        document.getElementById('previewCategoryText').innerText = selectedCatText;

        document.getElementById('previewContentBody').innerHTML = quill.root.innerHTML || '<p style="color:var(--text-light)">Konten kosong.</p>';
        
        // Show drawer
        previewDrawer.classList.add('active');
        backdrop.classList.add('active');
    });

    function closePreview() {
        previewDrawer.classList.remove('active');
        backdrop.classList.remove('active');
    }

    btnClosePreview.addEventListener('click', closePreview);
    backdrop.addEventListener('click', closePreview);


    // --- PERIODICAL AUTO-SAVE UX IMPLEMENTATION ---
    let autoSaveTimer = setInterval(performAutoSave, 30000); // Trigger auto-save every 30 seconds

    function performAutoSave() {
        const title = document.getElementById('postTitle').value.trim();
        const catId = document.getElementById('postCategoryId').value;
        const status = document.getElementById('postStatus').value;
        const content = quill.root.innerHTML;
        const postId = document.getElementById('postIdInput').value;

        // Skip if title or category is missing (not ready for draf creation)
        if (!title || !catId) {
            return;
        }

        const indicator = document.getElementById('autosaveIndicator');
        indicator.style.display = 'block';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Fetch AJAX Request
        fetch('{{ route("admin.posts.autosave") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id: postId,
                title: title,
                category_id: catId,
                status: status,
                content: content,
                published_at: document.getElementById('publishedAt').value
            })
        })
        .then(response => response.json())
        .then(data => {
            indicator.style.display = 'none';
            if (data.success) {
                // Update Post ID on hidden input
                document.getElementById('postIdInput').value = data.id;
                showToast(data.message, 'success');
            }
        })
        .catch(err => {
            indicator.style.display = 'none';
            console.error('Autosave Error:', err);
        });
    }
</script>
@endsection
