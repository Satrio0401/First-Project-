# 📋 Saran Perbaikan Dashboard Filament - Web HMI

Dokumen ini berisi analisis dan rekomendasi perbaikan untuk Admin Panel Filament pada project Web HMI.

---

## 🔴 Prioritas Tinggi (Bug & Masalah Kritis)

### 1. Bug pada OrganizationSettings - Misi Tidak Tersimpan dengan Benar
**File:** `app/Filament/Pages/OrganizationSettings.php`

**Masalah:**
```php
$this->form->fill([
    'visi' => $settings['visi'] ?? '',
    'misi' => $settings['visi'] ?? '',  // ❌ BUG: Harusnya 'misi' bukan 'visi'
    'sejarah' => $settings['sejarah'] ?? '',
]);
```

**Solusi:**
```php
$this->form->fill([
    'visi' => $settings['visi'] ?? '',
    'misi' => $settings['misi'] ?? '',  // ✅ PERBAIKAN
    'sejarah' => $settings['sejarah'] ?? '',
]);
```

---

### 2. KomisariatChart Tidak Sesuai dengan Nama
**File:** `app/Filament/Widgets/KomisariatChart.php`

**Masalah:**
- Nama widget adalah "KomisariatChart" tapi menampilkan data berdasarkan `tahun_lk1`, bukan komisariat
- Heading masih default "Komisariat Chart"

**Solusi:**
- Rename menjadi `TahunLK1Chart` atau ubah query untuk menampilkan data per komisariat
- Jika ingin tetap per tahun LK1, ganti nama dan heading:
```php
protected ?string $heading = 'Jumlah Anggota per Tahun LK1';
```

---

### 3. Tidak Ada Validasi Form di OrganizationSettings
**File:** `app/Filament/Pages/OrganizationSettings.php`

**Masalah:**
- Form tidak memiliki validasi `required()` untuk field penting
- Tidak ada konfirmasi sebelum menyimpan

**Solusi:**
```php
Textarea::make('visi')
    ->label('Visi Organisasi')
    ->required()  // Tambahkan validasi
    ->rows(4)
    ->columnSpanFull(),
```

---

## 🟡 Prioritas Sedang (Peningkatan Fungsionalitas)

### 4. Tambah Widget Anggota pada Dashboard
**Rekomendasi:**
Tambah statistik anggota di `StatsOverview`:
```php
Stat::make('Total Anggota', Anggota::count())
    ->description('Jumlah seluruh anggota terdaftar')
    ->descriptionIcon('heroicon-m-user-group')
    ->color('primary'),

Stat::make('Anggota Baru Bulan Ini', Anggota::whereMonth('created_at', now()->month)->count())
    ->description('Pendaftaran bulan ' . now()->translatedFormat('F'))
    ->descriptionIcon('heroicon-m-arrow-trending-up')
    ->color('success'),
```

---

### 5. Tambah Filter pada AnggotasTable
**File:** `app/Filament/Resources/Anggotas/Tables/AnggotasTable.php`

**Rekomendasi:**
```php
->filters([
    SelectFilter::make('komisariat_id')
        ->label('Komisariat')
        ->relationship('komisariat', 'nama'),
    
    SelectFilter::make('jurusan_id')
        ->label('Jurusan')
        ->relationship('jurusan', 'nama_jurusan'),
    
    SelectFilter::make('kelamin')
        ->label('Jenis Kelamin')
        ->options([
            'Laki-laki' => 'Laki-laki',
            'Perempuan' => 'Perempuan',
        ]),
    
    Filter::make('tahun_lk1')
        ->form([
            TextInput::make('tahun_lk1_from')->numeric()->label('Tahun LK1 Dari'),
            TextInput::make('tahun_lk1_to')->numeric()->label('Tahun LK1 Sampai'),
        ]),
])
```

---

### 6. Tambah Export Excel pada Lebih Banyak Resource
**Masalah:**
- Hanya `AnggotaResource` yang memiliki export
- Resource lain belum memiliki fitur export

**Rekomendasi:**
Tambahkan export action pada:
- `BeritaResource`
- `PengurusResource`
- `ProgramKerjaResource`

---

### 7. Tambah Soft Deletes dan Activity Log
**Rekomendasi:**
- Implementasikan soft deletes pada model penting
- Gunakan `spatie/laravel-activitylog` untuk tracking perubahan data

---

### 8. Tambah View Action pada Resources
**Masalah:**
- Beberapa resource hanya memiliki Edit, tidak ada View/Detail

**Rekomendasi:**
Tambahkan halaman View:
```php
public static function getPages(): array
{
    return [
        'index' => ListBeritas::route('/'),
        'create' => CreateBerita::route('/create'),
        'view' => ViewBerita::route('/{record}'),  // Tambahkan
        'edit' => EditBerita::route('/{record}/edit'),
    ];
}
```

---

## 🟢 Prioritas Rendah (Peningkatan UX)

### 9. Tambah Global Search
**Rekomendasi:**
Aktifkan global search dengan menambahkan `$recordTitleAttribute` pada setiap resource:
```php
protected static ?string $recordTitleAttribute = 'nama';

public static function getGloballySearchableAttributes(): array
{
    return ['nama', 'alamat', 'no_wa'];
}
```

---

### 10. Perbaiki Navigation Groups
**Masalah:**
- Beberapa resource masuk ke grup "Settings" padahal bukan settings
- Navigation group tidak konsisten

**Rekomendasi:**
```php
// Grup yang lebih baik:
// - "Master Data": Anggota, Jurusan, Komisariat
// - "Konten": Berita, Galeri, Program Kerja
// - "Organisasi": Pengurus, Sejarah
// - "Pengaturan": Users, Settings
```

---

### 11. Tambah Breadcrumbs Dinamis
**Rekomendasi:**
Tambahkan breadcrumb yang lebih informatif pada halaman detail/edit.

---

### 12. Tambah Konfirmasi Delete
**Masalah:**
- Beberapa delete action tidak memiliki konfirmasi

**Solusi:**
```php
DeleteAction::make()
    ->requiresConfirmation()
    ->modalHeading('Hapus Data')
    ->modalDescription('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')
    ->modalSubmitActionLabel('Ya, Hapus'),
```

---

### 13. Tambah Widget Chart untuk Berita
**Rekomendasi:**
Tambah chart statistik berita per bulan:
```php
class BeritaChart extends ChartWidget
{
    protected ?string $heading = 'Berita per Bulan';
    
    protected function getData(): array
    {
        $data = Berita::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        // ...
    }
}
```

---

### 14. Perbaiki Form GaleriImages
**File:** `app/Filament/Resources/Galeris/Schemas/GaleriForm.php`

**Rekomendasi:**
Tambahkan field caption/keterangan untuk setiap gambar:
```php
Repeater::make('images')
    ->relationship()
    ->schema([
        FileUpload::make('path')
            ->label('Unggah Gambar')
            ->image()
            ->directory('galeri-images')
            ->imageEditor(),
        TextInput::make('caption')  // Tambahkan caption
            ->label('Keterangan Gambar')
            ->maxLength(255),
    ])
```

---

### 15. Tambah Dashboard Khusus per Role
**Rekomendasi:**
Buat dashboard berbeda untuk setiap role:
- **Super Admin**: Statistik lengkap semua data
- **Admin Komisariat**: Statistik anggota komisariatnya saja
- **Anggota**: Profil pribadi dan informasi terbaru

---

## 🛡️ Keamanan

### 16. Tambah Policy pada Semua Resource
**Masalah:**
- Beberapa resource belum memiliki policy yang lengkap

**Rekomendasi:**
Pastikan setiap resource memiliki policy dengan method:
- `viewAny`, `view`, `create`, `update`, `delete`, `restore`, `forceDelete`

---

### 17. Tambah Rate Limiting pada Login
**Rekomendasi:**
Implementasikan rate limiting untuk mencegah brute force attack.

---

### 18. Validasi File Upload Lebih Ketat
**Rekomendasi:**
```php
FileUpload::make('foto')
    ->image()
    ->maxSize(2048)
    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
    ->imageResizeMode('cover')
    ->imageCropAspectRatio('1:1')
    ->imageResizeTargetWidth('500')
    ->imageResizeTargetHeight('500'),
```

---

## 📊 Ringkasan Prioritas

| Prioritas | Jumlah | Deskripsi |
|-----------|--------|-----------|
| 🔴 Tinggi | 3 | Bug kritis yang harus segera diperbaiki |
| 🟡 Sedang | 5 | Peningkatan fungsionalitas penting |
| 🟢 Rendah | 10 | Peningkatan UX dan fitur tambahan |

---

## ✅ Checklist Implementasi

- [ ] Fix bug misi di OrganizationSettings
- [ ] Perbaiki nama dan query KomisariatChart
- [ ] Tambah validasi form OrganizationSettings
- [ ] Tambah widget statistik anggota
- [ ] Tambah filter pada AnggotasTable
- [ ] Tambah export Excel pada resource lain
- [ ] Implementasi soft deletes
- [ ] Tambah View page pada resources
- [ ] Aktifkan global search
- [ ] Reorganisasi navigation groups
- [ ] Tambah konfirmasi delete
- [ ] Tambah chart berita per bulan
- [ ] Tambah caption pada galeri images
- [ ] Buat dashboard per role
- [ ] Lengkapi policies
- [ ] Validasi file upload lebih ketat

---

*Dokumen ini dibuat pada: 4 Desember 2025*
