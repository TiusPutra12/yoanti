@extends('layouts.app')
@section('title', 'Tambah Portofolio')

@push('styles')
    <style>
        .form-container {
            max-width: 600px;
            margin: 3rem auto;
            background: #fff;
            padding: clamp(2rem, 5vw, 3rem);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg), 0 0 0 1px rgba(0, 0, 0, 0.04);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .form-desc {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            background: #F8FAFC;
            color: var(--text-main);
            font-size: 0.95rem;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .file-upload-wrapper {
            position: relative;
            width: 100%;
            height: 200px;
            border: 2px dashed var(--border);
            border-radius: var(--radius-md);
            background: #F8FAFC;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            overflow: hidden;
        }

        .file-upload-wrapper:hover, .file-upload-wrapper.dragover {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }

        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

        .file-upload-content {
            text-align: center;
            padding: 1rem;
            z-index: 1;
            pointer-events: none;
        }

        .file-upload-icon {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .file-upload-text {
            font-size: 0.9rem;
            color: var(--text-main);
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .file-upload-hint {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .image-preview {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
            z-index: 1;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            font-size: 1.05rem;
            font-weight: 700;
            border-radius: var(--radius-sm);
            margin-top: 1rem;
            background: var(--primary);
            color: white;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            background: var(--primary-hover);
            box-shadow: 0 12px 32px rgba(37, 99, 235, 0.35);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            transition: var(--transition);
        }

        .btn-back:hover {
            color: var(--primary);
        }

        @media (max-width: 480px) {
            .form-container {
                margin: 1.5rem auto;
                padding: 1.5rem;
                border-radius: var(--radius-md);
            }
        }
    </style>
@endpush

@section('content')
    <div style="max-width: 600px; margin: 0 auto; padding-top: 2rem; padding-left: 1rem; padding-right: 1rem;">
        <a href="{{ url('/penyedia/dashboard') }}" class="btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title">Tambah Portofolio</h1>
            <p class="form-desc">Unggah detail produk atau layanan terbaik Anda.</p>
        </div>

        @if ($errors->any())
            <div style="background: #FEF2F2; color: #DC2626; padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; border: 1px solid #FECACA;">
                <ul style="margin: 0; padding-left: 1.5rem; font-size: 0.9rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/penyedia/produk/store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label" for="title">Nama Produk / Layanan</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Contoh: Desain Website E-commerce" required value="{{ old('title') }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Deskripsi</label>
                <textarea id="description" name="description" class="form-control" placeholder="Jelaskan detail layanan atau portofolio produk Anda..." required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="price">Harga Produk / Layanan</label>
                <input type="text" id="price" name="price" class="form-control" placeholder="Contoh: Rp 500.000 atau Hubungi Kami" required value="{{ old('price') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Gambar Portofolio</label>
                <div class="file-upload-wrapper" id="dropArea">
                    <input type="file" name="image" id="imageInput" class="file-upload-input" accept="image/*" required>
                    <div class="file-upload-content" id="uploadContent">
                        <svg class="file-upload-icon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        <div class="file-upload-text">Klik atau seret gambar ke sini</div>
                        <div class="file-upload-hint">Maksimal 5MB (JPEG, PNG, GIF)</div>
                    </div>
                    <img id="imagePreview" class="image-preview" alt="Preview">
                </div>
            </div>

            <button type="submit" class="btn-submit">Simpan Portofolio</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const uploadContent = document.getElementById('uploadContent');

        // Drag & Drop efek
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.remove('dragover'), false);
        });

        // Handle File Drop
        dropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                fileInput.files = files; // Assign files to input
                previewImage(files[0]);
            }
        }

        // Handle Input Change
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                previewImage(this.files[0]);
            }
        });

        function previewImage(file) {
            if (!file.type.match('image.*')) {
                alert('Tolong unggah file gambar (JPEG, PNG, GIF).');
                return;
            }

            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                uploadContent.style.opacity = '0'; // Sembunyikan teks upload
            }
            
            reader.readAsDataURL(file);
        }
    </script>
@endpush
