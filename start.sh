#!/bin/bash
# Helper script untuk menjalankan SPK SAW Pelangi Nusantara Food

echo "=========================================================="
echo " SPK SAW PENENTUAN VARIAN ROTI PRIORITAS PRODUKSI "
echo "        PELANGI NUSANTARA FOOD (ROTI PURNAMA)             "
echo "=========================================================="

echo "Pilih mode untuk menjalankan aplikasi:"
echo "1) Jalankan Lokal (PHP Artisan Serve - Port 8000)"
echo "2) Jalankan dengan Docker Container (Docker Compose - Port 8080)"
echo "3) Jalankan Migrasi & Database Seeder Ulang"
read -p "Masukkan pilihan [1-3]: " pilihan

case $pilihan in
    1)
        echo "Menjalankan server lokal di http://localhost:8000 ..."
        php artisan serve --port=8000
        ;;
    2)
        echo "Menjalankan container Docker..."
        docker compose up -d
        echo "Aplikasi berjalan di http://localhost:8080"
        ;;
    3)
        echo "Menjalankan migrasi dan seeder..."
        php artisan migrate:fresh --seed
        echo "Database selesai di-reset dan diisi data awal."
        ;;
    *)
        echo "Pilihan tidak valid."
        ;;
esac
