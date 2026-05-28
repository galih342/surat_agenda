<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan_surats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_opd');
            $table->string('perihal');
            $table->date('tanggal_acara');
            $table->time('jam_mulai');
            $table->time('jam_selesai')->nullable(); // Menjadi nullable agar aman saat checkbox "Sampai selesai" dicentang
            $table->string('file_surat'); // Menyimpan nama/path file PDF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surats');
    }
};
