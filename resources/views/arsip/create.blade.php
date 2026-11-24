<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editor Rumusan Bahtsul Masail - E-Arsip Al-Misky</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #1e1e1e;
            color: #f1f5f9;
            margin: 0;
            padding-bottom: 45px;
        }
        .word-titlebar {
            background-color: #18181b;
            border-bottom: 1px solid #2e2e32;
            padding: 8px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .word-ribbon {
            background-color: #252529;
            border-bottom: 1px solid #38383e;
            padding: 10px 18px;
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        .ribbon-group {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding-right: 12px;
            margin-right: 12px;
            border-right: 1px solid #3f3f46;
        }
        .ribbon-group:last-child {
            border-right: none;
        }
        .ribbon-btn {
            background: transparent;
            border: 1px solid transparent;
            color: #e4e4e7;
            border-radius: 6px;
            padding: 5px 9px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.15s;
        }
        .ribbon-btn:hover {
            background-color: #3f3f46;
            color: #ffffff;
        }
        .ribbon-select {
            background-color: #18181b;
            color: #f4f4f5;
            border: 1px solid #3f3f46;
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 0.85rem;
        }
        .workspace-wrapper {
            display: flex;
            gap: 24px;
            max-width: 1320px;
            margin: 24px auto;
            padding: 0 20px;
            align-items: flex-start;
        }
        .paper-sheet {
            background: #ffffff;
            color: #111827;
            width: 100%;
            max-width: 820px;
            min-height: 1050px;
            margin: 0 auto;
            padding: 64px 72px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.45);
            border-radius: 4px;
        }
        .doc-title-input {
            width: 100%;
            border: none;
            border-bottom: 2px solid #e5e7eb;
            font-size: 1.55rem;
            font-weight: 700;
            color: #064e3b;
            padding-bottom: 10px;
            margin-bottom: 24px;
            outline: none;
        }
        .doc-title-input::placeholder {
            color: #9ca3af;
            font-weight: 600;
        }
        .section-heading {
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #065f46;
            margin-top: 22px;
            margin-bottom: 8px;
        }
        .editor-box {
            min-height: 130px;
            padding: 10px 12px;
            border: 1px dashed #d1d5db;
            border-radius: 6px;
            outline: none;
            font-size: 1rem;
            line-height: 1.75;
            color: #1f2937;
            transition: border-color 0.2s, background-color 0.2s;
        }
        .editor-box:focus {
            border: 1px solid #059669;
            background-color: #f8fafc;
        }
        .editor-box:empty:before {
            content: attr(data-placeholder);
            color: #9ca3af;
            pointer-events: none;
        }
        .meta-sidebar {
            width: 360px;
            flex-shrink: 0;
            background-color: #252529;
            border: 1px solid #38383e;
            border-radius: 12px;
            padding: 20px;
            position: sticky;
            top: 72px;
        }
        .meta-sidebar .form-control,
        .meta-sidebar .form-select {
            background-color: #18181b;
            border: 1px solid #3f3f46;
            color: #f4f4f5;
            font-size: 0.9rem;
        }
        .meta-sidebar .form-control:focus,
        .meta-sidebar .form-select:focus {
            border-color: #10b981;
            box-shadow: none;
        }
        .upload-dropzone {
            border: 1.5px dashed #10b981;
            background-color: #18181b;
            border-radius: 10px;
            padding: 14px;
            transition: background-color 0.2s;
        }
        .upload-dropzone:hover {
            background-color: #1f2421;
        }
        .ml-preview-box {
            background-color: #064e3b;
            border: 1px solid #10b981;
            color: #ecfdf5;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 0.85rem;
        }
        .word-statusbar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #064e3b;
            color: #ecfdf5;
            font-size: 0.8rem;
            padding: 5px 18px;
            display: flex;
            justify-content: space-between;
            z-index: 1030;
        }
        @media (max-width: 992px) {
            .workspace-wrapper {
                flex-direction: column;
            }
            .meta-sidebar {
                width: 100%;
                position: static;
            }
            .paper-sheet {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>

<form id="arsipWordForm" action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Title Bar ala Word -->
    <div class="word-titlebar">
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-success px-2 py-1"><i class="bi bi-file-earmark-word me-1"></i> Dokumen Rumusan</span>
            <span class="fw-semibold text-light small">E-Arsip Bahtsul Masail — LBM Asrama Al-Misky</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('arsip.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 fw-semibold">
                <i class="bi bi-cloud-arrow-up me-1"></i> Simpan Arsip
            </button>
        </div>
    </div>

    <!-- Ribbon Toolbar Pemformatan ala Word -->
    <div class="word-ribbon">
        <div class="d-flex flex-wrap align-items-center gap-y-2">
            <div class="ribbon-group">
                <select class="ribbon-select" onchange="formatDoc('fontName', this.value)" title="Jenis Font">
                    <option value="Inter">Inter (Default)</option>
                    <option value="Times New Roman">Times New Roman</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Arial">Arial</option>
                    <option value="Traditional Arabic">Traditional Arabic</option>
                </select>
                <select class="ribbon-select" onchange="formatDoc('fontSize', this.value)" title="Ukuran Font">
                    <option value="3">Normal (12)</option>
                    <option value="2">Kecil (10)</option>
                    <option value="4">Sedang (14)</option>
                    <option value="5">Besar (18)</option>
                </select>
            </div>

            <div class="ribbon-group">
                <button type="button" class="ribbon-btn" onclick="formatDoc('bold')" title="Tebal (Ctrl+B)"><i class="bi bi-type-bold"></i></button>
                <button type="button" class="ribbon-btn" onclick="formatDoc('italic')" title="Miring (Ctrl+I)"><i class="bi bi-type-italic"></i></button>
                <button type="button" class="ribbon-btn" onclick="formatDoc('underline')" title="Garis Bawah (Ctrl+U)"><i class="bi bi-type-underline"></i></button>
                <button type="button" class="ribbon-btn" onclick="formatDoc('strikeThrough')" title="Coret"><i class="bi bi-type-strikethrough"></i></button>
            </div>

            <div class="ribbon-group">
                <button type="button" class="ribbon-btn" onclick="formatDoc('justifyLeft')" title="Rata Kiri"><i class="bi bi-text-left"></i></button>
                <button type="button" class="ribbon-btn" onclick="formatDoc('justifyCenter')" title="Rata Tengah"><i class="bi bi-text-center"></i></button>
                <button type="button" class="ribbon-btn" onclick="formatDoc('justifyRight')" title="Rata Kanan (Teks Arab)"><i class="bi bi-text-right"></i></button>
                <button type="button" class="ribbon-btn" onclick="formatDoc('justifyFull')" title="Rata Kiri-Kanan"><i class="bi bi-justify"></i></button>
            </div>

            <div class="ribbon-group">
                <button type="button" class="ribbon-btn" onclick="formatDoc('insertUnorderedList')" title="Bullet List"><i class="bi bi-list-ul"></i></button>
                <button type="button" class="ribbon-btn" onclick="formatDoc('insertOrderedList')" title="Numbering"><i class="bi bi-list-ol"></i></button>
                <button type="button" class="ribbon-btn" onclick="formatDoc('outdent')" title="Kurangi Indent"><i class="bi bi-text-indent-right"></i></button>
                <button type="button" class="ribbon-btn" onclick="formatDoc('indent')" title="Tambah Indent"><i class="bi bi-text-indent-left"></i></button>
            </div>

            <div class="ribbon-group">
                <button type="button" class="ribbon-btn" onclick="formatDoc('undo')" title="Undo"><i class="bi bi-arrow-counterclockwise"></i></button>
                <button type="button" class="ribbon-btn" onclick="formatDoc('redo')" title="Redo"><i class="bi bi-arrow-clockwise"></i></button>
                <button type="button" class="ribbon-btn" onclick="formatDoc('removeFormat')" title="Hapus Format"><i class="bi bi-eraser"></i></button>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="container mt-3">
            <div class="alert alert-danger mb-0">
                <strong>Periksa kembali isian dokumen:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Area Kerja: Lembar Kertas A4 + Panel Upload & Klasifikasi -->
    <div class="workspace-wrapper">
        <!-- Lembar Kertas Putih ala Word -->
        <div class="paper-sheet">
            <div class="text-center mb-4 pb-3 border-bottom">
                <div class="fw-bold text-uppercase small text-secondary">Lembaga Bahtsul Masail (LBM) Asrama Al-Misky</div>
                <div class="text-muted" style="font-size: 0.8rem;">Pondok Pesantren Al-Mahrusiyah Lirboyo Kediri</div>
            </div>

            <!-- Input Judul Kasus -->
            <input type="text"
                   name="judul_kasus"
                   id="judul_kasus"
                   class="doc-title-input"
                   value="{{ old('judul_kasus') }}"
                   placeholder="Ketik Judul Kasus (atau otomatis terisi dari nama file Word/PDF)..."
                   required>

            <!-- Bagian 1: Deskripsi Masalah -->
            <div class="section-heading">I. Deskripsi Masalah (Duduk Perkara)</div>
            <div id="editor_deskripsi"
                 class="editor-box"
                 contenteditable="true"
                 data-placeholder="Ketikkan di sini atau unggah file Word (.docx) / PDF di panel kanan untuk mengisi otomatis...">{!! old('deskripsi_masalah') !!}</div>
            <textarea name="deskripsi_masalah" id="input_deskripsi" class="d-none">{{ old('deskripsi_masalah') }}</textarea>

            <!-- Bagian 2: Rumusan Pertanyaan -->
            <div class="section-heading">II. Rumusan Pertanyaan</div>
            <div id="editor_pertanyaan"
                 class="editor-box"
                 contenteditable="true"
                 data-placeholder="Ketikkan poin-poin pertanyaan sidang di sini...">{!! old('pertanyaan') !!}</div>
            <textarea name="pertanyaan" id="input_pertanyaan" class="d-none">{{ old('pertanyaan') }}</textarea>

            <!-- Bagian 3: Hasil Keputusan & Ibarat Kitab -->
            <div class="section-heading">III. Hasil Keputusan & Rujukan Kitab (Ibarat)</div>
            <div id="editor_keputusan"
                 class="editor-box"
                 style="min-height: 220px;"
                 contenteditable="true"
                 data-placeholder="Ketikkan jawaban/keputusan sidang beserta ibarat kitab rujukan di sini...">{!! old('hasil_keputusan') !!}</div>
            <textarea name="hasil_keputusan" id="input_keputusan" class="d-none">{{ old('hasil_keputusan') }}</textarea>
        </div>

        <!-- Panel Samping untuk Upload Hasil Jadi Word/PDF & Metadata -->
        <div class="meta-sidebar">
            <h6 class="fw-bold text-white mb-3">
                <i class="bi bi-magic text-success me-2"></i>Import File Word / PDF
            </h6>

            <div class="upload-dropzone mb-3">
                <label for="file_dokumen" class="form-label small fw-semibold text-success mb-1">
                    <i class="bi bi-file-earmark-arrow-up me-1"></i> Unggah File Hasil Ketikan (.docx / .pdf)
                </label>
                <input type="file"
                       name="file_dokumen"
                       id="file_dokumen"
                       accept=".docx,.pdf,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                       class="form-control form-control-sm">
                <div class="form-text text-secondary mt-1" style="font-size: 0.75rem;">
                    Isi teks otomatis terbaca ke lembar kerja & langsung diprediksi kategorinya oleh sistem.
                </div>

                <!-- Status & Hasil Deteksi Otomatis ML -->
                <div id="mlLoading" class="mt-2 small text-warning d-none">
                    <span class="spinner-border spinner-border-sm me-1"></span> Membaca isi dokumen & menganalisis kategori...
                </div>

                <div id="mlPreviewBox" class="ml-preview-box mt-2 d-none">
                    <div class="small opacity-75">Hasil Deteksi Otomatis:</div>
                    <div class="fw-bold fs-6" id="mlDetectedCategory">-</div>
                </div>
            </div>

            <hr class="border-secondary my-3">

            <h6 class="fw-bold text-white mb-3">
                <i class="bi bi-sliders text-success me-2"></i>Pengaturan Arsip
            </h6>

            <div class="mb-3">
                <label class="form-label small text-light">Kategori Fiqih</label>
                <select name="kategori_fiqih" id="kategori_fiqih" class="form-select">
                    <option value="">Otomatis (Machine Learning)</option>
                    <option value="Fiqih Ibadah" {{ old('kategori_fiqih') == 'Fiqih Ibadah' ? 'selected' : '' }}>Fiqih Ibadah</option>
                    <option value="Fiqih Muamalah" {{ old('kategori_fiqih') == 'Fiqih Muamalah' ? 'selected' : '' }}>Fiqih Muamalah</option>
                    <option value="Fiqih Munakahat" {{ old('kategori_fiqih') == 'Fiqih Munakahat' ? 'selected' : '' }}>Fiqih Munakahat</option>
                    <option value="Fiqih Jinayah" {{ old('kategori_fiqih') == 'Fiqih Jinayah' ? 'selected' : '' }}>Fiqih Jinayah</option>
                    <option value="Umum" {{ old('kategori_fiqih') == 'Umum' ? 'selected' : '' }}>Umum</option>
                </select>
                <div class="form-text text-secondary" style="font-size: 0.75rem;">
                    Terisi otomatis saat unggah file, atau dapat diubah manual.
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small text-light">Perumus / Mushohih</label>
                <input type="text"
                       name="nama_perumus_mushohih"
                       class="form-control"
                       value="{{ old('nama_perumus_mushohih') }}"
                       placeholder="Contoh: Tim Perumus LBM">
            </div>

            <div class="mb-4">
                <label class="form-label small text-light">Tanggal Sidang</label>
                <input type="date"
                       name="tanggal_sidang"
                       class="form-control"
                       value="{{ old('tanggal_sidang') }}">
            </div>

            <button type="submit" class="btn btn-success w-100 rounded-pill fw-semibold py-2">
                <i class="bi bi-check2-circle me-1"></i> Simpan & Klasifikasikan
            </button>
        </div>
    </div>

    <!-- Status Bar Bawah ala Word -->
    <div class="word-statusbar">
        <div>Lembar Rumusan Bahtsul Masail &bull; Mode Editor & Import Dokumen</div>
        <div id="wordCounter">0 kata</div>
    </div>
</form>

<script>
    function formatDoc(cmd, value = null) {
        document.execCommand(cmd, false, value);
    }

    const editors = [
        { box: document.getElementById('editor_deskripsi'), input: document.getElementById('input_deskripsi') },
        { box: document.getElementById('editor_pertanyaan'), input: document.getElementById('input_pertanyaan') },
        { box: document.getElementById('editor_keputusan'), input: document.getElementById('input_keputusan') }
    ];

    function syncEditors() {
        let totalWords = 0;
        editors.forEach(item => {
            const textOnly = item.box.innerText.trim();
            item.input.value = textOnly.length > 0 ? item.box.innerHTML : '';
            if (textOnly.length > 0) {
                totalWords += textOnly.split(/\s+/).length;
            }
        });
        document.getElementById('wordCounter').textContent = totalWords + ' kata';
    }

    editors.forEach(item => {
        item.box.addEventListener('input', syncEditors);
    });

    document.getElementById('arsipWordForm').addEventListener('submit', function () {
        syncEditors();
    });

    // Otomatis baca file Word (.docx) / PDF saat dipilih & prediksi kategori ML
    document.getElementById('file_dokumen').addEventListener('change', async function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const loadingEl = document.getElementById('mlLoading');
        const previewBox = document.getElementById('mlPreviewBox');
        const detectedCatEl = document.getElementById('mlDetectedCategory');
        const judulInput = document.getElementById('judul_kasus');
        const kategoriSelect = document.getElementById('kategori_fiqih');

        // Isi judul otomatis dari nama file jika kolom judul masih kosong
        if (!judulInput.value.trim()) {
            const cleanName = file.name.replace(/\.[^/.]+$/, '').replace(/[_-]+/g, ' ');
            judulInput.value = cleanName;
        }

        loadingEl.classList.remove('d-none');
        previewBox.classList.add('d-none');

        const formData = new FormData();
        formData.append('file_dokumen', file);
        formData.append('judul_kasus', judulInput.value);

        try {
            const response = await fetch("{{ route('arsip.previewKlasifikasi') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok && result.status === 'ok') {
                // Tampilkan hasil kategori yang terdeteksi
                detectedCatEl.textContent = result.kategori;
                previewBox.classList.remove('d-none');
                kategoriSelect.value = result.kategori;

                // Masukkan teks yang terbaca dari file ke lembar kerja jika masih kosong
                if (result.teks && !document.getElementById('editor_deskripsi').innerText.trim()) {
                    document.getElementById('editor_deskripsi').innerText = result.teks;
                    syncEditors();
                }
            } else {
                alert(result.message || 'Gagal membaca isi file.');
            }
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat memproses file.');
        } finally {
            loadingEl.classList.add('d-none');
        }
    });

    syncEditors();
</script>

</body>
</html>