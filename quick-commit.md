# 🚀 Quick Commit Guide

## Cara Menggunakan Script Commit

### 🐧 Linux/Mac:
```bash
./commit.sh "pesan commit anda"
```

### 🪟 Windows:
```cmd
commit.bat "pesan commit anda"
```

## 📝 Contoh Penggunaan:

```bash
# Contoh commit fitur baru
./commit.sh "feat: menambahkan fitur notifikasi email"

# Contoh commit bug fix
./commit.sh "fix: memperbaiki error pada form login"

# Contoh commit update UI
./commit.sh "ui: memperbaiki responsive mobile dashboard"

# Contoh commit dokumentasi
./commit.sh "docs: update README dengan panduan instalasi"
```

## 🔧 Setup Sekali Saja:

### 1. Simpan Credentials (Opsional):
```bash
git config --global credential.helper store
```

### 2. Setup SSH Key (Recommended):
```bash
# Generate SSH key
ssh-keygen -t ed25519 -C "your_email@example.com"

# Copy public key
cat ~/.ssh/id_ed25519.pub

# Add ke GitHub Settings > SSH Keys
# Ubah remote ke SSH
git remote set-url origin git@github.com:Novandrya1/jasalaundry-system.git
```

## 📋 Apa yang Dilakukan Script:

1. ✅ **Check status** - Lihat perubahan yang ada
2. ✅ **Add all** - Tambahkan semua file yang berubah
3. ✅ **Commit** - Commit dengan pesan yang diberikan
4. ✅ **Push** - Push ke GitHub otomatis
5. ✅ **Show log** - Tampilkan 3 commit terakhir

## 🎯 Keuntungan:

- **Sekali setup**, pakai terus
- **Tidak perlu token** berulang kali
- **Otomatis** add, commit, push
- **Visual feedback** dengan warna
- **Error handling** yang jelas

## 🔒 Security Tips:

- Gunakan **SSH key** untuk keamanan terbaik
- Jangan share **Personal Access Token**
- Gunakan **credential helper** untuk menyimpan credentials lokal

---

**Happy Coding! 🎉**

<!-- SSH Test: Script sudah siap digunakan -->