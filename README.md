# Sistem Pendukung Keputusan (SPK) Penentuan Varian Roti Prioritas Produksi

Aplikasi Sistem Pendukung Keputusan (SPK) penentuan varian roti prioritas produksi berbasis website menggunakan metode **Simple Additive Weighting (SAW)**, dibangun dengan framework **Laravel** dan didukung arsitektur **Docker**.

Sistem ini dikembangkan berdasarkan proposal skripsi:
- **Penulis**: Alfonso Yanuarvi
- **NPM**: 22430109
- **Program Studi**: S1 Ilmu Komputer, Universitas Muhammadiyah Metro (2026)
- **Studi Kasus**: Pelangi Nusantara Food (Perusahaan Roti Purnama), Margodadi, Metro Selatan, Lampung.

---

## 👥 Pengguna & Hak Akses (Role)

Sistem memiliki 2 level pengguna sesuai analisis batasan masalah proposal (Halaman 3 & 47):

| Role | Akun Default | Kata Sandi | Tugas & Wewenang |
| :--- | :--- | :--- | :--- |
| **Admin** (Ibu Dian) | `admin@pelangifood.com` | `admin123` | Pengelolaan data master varian roti, kriteria & bobot, input data operasional bulanan (Matriks X), dan eksekusi SAW. |
| **Manajemen** (Bapak Wisnu Nur Yadi) | `manajemen@pelangifood.com` | `manajemen123` | Meninjau hasil analisis SAW, mengesahkan/memvalidasi keputusan prioritas produksi bulanan, dan mencetak laporan resmi. |

---

## 📊 5 Kriteria Penilaian SAW

Sesuai Batasan Masalah pada Proposal Skripsi:

| Kode | Nama Kriteria | Sifat (Atribut) | Bobot ($W_j$) | Satuan | Keterangan |
| :---: | :--- | :---: | :---: | :--- | :--- |
| **C1** | **Volume Penjualan** | **Benefit** | **30%** (0.30) | Pcs/Bulan | Jumlah roti laku terjual. Semakin besar semakin diprioritaskan. |
| **C2** | **Keuntungan (Profit)** | **Benefit** | **25%** (0.25) | Rupiah/Pcs | Margin laba per varian roti. Semakin besar semakin diprioritaskan. |
| **C3** | **Stok Bahan Baku** | **Benefit** | **15%** (0.15) | % Kesiapan | Ketersediaan bahan baku. Semakin siap semakin mudah diproduksi. |
| **C4** | **Waktu Produksi** | **Cost** | **15%** (0.15) | Menit/Batch | Durasi pembuatan. Semakin cepat waktu proses semakin efisien. |
| **C5** | **Sisa Stok Gudang** | **Cost** | **15%** (0.15) | Pcs | Sisa roti belum terjual. Semakin sedikit sisa stok, semakin perlu diproduksi kembali untuk mencegah roti kadaluarsa. |

---

## 🚀 Cara Menjalankan Aplikasi

### Opsi A: Menggunakan Docker (Rekomendasi Kontainer)
Pastikan Docker Desktop sudah terinstal dan aktif di komputer Anda:
```bash
cd /Users/aaaa/Documents/Desain/Client/alfonso/spk-saw-laravel

# Jalankan kontainer (App PHP-FPM, Nginx Webserver, MySQL)
docker compose up -d

# Jalankan migrasi dan data awal (seeder) di dalam kontainer
docker compose exec app php artisan migrate --seed
```
Akses di browser: **[http://localhost:8080](http://localhost:8080)**

---

### Opsi B: Menggunakan Local PHP Built-in Server
Jika Anda ingin menjalankan langsung secara lokal tanpa Docker:
```bash
cd /Users/aaaa/Documents/Desain/Client/alfonso/spk-saw-laravel

# Jalankan migrasi & data awal (SQLite / MySQL lokal)
php artisan migrate:fresh --seed

# Jalankan server
php artisan serve --port=8000
```
Akses di browser: **[http://localhost:8000](http://localhost:8000)**

---

## 🧮 Tahapan Perhitungan Algoritma SAW

1. **Matriks Keputusan ($X$)**: Tabel nilai riil $X_{ij}$ dari setiap varian roti $A_i$ terhadap kriteria $C_j$.
2. **Normalisasi Matriks ($R$)**:
   - Atribut Benefit: $R_{ij} = \frac{X_{ij}}{\max(X_j)}$
   - Atribut Cost: $R_{ij} = \frac{\min(X_j)}{X_{ij}}$
3. **Nilai Preferensi ($V_i$)**:
   $$V_i = \sum_{j=1}^n W_j \cdot R_{ij}$$
4. **Perangkingan & Rekomendasi**:
   - **Prioritas Utama**: Varian dengan nilai $V_i$ tertinggi ($V_i \ge 0.75$ / Top 40%), diprioritaskan produksinya.
   - **Prioritas Sedang**: Varian dengan permintaan sedang ($0.60 \le V_i < 0.75$).
   - **Prioritas Rendah**: Varian dengan nilai $V_i < 0.60$, disarankan membatasi produksi untuk menghindari kelebihan stok.

---

## 📄 Fitur Cetak Laporan Resmi
Sistem dilengkapi template cetak laporan formal berkop resmi **Pelangi Nusantara Food (Roti Purnama)** berizin Depkes RI, dilengkapi lembar pengesahan tanda tangan:
1. **Ibu Dian** (Admin Operasional)
2. **Bapak Wisnu Nur Yadi** (Manajer Operasional)
3. **Bapak H. Iwan Abdul Hamit** (Direktur Utama / Pemilik)
# SPK-Penentuan-Varian-Roti-Prioritas-Produksi-Menggunakan-SAW
