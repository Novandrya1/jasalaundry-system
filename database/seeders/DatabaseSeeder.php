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

        // Buat Paket Laundry
        Paket::create([
            'nama_paket' => 'Cuci Kering',
            'harga_per_kg' => 5000,
            'deskripsi' => 'Layanan cuci dan kering pakaian',
            'satuan' => 'kg',
            'is_active' => true,
        ]);

        Paket::create([
            'nama_paket' => 'Cuci Setrika',
            'harga_per_kg' => 7000,
            'deskripsi' => 'Layanan cuci, kering, dan setrika pakaian',
            'satuan' => 'kg',
            'is_active' => true,
        ]);

        Paket::create([
            'nama_paket' => 'Cuci Express',
            'harga_per_kg' => 10000,
            'deskripsi' => 'Layanan cuci kilat selesai dalam 24 jam',
            'satuan' => 'kg',
            'is_active' => true,
        ]);

        Paket::create([
            'nama_paket' => 'Cuci Sepatu',
            'harga_per_kg' => 15000,
            'deskripsi' => 'Layanan cuci sepatu',
            'satuan' => 'pcs',
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
