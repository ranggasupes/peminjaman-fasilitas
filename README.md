# Sistem Informasi Peminjaman dan Penyewaan Fasilitas Umum

**Sistem Informasi Peminjaman dan Penyewaan Fasilitas Umum Milik Instansi Pemerintah Berbasis Web di Kota Palu dan Sekitarnya**

Aplikasi ini dikembangkan dengan nama **Fasilitasku** sebagai sistem informasi berbasis web untuk mempermudah proses peminjaman dan penyewaan fasilitas umum milik instansi pemerintah di Kota Palu dan sekitarnya.

## Identitas Kelompok

**KELOMPOK 8**

| No. | Nama Anggota              | NIM         |
| --- | ------------------------- | ----------- |
| 1   | Moh. Abdi Ramadhan        | F5212510001 |
| 2   | Andi Nayla Safa Arrahma P | F5212510005 |
| 3   | Rangga Ferdi Kurniawan    | F5212510032 |

## Deskripsi Proyek

Fasilitasku merupakan aplikasi berbasis web yang dikembangkan untuk mempermudah proses pengajuan dan pengelolaan peminjaman fasilitas umum milik instansi pemerintah. Sistem ini menyediakan layanan bagi masyarakat untuk mencari fasilitas, mengajukan peminjaman, mengunggah bukti pembayaran, serta memantau status pengajuan secara online.

Aplikasi ini juga membantu pihak pengelola fasilitas dalam mengelola data fasilitas, memproses pengajuan peminjaman, dan melakukan verifikasi pembayaran melalui satu sistem terintegrasi.

## Fitur Utama

### 1. Peminjam

- Melihat daftar fasilitas publik yang tersedia.
- Melihat informasi dan detail fasilitas.
- Mengajukan peminjaman fasilitas.
- Melihat status pengajuan peminjaman.
- Mengunggah bukti pembayaran.
- Memantau status verifikasi pembayaran.
- Melihat riwayat peminjaman.

### 2. Admin Fasilitas

- Mengelola data fasilitas milik instansi.
- Melihat pengajuan peminjaman fasilitas.
- Menyetujui atau menolak pengajuan.
- Meminta peminjam melakukan perbaikan pengajuan.
- Memverifikasi bukti pembayaran.
- Memberikan catatan terkait pembayaran.

### 3. Super Admin

- Mengelola data instansi.
- Mengelola akun admin fasilitas.
- Memantau pengelolaan fasilitas dan sistem.

## Alur Peminjaman

1. Peminjam memilih fasilitas yang ingin digunakan.
2. Peminjam mengisi formulir pengajuan peminjaman.
3. Admin fasilitas memeriksa pengajuan.
4. Admin dapat menyetujui, menolak, atau meminta perbaikan pengajuan.
5. Jika disetujui, peminjam melanjutkan proses pembayaran.
6. Peminjam mengunggah bukti pembayaran.
7. Admin melakukan verifikasi pembayaran.
8. Jika pembayaran terverifikasi, peminjaman dikonfirmasi.
9. Setelah kegiatan selesai, status peminjaman dapat diperbarui menjadi selesai.

## Teknologi yang Digunakan

- **Backend:** Laravel 12
- **Bahasa Pemrograman:** PHP
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript, Blade
- **Build Tool:** Vite
- **Dependency Management:** Composer dan NPM
- **Version Control:** Git dan GitHub

## Persyaratan Sistem

- PHP 8.2 atau lebih baru.
- Composer.
- Node.js dan NPM.
- MySQL atau MariaDB.
- Git.
- Web server lokal seperti Laragon.

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/ranggasupes/peminjaman-fasilitas.git
```

### 2. Masuk ke Direktori Project

```bash
cd peminjaman-fasilitas
```

### 3. Install Dependency Laravel

```bash
composer install
```

### 4. Buat File Environment

```powershell
Copy-Item .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Buat database MySQL dengan nama `peminjaman_fasilitas`, kemudian sesuaikan konfigurasi pada file `.env`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=peminjaman_fasilitas
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Jalankan Migration dan Seeder

```bash
php artisan migrate --seed
```

### 8. Install Dependency Frontend

```bash
npm install
```

### 9. Buat Storage Link

```bash
php artisan storage:link
```

### 10. Jalankan Aplikasi

Terminal pertama:

```bash
php artisan serve
```

Terminal kedua:

```bash
npm run dev
```

Akses aplikasi melalui `http://127.0.0.1:8000`.

## Status Peminjaman

| Status                           | Keterangan                        |
| -------------------------------- | --------------------------------- |
| `diajukan`                       | Pengajuan baru dikirim            |
| `perlu_perbaikan`                | Pengajuan perlu diperbaiki        |
| `disetujui`                      | Pengajuan disetujui               |
| `menunggu_pembayaran`            | Menunggu pembayaran               |
| `menunggu_verifikasi_pembayaran` | Bukti pembayaran sedang diperiksa |
| `dikonfirmasi`                   | Pembayaran terverifikasi          |
| `ditolak`                        | Pengajuan ditolak                 |
| `dibatalkan`                     | Peminjaman dibatalkan             |
| `selesai`                        | Peminjaman telah selesai          |

## Catatan

- Aplikasi dikembangkan sebagai proyek pembelajaran dan implementasi Rekayasa Perangkat Lunak.
- Informasi pembayaran pada lingkungan simulasi bukan merupakan rekening pembayaran resmi.
- Konfigurasi database perlu disesuaikan sebelum menjalankan aplikasi.
- Jangan mengunggah file `.env` atau informasi kredensial pribadi ke repository publik.

---

**Kelompok 8**  
Sistem Informasi  
© 2026
