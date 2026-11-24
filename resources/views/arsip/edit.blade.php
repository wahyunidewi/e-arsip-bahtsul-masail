<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Arsip - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-dark mb-4"><i class="bi bi-pencil-square me-2 text-success"></i>Edit Arsip Bahtsul Masail</h4>

                        <form action="{{ route('arsip.update', $arsip->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-medium">Judul Kasus</label>
                                <input type="text" name="judul_kasus" class="form-control" value="{{ old('judul_kasus', $arsip->judul_kasus) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Kategori Fiqih</label>
                                <select name="kategori_fiqih" class="form-select" required>
                                    <option value="Fiqih Ibadah" {{ $arsip->kategori_fiqih == 'Fiqih Ibadah' ? 'selected' : '' }}>Fiqih Ibadah</option>
                                    <option value="Fiqih Muamalah" {{ $arsip->kategori_fiqih == 'Fiqih Muamalah' ? 'selected' : '' }}>Fiqih Muamalah</option>
                                    <option value="Fiqih Munakahat" {{ $arsip->kategori_fiqih == 'Fiqih Munakahat' ? 'selected' : '' }}>Fiqih Munakahat</option>
                                    <option value="Fiqih Jinayah" {{ $arsip->kategori_fiqih == 'Fiqih Jinayah' ? 'selected' : '' }}>Fiqih Jinayah</option>
                                    <option value="Umum" {{ $arsip->kategori_fiqih == 'Umum' ? 'selected' : '' }}>Umum</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Deskripsi Masalah (Waqiatul Hal)</label>
                                <textarea name="deskripsi_masalah" class="form-control" rows="4" required>{{ old('deskripsi_masalah', $arsip->deskripsi_masalah) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Pertanyaan</label>
                                <textarea name="pertanyaan" class="form-control" rows="3" required>{{ old('pertanyaan', $arsip->pertanyaan) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Hasil Keputusan (Natijah)</label>
                                <textarea name="hasil_keputusan" class="form-control" rows="4" required>{{ old('hasil_keputusan', $arsip->hasil_keputusan) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Tim Perumus / Mushohih</label>
                                <input type="text" name="nama_perumus_mushohih" class="form-control" value="{{ old('nama_perumus_mushohih', $arsip->nama_perumus_mushohih) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Tanggal Sidang</label>
                                <input type="date" name="tanggal_sidang" class="form-control" value="{{ old('tanggal_sidang', $arsip->tanggal_sidang) }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Ganti File PDF (Opsional)</label>
                                @if($arsip->file_pdf)
                                    <div class="mb-2">
                                        <small class="text-muted">File saat ini: <a href="{{ asset('uploads/pdf/' . $arsip->file_pdf) }}" target="_blank">{{ $arsip->file_pdf }}</a></small>
                                    </div>
                                @endif
                                <input type="file" name="file_pdf" class="form-control" accept=".pdf">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file PDF.</small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('arsip.index') }}" class="btn btn-secondary rounded-pill px-4">Kembali</a>
                                <button type="submit" class="btn btn-success rounded-pill px-4">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>