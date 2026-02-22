# PT. Aplikasi Dagang Teknologi - Employee Management System

Sistem manajemen terpadu untuk karyawan PT. Aplikasi Dagang Teknologi yang mencakup absensi RFID, penugasan kerja, dan sistem reward/penukaran poin.

## Fitur Utama

### 1. Sistem Absensi RFID
- **Tap In / Tap Out**: Karyawan melakukan absensi menggunakan kartu RFID.
- **Validasi Hardware**: Dilengkapi dengan validasi tanda tangan perangkat keras (Device Signature Verification) untuk keamanan absensi.
- **Poin Kehadiran**: Karyawan otomatis mendapatkan 1 Poin Reward setiap kali berhasil melakukan Check-in dan Check-out (Maksimal 2 poin per hari).
- **Anti-Spam & Cooldown**: Sistem dilengkapi dengan proteksi *cooldown* antrean tap dan batas maksimal harian untuk mencegah penyalahgunaan kartu RFID.

### 2. Manajemen Tugas (Task Management)
- **Delegasi**: Admin dapat membuat dan memberikan tugas (Assignment) khusus kepada karyawan.
- **Nilai Poin**: Setiap tugas memiliki bobot poin *reward* yang berbeda-beda.
- **Status Alur Kerja**: Tugas memiliki status transparan mulai dari `Tersedia`, `Dikerjakan`, `Menunggu Persetujuan` (Pending Approval), hingga `Selesai` atau `Ditolak`.
- **Eksekusi Karyawan**: Karyawan dapat mengambil tugas secara mandiri dari daftar tugas yang tersedia dan memandainya sebagai selesai untuk ditinjau oleh Admin.

### 3. Sistem Reward & Penukaran (Redemption System)
- **Pengumpulan Poin**: Poin didapatkan dari gabungan absensi harian (RFID) dan penyelesaian tugas.
- **Katalog Produk**: Tersedia katalog produk makanan dan minuman yang dikelola oleh Admin.
- **Penukaran Otomatis (Checkout)**: Karyawan menukarkan poin dengan produk secara langsung melalui Dasbor, saldo poin terpotong otomatis sementara status pesanan menjadi "Menunggu Disetujui Admin".
- **Refund Poin**: Jika Admin menolak pesanan penukaran pada halaman Persetujuan, poin karyawan langsung dikembalikan (*refund*) ke akun.

### 4. Admin Panel & Dashboard
- **Role-Based Access Control**: Sistem yang ketat membedakan antara Karyawan dan Admin menggunakan `Middleware`. Karyawan hanya bisa mengakses rute karyawannya, sedangkan Admin memiliki kendali penuh CRUD.
- **Dashboard Karyawan yang Clean & Professional**: Antarmuka korporat minimalis menampilkan poin, riwayat tap terakhir, dan pemantauan tugas.
- **Manajemen Akun dan Perangkat**: Admin dapat dengan mudah menambahkan akun karyawan baru, menghapus akun, dan mendaftarkan ID perangkat mesin RFID.

---

## Prasyarat Lingkungan
- **PHP** ^8.2
- **Laravel Framework** ^11.0 (atau lebih baru)
- **Node.js** & **NPM** (untuk menjalankan Vite & Tailwind CSS)
- **MySQL/MariaDB** atau **SQLite** Database
- Hardware ESP32 dengan sensor RFID rc522 (C++ firmware disediakan terpisah jika diperlukan).

## Instalasi

1. Lakukan *Clone* repositori ini:
```bash
git clone https://github.com/FAJRIAG/magang.git
cd magang
```

2. Unduh dan *install* semua dependensi layanan PHP & Javascript:
```bash
composer install
npm install
```

3. Modifikasi konfigurasi variabel Anda. Salin file lingkungan (*environment*):
```bash
cp .env.example .env
```
*(Pastikan Anda telah memasukkan kredensial database `DB_DATABASE`, `DB_USERNAME`, dll pada file `.env`)*

4. *Generate* kunci keamanan (*App Key*) aplikasi Laravel:
```bash
php artisan key:generate
```

5. Lakukan migrasi skema tabel-tabel ke database (dan buat data bohongan/Seeder default):
```bash
php artisan migrate:fresh --seed
```
*(Catatan: Menjalankan Perintah Seeder ini akan otomatis membuat akun Admin *default* dan konfigurasi waktu Tap RFID)*

6. Jalankan server lokal:
```bash
# Buka dua tab terminal.

# Terminal 1 - Jalankan server PHP
php artisan serve

# Terminal 2 - Jalankan kompilator tampilan Vite (Tailwind CSS)
npm run dev
```

7. Buka browser menuju `http://127.0.0.1:8000`. 
Jika Anda menggunakan *seeder* default, Anda bisa login menggunakan:
- Email: `admin@example.com`
- Password: `password`

## Dokumentasi API Perangkat Keras (ESP32)

Fungsi utama RFID berjalan di atas endpoint `/api/tap`. Endpoint ini menerima permintaan tipe `POST` yang mengharuskan perangkat keras (*device*) terdaftar valid di database.

**Header Permintaan (*Request Header*):**
```
Accept: application/json
Content-Type: application/json
```

**Isi Muatan (*Payload Body*):**
```json
{
    "rfid_uid": "E01234F",
    "device_id": "ABC123XYZ",
    "signature": "b2c01..." 
}
```
*(Signature diciptakan di mesin ESP32 menggunakan HMAC SHA-256 rahasia berdasarkan *Device ID* demi mengantisipasi request palsu dari pihak ketiga).*

---
© 2026 PT. Aplikasi Dagang Teknologi. Seluruh hak cipta dilindungi.
