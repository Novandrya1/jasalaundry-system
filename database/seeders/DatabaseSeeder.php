<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Paket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1',
        ]);

        // Buat Kurir
        User::create([
            'name' => 'Kurir Satu',
            'email' => 'kurir@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'kurir',
            'phone' => '081234567891',
            'address' => 'Jl. Kurir No. 1',
        ]);

        // Buat Pelanggan
        User::create([
            'name' => 'Pelanggan Test',
            'email' => 'pelanggan@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
            'phone' => '081234567892',
            'address' => 'Jl. Pelanggan No. 1',
        ]);

        // Buat Paket Laundry (8 paket sesuai dashboard)
        Paket::create([
            'nama_paket' => 'Cuci Kering + Setrika',
            'harga_per_kg' => 7000,
            'deskripsi' => 'Layanan cuci, kering, dan setrika lengkap',
            'satuan' => 'kg',
            'is_active' => true,
        ]);

        Paket::create([
            'nama_paket' => 'Laundry Cepat',
            'harga_per_kg' => 9000,
            'deskripsi' => 'Layanan laundry kilat selesai 1 hari',
            'satuan' => 'kg',
            'is_active' => true,
        ]);

        Paket::create([
            'nama_paket' => 'Setrika Wangi + Lipat',
            'harga_per_kg' => 5000,
            'deskripsi' => 'Layanan setrika dengan pewangi dan lipat rapi',
            'satuan' => 'kg',
            'is_active' => true,
        ]);

        Paket::create([
            'nama_paket' => 'Cuci Kering',
            'harga_per_kg' => 6000,
            'deskripsi' => 'Layanan cuci dan kering pakaian',
            'satuan' => 'kg',
            'is_active' => true,
        ]);

        Paket::create([
            'nama_paket' => 'Cuci Express',
            'harga_per_kg' => 13000,
            'deskripsi' => 'Layanan cuci express dengan antar jemput',
            'satuan' => 'kg',
            'is_active' => true,
        ]);

        Paket::create([
            'nama_paket' => 'Cuci Karpet & Bed Cover',
            'harga_per_kg' => 20000,
            'deskripsi' => 'Layanan cuci karpet dan bed cover',
            'satuan' => 'kg',
            'is_active' => true,
        ]);

        Paket::create([
            'nama_paket' => 'Setrika Wangi + Lipat (Antar)',
            'harga_per_kg' => 7500,
            'deskripsi' => 'Layanan setrika dengan antar jemput',
            'satuan' => 'kg',
            'is_active' => true,
        ]);

        Paket::create([
            'nama_paket' => 'Cuci Kering (Antar)',
            'harga_per_kg' => 6000,
            'deskripsi' => 'Layanan cuci kering dengan antar jemput',
            'satuan' => 'kg',
            'is_active' => true,
        ]);

        // Buat Promo
        \App\Models\Promo::create([
            'judul' => 'Promo Cuci Gratis Setrika!',
            'deskripsi' => 'Khusus bulan ini, setiap cuci 5kg gratis setrika! Hemat lebih banyak dengan JasaLaundry.',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(30),
            'is_active' => true,
        ]);

        \App\Models\Promo::create([
            'judul' => 'Diskon 20% Pelanggan Baru',
            'deskripsi' => 'Dapatkan diskon 20% untuk pemesanan pertama Anda. Syarat dan ketentuan berlaku.',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(60),
            'is_active' => true,
        ]);
    }
}
