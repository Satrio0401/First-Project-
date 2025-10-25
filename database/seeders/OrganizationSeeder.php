<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Pengurus;
use App\Models\Berita;
use App\Models\ProgramKerja;
use App\Models\SejarahPengurus;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Settings
        Setting::create([
            'key' => 'visi',
            'value' => 'Menjadi organisasi yang terdepan dalam memberikan kontribusi positif bagi kemajuan masyarakat dan pembangunan berkelanjutan.'
        ]);
        Setting::create([
            'key' => 'misi',
            'value' => 'Menjadi organisasi yang terdepan dalam memberikan kontribusi positif bagi kemajuan masyarakat dan pembangunan berkelanjutan.Menjadi organisasi yang terdepan dalam memberikan kontribusi positif bagi kemajuan masyarakat dan pembangunan berkelanjutan.Menjadi organisasi yang terdepan dalam memberikan kontribusi positif bagi kemajuan masyarakat dan pembangunan berkelanjutan.Menjadi organisasi yang terdepan dalam memberikan kontribusi positif bagi kemajuan masyarakat dan pembangunan berkelanjutan.Menjadi organisasi yang terdepan dalam memberikan kontribusi positif bagi kemajuan masyarakat dan pembangunan berkelanjutan.'
        ]);


        Setting::create([
            'key' => 'sejarah',
            'value' => 'Organisasi kami didirikan pada tahun 2020 dengan semangat untuk memberikan kontribusi nyata bagi masyarakat. Berawal dari sekelompok individu yang memiliki visi yang sama, kami terus berkembang dan kini telah memiliki puluhan anggota aktif yang berdedikasi.Dalam perjalanannya, organisasi kami telah melaksanakan berbagai program dan kegiatan yang berdampak positif bagi masyarakat. Kami berkomitmen untuk terus berinovasi dan memberikan yang terbaik dalam setiap program yang kami jalankan.'
        ]);


        SejarahPengurus::create([
            'ketua' => 'Dr. Ahmad Wijaya',
            'wakil_ketua' => 'Siti Nurhaliza, M.Si',
            'periode_mulai' => '2020',
            'periode_berakhir' => '2022',
            'order_column' => 1,
        ]);
        SejarahPengurus::create([
            'ketua' => 'Dr. Ahmad Wijaya',
            'wakil_ketua' => 'Siti Nurhaliza, M.Si',
            'periode_mulai' => '2020',
            'periode_berakhir' => '2022',
            'order_column' => 2,
        ]);
        SejarahPengurus::create([
            'ketua' => 'Dr. Ahmad Wijaya',
            'wakil_ketua' => 'Siti Nurhaliza, M.Si',
            'periode_mulai' => '2020',
            'periode_berakhir' => '2022',
            'order_column' => 3,
        ]);
        SejarahPengurus::create([
            'ketua' => 'Dr. Ahmad Wijaya',
            'wakil_ketua' => 'Siti Nurhaliza, M.Si',
            'periode_mulai' => '2020',
            'periode_berakhir' => '2022',
            'order_column' => 4,
        ]);
        // Pengurus Inti
        Pengurus::create([
            'nama' => 'Dr. Ahmad Wijaya',
            'jabatan' => 'Ketua',
            'status' => 'Pengurus Inti',
            'urutan' => 1,
            'is_active' => true,
        ]);

        Pengurus::create([
            'nama' => 'Siti Nurhaliza, M.Si',
            'jabatan' => 'Wakil Ketua',
            'status' => 'Pengurus Inti',
            'urutan' => 2,
            'is_active' => true,
        ]);

        Pengurus::create([
            'nama' => 'Rahmat Hidayat, S.E',
            'jabatan' => 'Sekretaris',
            'status' => 'Pengurus Inti',
            'urutan' => 3,
            'is_active' => true,
        ]);

        Pengurus::create([
            'nama' => 'Indah Permata Sari, S.Ak',
            'jabatan' => 'Bendahara',
            'status' => 'Pengurus Inti',
            'urutan' => 4,
            'is_active' => true,
        ]);

        // Divisi

        Pengurus::create([
            'nama' => 'Maya Angelina',
            'jabatan' => 'Koordinator Humas',
            'status' => 'Divisi Humas',
            'urutan' => 5,
            'is_active' => true,
        ]);
        Pengurus::create([
            'nama' => 'Maya Angelina',
            'jabatan' => 'Koordinator Humas',
            'status' => 'Divisi Humas',
            'urutan' => 6,
            'is_active' => true,
        ]);
        Pengurus::create([
            'nama' => 'Maya Angelina',
            'jabatan' => 'Koordinator Humas',
            'status' => 'Divisi Humas',
            'urutan' => 7,
            'is_active' => true,
        ]);
        Pengurus::create([
            'nama' => 'Maya Angelina',
            'jabatan' => 'Koordinator Humas',
            'status' => 'Divisi Dokumentasi',
            'urutan' => 8,
            'is_active' => true,
        ]);
        Pengurus::create([
            'nama' => 'Maya Angelina',
            'jabatan' => 'Koordinator Humas',
            'status' => 'Divisi Dokumentasi',
            'urutan' => 9,
            'is_active' => true,
        ]);
        Pengurus::create([
            'nama' => 'Maya Angelina',
            'jabatan' => 'Koordinator Humas',
            'status' => 'Divisi Dokumentasi',
            'urutan' => 10,
            'is_active' => true,
        ]);
        Pengurus::create([
            'nama' => 'Maya Angelina',
            'jabatan' => 'Koordinator Humas',
            'status' => 'Divisi Usaha dan Dana',
            'urutan' => 11,
            'is_active' => true,
        ]);
        Pengurus::create([
            'nama' => 'Maya Angelina',
            'jabatan' => 'Koordinator Humas',
            'status' => 'Divisi Usaha dan Dana',
            'urutan' => 12,
            'is_active' => true,
        ]);
        Pengurus::create([
            'nama' => 'Maya Angelina',
            'jabatan' => 'Koordinator Humas',
            'status' => 'Divisi Usaha dan Dana',
            'urutan' => 13,
            'is_active' => true,
        ]);

        // Berita
        Berita::create([
            'judul' => 'Peluncuran Program Pemberdayaan Masyarakat 2025',
            'slug' => Str::slug('Peluncuran Program Pemberdayaan Masyarakat 2025'),
            'konten' => '<p>Organisasi kami dengan bangga mengumumkan peluncuran program pemberdayaan masyarakat tahun 2025. Program ini dirancang untuk memberikan pelatihan keterampilan dan pendampingan usaha kepada masyarakat kurang mampu.</p><p>Kegiatan ini akan melibatkan berbagai stakeholder termasuk pemerintah daerah, dunia usaha, dan lembaga pendidikan. Kami optimis program ini akan memberikan dampak yang signifikan bagi peningkatan kesejahteraan masyarakat.</p>',
            'kategori' => 'Artikel',
            'is_published' => true,
            'published_at' => now()->subDays(5),
            'views' => 125,
        ]);

        Berita::create([
            'judul' => 'Pengumuman: Rapat Anggota Tahunan 2025',
            'slug' => Str::slug('Pengumuman: Rapat Anggota Tahunan 2025'),
            'konten' => '<p><strong>Kepada Yth. Seluruh Anggota Organisasi</strong></p><p>Dengan hormat, kami mengundang seluruh anggota untuk menghadiri Rapat Anggota Tahunan (RAT) 2025 yang akan dilaksanakan pada:</p><ul><li>Hari/Tanggal: Sabtu, 25 Januari 2025</li><li>Waktu: 09.00 - 15.00 WIB</li><li>Tempat: Aula Kantor Pusat</li></ul><p>Agenda rapat meliputi laporan kegiatan, laporan keuangan, dan rencana program tahun 2025. Kehadiran Anda sangat kami harapkan.</p>',
            'kategori' => 'Pengumuman',
            'is_published' => true,
            'published_at' => now()->subDays(2),
            'views' => 245,
        ]);

        Berita::create([
            'judul' => 'Kegiatan Bakti Sosial di Desa Sukamaju',
            'slug' => Str::slug('Kegiatan Bakti Sosial di Desa Sukamaju'),
            'konten' => '<p>Tim relawan organisasi kami telah melaksanakan kegiatan bakti sosial di Desa Sukamaju pada hari Minggu, 15 Desember 2024. Kegiatan ini meliputi pembagian sembako, pemeriksaan kesehatan gratis, dan renovasi sekolah.</p><p>Kegiatan ini mendapat apresiasi tinggi dari masyarakat setempat dan pemerintah desa. Kami berterima kasih kepada semua pihak yang telah mendukung dan berpartisipasi dalam kegiatan ini.</p>',
            'kategori' => 'Artikel',
            'is_published' => true,
            'published_at' => now()->subDays(15),
            'views' => 89,
        ]);

        // Program Kerja
        ProgramKerja::create([
            'nama' => 'Pelatihan Kewirausahaan Digital',
            'deskripsi' => 'Program pelatihan kewirausahaan digital bagi UMKM yang meliputi digital marketing, e-commerce, dan manajemen bisnis online. Target peserta 100 orang UMKM di wilayah Jakarta.',
            'status' => 'Aktif',
            'tanggal_mulai' => now()->subMonths(1),
            'tanggal_selesai' => now()->addMonths(3),
        ]);

        ProgramKerja::create([
            'nama' => 'Gerakan Literasi Masyarakat',
            'deskripsi' => 'Program untuk meningkatkan minat baca masyarakat melalui pendirian taman bacaan, donasi buku, dan kegiatan storytelling untuk anak-anak di berbagai komunitas.',
            'status' => 'Aktif',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonths(6),
        ]);

        ProgramKerja::create([
            'nama' => 'Workshop Pengembangan SDM',
            'deskripsi' => 'Serangkaian workshop untuk pengembangan soft skills dan hard skills bagi anggota organisasi, meliputi leadership, communication, project management, dan technical skills.',
            'status' => 'Selesai',
            'tanggal_mulai' => now()->subMonths(6),
            'tanggal_selesai' => now()->subMonths(1),
        ]);

        ProgramKerja::create([
            'nama' => 'Kampanye Lingkungan Hijau',
            'deskripsi' => 'Program kampanye dan aksi nyata untuk pelestarian lingkungan termasuk penanaman pohon, pengolahan sampah, dan edukasi lingkungan kepada masyarakat.',
            'status' => 'Selesai',
            'tanggal_mulai' => now()->subMonths(8),
            'tanggal_selesai' => now()->subMonths(3),
        ]);
    }
}
