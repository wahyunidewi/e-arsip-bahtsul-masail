<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('arsip_bahtsul_masail', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kasus');
            $table->text('deskripsi_masalah');
            $table->text('pertanyaan');
            $table->text('hasil_keputusan');
            $table->string('nama_perumus_mushohih');
            $table->date('tanggal_sidang');
            $table->string('file_pdf')->nullable();
            $table->string('kategori_fiqih')->nullable;
            $table->timestamps();

        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('arsip_bahtsul_masail');
    }
};
