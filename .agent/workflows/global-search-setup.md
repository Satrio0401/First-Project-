---
description: Konfigurasi Global Search di Filament Admin Panel
---

# Global Search di Filament Admin Panel

## Fitur yang Ditambahkan

Global search telah diaktifkan untuk mencari data dari **8 model utama**:
- **Anggota**
- **Komisariat**
- **Jurusan**
- **Berita**
- **Galeri**
- **Pengurus**
- **Program Kerja**
- **User**

**Note:** `TestingMap` resource **tidak** termasuk dalam global search (sudah di-exclude).

## Kolom yang Dapat Dicari

### 1. Anggota
- Nama
- Alamat
- No. WhatsApp
- Tempat Lahir
- Nama Jurusan (relasi)
- Nama Komisariat (relasi)

**Detail yang ditampilkan:**
- Jurusan
- Komisariat
- No. WA

### 2. Komisariat
- Nama
- Alamat

**Detail yang ditampilkan:**
- Alamat
- Jumlah Anggota

### 3. Jurusan
- Nama Jurusan

**Detail yang ditampilkan:**
- Jumlah Anggota

### 4. Berita
- Judul
- Konten

**Detail yang ditampilkan:**
- Tanggal Publikasi

### 5. Galeri
- Judul
- Deskripsi

**Detail yang ditampilkan:**
- Tanggal Upload

### 6. Pengurus
- Nama
- Jabatan

**Detail yang ditampilkan:**
- Jabatan
- Status (Pengurus Inti/Divisi)

### 7. Program Kerja
- Nama
- Deskripsi

**Detail yang ditampilkan:**
- Status (Aktif/Selesai)
- Tanggal Mulai

### 8. User
- Email
- Nama Anggota (relasi)

**Detail yang ditampilkan:**
- Nama
- Email

## Cara Menggunakan

1. Buka Filament Admin Panel di browser
2. Lihat search bar di bagian atas navbar (biasanya di kanan atas)
3. Ketik kata kunci yang ingin dicari
4. Hasil pencarian akan muncul secara real-time dari ketiga model
5. Klik hasil pencarian untuk langsung membuka detail record tersebut

## File yang Dimodifikasi

1. `app/Providers/Filament/AdminPanelProvider.php`
   - Menghapus `->globalSearch(false)` untuk mengaktifkan fitur

2. `app/Filament/Resources/Anggotas/AnggotaResource.php`
   - Menambahkan `$globalSearchAttributes`
   - Menambahkan `getGlobalSearchResultDetails()`

3. `app/Filament/Resources/Komisariats/KomisariatResource.php`
   - Menambahkan `$globalSearchAttributes`
   - Menambahkan `getGlobalSearchResultDetails()`

4. `app/Filament/Resources/Jurusans/JurusanResource.php`
   - Menambahkan `$globalSearchAttributes`
   - Menambahkan `getGlobalSearchResultDetails()`

5. `app/Filament/Resources/Beritas/BeritaResource.php`
   - Menambahkan `$recordTitleAttribute`
   - Menambahkan `$globalSearchAttributes`
   - Menambahkan `getGlobalSearchResultDetails()`

6. `app/Filament/Resources/Galeris/GaleriResource.php`
   - Menambahkan `$globalSearchAttributes`
   - Menambahkan `getGlobalSearchResultDetails()`

7. `app/Filament/Resources/Penguruses/PengurusResource.php`
   - Menambahkan `$recordTitleAttribute`
   - Menambahkan `$globalSearchAttributes`
   - Menambahkan `getGlobalSearchResultDetails()`

8. `app/Filament/Resources/ProgramKerjas/ProgramKerjaResource.php`
   - Menambahkan `$recordTitleAttribute`
   - Menambahkan `$globalSearchAttributes`
   - Menambahkan `getGlobalSearchResultDetails()`

9. `app/Filament/Resources/Users/UserResource.php`
   - Mengubah `$recordTitleAttribute` dari 'user' ke 'email'
   - Menambahkan `$globalSearchAttributes`
   - Menambahkan `getGlobalSearchResultDetails()`

10. `app/Filament/Resources/TestingMaps/TestingMapResource.php`
    - Menambahkan `$isGloballySearchable = false` untuk menonaktifkan global search

## Cara Menonaktifkan Global Search untuk Resource Tertentu

Jika Anda ingin menonaktifkan global search untuk Resource tertentu (seperti TestingMap), tambahkan property berikut di Resource class:

```php
protected static bool $isGloballySearchable = false;
```

Contoh:
```php
class TestingMapResource extends Resource
{
    protected static ?string $model = TestingMap::class;
    
    // Disable global search
    protected static bool $isGloballySearchable = false;
    
    // ... rest of the code
}
```

## Catatan

- Global search akan tetap mematuhi batasan akses yang sudah dikonfigurasi (role-based access)
- Untuk Anggota, pencarian juga akan mencari di data relasi (jurusan dan komisariat)
- Hasil pencarian menampilkan informasi tambahan yang relevan untuk memudahkan identifikasi
