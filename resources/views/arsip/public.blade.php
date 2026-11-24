<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Arsip Digital Bahtsul Masail Al-Mahrusiyah</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .navbar-brand { font-weight: 700; color: #064e3b !important; }
        .hero-section { background: linear-gradient(135deg, #064e3b 0%, #022c22 100%); color: white; padding: 50px 0 70px 0; border-radius: 0 0 2.5rem 2.5rem; }
        .search-box { max-width: 650px; margin: -35px auto 45px auto; position: relative; z-index: 10; }
        .category-card { border: none; border-radius: 1.25rem; transition: transform 0.2s, box-shadow 0.2s; color: white; padding: 1.5rem; }
        .category-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .card-ibadah { background: linear-gradient(135deg, #059669 0%, #047857 100%); }
        .card-muamalah { background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); }
        .card-munakahat { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
        .card-jinayah { background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); }
        .arsip-card { border: none; border-radius: 1rem; transition: all 0.2s; background: white; }
        .arsip-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <i class="bi bi-journal-richtext text-success fs-3 me-2"></i>
                <span>E-Arsip Al-Mahrusiyah</span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ url('/') }}" class="text-success text-decoration-none fw-semibold d-none d-md-inline">Beranda</a>
                <a href="#arsip-terbaru" class="text-muted text-decoration-none d-none d-md-inline">Cari Arsip</a>
                <a href="#tentang" class="text-muted text-decoration-none d-none d-md-inline">Tentang</a>
                <a href="{{ route('login') }}" class="btn btn-outline-success px-3 rounded-pill fw-medium btn-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i> [Admin Login]
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section text-center shadow-sm">
        <div class="container py-4">
            <h1 class="fw-bold mb-2 display-6">E-ARSIP DIGITAL BAHTSUL MASAIL AL-MAHRUSIYAH</h1>
            <p class="text-light opacity-75 mb-0">Pusat Keputusan & Hasil Sidang yang dikelola oleh LBM Asrama Al-Misky Lirboyo Kediri</p>
        </div>
    </div>

    <!-- Search Bar Mengambang -->
    <div class="container search-box">
        <div class="card shadow border-0 rounded-pill p-2 bg-white">
            <form action="{{ url('/') }}" method="GET" class="input-group">
                <span class="input-group-text bg-transparent border-0 ps-3 text-success fs-5">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="cari" value="{{ request('cari') }}" class="form-control border-0 shadow-none py-2" placeholder="Ketik kata kunci masalah hukum (Cth: Paylater)...">
                <button class="btn btn-success rounded-pill px-4 fw-medium" type="submit">Cari</button>
            </form>
        </div>
    </div>

    <!-- Kategori Fiqih Cards -->
    <div class="container mb-5">
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="card category-card card-ibadah shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <i class="bi bi-moon-stars fs-2 opacity-75"></i>
                        <span class="badge bg-white text-success rounded-pill px-3 py-1 fw-bold">Fiqih</span>
                    </div>
                    <h5 class="fw-bold mb-1">Fiqih Ibadah</h5>
                    <p class="small opacity-75 mb-0">Shalat, Thaharah, Zakat</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card category-card card-muamalah shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <i class="bi bi-briefcase fs-2 opacity-75"></i>
                        <span class="badge bg-white text-teal rounded-pill px-3 py-1 fw-bold">Fiqih</span>
                    </div>
                    <h5 class="fw-bold mb-1">Fiqih Muamalah</h5>
                    <p class="small opacity-75 mb-0">Transaksi, Modern, Bisnis</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card category-card card-munakahat shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <i class="bi bi-people fs-2 opacity-75"></i>
                        <span class="badge bg-white text-primary rounded-pill px-3 py-1 fw-bold">Fiqih</span>
                    </div>
                    <h5 class="fw-bold mb-1">Fiqih Munakahat</h5>
                    <p class="small opacity-75 mb-0">Pernikahan & Keluarga</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card category-card card-jinayah shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <i class="bi bi-shield-exclamation fs-2 opacity-75"></i>
                        <span class="badge bg-white text-indigo rounded-pill px-3 py-1 fw-bold">Fiqih</span>
                    </div>
                    <h5 class="fw-bold mb-1">Fiqih Jinayah</h5>
                    <p class="small opacity-75 mb-0">Pidana & Hukum Islam</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Arsip Terbaru -->
    <div id="arsip-terbaru" class="container mb-5">
        <h4 class="fw-bold text-dark mb-4"><i class="bi bi-clock-history me-2 text-success"></i>Arsip Terbaru</h4>
        
        <div class="row g-4">
            @forelse ($arsip as $item)
                <div class="col-md-4">
                    <div class="card arsip-card shadow-sm h-100 p-3">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 mb-2 fw-semibold">
                                    {{ $item->kategori_fiqih ?? 'Umum' }}
                                </span>
                                <h5 class="fw-bold text-dark mb-2">{{ $item->judul_kasus }}</h5>
                                <p class="text-muted small mb-3">
                                    {{ Str::limit($item->deskripsi_masalah, 95) }}
                                </p>
                            </div>
                            <div class="border-top pt-3 mt-3 d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i> {{ $item->tanggal_sidang }}
                                </small>
                                <div class="d-flex gap-2">
                                    @if($item->file_pdf)
                                        <a href="{{ asset('uploads/pdf/' . $item->file_pdf) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                            <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-folder2-open display-4 text-muted mb-3"></i>
                            <p class="text-muted mb-0">Belum ada data arsip Bahtsul Masail yang tersedia.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <footer id="tentang" class="bg-white text-center py-4 border-top mt-5">
        <div class="container text-muted small">
            &copy; 2026 E-Arsip Bahtsul Masail - LBM Asrama Al-Misky Al-Mahrusiyah Lirboyo Kediri.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>