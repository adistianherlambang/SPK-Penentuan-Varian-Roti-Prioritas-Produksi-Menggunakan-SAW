# 🥖 Sistem Pendukung Keputusan (SPK) Penentuan Varian Roti Prioritas Produksi
### Metode Simple Additive Weighting (SAW) — Pelangi Nusantara Food (Roti Purnama)

Aplikasi Sistem Pendukung Keputusan (SPK) penentuan varian roti prioritas produksi berbasis website menggunakan metode **Simple Additive Weighting (SAW)**, dibangun dengan framework **Laravel 12** dan didukung arsitektur **Docker**.

Sistem ini dikembangkan berdasarkan proposal skripsi:
- **Penulis**: Alfonso Yanuarvi
- **NPM**: 22430109
- **Program Studi**: S1 Ilmu Komputer, Universitas Muhammadiyah Metro (2026)
- **Studi Kasus**: Pelangi Nusantara Food (Perusahaan Roti Purnama), Margodadi, Metro Selatan, Lampung.

---

## 🔄 1. Alur Kerja Sistem (System Workflow)

Sistem ini mengotomatiskan penentuan varian roti prioritas produksi bulanan melalui 7 tahapan terintegrasi:

```
┌───────────────────────────────┐
│       1. Autentikasi          │
│   (Admin / Manajemen Login)   │
└───────────────┬───────────────┘
                │
                ▼
┌───────────────────────────────┐
│     2. Master Data & Bobot    │
│  - 10 Varian Roti (Alternatif)│
│  - 5 Kriteria & Bobot Wj      │
└───────────────┬───────────────┘
                │
                ▼
┌───────────────────────────────┐
│     3. Periode Penilaian      │
│  - Buka Periode Baru (Bulanan)│
│  - Status Awal: "Draft"       │
└───────────────┬───────────────┘
                │
                ▼
┌───────────────────────────────┐
│    4. Input Nilai Matriks X   │
│  - Admin input data riil      │
│    operasional bulanan        │
└───────────────┬───────────────┘
                │
                ▼
┌───────────────────────────────┐
│     5. Kalkulasi Mesin SAW    │
│  - Normalisasi Matriks (R)    │
│  - Nilai Preferensi (Vi)      │
│  - Ranking & Rekomendasi      │
└───────────────┬───────────────┘
                │
                ▼
┌───────────────────────────────┐
│  6. Validasi oleh Manajemen   │
│  - Manajer tinjau hasil       │
│  - Validasi & Kunci Periode   │
└───────────────┬───────────────┘
                │
                ▼
┌───────────────────────────────┐
│   7. Cetak Laporan Resmi      │
│  - Dokumen Berkop Resmi       │
│  - Lembar Tanda Tangan 3 Pihak│
└───────────────────────────────┘
```

### Rincian Langkah-Langkah:
1. **Autentikasi Pengguna**:
   - Pengguna masuk melalui halaman `/login`. Sistem secara otomatis mengarahkan ke dashboard operasional sesuai hak akses (*Role*).
2. **Pengelolaan Master Data**:
   - Menu **Varian Roti** (`/varian`): Data varian roti (kode $A_1 - A_{10}$, nama varian, harga jual, estimasi waktu proses).
   - Menu **Kriteria Penilaian** (`/kriteria`): Konfigurasi 5 kriteria, sifat (*Benefit* / *Cost*), dan persentase bobot ($W_j$).
3. **Pengelolaan Periode Bulanan (`/periode`)**:
   - Admin membuat periode penilaian (contoh: *September 2026*). Status awal berupa `draft`.
4. **Input Matriks Keputusan ($X$) (`/penilaian`)**:
   - Admin menginputkan nilai riil operasional untuk setiap varian roti terhadap 5 kriteria:
     - Volume penjualan riil (Pcs).
     - Margin keuntungan (Rp/Pcs).
     - Kesiapan bahan baku (%).
     - Durasi proses produksi (Menit/Batch).
     - Sisa stok gudang belum terjual (Pcs).
5. **Eksekusi Perhitungan Algoritma SAW (`/perhitungan`)**:
   - Sistem secara otomatis membentuk **Matriks Keputusan ($X$)**.
   - Melakukan **Normalisasi Matriks ($R$)** berdasarkan klasifikasi kriteria *Benefit* dan *Cost*.
   - Menghitung **Nilai Preferensi ($V_i$)** dari perkalian bobot $W_j \cdot R_{ij}$.
   - Mengurutkan nilai preferensi dari tertinggi ke terendah dan memetakan ke dalam rekomendasi: **Prioritas Utama**, **Prioritas Sedang**, atau **Prioritas Rendah**.
6. **Validasi & Pengesahan Keputusan**:
   - Akun Manajemen (Manajer Operasional) meninjau hasil kalkulasi ranking.
   - Manajemen menekan tombol **"Validasi Periode"** untuk mengesahkan keputusan secara resmi (status periode berubah menjadi `divalidasi` dan terkunci).
7. **Cetak Laporan Formal (`/laporan`)**:
   - Menghasilkan dokumen laporan resmi berkop **Pelangi Nusantara Food (Roti Purnama)** berizin Depkes RI, lengkap dengan tabel perangkingan dan lembar pengesahan 3 tanda tangan.

---

## 👥 2. Pengguna & Hak Akses (Informasi Akun Login)

Sistem membagi wewenang menjadi 2 peran pengguna (*Role*) sesuai batasan masalah proposal skripsi (Halaman 3 & 47):

| Role | Nama Pengguna | Email Login | Kata Sandi Default | Tugas & Wewenang |
| :--- | :--- | :--- | :--- | :--- |
| **Admin** | Ibu Dian | `admin@pelangifood.com` | `admin123` | Mengelola data master varian roti, kriteria, membuat periode baru, menginput data operasional (Matriks X), dan menjalankan kalkulasi SAW. |
| **Manajemen** | Bapak Wisnu Nur Yadi | `manajemen@pelangifood.com` | `manajemen123` | Meninjau hasil analisis rekomendasi produksi, melakukan pengesahan/validasi keputusan periode, dan mencetak laporan resmi. |

> 💡 **Fitur Quick-Fill Demo (1-Klik)**: Pada antarmuka login telah disediakan tombol bantuan cepat untuk langsung mengisi email & password Admin atau Manajemen tanpa perlu mengetik manual.

---

## 🧮 3. Tahapan & Rumus Perhitungan Algoritma SAW

Metode **Simple Additive Weighting (SAW)** sering dikenal dengan istilah metode penjumlahan berbobot. Konsep dasarnya adalah mencari penjumlahan berbobot dari rating kinerja pada setiap alternatif di semua kriteria.

### A. 5 Kriteria Penilaian Sesuai Proposal Skripsi

| Kode | Nama Kriteria | Sifat (Atribut) | Bobot ($W_j$) | Satuan | Keterangan |
| :---: | :--- | :---: | :---: | :--- | :--- |
| **C1** | **Volume Penjualan** | **Benefit** | **30%** (0.30) | Pcs/Bulan | Jumlah roti laku terjual. Semakin besar semakin diprioritaskan. |
| **C2** | **Keuntungan (Profit)** | **Benefit** | **25%** (0.25) | Rupiah/Pcs | Margin laba per varian roti. Semakin besar semakin diprioritaskan. |
| **C3** | **Stok Bahan Baku** | **Benefit** | **15%** (0.15) | % Kesiapan | Ketersediaan bahan baku. Semakin siap semakin mudah diproduksi. |
| **C4** | **Waktu Produksi** | **Cost** | **15%** (0.15) | Menit/Batch | Durasi pembuatan. Semakin cepat waktu proses semakin efisien. |
| **C5** | **Sisa Stok Gudang** | **Cost** | **15%** (0.15) | Pcs | Sisa roti belum terjual. Semakin sedikit sisa stok, semakin perlu diproduksi untuk mencegah kadaluarsa. |

$$\sum_{j=1}^{5} W_j = 0.30 + 0.25 + 0.15 + 0.15 + 0.15 = 1.00 \ (100\%)$$

---

### B. Tahapan Matematis SAW

#### 1. Matriks Keputusan ($X$)
Membentuk matriks berukuran $m \times n$, di mana $m$ adalah jumlah alternatif varian roti ($A_1, A_2, \dots, A_m$) dan $n$ adalah jumlah kriteria ($C_1, C_2, \dots, C_n$):
$$X = \begin{pmatrix}
x_{11} & x_{12} & \cdots & x_{1n} \\
x_{21} & x_{22} & \cdots & x_{2n} \\
\vdots & \vdots & \ddots & \vdots \\
x_{m1} & x_{m2} & \cdots & x_{mn}
\end{pmatrix}$$

#### 2. Normalisasi Matriks Keputusan ($R$)
Setiap elemen matriks dinormalisasi menjadi $R_{ij}$ dengan ketentuan:

- **Jika Kriteria adalah Atribut Keuntungan (Benefit)**:
  $$R_{ij} = \frac{x_{ij}}{\max_{i} (x_{ij})}$$
  *(Digunakan pada kriteria **C1 Volume Penjualan**, **C2 Profit**, dan **C3 Stok Bahan Baku**)*.

- **Jika Kriteria adalah Atribut Biaya (Cost)**:
  $$R_{ij} = \frac{\min_{i} (x_{ij})}{x_{ij}}$$
  *(Digunakan pada kriteria **C4 Waktu Produksi** dan **C5 Sisa Stok Gudang**)*.

#### 3. Nilai Preferensi Alternatif ($V_i$)
Nilai preferensi untuk setiap alternatif varian roti dihitung dengan menjumlahkan perkalian elemen baris matriks ternormalisasi ($R$) dengan bobot kriteria ($W$):
$$V_i = \sum_{j=1}^{n} W_j \cdot R_{ij}$$

#### 4. Klasifikasi Rekomendasi Prioritas Produksi
Berdasarkan nilai preferensi akhir ($V_i$):
- 🟢 **Prioritas Utama**: Varian dengan nilai $V_i \ge 0.80$ (atau kuadran teratas 40% dari total varian).
  - *Keputusan*: Tingkatkan kapasitas produksi bulanan untuk memenuhi tingginya serapan pasar.
- 🟡 **Prioritas Sedang**: Varian dengan nilai $0.60 \le V_i < 0.80$.
  - *Keputusan*: Produksi sesuai rata-rata permintaan harian atau pesanan terkonfirmasi.
- ⚪ **Prioritas Rendah**: Varian dengan nilai $V_i < 0.60$.
  - *Keputusan*: Batasi kuota produksi untuk mencegah penumpukan sisa stok gudang dan risiko kadaluarsa.

---

## 🚀 4. Cara Menjalankan Aplikasi

Aplikasi dapat dijalankan melalui **2 pilihan metode**:

### 🐳 Opsi A: Menggunakan Docker Container (Sangat Direkomendasikan)

Metode ini menjalankan aplikasi di dalam container terisolasi yang sudah dikonfigurasi lengkap dengan **PHP 8.4-FPM Alpine**, **Nginx**, dan **MySQL 8.0**:

1. **Buka terminal dan masuk ke folder proyek**:
   ```bash
   cd /Users/aaaa/Documents/Desain/Client/alfonso/kode
   ```
2. **Jalankan container dengan Docker Compose**:
   ```bash
   docker compose up -d
   ```
3. **Jalankan migrasi database dan pengisian data awal (seeder)**:
   ```bash
   docker compose exec app php artisan migrate --seed
   ```
4. **Buka aplikasi di browser**:
   👉 **[http://localhost:8080](http://localhost:8080)**

*Catatan Layanan Docker:*
- Web Server (Nginx): `http://localhost:8080`
- Database MySQL: port `33066` di host (Database: `spksaw_laravel`, User: `spk_user`, Password: `spk_password`)

---

### 💻 Opsi B: Menggunakan Local PHP Built-in Server (Tanpa Docker)

Jika Anda ingin menjalankan langsung di lingkungan mesin lokal (misal menggunakan PHP lokal & MySQL/SQLite):

1. **Buka terminal dan masuk ke folder proyek**:
   ```bash
   cd /Users/aaaa/Documents/Desain/Client/alfonso/kode
   ```
2. **Install dependensi Composer**:
   ```bash
   composer install
   ```
3. **Siapkan file `.env`**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Jalankan migrasi database & seeder**:
   ```bash
   php artisan migrate:fresh --seed
   ```
5. **Jalankan server pengembangan Laravel**:
   ```bash
   php artisan serve --port=8000
   ```
6. **Buka aplikasi di browser**:
   👉 **[http://localhost:8000](http://localhost:8000)**

---

### ⚡ Opsi C: Menjalankan via Script Otomatis (`start.sh`)

Tersedia skrip pembantu interaktif untuk memudahkan pengoperasian:
```bash
cd /Users/aaaa/Documents/Desain/Client/alfonso/kode
chmod +x start.sh
./start.sh
```
Pilih opsi:
- `1` untuk menjalankan Lokal (`localhost:8000`)
- `2` untuk menjalankan Docker (`localhost:8080`)
- `3` untuk me-reset database dan mengulang seeder

---

## 📄 5. Fitur Cetak Laporan Resmi

Sistem dilengkapi template cetak laporan formal berkop resmi **Pelangi Nusantara Food (Roti Purnama)** berizin resmi Depkes RI:
- **Kop Surat**: CV Pelangi Nusantara Food, Margodadi, Metro Selatan, Kota Metro, Lampung.
- **Isi Laporan**: Ringkasan Matriks Keputusan, Normalisasi Matriks, Nilai Preferensi, Ranking Akhir, dan Rekomendasi Kapasitas Produksi.
- **Lembar Pengesahan Tanda Tangan 3 Pihak**:
  1. **Ibu Dian** — Admin Operasional
  2. **Bapak Wisnu Nur Yadi** — Manajer Operasional
  3. **Bapak H. Iwan Abdul Hamit** — Direktur Utama / Pemilik Perusahaan

---

<div align="center">

**SPK Penentuan Varian Roti Prioritas Produksi — Pelangi Nusantara Food**  
*Alfonso Yanuarvi (NPM: 22430109) • Universitas Muhammadiyah Metro (2026)*

</div>
