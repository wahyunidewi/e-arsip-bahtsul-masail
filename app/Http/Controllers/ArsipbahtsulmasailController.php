<?php

namespace App\Http\Controllers;

use App\Models\arsipbahtsulmasail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ZipArchive;
use DOMDocument;

class arsipbahtsulmasailController extends Controller
{
    public function index()
    {
        $arsip = arsipbahtsulmasail::latest()->get();
        return view('arsip.index', compact('arsip'));
    }

    public function create()
    {
        $arsipList = arsipbahtsulmasail::latest()->get();
        return view('arsip.create', compact('arsipList'));
    }

    /**
     * Endpoint AJAX untuk langsung membaca file Word (.docx) / PDF
     * dan menampilkan prediksi kategori fiqih sebelum form disimpan.
     */
    public function previewKlasifikasi(Request $request)
    {
        $request->validate([
            'file_dokumen' => 'required|mimes:docx,pdf|max:5120',
            'judul_kasus' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file_dokumen');
        $ext = strtolower($file->getClientOriginalExtension());
        $teksFile = $this->ekstrakTeksFile($file->getRealPath(), $ext);

        $teksGabungan = trim(($request->judul_kasus ?? '') . ' ' . $teksFile);
        $kategori = $this->klasifikasikanKategori($teksGabungan);

        return response()->json([
            'status' => 'ok',
            'kategori' => $kategori,
            'teks' => $teksFile,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_kasus' => 'required|string|max:255',
            'deskripsi_masalah' => 'nullable|string',
            'pertanyaan' => 'nullable|string',
            'hasil_keputusan' => 'nullable|string',
            'nama_perumus_mushohih' => 'nullable|string|max:255',
            'tanggal_sidang' => 'nullable|date',
            'kategori_fiqih' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|mimes:docx,pdf|max:5120',
        ]);

        $fileName = null;
        $teksDariFile = '';

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $ext = strtolower($file->getClientOriginalExtension());
            $teksDariFile = $this->ekstrakTeksFile($file->getRealPath(), $ext);

            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/pdf'), $fileName);
        }

        $deskripsiFinal = trim((string) $request->deskripsi_masalah);
        if (strip_tags($deskripsiFinal) === '' && $teksDariFile !== '') {
            $deskripsiFinal = nl2br(e($teksDariFile));
        }

        if (strip_tags($deskripsiFinal) === '') {
            return back()
                ->withInput()
                ->withErrors(['deskripsi_masalah' => 'Isi deskripsi masalah di lembar kerja atau unggah file dokumen (.docx / .pdf).']);
        }

        $teksAnalisis = strip_tags(
            $request->judul_kasus . ' ' .
            $deskripsiFinal . ' ' .
            ($request->pertanyaan ?? '') . ' ' .
            ($request->hasil_keputusan ?? '') . ' ' .
            $teksDariFile
        );

        $kategoriOtomatis = $this->klasifikasikanKategori($teksAnalisis);

        $kategoriFinal = $request->filled('kategori_fiqih')
            ? $request->input('kategori_fiqih')
            : $kategoriOtomatis;

        arsipbahtsulmasail::create([
            'judul_kasus' => $request->judul_kasus,
            'deskripsi_masalah' => $deskripsiFinal,
            'pertanyaan' => $request->pertanyaan,
            'hasil_keputusan' => $request->hasil_keputusan,
            'nama_perumus_mushohih' => $request->nama_perumus_mushohih,
            'tanggal_sidang' => $request->tanggal_sidang,
            'kategori_fiqih' => $kategoriFinal,
            'file_pdf' => $fileName,
        ]);

        return redirect()->route('arsip.index')
            ->with('success', 'Arsip berhasil disimpan & diklasifikasikan ke kategori: ' . $kategoriFinal);
    }

    public function edit($id)
    {
        $arsip = arsipbahtsulmasail::findOrFail($id);
        return view('arsip.edit', compact('arsip'));
    }

    public function update(Request $request, $id)
    {
        $arsip = arsipbahtsulmasail::findOrFail($id);

        $request->validate([
            'judul_kasus' => 'required|string|max:255',
            'deskripsi_masalah' => 'required',
            'pertanyaan' => 'required',
            'hasil_keputusan' => 'required',
            'kategori_fiqih' => 'required|string',
            'nama_perumus_mushohih' => 'required',
            'tanggal_sidang' => 'required|date',
            'file_pdf' => 'nullable|mimes:docx,pdf|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_pdf')) {
            if ($arsip->file_pdf) {
                $oldPath = public_path('uploads/pdf/' . $arsip->file_pdf);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('file_pdf');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/pdf'), $filename);
            $data['file_pdf'] = $filename;
        } else {
            $data['file_pdf'] = $arsip->file_pdf;
        }

        $arsip->update($data);

        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $arsip = arsipbahtsulmasail::findOrFail($id);

        if ($arsip->file_pdf) {
            $filePath = public_path('uploads/pdf/' . $arsip->file_pdf);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $arsip->delete();

        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil dihapus.');
    }

    public function indexPublic()
    {
        $arsipList = arsipbahtsulmasail::latest()->get();
        return view('welcome', compact('arsipList'));
    }

    /**
     * Ekstraksi teks otomatis dari file .docx (bawaan PHP ZipArchive) atau .pdf
     */
    private function ekstrakTeksFile(string $path, string $ext): string
    {
        if ($ext === 'docx') {
            $zip = new ZipArchive();
            if ($zip->open($path) === true) {
                $xmlContent = $zip->getFromName('word/document.xml');
                $zip->close();

                if ($xmlContent !== false) {
                    $dom = new DOMDocument();
                    libxml_use_internal_errors(true);
                    $dom->loadXML($xmlContent);
                    libxml_clear_errors();

                    $paragraphs = [];
                    foreach ($dom->getElementsByTagName('p') as $p) {
                        $line = trim($p->textContent);
                        if ($line !== '') {
                            $paragraphs[] = $line;
                        }
                    }

                    return implode("\n\n", $paragraphs);
                }
            }
        }

        if ($ext === 'pdf' && class_exists(\Smalot\PdfParser\Parser::class)) {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($path);
            return trim($pdf->getText());
        }

        return '';
    }

    private function klasifikasikanKategori($teks)
    {
        $teks = strtolower($teks);

        $keywords = [
            'Fiqih Ibadah' => ['sholat', 'shalat', 'wudhu', 'puasa', 'zakat', 'haji', 'tayamum', 'najis', 'suci', 'dzikir', 'doa'],
            'Fiqih Muamalah' => ['jual', 'beli', 'utang', 'piutang', 'sewa', 'transaksi', 'riba', 'gaji', 'online shop', 'shopeepay', 'paylater', 'bisnis', 'perusahaan'],
            'Fiqih Munakahat' => ['nikah', 'talak', 'cerai', 'suami', 'istri', 'mahar', 'kawin', 'nasab', 'khitbah', 'pinangan'],
            'Fiqih Jinayah' => ['pembunuhan', 'qishash', 'diyat', 'pencurian', 'zina', 'hudud', 'kriminal', 'hukuman'],
        ];

        foreach ($keywords as $kategori => $words) {
            foreach ($words as $word) {
                if (str_contains($teks, $word)) {
                    return $kategori;
                }
            }
        }

        return 'Umum';
    }

    public function byKategori($kategori)
    {
        $arsipList = arsipbahtsulmasail::where('kategori_fiqih', $kategori)->latest()->get();
        return view('welcome', compact('arsipList', 'kategori'));
    }

    public function searchPublic(Request $request)
    {
        $keyword = $request->input('cari');

        $arsipList = arsipbahtsulmasail::where('judul_kasus', 'LIKE', "%{$keyword}%")
            ->orWhere('deskripsi_masalah', 'LIKE', "%{$keyword}%")
            ->orWhere('kategori_fiqih', 'LIKE', "%{$keyword}%")
            ->latest()
            ->get();

        return view('welcome', compact('arsipList', 'keyword'));
    }
}