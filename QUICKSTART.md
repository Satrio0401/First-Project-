# Quick Start Guide 🚀

## Instalasi Cepat

### 1. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 2. Konfigurasi Database di `.env`
```env
DB_CONNECTION=sqlite
# atau gunakan MySQL:
# DB_CONNECTION=mysql
# DB_DATABASE=organization_profile
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Setup Database & Data
```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

### 5. Build Assets
```bash
npm run build
# atau untuk development:
npm run dev
```

### 6. Jalankan Server
```bash
php artisan serve
```

## 🎯 Akses Aplikasi

### Frontend (Public)
- **URL**: http://localhost:8000
- **Halaman**: Beranda, Tentang, Pengurus, Berita, Program Kerja

### Admin Panel
- **URL**: http://localhost:8000/admin
- **Email**: admin@organization.com
- **Password**: password

## 📝 Data Dummy

Setelah seeding, sistem sudah terisi dengan:
- ✅ 1 Admin user
- ✅ 6 Data pengurus (4 inti, 2 divisi)
- ✅ 3 Berita (artikel & pengumuman)
- ✅ 4 Program kerja (2 aktif, 2 selesai)
- ✅ Pengaturan organisasi (visi, misi, sejarah)

## 🔧 Quick Commands

```bash
# Clear cache
php artisan optimize:clear

# Create new admin user
php artisan make:filament-user

# Reset database
php artisan migrate:fresh --seed

# Check routes
php artisan route:list
```

## 📱 Testing

1. Buka http://localhost:8000 - Lihat homepage
2. Navigasi ke semua menu - Cek responsiveness
3. Login ke /admin - Test CRUD operations
4. Coba search & filter di halaman Berita
5. Upload foto di Pengurus/Berita

## 🎨 Kustomisasi Cepat

### Ganti Nama Organisasi
Edit `.env`:
```env
APP_NAME="Nama Organisasi Anda"
```

### Update Konten
1. Login ke admin panel
2. Buka "Pengaturan Organisasi"
3. Edit Visi, Misi, Sejarah
4. Simpan!

### Tambah Pengurus
1. Admin → Pengurus → Create
2. Isi form (nama, jabatan, status)
3. Upload foto (optional)
4. Set urutan tampilan
5. Save!

### Tambah Berita
1. Admin → Berita → Create
2. Tulis judul (slug otomatis)
3. Pilih kategori
4. Tulis konten dengan WYSIWYG
5. Upload gambar
6. Publish!

## ⚡ Performance Tips

```bash
# Production optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

## 🆘 Troubleshooting

**Error 500?**
```bash
php artisan optimize:clear
composer dump-autoload
```

**Gambar tidak muncul?**
```bash
php artisan storage:link
```

**Style tidak load?**
```bash
npm run build
```

**Database error?**
```bash
php artisan migrate:fresh --seed
```

## 📚 Dokumentasi Lengkap

Lihat `README.md` untuk dokumentasi detail.

---

**Happy Coding! 🎉**
