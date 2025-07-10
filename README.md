# Kasir Ageng - Aplikasi Point of Sale Modern

![Tangkapan Layar Dasbor Kasir Ageng](https://imgur.com/a/JpFSKj1)

**Kasir Ageng** adalah aplikasi web Point of Sale (POS) atau aplikasi kasir lengkap yang dibangun dari nol menggunakan teknologi modern. Aplikasi ini dirancang untuk menjadi portofolio yang menunjukkan pemahaman mendalam tentang pengembangan web *full-stack*, mulai dari manajemen data di *backend* hingga antarmuka yang interaktif di *frontend*.

---

## ✨ Fitur Utama

Aplikasi ini dilengkapi dengan semua fitur esensial yang dibutuhkan oleh sistem kasir modern:

* **Dashboard Informatif:** Menampilkan ringkasan statistik penjualan harian (pendapatan, jumlah transaksi, produk terjual) dan grafik tren penjualan selama 7 hari terakhir.
* **Manajemen Data Lengkap (CRUD):**
    * **Produk:** Tambah, lihat, edit, dan hapus produk dengan upload gambar.
    * **Kategori:** Kelola kategori untuk setiap produk.
    * **Pengguna:** Kelola akun pengguna (admin dan kasir).
* **Sistem Kasir Interaktif:**
    * Antarmuka kasir *real-time* menggunakan Alpine.js.
    * Pencarian produk instan tanpa memuat ulang halaman.
    * Fungsi keranjang belanja (tambah, hapus, ubah jumlah).
    * Perhitungan total belanja dan uang kembalian otomatis.
* **Transaksi & Pelaporan:**
    * Penyimpanan riwayat transaksi yang aman.
    * Pengurangan stok produk secara otomatis setelah transaksi berhasil.
    * Halaman laporan penjualan yang bisa difilter berdasarkan rentang tanggal.
    * Fitur **Export Laporan ke PDF**.
    * Fitur **Cetak Nota** untuk setiap transaksi.
* **Sistem Peran & Keamanan:**
    * Dua peran pengguna: **Admin** (akses penuh) dan **Kasir** (hanya akses ke halaman kasir).
    * Perlindungan halaman admin menggunakan *Middleware* dan *Gate* Laravel.

---

## 🚀 Teknologi yang Digunakan

Proyek ini dibangun dengan TALL Stack yang dimodifikasi dan beberapa teknologi populer lainnya:

* **Backend:** Laravel 11
* **Frontend:** Tailwind CSS, Alpine.js
* **Database:** MySQL (atau database lain yang didukung Laravel)
* **Grafik:** Chart.js
* **Export PDF:** `barryvdh/laravel-dompdf`

---

## ⚙️ Cara Instalasi & Menjalankan Proyek

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/Winaldo2111082047/Aplikasi-Web-Kasir.git](https://github.com/Winaldo2111082047/Aplikasi-Web-Kasir.git)
    cd kasir-ageng
    ```

2.  **Install Dependensi**
    Jalankan perintah berikut untuk menginstal semua paket PHP dan JavaScript yang dibutuhkan.
    ```bash
    composer install
    npm install
    ```

3.  **Setup Lingkungan (.env)**
    Salin file `.env.example` menjadi `.env` dan buat kunci aplikasi.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan pengaturan database Anda (nama database, username, password).
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=kasir_ageng
    DB_USERNAME=root
    DB_PASSWORD=
    ```
    Pastikan Anda sudah membuat database dengan nama yang sama di phpMyAdmin atau tool database Anda.

5.  **Jalankan Migrasi & Buat Symbolic Link**
    Perintah ini akan membuat semua tabel di database dan membuat shortcut untuk folder storage.
    ```bash
    php artisan migrate
    php artisan storage:link
    ```

6.  **Jalankan Aplikasi**
    Terakhir, jalankan server pengembangan.
    ```bash
    # Jalankan di terminal pertama
    npm run dev

    # Buka terminal kedua, lalu jalankan
    php artisan serve
    ```
    Aplikasi sekarang bisa diakses di `http://127.0.0.1:8000`.

7.  **Buat Akun Admin**
    * Register akun baru melalui halaman pendaftaran.
    * Buka database Anda (misal: phpMyAdmin), masuk ke tabel `users`, dan ubah nilai di kolom `role` untuk akun Anda menjadi `admin`.

---

## 🤝 Kontribusi

Merasa ada yang bisa ditingkatkan? Silakan buat *pull request* atau buka *issue*. Kontribusi dalam bentuk apa pun sangat diterima!
