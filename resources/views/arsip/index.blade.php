<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-Arsip Bahtsul Masail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .navbar-brand { font-weight: 700; color: #064e3b !important; }
    </style>
</head>
<body>

    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-shield-lock-fill text-success fs-3 me-2"></i>
                <span>Admin Panel - E-Arsip Al-Mahrusiyah</span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ url('/') }}" target="_blank" class="text-muted text-decoration-none small">
                    <i class="bi bi-globe me-1"></i> Lihat Halaman Publik
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container my-5">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-dark mb-0"><i class="bi bi-archive me-2 text-success"></i>Kelola Arsip Bahtsul Masail</h4>
                    <a href="{{ route('arsip.create') }}" class="btn btn-success rounded-pill px-4 fw-medium">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Arsip Baru
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>No</th>
                                <th>Judul Kasus</th>
                                <th>Kategori</th>
                                <th>Tim Mushohih / Perumus</th>
                                <th>Tanggal Sidang</th>
                                <th>PDF</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Perhatikan penggunaan $item di bawah ini -->
                            @forelse ($arsip as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-medium text-dark">{{ $item->judul_kasus }}</td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">
                                            {{ $item->kategori_fiqih ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($item->nama_perumus_mushohih, 30) }}</td>
                                    <td>{{ $item->tanggal_sidang }}</td>
                                    <td>
                                        @if($item->file_pdf)
                                            <a href="{{ asset('uploads/pdf/' . $item->file_pdf) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Tombol Edit menggunakan $item->id -->
                                        <a href="{{ route('arsip.edit', $item->id) }}" class="btn btn-sm btn-warning rounded-pill px-3 me-1 text-white">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>

                                        <!-- Tombol Hapus menggunakan $item->id -->
                                        <form action="{{ route('arsip.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus arsip ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">
                                                <i class="bi bi-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data arsip yang tersimpan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>