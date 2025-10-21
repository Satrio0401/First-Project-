# Organization Profile System

Sistem Organization Profile terintegrasi menggunakan Laravel dengan Filament sebagai Admin Panel dan Livewire untuk Frontend publik.

## 🚀 Fitur Utama

### Admin Panel (Filament v4)
- ✅ **Manajemen Pengurus**: CRUD lengkap dengan upload foto, status (Pengurus Inti/Divisi), urutan tampilan
- ✅ **Manajemen Berita**: CRUD dengan WYSIWYG editor, auto-slug, kategori (Artikel/Pengumuman), view counter
- ✅ **Manajemen Program Kerja**: CRUD dengan status (Aktif/Selesai), periode program
- ✅ **Pengaturan Organisasi**: Visi, Misi, Sejarah, Sejarah Kepengurusan (repeater)
- ✅ Filter, search, sorting di semua resource
- ✅ Image editor terintegrasi
- ✅ Badge & color coding untuk status

### Frontend (Livewire)
- ✅ **Beranda**: Hero section, Visi/Misi, Berita terbaru, Program aktif, CTA
- ✅ **Tentang**: Visi, Misi, Sejarah, Sejarah Kepengurusan
- ✅ **Struktur Pengurus**: Tampilan hierarki (Pengurus Inti & Divisi)
- ✅ **Berita**: List dengan real-time search & filter, pagination, detail view
- ✅ **Program Kerja**: Tampilan program aktif & selesai
- ✅ Layout responsif dengan Tailwind CSS
- ✅ Navigasi sticky & mobile-friendly
- ✅ Footer informatif

## 📦 Teknologi

- **Framework**: Laravel 12
- **Admin Panel**: Filament v4.1
- **Frontend**: Livewire v3 + Volt
- **Styling**: Tailwind CSS
- **Database**: MySQL/SQLite
- **PHP**: 8.2+

## 🛠️ Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- Database (MySQL/SQLite)

### Langkah Instalasi

1. **Clone & Setup**
```bash
composer install
npm install
```

2. **Environment**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Database**
Konfigurasi database di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=organization_profile
DB_USERNAME=root
DB_PASSWORD=
```

4. **Migrate & Seed**
```bash
php artisan migrate:fresh --seed
```

5. **Build Assets**
```bash
npm run build
```

6. **Jalankan Server**
```bash
php artisan serve
```

## 🔐 Login Admin

Akses admin panel di: `http://localhost:8000/admin`

**Kredensial Default:**
- Email: `admin@organization.com`
- Password: `password`

## 📁 Struktur Database

### Tabel: `pengurus`
- `id`, `nama`, `jabatan`, `status` (Pengurus Inti/Divisi)
- `foto`, `urutan`, `is_active`
- `created_at`, `updated_at`

### Tabel: `berita`
- `id`, `judul`, `slug`, `konten`, `kategori` (Artikel/Pengumuman)
- `gambar`, `is_published`, `published_at`, `views`
- `created_at`, `updated_at`

### Tabel: `program_kerja`
- `id`, `nama`, `deskripsi`, `status` (Aktif/Selesai)
- `tanggal_mulai`, `tanggal_selesai`
- `created_at`, `updated_at`

### Tabel: `settings`
- `id`, `key`, `value`
- `created_at`, `updated_at`

## 🎯 Routing

### Public Routes
```php
GET  /                      // Beranda
GET  /tentang              // Tentang Kami
GET  /pengurus             // Struktur Pengurus
GET  /berita               // List Berita
GET  /berita/{slug}        // Detail Berita
GET  /program-kerja        // Program Kerja
```

### Admin Routes
```php
GET  /admin                // Dashboard
GET  /admin/login          // Login
GET  /admin/pengurus       // Manage Pengurus
GET  /admin/berita         // Manage Berita
GET  /admin/program-kerja  // Manage Program Kerja
GET  /admin/organization-settings  // Pengaturan Organisasi
```

## 🎨 Kustomisasi

### Warna Organisasi
Edit di `tailwind.config.js` untuk mengubah skema warna:
```js
colors: {
    primary: colors.blue,
    secondary: colors.indigo,
}
```

### Logo & Branding
- Logo: Tambahkan di `public/images/logo.png`
- Update nama di `.env`: `APP_NAME="Nama Organisasi"`

### Konten Footer
Edit di `resources/views/components/layouts/app.blade.php`

## 📸 Screenshot Fitur

### Admin Panel
- Dashboard dengan statistik
- Form dengan image editor
- Table dengan filter & search
- Settings page dengan repeater

### Frontend
- Hero section menarik
- Card design yang clean
- Responsive di semua device
- Loading states yang smooth

## 🔄 Update & Maintenance

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Optimize
```bash
php artisan optimize
npm run build
```

## 📝 Fitur Tambahan yang Bisa Dikembangkan

- [ ] Export data ke PDF/Excel
- [ ] Email notifications
- [ ] Social media integration
- [ ] Member area/portal
- [ ] Event management
- [ ] Gallery/photo album
- [ ] Testimonials
- [ ] Contact form
- [ ] Newsletter subscription
- [ ] Multi-language support

## 🐛 Troubleshooting

### Error: Class not found
```bash
composer dump-autoload
```

### Error: Storage link
```bash
php artisan storage:link
```

### Error: Permission denied
```bash
chmod -R 775 storage bootstrap/cache
```

## 📞 Support

Untuk pertanyaan dan dukungan, silakan hubungi:
- Email: admin@organization.com
- Website: http://localhost:8000

## 📄 License

Project ini menggunakan lisensi MIT.

---

**Dibuat dengan ❤️ menggunakan Laravel + Filament + Livewire**
