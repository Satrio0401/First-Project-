<div>

    <section class="bg-linear-to-r from-emerald-700 via-green-800 to-teal-900 text-white py-20">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center px-6 md:px-12">
            
            <!-- Teks Kiri -->
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                    Selamat Datang di Website Official<br>
                    <span class="text-emerald-300">HMI Cabang Pontianak</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-200 mb-8">
                    Wadah perjuangan mahasiswa Islam dalam mewujudkan insan akademis, pencipta, pengabdi yang bernafaskan Islam.
                </p>
                <div class="flex space-x-4">
                    <a href="{{ route('tentang') }}" 
                       class="bg-white text-green-800 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition">
                        Tentang Kami
                    </a>
                    <a href="{{ route('berita.index') }}" 
                       class="bg-emerald-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-emerald-500 transition">
                        Berita Terbaru
                    </a>
                </div>
            </div>
    
            <!-- Ilustrasi / Logo Kanan -->
            <div class="md:w-1/2 flex justify-center">
                <img src="LOGO-HMI.webp" alt="Ilustrasi HMI" class="w-50 md:w-50 drop-shadow-xl">
            </div>
        </div>
    </section>
    
    
    
    
    <div class="reveal py-16 bg-white opacity-0 translate-y-10 transition-all duration-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                
                <!-- Bagian Teks -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Tentang Kami</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        HMI Cabang Pontianak adalah organisasi mahasiswa yang berfokus pada pengembangan
                        kepemimpinan, intelektualitas, dan pengabdian masyarakat. Kami aktif menyelenggarakan
                        program pendidikan, seminar, dan kegiatan sosial untuk membentuk kader berkualitas,
                        kreatif, dan berintegritas.
                    </p>
    
                    <a href="#program" 
                       class="inline-block bg-green-700 hover:bg-green-800 text-white font-medium px-6 py-3 rounded-lg transition">
                        Pelajari Program Kami
                    </a>
                </div>
    
<!-- Bagian Ilustrasi -->
<div class="flex justify-center">
    <div class="overflow-hidden border-4 border-green-500 rounded-lg w-full max-w-md">
        <img 
            src="hmi.jpg" 
            alt="Ilustrasi Organisasi" 
            class="w-full h-auto object-cover transform transition-transform duration-500 hover:scale-105 hover:rotate-2"
        >
    </div>
</div>

    
            </div>
        </div>
    </div>
     

    {{-- <!-- Visi Misi Section -->
    @if($visi || $misi)
    <div class="reveal py-16 bg-white opacity-0 translate-y-10 transition-all duration-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @if($visi)
                <div class="bg-blue-50 p-8 rounded-lg">
                    <h2 class="text-2xl font-bold text-blue-900 mb-4">Visi</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $visi }}</p>
                </div>
                @endif
                
                @if($misi)
                <div class="bg-indigo-50 p-8 rounded-lg">
                    <h2 class="text-2xl font-bold text-indigo-900 mb-4">Misi</h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $misi }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif --}}

    @if($pengumuman->count() > 0)
    <div class="reveal py-16 bg-yellow-50 opacity-0 translate-y-10 transition-all duration-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Pengumuman Terbaru</h2>
                <a href="{{ route('berita.index', ['kategori' => 'Pengumuman']) }}" class="text-[#0a826c] hover:text-[#086b57] font-semibold">
                    Lihat Semua →
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($pengumuman as $berita)
                <a href="{{ route('berita.show', $berita->slug) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    @if($berita->gambar)
                    <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">No Image</span>
                    </div>
                    @endif
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full mb-2 bg-yellow-100 text-yellow-800">
                            {{ $berita->kategori }}
                        </span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $berita->judul }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $berita->excerpt }}</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $berita->published_at->format('d M Y') }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    

    @if($artikel->count() > 0)
    <div class="reveal py-16 bg-gray-50 opacity-0 translate-y-10 transition-all duration-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Artikel Terbaru</h2>
                <a href="{{ route('berita.index', ['kategori' => 'Artikel']) }}" class="text-[#0a826c] hover:text-[#086b57] font-semibold">
                    Lihat Semua →
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($artikel as $berita)
                <a href="{{ route('berita.show', $berita->slug) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    @if($berita->gambar)
                    <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">No Image</span>
                    </div>
                    @endif
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full mb-2 bg-blue-100 text-blue-800">
                            {{ $berita->kategori }}
                        </span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $berita->judul }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $berita->excerpt }}</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $berita->published_at->format('d M Y') }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    

    <!-- Program Kerja Aktif Section -->
    @if($programKerjaAktif->count() > 0)
    <div class="reveal py-16 bg-white opacity-0 translate-y-10 transition-all duration-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Program Kerja Aktif</h2>
                <a href="{{ route('program-kerja') }}" class="text-[#0a826c] hover:text-[#086b57] font-semibold"
                >
                    Lihat Semua →
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($programKerjaAktif as $program)
                <div class="bg-linear-to-br from-green-50 to-green-100 p-6 rounded-lg border border-green-200">
                    <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-500 text-white rounded-full mb-4">Aktif</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $program->nama }}</h3>
                    <p class="text-gray-700 mb-4">{{ Str::limit($program->deskripsi, 150) }}</p>
                    @if($program->tanggal_mulai || $program->tanggal_selesai)
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold">Periode:</span>
                        {{ $program->tanggal_mulai->format('d M Y') }} - {{ $program->tanggal_selesai->format('d M Y') }}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- CTA Section -->
    <div class="reveal bg-linear-to-r from-indigo-600 to-purple-700 text-white py-16 opacity-0 translate-y-10 transition-all duration-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Ingin Bergabung dengan Kami?</h2>
            <p class="text-xl text-indigo-100 mb-8">
                Jadilah bagian dari perubahan positif untuk masa depan yang lebih baik
            </p>
            <a href="{{ route('tentang') }}" wire:navigate class="inline-block bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-indigo-50 transition">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>

</div>
