# 🧺 JasaLaundry - Sistem Manajemen Laundry

Aplikasi web untuk mengelola layanan laundry antar-jemput dengan sistem multi-role (Admin, Kurir, Pelanggan) yang dilengkapi dengan sistem promo, analytics, dan integrasi WhatsApp.

## 🚀 Fitur Utama

### 👤 **Pelanggan**
- **Dashboard Interaktif** dengan carousel promo
- **Pemesanan Laundry** dengan pilihan paket dan metode pembayaran
- **Sistem Promo** - klaim promo dari carousel dan gunakan kode diskon
- **Riwayat Transaksi** lengkap dengan status real-time
- **Integrasi WhatsApp** untuk notifikasi otomatis

### 🚚 **Kurir**
- **Dashboard Tugas** dengan statistik dan filter
- **Manajemen Tugas** penjemputan dan pengantaran
- **Update Status** transaksi secara real-time
- **WhatsApp Integration** untuk komunikasi dengan pelanggan
- **Google Maps Integration** untuk navigasi alamat

### 👨‍💼 **Admin**
- **Dashboard Analytics** dengan grafik dan statistik
- **Kelola Paket** laundry dengan CRUD lengkap
- **Manajemen Transaksi** dengan update berat dan harga
- **Kelola Kurir** dan penugasan
- **Sistem Promo** - buat dan kelola promo
- **Validasi Promo** - approve/reject klaim pelanggan
- **Laporan & Analytics** dengan grafik pendapatan dan filter cetak
- **WhatsApp Notifications** otomatis untuk update status

## 🛠️ Teknologi

- **Backend:** Laravel 11
- **Frontend:** Bootstrap 5.3, Chart.js
- **Database:** MySQL
- **Icons:** Bootstrap Icons
- **Charts:** Chart.js untuk analytics
- **Integration:** WhatsApp Web API, Google Maps

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM (opsional)

## 🔧 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/yourusername/ta-laundry.git
cd ta-laundry
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ta_laundry
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Database Migration
```bash
php artisan migrate
```

### 6. Create Admin User (Manual)
Daftar manual di `/register` atau buat via tinker:
```bash
php artisan tinker
User::create(['name'=>'Admin','email'=>'admin@jasalaundry.com','password'=>bcrypt('password'),'role'=>'admin','phone'=>'628123456789','address'=>'Alamat Admin']);
```

### 7. Run Application
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 👥 Akun Demo

Buat akun manual atau gunakan registrasi:

### Admin (Buat Manual)
- **Email:** admin@jasalaundry.com
- **Password:** password
- **Role:** admin

### Kurir & Pelanggan
- Daftar melalui `/register`
- Admin dapat mengubah role kurir di menu "Kelola Kurir"

## 📱 Fitur WhatsApp Integration

Aplikasi menggunakan WhatsApp Web API untuk:
- Notifikasi status transaksi
- Pengiriman kode promo
- Komunikasi kurir-pelanggan

Format nomor: `62812345678` (tanpa +, dimulai dengan 62)

## 📊 Analytics & Reporting

### Dashboard Analytics
- **Grafik Pendapatan** 7 hari terakhir (Line Chart)
- **Status Transaksi** distribusi (Doughnut Chart)
- **Statistik Real-time** (Total transaksi, pendapatan, dll)

### Laporan
- **Filter Lengkap:** Status, tanggal, kurir, metode pembayaran
- **Cetak Laporan** dengan filter khusus
- **Export** data transaksi

## 🎯 Sistem Promo

### Flow Promo
1. **Admin** membuat promo (persen/nominal)
2. **Pelanggan** klaim promo dari carousel
3. **Admin** approve/reject klaim
4. **Pelanggan** terima kode promo via WhatsApp
5. **Pelanggan** gunakan kode saat order
6. **Sistem** otomatis potong harga

## 🔄 Status Transaksi

1. **Request Jemput** - Pelanggan buat pesanan
2. **Dijemput Kurir** - Kurir ambil laundry
3. **Proses Cuci** - Laundry sedang dicuci
4. **Siap Antar** - Laundry siap diantar
5. **Selesai** - Transaksi selesai

## 💳 Metode Pembayaran

- **Tunai (COD)** - Bayar saat pengantaran
- **Transfer Bank** - Transfer setelah konfirmasi harga

## 🗂️ Struktur Database

### Tables Utama
- `users` - Data pengguna (admin, kurir, pelanggan)
- `pakets` - Paket laundry dan harga
- `transaksis` - Data transaksi utama
- `detail_transaksis` - Detail item transaksi
- `promos` - Data promo dan diskon
- `promo_claims` - Klaim promo pelanggan

## 🚀 Deployment

### Production Setup
1. Set `APP_ENV=production` di `.env`
2. Set `APP_DEBUG=false`
3. Configure database production
4. Run `php artisan config:cache`
5. Run `php artisan route:cache`
6. Run `php artisan view:cache`

### Server Requirements
- Apache/Nginx
- PHP 8.2+
- MySQL 8.0+
- SSL Certificate (recommended)

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 License

Distributed under the MIT License. See `LICENSE` for more information.

## 📞 Contact

**Developer:** Novandrya
- Email: novandriy4@gmail.com
- GitHub: [@novandrya1](https://github.com/novandrya1)

## 🙏 Acknowledgments

- [Laravel](https://laravel.com/) - PHP Framework
- [Bootstrap](https://getbootstrap.com/) - CSS Framework
- [Chart.js](https://www.chartjs.org/) - Charts Library
- [Bootstrap Icons](https://icons.getbootstrap.com/) - Icon Library

