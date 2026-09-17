<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Kriteria SPK
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); // C1, C2, etc
            $table->string('nama');
            $table->enum('sifat', ['benefit', 'cost']);
            $table->double('bobot'); // 0.30, 0.25, etc
            $table->string('satuan', 50)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 2. Tabel Alternatif Varian Roti (Pelangi Nusantara Food)
        Schema::create('varian_rotis', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); // A1, A2, etc
            $table->string('nama_varian');
            $table->string('kategori')->default('Roti Manis');
            $table->decimal('harga_jual', 12, 2)->default(0);
            $table->decimal('estimasi_keuntungan', 12, 2)->default(0);
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 3. Tabel Periode Penilaian Produksi Bulanan
        Schema::create('periodes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode'); // e.g. "Oktober 2026"
            $table->unsignedTinyInteger('bulan'); // 1-12
            $table->unsignedSmallInteger('tahun'); // 2026
            $table->enum('status', ['draft', 'dihitung', 'divalidasi'])->default('draft');
            $table->text('catatan_manajemen')->nullable();
            $table->timestamp('tanggal_validasi')->nullable();
            $table->timestamps();
        });

        // 4. Tabel Penilaian Alternatif per Kriteria (Matriks X)
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade');
            $table->foreignId('varian_roti_id')->constrained('varian_rotis')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->double('nilai'); // Nilai operasional riil (misal volume penjualan = 1500)
            $table->timestamps();

            $table->unique(['periode_id', 'varian_roti_id', 'kriteria_id'], 'unique_penilaian_per_kriteria');
        });

        // 5. Tabel Hasil Perhitungan SAW & Rekomendasi Prioritas
        Schema::create('hasil_saw_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade');
            $table->foreignId('varian_roti_id')->constrained('varian_rotis')->onDelete('cascade');
            $table->double('nilai_preferensi'); // Nilai Vi
            $table->unsignedInteger('ranking'); // 1, 2, 3...
            $table->string('rekomendasi'); // 'Prioritas Utama', 'Prioritas Sedang', 'Prioritas Rendah'
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['periode_id', 'varian_roti_id'], 'unique_hasil_per_varian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_saw_details');
        Schema::dropIfExists('penilaians');
        Schema::dropIfExists('periodes');
        Schema::dropIfExists('varian_rotis');
        Schema::dropIfExists('kriterias');
    }
};
