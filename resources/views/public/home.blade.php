@extends('layouts.public')

@section('title', 'Sistem Informasi LPKIA - Unggul & Profesional')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    .swiper-container {
        width: 100%;
        padding-bottom: 50px;
    }
    .swiper-slide {
        display: flex;
        height: auto;
    }
    .swiper-pagination-bullet-active {
        background: var(--primary);
    }
</style>
@endsection

@section('content')

    <!-- Hero Section -->
    <section class="hero-section" style="position: relative; overflow: hidden; padding: 120px 0; background: none;">
        @php
            $heroImagesRaw = \App\Models\Setting::get('home_hero_images', json_encode(['images/tech_hero.png']));
            $heroImages = json_decode($heroImagesRaw, true);
            if (!is_array($heroImages) || empty($heroImages)) {
                $heroImages = ['images/tech_hero.png'];
            }
        @endphp

        <!-- Background Image Slider -->
        <div class="hero-slider-container" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; overflow: hidden;">
            <div class="hero-slider" style="width: 100%; height: 100%; display: flex; transition: transform 0.5s ease-in-out;">
                @foreach($heroImages as $img)
                    <div class="slide" style="min-width: 100%; height: 100%; flex-shrink: 0;">
                        <img src="{{ asset($img) }}" alt="Sistem Informasi LPKIA" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                @endforeach
            </div>
            <!-- Overlay to ensure text readability -->
            <div class="hero-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(30, 41, 59, 0.85) 0%, rgba(15, 23, 42, 0.75) 100%);"></div>
        </div>

        <!-- Content Area -->
        <div class="container" style="position: relative; z-index: 2;">
            <div class="hero-content" style="max-width: 800px;">
                <h2 style="color: #ffffff; font-size: 3rem; font-weight: 800; line-height: 1.25; margin-bottom: 25px;">{{ \App\Models\Setting::get('home_hero_title', 'Sistem Informasi LPKIA') }}</h2>
                <p style="font-size: 1.15rem; color: rgba(255,255,255,0.9); margin-bottom: 35px; line-height: 1.7;">{{ \App\Models\Setting::get('home_hero_text', 'Menciptakan Profesional IT Global di Bidang Tata Kelola & Analitik Data. Menghasilkan lulusan yang siap bersaing dalam era ekonomi digital dengan kurikulum berbasis industri.') }}</p>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="#kurikulum" class="btn btn-secondary">
                        <i class="fa-solid fa-graduation-cap"></i> Lihat Kurikulum
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation Dots -->
        @if(count($heroImages) > 1)
            <style>
                .slider-dots .dot.active {
                    background-color: #ffffff !important;
                    transform: scale(1.2);
                    box-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
                }
            </style>
            <div class="slider-dots" style="position: absolute; bottom: 25px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 3;">
                @foreach($heroImages as $idx => $img)
                    <span class="dot {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}" style="width: 10px; height: 10px; border-radius: 50%; background-color: rgba(255,255,255,0.4); cursor: pointer; transition: all 0.3s ease;"></span>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Shortcut Menu Section -->
    <section class="shortcuts-section" id="shortcut-menu">
        <div class="container">
            <div class="shortcuts-grid">
                
                <a href="#jadwal" class="shortcut-card">
                    <div class="shortcut-icon">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <h3>Jadwal Perkuliahan</h3>
                    <p>Lihat dan pantau jadwal kelas harian Program Studi Sistem Informasi secara berkala.</p>
                </a>

                <div class="shortcut-card" onclick="alert('Kalender Akademik Semester Ganjil 2026/2027 telah diunggah ke area download. Silakan scroll ke bawah untuk mengunduh.')" style="cursor: pointer;">
                    <div class="shortcut-icon">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <h3>Kalender Akademik</h3>
                    <p>Pantau tanggal registrasi, UTS/UAS, libur akademik, dan agenda wisuda terbaru.</p>
                </div>

                <a href="{{ route('login') }}" class="shortcut-card">
                    <div class="shortcut-icon">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <h3>Portal Mahasiswa</h3>
                    <p>Masuk ke portal kemahasiswaan untuk monitoring KRS, nilai, dan tugas kuliah.</p>
                </a>

            </div>
        </div>
    </section>

    <!-- Profile & Organization Section -->
    <section class="content-section">
        <div class="container">
            <div class="grid-2-col" style="align-items: center; margin-bottom: 60px;">
                <div>
                    <h2 style="font-size: 2.2rem; color: var(--primary-dark); margin-bottom: 20px; line-height: 1.2;">
                        Membangun Kompetensi <span style="color: var(--secondary)">Masa Depan</span>
                    </h2>
                    <p style="font-size: 1.05rem; color: var(--text-muted); margin-bottom: 15px;">
                        Program Studi Sistem Informasi LPKIA memadukan ilmu teknologi komputer dengan pemahaman bisnis korporasi. Fokus kami adalah membekali mahasiswa dengan keahlian praktis dalam menganalisis data bisnis, mengelola tata kelola IT (IT Governance), dan merancang sistem perangkat lunak yang andal.
                    </p>
                    <p style="font-size: 1.05rem; color: var(--text-muted);">
                        Lulusan kami dipersiapkan untuk menjadi Systems Analyst, Data Scientist, IT Consultant, serta Technopreneur yang siap memimpin revolusi industri digital.
                    </p>
                </div>
                <div style="background-color: var(--bg-white); padding: 40px; border-radius: var(--border-radius-lg); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
                    <h3 style="font-size: 1.3rem; color: var(--primary); margin-bottom: 20px;"><i class="fa-solid fa-bullseye"></i> Visi Program Studi</h3>
                    <p style="font-style: italic; font-size: 1.1rem; color: var(--text-dark); line-height: 1.7; margin-bottom: 25px;">
                        "Menjadi program studi sistem informasi yang unggul secara nasional dalam menghasilkan profesional IT yang berkarakter, ahli di bidang tata kelola dan analitik data digital pada tahun 2030."
                    </p>
                    <h3 style="font-size: 1.3rem; color: var(--primary); margin-bottom: 15px;"><i class="fa-solid fa-list-check"></i> Misi Utama</h3>
                    <ul style="list-style: none; padding-left: 0; font-size: 0.95rem; color: var(--text-muted);">
                        <li style="margin-bottom: 8px;"><i class="fa-solid fa-circle-check" style="color:var(--success); margin-right: 8px;"></i> Menyelenggarakan pendidikan berkualitas berbasis praktik.</li>
                        <li style="margin-bottom: 8px;"><i class="fa-solid fa-circle-check" style="color:var(--success); margin-right: 8px;"></i> Melakukan penelitian inovatif yang berkontribusi bagi masyarakat.</li>
                        <li><i class="fa-solid fa-circle-check" style="color:var(--success); margin-right: 8px;"></i> Menjalin kemitraan strategis dengan industri startup IT global.</li>
                    </ul>
                </div>
            </div>

            <!-- Organization Structure -->
            <h2 class="section-title">Struktur Organisasi Program Studi</h2>
            <div class="org-grid">
                @forelse($orgMembers as $index => $member)
                    <div class="org-card">
                        <div class="org-avatar" style="color: {{ $index === 1 ? 'var(--secondary)' : ($index === 2 ? 'var(--success)' : 'var(--primary)') }}; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            @if($member->photo)
                                <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fa-solid {{ $index === 2 ? 'fa-users-gear' : ($index === 1 ? 'fa-user-gear' : 'fa-user-tie') }}"></i>
                            @endif
                        </div>
                        <h4>{{ $member->name }}</h4>
                        <div class="role">{{ $member->role }}</div>
                        @if($member->nip)
                            <div class="nip">NIP. {{ $member->nip }}</div>
                        @endif
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 20px;">
                        Struktur organisasi belum diatur.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Faculty/Lecturer Section (Interactive Filter) -->
    <section class="content-section" style="background-color: var(--bg-white);">
        <div class="container">
            <h2 class="section-title">Dosen Ahli & Pengajar</h2>
            <p style="text-align: center; color: var(--text-muted); max-width: 600px; margin: -20px auto 40px; font-size: 0.95rem;">
                Dosen kami merupakan praktisi berpengalaman dan akademisi yang kompeten di bidang teknologi sistem informasi.
            </p>

            <!-- Interactive Filter tabs -->
            <div class="filter-tabs">
                <button type="button" class="filter-btn active" onclick="filterLecturers('all', this)">Semua Bidang</button>
                <button type="button" class="filter-btn" onclick="filterLecturers('data', this)">Data Science & Analytics</button>
                <button type="button" class="filter-btn" onclick="filterLecturers('dev', this)">Software Engineering</button>
                <button type="button" class="filter-btn" onclick="filterLecturers('gov', this)">IT Governance</button>
            </div>

            <!-- Lecturers Grid -->
            <div class="lecturer-grid" id="lecturerGrid">
                @forelse($lecturers as $lecturer)
                    @php
                        $categories = $lecturer->expertises->pluck('category')->map(function($c) { return strtolower($c); })->toArray();
                        $dataExpert = implode(',', $categories);
                        
                        $firstCategory = count($categories) > 0 ? $categories[0] : 'other';
                        $expertColor = $firstCategory === 'dev' ? 'var(--secondary)' : ($firstCategory === 'data' ? 'var(--success)' : 'var(--primary)');
                    @endphp
                    <div class="lecturer-card" data-expert="{{ $dataExpert }}">
                        @if($lecturer->photo)
                            <img src="{{ asset($lecturer->photo) }}" alt="{{ $lecturer->name }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; display: inline-block; border: 2px solid var(--border-color);">
                        @else
                            <i class="fa-solid fa-user-circle fa-4x" style="color: {{ $expertColor }}; margin-bottom: 15px; display: block;"></i>
                        @endif
                        <h4>{{ $lecturer->name }}</h4>
                        
                        <div style="display: flex; gap: 5px; flex-wrap: wrap; justify-content: center; margin-top: 8px;">
                            @forelse($lecturer->expertises as $exp)
                                @php
                                    $expCat = strtolower($exp->category);
                                    $color = $expCat === 'dev' ? 'var(--secondary)' : ($expCat === 'data' ? 'var(--success)' : 'var(--primary)');
                                @endphp
                                <span class="badge" style="background-color: {{ $color }}; color: white; padding: 4px 10px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    {{ $exp->name }}
                                </span>
                            @empty
                                <span class="badge" style="background-color: var(--text-light); color: white; padding: 4px 10px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-block;">
                                    Umum
                                </span>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 30px;">
                        Data dosen belum tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Academics, Downloads & Schedule Table -->
    <section class="content-section" id="kurikulum">
        <div class="container">
            <div class="grid-2-col" style="margin-bottom: 60px;">
                <!-- Download Area -->
                <div>
                    <h3 style="font-size: 1.5rem; color: var(--primary-dark); margin-bottom: 15px;">
                        <i class="fa-solid fa-circle-down"></i> Area Unduhan (Download Area)
                    </h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 25px;">
                        Unduh berkas dokumen kurikulum, silabus pembelajaran, dan regulasi akademik Program Studi Sistem Informasi LPKIA.
                    </p>
                    
                    <div class="download-grid">
                        <div class="download-card">
                            <div class="download-info">
                                <i class="fa-solid fa-file-pdf"></i>
                                <div>
                                    <h5>Kurikulum SI 2026.pdf</h5>
                                    <p>Ukuran: 1.2 MB | Versi Terbaru</p>
                                </div>
                            </div>
                            <a href="#" onclick="alert('Mengunduh dokumen Kurikulum SI 2026.pdf (Simulasi)')" class="btn btn-primary btn-sm btn-icon" title="Download">
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </div>

                        <div class="download-card">
                            <div class="download-info">
                                <i class="fa-solid fa-file-pdf"></i>
                                <div>
                                    <h5>Silabus & RPS.pdf</h5>
                                    <p>Ukuran: 840 KB | Update Terbaru</p>
                                </div>
                            </div>
                            <a href="#" onclick="alert('Mengunduh dokumen Rencana Pembelajaran Semester.pdf (Simulasi)')" class="btn btn-primary btn-sm btn-icon" title="Download">
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Academic Calendar alert info -->
                <div style="background: linear-gradient(135deg, #0d1e33 0%, var(--primary-dark) 100%); color: white; padding: 40px; border-radius: var(--border-radius-lg); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; justify-content: center;">
                    <h4 style="color: var(--secondary); font-size: 1.25rem; margin-bottom: 15px;"><i class="fa-solid fa-bullhorn"></i> Pengumuman Akademik</h4>
                    <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 20px;">
                        Perkuliahan Semester Ganjil Tahun Akademik 2026/2027 akan dimulai pada hari <strong>Senin, 1 September 2026</strong>. Mahasiswa diwajibkan menyelesaikan perwalian KRS paling lambat tanggal 25 Agustus 2026.
                    </p>
                    <a href="#jadwal" class="btn btn-secondary btn-sm" style="align-self: flex-start;">
                        <i class="fa-solid fa-arrow-down"></i> Lihat Jadwal Kelas
                    </a>
                </div>
            </div>

            <!-- Class Schedule Table -->
            <div id="jadwal">
                <h2 class="section-title">Jadwal Kelas Semester Ganjil</h2>
                <p style="text-align: center; color: var(--text-muted); max-width: 600px; margin: -20px auto 30px; font-size: 0.95rem;">
                    Jadwal kuliah mingguan mahasiswa Program Studi Sistem Informasi. Gunakan gulir horizontal di perangkat seluler.
                </p>

                <div class="table-wrapper">
                    <table class="responsive-table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam Kuliah</th>
                                <th>Mata Kuliah</th>
                                <th>Dosen Pengampu</th>
                                <th>Ruangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $scheduleJson = \App\Models\Setting::get('class_schedule');
                                $schedules = $scheduleJson ? json_decode($scheduleJson, true) : [
                                    ["hari" => "Senin", "jam" => "08:00 - 10:30", "matkul" => "Big Data Analytics", "dosen" => "Hesti Lestari, M.C.S.", "ruangan" => "Lab Komputer 3"],
                                    ["hari" => "Selasa", "jam" => "10:40 - 13:10", "matkul" => "IT Governance & Audit", "dosen" => "Dr. Ahmad Sudrajat, M.T.", "ruangan" => "Ruang 402"],
                                    ["hari" => "Rabu", "jam" => "13:30 - 16:00", "matkul" => "Rekayasa Perangkat Lunak", "dosen" => "Rina Wijaya, M.Kom.", "ruangan" => "Ruang 305"],
                                    ["hari" => "Kamis", "jam" => "08:00 - 10:30", "matkul" => "Pemrograman Web Lanjut", "dosen" => "Yusuf Mansur, M.T.", "ruangan" => "Lab Komputer 1"],
                                    ["hari" => "Jumat", "jam" => "10:00 - 12:30", "matkul" => "Cloud Computing", "dosen" => "Budi Pratama, M.T.I.", "ruangan" => "Lab Komputer 2"]
                                ];
                            @endphp

                            @forelse($schedules as $sched)
                                <tr>
                                    <td style="font-weight: 700; color: var(--primary);">{{ $sched['hari'] }}</td>
                                    <td>{{ $sched['jam'] }}</td>
                                    <td style="font-weight: 600;">{{ $sched['matkul'] }}</td>
                                    <td>{{ $sched['dosen'] }}</td>
                                    <td>
                                        <span class="badge {{ strpos(strtolower($sched['ruangan']), 'lab') !== false ? 'badge-success' : 'badge-secondary' }}" style="font-size: 0.8rem; border-radius: 4px;">
                                            {{ $sched['ruangan'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 15px;">Jadwal perkuliahan belum ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News / Articles -->
    <section class="content-section" id="berita" style="background-color: var(--bg-light); border-top: 1px solid var(--border-color);">
        <div class="container">
            <h2 class="section-title">Berita & Pengumuman Terbaru</h2>

            @if(isset($sliderPosts) && count($sliderPosts) > 0)
                <div class="swiper-container mySwiper" style="overflow: hidden; position: relative;">
                    <div class="swiper-wrapper">
                        @foreach($sliderPosts as $post)
                            <div class="swiper-slide">
                                <article class="post-card" style="width: 100%; margin-bottom: 0;">
                                    @if($post->featured_image)
                                        <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="post-card-img">
                                    @else
                                        <div class="post-card-img" style="display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.25);">
                                            <i class="fa-solid fa-image fa-3x"></i>
                                            <span class="post-card-category">{{ $post->category->name }}</span>
                                        </div>
                                    @endif
                                    <div class="post-card-body">
                                        <div class="post-card-meta">
                                            <span><i class="fa-solid fa-calendar-days"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                            <span><i class="fa-solid fa-user"></i> {{ $post->author->name }}</span>
                                        </div>
                                        <h3 class="post-card-title">{{ \Illuminate\Support\Str::limit($post->title, 55) }}</h3>
                                        <p class="post-card-excerpt">{!! \Illuminate\Support\Str::limit(strip_tags($post->content), 120) !!}</p>
                                        <a href="{{ route('public.post.show', $post->slug) }}" class="post-card-link">
                                            Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            @else
                <div class="grid-3-col">
                    @forelse($posts as $post)
                        <article class="post-card">
                            @if($post->featured_image)
                                <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="post-card-img">
                            @else
                                <div class="post-card-img" style="display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.25);">
                                    <i class="fa-solid fa-image fa-3x"></i>
                                    <span class="post-card-category">{{ $post->category->name }}</span>
                                </div>
                            @endif
                            <div class="post-card-body">
                                <div class="post-card-meta">
                                    <span><i class="fa-solid fa-calendar-days"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                    <span><i class="fa-solid fa-user"></i> {{ $post->author->name }}</span>
                                </div>
                                <h3 class="post-card-title">{{ \Illuminate\Support\Str::limit($post->title, 55) }}</h3>
                                <p class="post-card-excerpt">{!! \Illuminate\Support\Str::limit(strip_tags($post->content), 120) !!}</p>
                                <a href="{{ route('public.post.show', $post->slug) }}" class="post-card-link">
                                    Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text-muted);">
                            <i class="fa-regular fa-folder-open fa-3x" style="margin-bottom: 15px; display: block;"></i>
                            Belum ada berita yang diterbitkan saat ini.
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    // Initialize Swiper
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });

    // Faculty Filter Logic
    function filterLecturers(category, button) {
        // Toggle Active Button
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Toggle Cards Visibility
        const cards = document.querySelectorAll('#lecturerGrid .lecturer-card');
        cards.forEach(card => {
            const expertType = card.getAttribute('data-expert') || '';
            const categories = expertType.split(',');
            if (category === 'all' || categories.includes(category)) {
                card.style.display = 'block';
                // Add minor fade animation
                card.style.opacity = '0';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transition = 'opacity 0.4s ease';
                }, 50);
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Hero Slider Logic
    document.addEventListener('DOMContentLoaded', () => {
        const slider = document.querySelector('.hero-slider');
        const slides = document.querySelectorAll('.hero-slider .slide');
        const dots = document.querySelectorAll('.slider-dots .dot');
        
        if (slider && slides.length > 1) {
            let currentSlide = 0;
            const totalSlides = slides.length;
            let slideInterval;

            function goToSlide(index) {
                currentSlide = index;
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;
                
                // Update dots active class
                dots.forEach((dot, idx) => {
                    if (idx === currentSlide) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            }

            function nextSlide() {
                goToSlide((currentSlide + 1) % totalSlides);
            }

            const intervalTime = {{ (int) \App\Models\Setting::get('home_hero_slider_interval', 5) * 1000 }};
            function startSlideShow() {
                slideInterval = setInterval(nextSlide, intervalTime);
            }

            function stopSlideShow() {
                clearInterval(slideInterval);
            }

            // Click dots behavior
            dots.forEach((dot, idx) => {
                dot.addEventListener('click', () => {
                    stopSlideShow();
                    goToSlide(idx);
                    startSlideShow();
                });
            });

            // Initialize automatic playback
            startSlideShow();
        }
    });
</script>
@endsection
