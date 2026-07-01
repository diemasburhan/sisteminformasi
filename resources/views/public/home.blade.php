@extends('layouts.public')

@section('title', 'Sistem Informasi LPKIA - Unggul & Profesional')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-grid">
            <div class="hero-content">
                <h2 style="color: #ffffff;">Sistem Informasi IDE & LPKIA</h2>
                <p>Menciptakan Profesional IT Global di Bidang Tata Kelola & Analitik Data. Menghasilkan lulusan yang siap bersaing dalam era ekonomi digital dengan kurikulum berbasis industri.</p>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="#kurikulum" class="btn btn-secondary">
                        <i class="fa-solid fa-graduation-cap"></i> Lihat Kurikulum
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline" style="border-color: var(--secondary); color: var(--secondary);">
                        <i class="fa-solid fa-right-to-bracket"></i> Portal Mahasiswa
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/tech_hero.png') }}" alt="Sistem Informasi Teknologi LPKIA" style="width: 100%; max-height: 380px; object-fit: cover; border-radius: var(--border-radius-lg); box-shadow: var(--shadow-lg); transition: var(--transition);">
            </div>
        </div>
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
                <div class="org-card">
                    <div class="org-avatar">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <h4>Dr. Ahmad Sudrajat, M.T.</h4>
                    <div class="role">Kepala Program Studi</div>
                    <div class="nip">NIP. 19820412 201012 1 002</div>
                </div>

                <div class="org-card">
                    <div class="org-avatar" style="color: var(--secondary);">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                    <h4>Rina Wijaya, M.Kom.</h4>
                    <div class="role">Sekretaris Program Studi</div>
                    <div class="nip">NIP. 19870915 201503 2 001</div>
                </div>

                <div class="org-card">
                    <div class="org-avatar" style="color: var(--success);">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <h4>Budi Pratama, M.T.I.</h4>
                    <div class="role">Pembina Kemahasiswaan</div>
                    <div class="nip">NIP. 19900224 201801 1 003</div>
                </div>
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
                
                <div class="lecturer-card" data-expert="gov">
                    <i class="fa-solid fa-user-circle fa-4x" style="color: var(--primary); margin-bottom: 15px; display: block;"></i>
                    <h4>Dr. Ahmad Sudrajat, M.T.</h4>
                    <span class="field">IT Governance</span>
                </div>

                <div class="lecturer-card" data-expert="dev">
                    <i class="fa-solid fa-user-circle fa-4x" style="color: var(--secondary); margin-bottom: 15px; display: block;"></i>
                    <h4>Rina Wijaya, M.Kom.</h4>
                    <span class="field">Software Engineering</span>
                </div>

                <div class="lecturer-card" data-expert="data">
                    <i class="fa-solid fa-user-circle fa-4x" style="color: var(--success); margin-bottom: 15px; display: block;"></i>
                    <h4>Budi Pratama, M.T.I.</h4>
                    <span class="field">Data Science</span>
                </div>

                <div class="lecturer-card" data-expert="data">
                    <i class="fa-solid fa-user-circle fa-4x" style="color: var(--primary); margin-bottom: 15px; display: block;"></i>
                    <h4>Hesti Lestari, M.C.S.</h4>
                    <span class="field">Data Science</span>
                </div>

                <div class="lecturer-card" data-expert="dev">
                    <i class="fa-solid fa-user-circle fa-4x" style="color: var(--secondary); margin-bottom: 15px; display: block;"></i>
                    <h4>Yusuf Mansur, M.T.</h4>
                    <span class="field">Software Engineering</span>
                </div>

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
                            <tr>
                                <td style="font-weight: 700; color: var(--primary);">Senin</td>
                                <td>08:00 - 10:30</td>
                                <td style="font-weight: 600;">Big Data Analytics</td>
                                <td>Hesti Lestari, M.C.S.</td>
                                <td><span class="badge badge-success" style="font-size: 0.8rem; border-radius: 4px;">Lab Komputer 3</span></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700; color: var(--primary);">Selasa</td>
                                <td>10:40 - 13:10</td>
                                <td style="font-weight: 600;">IT Governance & Audit</td>
                                <td>Dr. Ahmad Sudrajat, M.T.</td>
                                <td><span class="badge badge-secondary" style="font-size: 0.8rem; border-radius: 4px;">Ruang 402</span></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700; color: var(--primary);">Rabu</td>
                                <td>13:30 - 16:00</td>
                                <td style="font-weight: 600;">Rekayasa Perangkat Lunak</td>
                                <td>Rina Wijaya, M.Kom.</td>
                                <td><span class="badge badge-secondary" style="font-size: 0.8rem; border-radius: 4px;">Ruang 305</span></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700; color: var(--primary);">Kamis</td>
                                <td>08:00 - 10:30</td>
                                <td style="font-weight: 600;">Pemrograman Web Lanjut</td>
                                <td>Yusuf Mansur, M.T.</td>
                                <td><span class="badge badge-success" style="font-size: 0.8rem; border-radius: 4px;">Lab Komputer 1</span></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700; color: var(--primary);">Jumat</td>
                                <td>10:00 - 12:30</td>
                                <td style="font-weight: 600;">Cloud Computing</td>
                                <td>Budi Pratama, M.T.I.</td>
                                <td><span class="badge badge-success" style="font-size: 0.8rem; border-radius: 4px;">Lab Komputer 2</span></td>
                            </tr>
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
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Faculty Filter Logic
    function filterLecturers(category, button) {
        // Toggle Active Button
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Toggle Cards Visibility
        const cards = document.querySelectorAll('#lecturerGrid .lecturer-card');
        cards.forEach(card => {
            const expertType = card.getAttribute('data-expert');
            if (category === 'all' || expertType === category) {
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
</script>
@endsection
