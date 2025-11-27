# Web Aplikasi Laundry Antar-Jemput

## Deskripsi
Aplikasi web untuk mengelola layanan laundry antar-jemput dengan sistem multi-role (Admin, Pelanggan, Kurir).

## Tech Stack
- **Backend**: PHP 8.2+ dengan Laravel 11
- **Database**: MySQL
- **Frontend**: Blade Template Engine + Bootstrap 5.3
- **Server**: Nginx/Apache (XAMPP)

## Fitur yang Sudah Diimplementasikan

### ✅ TAHAP 1: Core Setup & Data Master
- [x] Model & Migration untuk semua tabel (users, pakets, transaksis, detail_transaksis)
- [x] CRUD Paket Laundry lengkap (/admin/paket)
- [x] Middleware CheckRole untuk pembatasan akses
- [x] Seeder untuk data awal (admin, kurir, pelanggan, paket)

### ✅ TAHAP 2: Autentikasi dan Homepage Pelanggan
- [x] Sistem Login/Register/Logout
- [x] Dashboard Pelanggan dengan katalog paket
- [x] Form Order dengan generate kode invoice otomatis
- [x] Riwayat pesanan pelanggan

### ✅ TAHAP 3: Dashboard Admin
- [x] Dashboard Admin dengan statistik real-time
- [x] Kelola Paket Laundry (CRUD lengkap)

## Instalasi & Setup

### 1. Persiapan Database
1. Jalankan XAMPP dan aktifkan MySQL
2. Buka phpMyAdmin (http://localhost/phpmyadmin)
3. Buat database baru dengan nama `laundry_db`

### 2. Konfigurasi Environment
File `.env` sudah dikonfigurasi untuk MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laundry_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Menjalankan Migrasi & Seeder
```bash
# Jalankan migrasi
php artisan migrate

# Jalankan seeder untuk data awal
php artisan db:seed
```

### 4. Menjalankan Aplikasi
```bash
php artisan serve
```
Akses aplikasi di: http://localhost:8000

## Akun Default untuk Testing

### Admin
- **Email**: admin@laundry.com
- **Password**: password
- **Akses**: Dashboard admin, kelola paket, kelola transaksi

### Pelanggan
- **Email**: pelanggan@laundry.com
- **Password**: password
- **Akses**: Dashboard pelanggan, pesan laundry, riwayat

### Kurir
- **Email**: kurir@laundry.com
- **Password**: password
- **Akses**: Dashboard kurir (placeholder)

## Struktur Database

### Tabel Users
- id, name, email, password, role, phone, address, timestamps

### Tabel Pakets
- id, nama_paket, harga_per_kg, deskripsi, satuan, is_active, timestamps

### Tabel Transaksis
- id, kode_invoice, user_id, kurir_id, berat_aktual, total_harga
- status_transaksi, status_bayar, alamat_jemput, catatan, timestamps

### Tabel Detail_Transaksis
- id, transaksi_id, paket_id, jumlah, harga_satuan, subtotal, timestamps

## Fitur yang Akan Dikembangkan Selanjutnya

### 🔄 TAHAP 4: Modul Manajemen Transaksi (Admin)
- [ ] Dashboard Transaksi (/admin/transaksi)
- [ ] Proses Transaksi dengan input berat aktual
- [ ] Update status transaksi dan pembayaran
- [ ] Penugasan kurir

### 🔄 TAHAP 5: Modul Kurir
- [ ] CRUD Kurir (/admin/kurir)
- [ ] Dashboard Kurir dengan daftar tugas
- [ ] Update status penjemputan/pengantaran

### 🔄 TAHAP 6: Riwayat dan Pelaporan
- [ ] Riwayat Admin dengan filter dan pagination
- [ ] Laporan cetak invoice
- [ ] Export data transaksi

### 🔄 TAHAP 7: API untuk Mobile App
- [ ] API Authentication dengan Laravel Sanctum
- [ ] Endpoint /api/kurir/tugas
- [ ] API untuk update status transaksi

## Cara Penggunaan

### Untuk Admin:
1. Login dengan akun admin
2. Kelola paket laundry di menu "Kelola Paket"
3. Monitor statistik di dashboard
4. (Segera) Kelola transaksi dan assign kurir

### Untuk Pelanggan:
1. Register akun baru atau login
2. Lihat katalog paket di dashboard
3. Klik "Pesan Laundry Sekarang"
4. Pilih paket dan isi alamat penjemputan
5. Lihat status pesanan di "Riwayat"

### Untuk Kurir:
1. Login dengan akun kurir
2. (Segera) Lihat daftar tugas penjemputan
3. (Segera) Update status penjemputan/pengantaran

## Troubleshooting

### Error Database Connection
- Pastikan XAMPP MySQL sudah berjalan
- Cek konfigurasi database di file `.env`
- Pastikan database `laundry_db` sudah dibuat

### Error 403 Forbidden
- Pastikan sudah login dengan role yang sesuai
- Cek middleware CheckRole di routes

### Error 500 Internal Server Error
- Cek log Laravel di `storage/logs/laravel.log`
- Pastikan semua dependency sudah terinstall dengan `composer install`

## Kontribusi
Aplikasi ini dikembangkan secara bertahap. Setiap tahap akan menambahkan fitur baru sesuai dengan spesifikasi yang telah ditentukan.

## Lisensi
Aplikasi ini dibuat untuk keperluan pembelajaran dan pengembangan sistem laundry antar-jemput.