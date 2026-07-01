@extends('layouts.admin')

@section('title', isset($page) ? 'Edit Halaman - Admin LPKIA' : 'Tambah Halaman Baru - Admin LPKIA')
@section('page_title', isset($page) ? 'Edit Halaman' : 'Buat Halaman Baru')

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
        <i class="fa-solid fa-spinner fa-spin"></i> Menyimpan draf halaman secara otomatis...
    </div>

    <!-- Main Form -->
    <form action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" id="pageEditorForm">
        @csrf
        @if(isset($page))
            @method('PUT')
        @endif
        
        <!-- Page ID for AJAX autosave -->
        <input type="hidden" name="page_id" id="pageIdInput" value="{{ $page->id ?? '' }}">

        <div class="editor-layout">
            <!-- Left Panel: Main Workspace Area -->
            <div class="editor-main-area">
                <div class="form-group title-group">
                    <label class="form-label" style="font-size: 1rem; color: var(--primary);">Judul Halaman</label>
                    <input type="text" name="title" id="pageTitle" class="form-control title-input" placeholder="Masukkan Judul Halaman di Sini..." required value="{{ old('title', $page->title ?? '') }}">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-size: 0.9rem;">Konten Halaman</label>
                    <!-- Quill Container -->
                    <div id="quillEditor" style="height: 350px;">
                        {!! old('content', $page->content ?? '') !!}
                    </div>
                    <!-- Hidden Input to store HTML -->
                    <input type="hidden" name="content" id="pageContentInput">
                </div>
            </div>

            <!-- Right Panel: Sidebar Properties Area -->
            <div class="editor-sidebar-area">
                
                <!-- Status & Publish Actions -->
                <div class="editor-sidebar-widget">
                    <div class="editor-widget-title">Penerbitan (Publish)</div>
                    
                    <div class="form-group">
                        <label class="form-label">Status Halaman</label>
                        <select name="status" id="pageStatus" class="form-control" required>
                            <option value="draft" {{ (old('status', $page->status ?? '') === 'draft') ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ (old('status', $page->status ?? '') === 'published') ? 'selected' : '' }}>Published</option>
                            <option value="scheduled" {{ (old('status', $page->status ?? '') === 'scheduled') ? 'selected' : '' }}>Scheduled</option>
                        </select>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Simpan Halaman
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" id="btnLivePreview" style="width: 100%;">
                            <i class="fa-solid fa-eye"></i> Live Preview
                        </button>
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
                            
                            @if(isset($page) && $page->featured_image)
                                <img src="{{ asset($page->featured_image) }}" class="image-upload-preview" id="imagePreviewElement">
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
            <h3><i class="fa-solid fa-magnifying-glass-chart"></i> Live Preview Halaman</h3>
            <button type="button" class="btn btn-sm btn-danger btn-icon" id="btnClosePreview">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="preview-body">
            <h2 id="previewTitle" style="font-size: 2.2rem; font-weight: 800; color: var(--primary); margin-bottom: 20px; line-height: 1.3;">Judul Halaman</h2>
            <div id="previewMetadata" style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
                <span><i class="fa-solid fa-file"></i> Halaman Statis</span> &nbsp;|&nbsp; 
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
        placeholder: 'Mulai ketik isi konten halaman statis LPKIA di sini...',
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
    const form = document.getElementById('pageEditorForm');
    const contentInput = document.getElementById('pageContentInput');

    form.addEventListener('submit', function() {
        contentInput.value = quill.root.innerHTML;
    });

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
        document.getElementById('previewTitle').innerText = document.getElementById('pageTitle').value || 'Judul Halaman Anda';
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


    // --- PERIODICAL AUTO-SAVE UX IMPLEMENTATION FOR PAGES ---
    let autoSaveTimer = setInterval(performAutoSave, 30000); // Trigger auto-save every 30 seconds

    function performAutoSave() {
        const title = document.getElementById('pageTitle').value.trim();
        const status = document.getElementById('pageStatus').value;
        const content = quill.root.innerHTML;
        const pageId = document.getElementById('pageIdInput').value;

        // Skip if title is missing
        if (!title) {
            return;
        }

        const indicator = document.getElementById('autosaveIndicator');
        indicator.style.display = 'block';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Fetch AJAX Request
        fetch('{{ route("admin.pages.autosave") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id: pageId,
                title: title,
                status: status,
                content: content
            })
        })
        .then(response => response.json())
        .then(data => {
            indicator.style.display = 'none';
            if (data.success) {
                // Update Page ID on hidden input
                document.getElementById('pageIdInput').value = data.id;
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
