@extends('layouts.public')

@section('title', 'Sistem Informasi LPKIA')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home-editorial.css') }}">
@endsection

@section('content')

<div class="si-home">

    {{-- ======================================================
         NAVBAR
         ====================================================== --}}
    <header class="si-nav" id="siNav">
        <div class="si-container si-nav-inner">

            <a href="{{ url('/') }}" class="si-brand">
                <img
                    src="{{ asset('images/logo-lpkiaa.png') }}"
                    alt="Sistem Informasi LPKIA"
                    class="si-brand-logo"
                >

                <span class="si-brand-text">
                    <span class="si-brand-title">SISTEM INFORMASI</span>
                    <span class="si-brand-subtitle">LPKIA</span>
                </span>
            </a>

           <nav class="si-nav-menu" id="siNavMenu">

    <a href="{{ url('/#people') }}"
       class="si-nav-link"
       data-section="people">
        Dosen
    </a>

    <a href="{{ url('/#akademik') }}"
       class="si-nav-link"
       data-section="akademik">
        Akademik
    </a>

    <a href="{{ url('/#berita') }}"
       class="si-nav-link"
       data-section="berita">
        Berita
    </a>

    <a href="{{ url('/#tentangkami') }}"
       class="si-nav-link"
       data-section="tentangkami">
        Tentang Kami
    </a>

    <a href="{{ route('si.galeri') }}"
       class="si-nav-link {{ request()->routeIs('si.galeri') ? 'active' : '' }}">
        SI Galeri
    </a>

</nav>
            <div class="si-nav-actions">

                <button
                    type="button"
                    class="si-theme-toggle"
                    id="siThemeToggle"
                    aria-label="Toggle dark mode"
                >
                    <i class="fa-solid fa-moon" id="siThemeIcon"></i>
                </button>

                <button
                    type="button"
                    class="si-mobile-toggle"
                    id="siMobileToggle"
                    aria-label="Buka menu"
                >
                    <i class="fa-solid fa-bars"></i>
                </button>

            </div>

        </div>
    </header>


    {{-- ======================================================
         HERO
         ====================================================== --}}
    @php
        $heroImagesRaw = \App\Models\Setting::get(
            'home_hero_images',
            json_encode(['images/tech_hero.png'])
        );

        $heroImages = json_decode($heroImagesRaw, true);

        if (!is_array($heroImages) || empty($heroImages)) {
            $heroImages = ['images/tech_hero.png'];
        }

        $heroTitle = \App\Models\Setting::get(
            'home_hero_title',
            'Sistem Informasi LPKIA'
        );

        $heroText = \App\Models\Setting::get(
            'home_hero_text',
            'Menciptakan Profesional IT Global di Bidang Tata Kelola & Analitik Data. Menghasilkan lulusan yang siap bersaing dalam era ekonomi digital dengan kurikulum berbasis industri.'
        );
    @endphp

    <section class="si-hero">

        <div class="si-container si-hero-grid">

            <div class="si-hero-copy si-reveal">

                <div class="si-eyebrow">
                    Program Studi
                </div>

                <h1 class="si-hero-title">
                    SISTEM
                    <span>INFORMASI</span>
                    LPKIA.
                </h1>

                <p class="si-hero-description">
                    {{ $heroText }}
                </p>

                <div class="si-hero-actions">

                    <a href="#kompetensi" class="si-btn si-btn-primary">
                        Jelajahi Program
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                    <a href="#akademik" class="si-btn si-btn-ghost">
                        Lihat Akademik
                    </a>

                </div>

            </div>

         <div class="si-hero-news si-reveal">

    @if($posts->count() > 0)

        @php
            $latestPost = $posts->first();
        @endphp

        <a href="{{ route('public.post.show', $latestPost->slug) }}"
           class="si-hero-news-card">

            <div class="si-hero-news-image">

                @if($latestPost->featured_image)

                    <img
                        src="{{ asset($latestPost->featured_image) }}"
                        alt="{{ $latestPost->title }}"
                    >

                @else

                    <div class="si-hero-news-placeholder">
                        <span>SI</span>
                    </div>

                @endif

                <div class="si-hero-news-overlay"></div>

                <div class="si-hero-news-number">
                    NEWS / 01
                </div>

            </div>

            <div class="si-hero-news-content">

                <div class="si-hero-news-meta">

                    @if($latestPost->category)
                        <span>
                            {{ $latestPost->category->name }}
                        </span>
                    @endif

                    <span>
                        {{ optional($latestPost->published_at ?? $latestPost->created_at)->format('d M Y') }}
                    </span>

                </div>

                <h3>
                    {{ $latestPost->title }}
                </h3>

                <div class="si-hero-news-read">
                    Baca berita
                    <span>↗</span>
                </div>

            </div>

        </a>

    @else

        <div class="si-hero-news-empty">
            <span>BERITA TERBARU</span>

            <h3>Belum ada berita.</h3>

            <p>
                Berita yang dipublikasikan akan muncul di sini.
            </p>
        </div>

    @endif

</div>



    </section>


    {{-- ======================================================
         STATS
         ====================================================== --}}
    <section class="si-section" style="padding: 0; border-top: 0;">

        <div class="si-container">

            <div class="si-stats si-reveal">

                <div class="si-stat">
                    <div class="si-stat-value">1</div>
                    <div class="si-stat-label">Program Studi</div>
                </div>

                <div class="si-stat">
                    <div class="si-stat-value">2</div>
                    <div class="si-stat-label">Fokus Kompetensi</div>
                </div>

                <div class="si-stat">
                    <div class="si-stat-value">IT</div>
                    <div class="si-stat-label">Industry Oriented</div>
                </div>

                <div class="si-stat">
                    <div class="si-stat-value">Kompetensi</div>
                    <div class="si-stat-label">Digital Bisnis Dan DKV</div>
                </div>

            </div>

        </div>

    </section>

    {{-- ======================================================
         AKADEMIK
         ====================================================== --}}
    <section class="si-section" id="akademik">

        <div class="si-container">

            <div class="si-section-head si-reveal">
                <div class="si-section-number"></div>

                <div>
                    <h2 class="si-section-title">
                        Belajar
                        Berkembang.
                    </h2>

                    <p class="si-section-desc">
                        Informasi akademik, dokumen pembelajaran,
                        dan jadwal perkuliahan.
                    </p>
                </div>
            </div>


            <div class="si-academic-grid">

                <div class="si-reveal">

                    <div class="si-download-list">

                        <div class="si-download">

                            <div class="si-download-info">

                                <div class="si-download-icon">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>

                                <div>
                                    <h3 class="si-download-name">
                                        Kurikulum SI 2026.pdf
                                    </h3>

                                    <div class="si-download-meta">
                                        1.2 MB · Versi terbaru
                                    </div>
                                </div>

                            </div>

                            <a
                                href="#"
                                class="si-download-btn"
                                onclick="alert('Dokumen Kurikulum SI 2026 belum terhubung ke file download.'); return false;"
                            >
                                <i class="fa-solid fa-arrow-down"></i>
                            </a>

                        </div>


                        <div class="si-download">

                            <div class="si-download-info">

                                <div class="si-download-icon">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>

                                <div>
                                    <h3 class="si-download-name">
                                        Silabus & RPS.pdf
                                    </h3>

                                    <div class="si-download-meta">
                                        840 KB · Update terbaru
                                    </div>
                                </div>

                            </div>

                            <a
                                href="#"
                                class="si-download-btn"
                                onclick="alert('Dokumen Silabus & RPS belum terhubung ke file download.'); return false;"
                            >
                                <i class="fa-solid fa-arrow-down"></i>
                            </a>

                        </div>

                    </div>

                </div>


                <div class="si-announcement si-reveal">

                    <div class="si-announcement-label">
                        Pengumuman Akademik
                    </div>

                    <h3>
                        Semester Ganjil
                        2026/2027
                    </h3>

                    <p>
                        Perkuliahan Semester Ganjil Tahun Akademik
                        2026/2027 akan dimulai pada hari
                        <strong>Senin, 28 September 2026</strong>.
                        Mahasiswa diwajibkan menyelesaikan Administrasi Akademik sebelum mengikuti perkuliahan.
                    </p>

                    <a
                        href="#jadwal"
                        class="si-btn si-btn-ghost"
                        style="
                            margin-top:15px;
                            border-color:rgba(255,255,255,.25);
                            color:white !important;
                        "
                    >
                        Lihat Jadwal
                        <i class="fa-solid fa-arrow-down"></i>
                    </a>

                </div>

            </div>


      

    {{-- ======================================================
     SECTION TENTANG
     ====================================================== --}}
<section class="si-section" id="tentang">
    <div class="si-container">
        {{-- SECTION HEADER --}}
        <div class="si-section-head si-reveal">
            <div class="si-section-number"></div>
            <div>
                <h2 class="si-section-title">
                    Teknologi yang
                    memahami bisnis.
                </h2>
                <p class="si-section-desc">
                    Program Studi Sistem Informasi LPKIA memadukan
                    ilmu teknologi komputer dengan pemahaman bisnis
                    korporasi untuk mempersiapkan profesional digital
                    yang mampu menyelesaikan masalah nyata.
                </p>
            </div>
        </div>
        {{-- ================================================
             TUJUAN PROGRAM STUDI
             ================================================ --}}
        <div class="si-tujuan-wrap si-reveal">
            <div class="si-tujuan-header">
                <span class="si-tujuan-eyebrow">
                    <span class="si-tujuan-eyebrow-line"></span>
                    Tujuan Program Studi
                </span>
                <h3 class="si-tujuan-title">
                    Sistem <span>Informasi.</span>
                </h3>
            </div>
            <div class="si-tujuan-grid">
                <article class="si-tujuan-card si-reveal">
                    <div class="si-tujuan-card-top">
                        <span class="si-tujuan-num">01</span>
                        <div class="si-tujuan-icon">
                            <i class="fa-solid fa-medal"></i>
                        </div>
                    </div>
                    <h4>Lulusan Unggul &amp; Adaptif</h4>
                    <p>
                        Menghasilkan lulusan yang memiliki kompetensi unggul dan adaptif di bidang
                        sistem informasi dan bisnis, dengan penguasaan <em>hardskill</em> dan <em>softskill</em>,
                        sehingga mampu bersaing di pasar kerja nasional maupun global, serta memiliki jiwa
                        kewirausahaan yang inovatif dan tangguh sesuai kebutuhan industri dan perkembangan
                        ekonomi digital.
                    </p>
                </article>
                <article class="si-tujuan-card si-reveal">
                    <div class="si-tujuan-card-top">
                        <span class="si-tujuan-num">02</span>
                        <div class="si-tujuan-icon">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                    </div>
                    <h4>Sertifikasi Profesional</h4>
                    <p>
                        Menghasilkan lulusan yang memiliki pengakuan melalui sertifikasi kompetensi
                        profesional berskala nasional maupun internasional di bidang sistem informasi
                        dan bisnis, guna meningkatkan daya saing di pasar kerja dan memenuhi kebutuhan
                        industri di tingkat nasional maupun global.
                    </p>
                </article>
                <article class="si-tujuan-card si-reveal">
                    <div class="si-tujuan-card-top">
                        <span class="si-tujuan-num">03</span>
                        <div class="si-tujuan-icon">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                    </div>
                    <h4>Efisiensi Biaya Pendidikan</h4>
                    <p>
                        Mendorong efisiensi biaya pendidikan melalui pemanfaatan teknologi, sistem
                        pembelajaran terbuka dan fleksibel, serta model pembelajaran berbasis proyek
                        yang relevan dengan dunia usaha dan dunia industri.
                    </p>
                </article>
                <article class="si-tujuan-card si-reveal">
                    <div class="si-tujuan-card-top">
                        <span class="si-tujuan-num">04</span>
                        <div class="si-tujuan-icon">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                    </div>
                    <h4>Kualitas Pembelajaran Berbasis Praktik</h4>
                    <p>
                        Meningkatkan kualitas pembelajaran dan kurikulum melalui pendekatan berbasis
                        praktik (applied), kolaborasi dengan DUDI, serta integrasi teknologi digital
                        dalam proses belajar mengajar.
                    </p>
                </article>
            </div>
        </div>
        {{-- ================================================
             VISI MISI
             ================================================ --}}
        <div class="si-visimisi-wrap si-reveal">
            {{-- VISI --}}
            <div class="si-visi-block">
                <div class="si-visi-label">
                    <span class="si-visi-badge">VISI</span>
                </div>
                <div class="si-visi-content">
                    <div class="si-visi-quote-mark">"</div>
                    <p class="si-visi-text">
                        Menjadi program studi sistem informasi unggul di Indonesia dengan
                        mengutamakan keunggulan dalam menghasilkan lulusan Sarjana yang mudah
                        bekerja dan berkualitas Bidang Sistem Informasi dan Bisnis yang selaras
                        dengan kebutuhan industri dan perkembangan ekonomi digital.
                    </p>
                    <div class="si-visi-source">
                        Program Studi Sistem Informasi — IDE LPKIA
                    </div>
                </div>
            </div>
            {{-- MISI --}}
            <div class="si-misi-block">
                <div class="si-misi-label">
                    <span class="si-misi-badge">MISI</span>
                    <p class="si-misi-subtitle">
                        Lima pilar misi yang menjadi landasan pengembangan
                        Program Studi Sistem Informasi.
                    </p>
                </div>
                <div class="si-misi-list">
                    <div class="si-misi-item">
                        <div class="si-misi-item-left">
                            <div class="si-misi-num-wrap">
                                <span class="si-misi-num">01</span>
                                <div class="si-misi-connector"></div>
                            </div>
                        </div>
                        <div class="si-misi-item-body">
                            <h5>Pengembangan Citra Program Studi</h5>
                            <p>
                                Mengembangkan citra Program Studi Sistem Informasi sebagai
                                program studi bidang Sistem Informasi dan Bisnis.
                            </p>
                        </div>
                    </div>
                    <div class="si-misi-item">
                        <div class="si-misi-item-left">
                            <div class="si-misi-num-wrap">
                                <span class="si-misi-num">02</span>
                                <div class="si-misi-connector"></div>
                            </div>
                        </div>
                        <div class="si-misi-item-body">
                            <h5>Penjaminan Mutu &amp; Akreditasi</h5>
                            <p>
                                Mengembangkan sistem penjaminan mutu program studi
                                untuk memperoleh akreditasi unggul.
                            </p>
                        </div>
                    </div>
                    <div class="si-misi-item">
                        <div class="si-misi-item-left">
                            <div class="si-misi-num-wrap">
                                <span class="si-misi-num">03</span>
                                <div class="si-misi-connector"></div>
                            </div>
                        </div>
                        <div class="si-misi-item-body">
                            <h5>Pendidikan Tinggi Berbasis Industri</h5>
                            <p>
                                Menyelenggarakan program pendidikan tinggi bidang sistem informasi
                                dan bisnis yang selaras dengan kebutuhan DUDI dan perkembangan
                                ekonomi digital.
                            </p>
                        </div>
                    </div>
                    <div class="si-misi-item">
                        <div class="si-misi-item-left">
                            <div class="si-misi-num-wrap">
                                <span class="si-misi-num">04</span>
                                <div class="si-misi-connector"></div>
                            </div>
                        </div>
                        <div class="si-misi-item-body">
                            <h5>Penelitian Bertaraf Internasional</h5>
                            <p>
                                Menyelenggarakan kegiatan penelitian bertaraf lokal, nasional dan
                                internasional yang mendorong perkembangan ilmu pengetahuan dan teknologi
                                bidang Sistem Informasi dan Bisnis melalui pemanfaatan TIK bagi
                                kegiatan bisnis.
                            </p>
                        </div>
                    </div>
                    <div class="si-misi-item si-misi-item--last">
                        <div class="si-misi-item-left">
                            <div class="si-misi-num-wrap">
                                <span class="si-misi-num">05</span>
                            </div>
                        </div>
                        <div class="si-misi-item-body">
                            <h5>Pengabdian kepada Masyarakat</h5>
                            <p>
                                Menyelenggarakan kegiatan pengabdian kepada masyarakat bertaraf lokal,
                                nasional dan internasional dalam bidang sistem informasi dan bisnis sebagai
                                wujud pertanggungjawaban sosial insan akademisi dalam rangka meningkatkan
                                kesejahteraan masyarakat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- ======================================================
     TENTANG KAMI
     ====================================================== --}}
<section class="si-section si-about-us" id="tentangkami">

    <div class="si-container si-about-us-inner">

        {{-- HEADER --}}
        <div class="si-about-us-head si-reveal">

            <div class="si-about-us-label">
                Tentang Kami
            </div>

            <div>

                <h2 class="si-about-us-title">
                    Lebih dari sekadar
                    <span>program studi.</span>
                </h2>

                <p class="si-about-us-intro">
                    Sistem Informasi LPKIA hadir untuk menjembatani
                    teknologi, manusia, dan kebutuhan bisnis.
                    Kami membentuk lingkungan pembelajaran yang
                    mendorong mahasiswa untuk berpikir kritis,
                    membangun solusi, dan siap menghadapi dunia
                    industri digital.
                </p>

            </div>

        </div>


        {{-- STORY --}}
        <div class="si-about-us-grid">

            <article class="si-about-us-card si-reveal">

                <div class="si-about-us-card-number">
                    01 / IDENTITAS
                </div>

                <h3>
                    Membangun talenta digital
                    yang relevan.
                </h3>

                <p>
                    Sistem Informasi LPKIA memadukan pemahaman
                    teknologi informasi dengan perspektif bisnis
                    dan organisasi. Mahasiswa tidak hanya belajar
                    bagaimana teknologi dibuat, tetapi juga
                    bagaimana teknologi memberikan dampak nyata.
                </p>

            </article>


            <article class="si-about-us-card si-reveal">

                <div class="si-about-us-card-number">
                    02 / PENDEKATAN
                </div>

                <h3>
                    Belajar untuk
                    menyelesaikan masalah.
                </h3>

                <p>
                    Pembelajaran diarahkan pada kemampuan analisis,
                    perancangan sistem, pengolahan data, tata kelola
                    teknologi, serta pengembangan solusi digital
                    yang dapat diterapkan dalam berbagai kebutuhan.
                </p>

            </article>

        </div>


        {{-- VALUES --}}
        <div class="si-about-us-values">

            <article class="si-about-us-value si-reveal">

                <div class="si-about-us-value-icon">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>

                <h4>Inovatif</h4>

                <p>
                    Mendorong cara berpikir kreatif dan kemampuan
                    menciptakan solusi berbasis teknologi.
                </p>

            </article>


            <article class="si-about-us-value si-reveal">

                <div class="si-about-us-value-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>

                <h4>Berorientasi Data</h4>

                <p>
                    Mengembangkan kemampuan mengolah data menjadi
                    informasi dan insight yang bernilai.
                </p>

            </article>


            <article class="si-about-us-value si-reveal">

                <div class="si-about-us-value-icon">
                    <i class="fa-solid fa-people-group"></i>
                </div>

                <h4>Kolaboratif</h4>

                <p>
                    Menghubungkan mahasiswa, akademisi, dan industri
                    untuk menciptakan pengalaman belajar yang relevan.
                </p>

            </article>

        </div>


        {{-- BOTTOM STATEMENT --}}
        <div class="si-about-us-bottom si-reveal">

            <div class="si-about-us-bottom-text">
                Sistem Informasi LPKIA
            </div>

            <div class="si-about-us-bottom-highlight">
                #SatuJurusanBanyakJalan 
            </div>

        </div>

    </div>

</section>

    {{-- ======================================================
         KOMPETENSI
         ====================================================== --}}
   <section class="si-career-section" id="profil-lulusan">

    <div class="si-career-container">

        <!-- HEADER -->
        <div class="si-career-header">

            <div class="si-career-eyebrow">
                <span></span>
                
            </div>

            <div class="si-career-heading">
                <h2>
                    Profil Lulusan Prodi<br>
                    Sistem Informasi.
                </h2>

                
            </div>

        </div>


        <!-- CAREER GRID -->
        <div class="si-career-grid">

            <!-- 01 -->
            <article class="si-career-card">
                <div class="si-career-top">
                    <span class="si-career-number">01</span>
                    <span class="si-career-line"></span>
                </div>

                <div class="si-career-content">
                    <h3>System Analyst</h3>
                    <p>
                        Menganalisis kebutuhan bisnis dan merancang solusi
                        sistem informasi yang sesuai dengan proses dan
                        strategi organisasi.
                    </p>
                </div>

                <div class="si-career-bottom">
                    <span></span>
                    <span class="si-career-arrow"></span>
                </div>
            </article>


            <!-- 02 -->
            <article class="si-career-card">
                <div class="si-career-top">
                    <span class="si-career-number">02</span>
                    <span class="si-career-line"></span>
                </div>

                <div class="si-career-content">
                    <h3>Business Analyst</h3>
                    <p>
                        Menjembatani kebutuhan bisnis dan teknologi,
                        menganalisis proses bisnis, serta merancang
                        perbaikan berbasis sistem informasi.
                    </p>
                </div>

                <div class="si-career-bottom">
                    <span></span>
                    <span class="si-career-arrow"></span>
                </div>
            </article>


            <!-- 03 -->
            <article class="si-career-card">
                <div class="si-career-top">
                    <span class="si-career-number">03</span>
                    <span class="si-career-line"></span>
                </div>

                <div class="si-career-content">
                    <h3>IT Project Manager</h3>
                    <p>
                        Merencanakan, mengelola, dan mengevaluasi proyek
                        teknologi informasi termasuk waktu, biaya,
                        dan kualitas.
                    </p>
                </div>

                <div class="si-career-bottom">
                    <span></span>
                    <span class="si-career-arrow"></span>
                </div>
            </article>


            <!-- 04 -->
            <article class="si-career-card">
                <div class="si-career-top">
                    <span class="si-career-number">04</span>
                    <span class="si-career-line"></span>
                </div>

                <div class="si-career-content">
                    <h3>Information System Developer</h3>
                    <p>
                        Mengembangkan dan mengimplementasikan sistem
                        informasi berbasis web, mobile, cloud,
                        atau enterprise.
                    </p>
                </div>

                <div class="si-career-bottom">
                    <span></span>
                    <span class="si-career-arrow"></span>
                </div>
            </article>


            <!-- 05 -->
            <article class="si-career-card">
                <div class="si-career-top">
                    <span class="si-career-number">05</span>
                    <span class="si-career-line"></span>
                </div>

                <div class="si-career-content">
                    <h3>Database Administrator / Data Analyst</h3>
                    <p>
                        Merancang, mengelola, dan menganalisis data dalam
                        skala kecil hingga besar untuk mendukung
                        pengambilan keputusan.
                    </p>
                </div>

                <div class="si-career-bottom">
                    <span></span>
                    <span class="si-career-arrow"></span>
                </div>
            </article>


            <!-- 06 -->
            <article class="si-career-card">
                <div class="si-career-top">
                    <span class="si-career-number">06</span>
                    <span class="si-career-line"></span>
                </div>

                <div class="si-career-content">
                    <h3>IT Governance &amp; Auditor</h3>
                    <p>
                        Memahami prinsip tata kelola TI, audit sistem
                        informasi, manajemen risiko, serta kepatuhan
                        terhadap standar organisasi.
                    </p>
                </div>

                <div class="si-career-bottom">
                    <span></span>
                    <span class="si-career-arrow"></span>
                </div>
            </article>


            <!-- 07 -->
            <article class="si-career-card">
                <div class="si-career-top">
                    <span class="si-career-number">07</span>
                    <span class="si-career-line"></span>
                </div>

                <div class="si-career-content">
                    <h3>Enterprise Architect</h3>
                    <p>
                        Merancang arsitektur sistem informasi secara
                        menyeluruh serta memastikan integrasi antar
                        sistem dan strategi bisnis.
                    </p>
                </div>
  
                <div class="si-career-bottom">
                    <span></span>
                    <span class="si-career-arrow"></span>
                </div>
            </article>


            <!-- 08 -->
            <article class="si-career-card">
                <div class="si-career-top">
                    <span class="si-career-number">08</span>
                    <span class="si-career-line"></span>
                </div>

                <div class="si-career-content">
                    <h3>Technopreneur</h3>
                    <p>
                        Mengidentifikasi peluang bisnis berbasis teknologi
                        informasi dan mengembangkan produk atau layanan
                        digital secara mandiri maupun dalam tim.
                    </p>
                </div>

                <div class="si-career-bottom">
                    <span></span>
                    <span class="si-career-arrow"></span>
                </div>
            </article>

        </div>

    </div>

</section>


    {{-- ======================================================
         ORGANIZATION
         ====================================================== --}}
    <section class="si-section" id="people">

        <div class="si-container">

            <div class="si-section-head si-reveal">
                <div class="si-section-number"></div>

                <div>
                    <h2 class="si-section-title">
                        Orang-orang
                        di balik Program Studi Sistem Informasi.
                    </h2>

                    <p class="si-section-desc">
                        Struktur organisasi Program Studi Sistem Informasi.
                    </p>
                </div>
            </div>


            <div class="si-people-grid">

                @forelse($orgMembers as $member)

                    <article class="si-person si-reveal">

                        <div class="si-person-image">

                            @if($member->photo)

                                <img
                                    src="{{ asset($member->photo) }}"
                                    alt="{{ $member->name }}"
                                >

                            @else

                                <div style="
                                    width:100%;
                                    height:100%;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    color:var(--si-primary);
                                    font-size:2.2rem;
                                ">
                                    <i class="fa-solid fa-user"></i>
                                </div>

                            @endif

                        </div>

                        <h3 class="si-person-name">
                            {{ $member->name }}
                        </h3>

                        <div class="si-person-role">
                            {{ $member->role }}
                        </div>

                        @if($member->nip)
                            <div class="si-person-nip">
                                NIP. {{ $member->nip }}
                            </div>
                        @endif

                    </article>

                @empty

                    <div style="
                        grid-column:1/-1;
                        padding:50px;
                        text-align:center;
                        color:var(--si-text-muted);
                    ">
                        Struktur organisasi belum diatur.
                    </div>

                @endforelse

            </div>

        </div>

    </section>


    {{-- ======================================================
         DOSEN
         ====================================================== --}}
    <section class="si-section si-section-soft">

        <div class="si-container">

            <div class="si-section-head si-reveal">
                <div class="si-section-number"></div>

                <div>
                    <h2 class="si-section-title">
                        Akademisi &
                        praktisi.
                    </h2>

                    <p class="si-section-desc">
                        Dosen yang mendukung pembelajaran di berbagai
                        bidang Sistem Informasi.
                    </p>
                </div>
            </div>


            <div class="si-filter si-reveal">

                <button
                    type="button"
                    class="si-filter-btn active"
                    onclick="siFilterLecturers('all', this)"
                >
                    Semua
                </button>

                <button
                    type="button"
                    class="si-filter-btn"
                    onclick="siFilterLecturers('data', this)"
                >
                    Data Science
                </button>

                <button
                    type="button"
                    class="si-filter-btn"
                    onclick="siFilterLecturers('dev', this)"
                >
                    Software Engineering
                </button>

                <button
                    type="button"
                    class="si-filter-btn"
                    onclick="siFilterLecturers('gov', this)"
                >
                    IT Governance
                </button>

            </div>


            <div class="si-lecturer-grid" id="siLecturerGrid">

                @forelse($lecturers as $lecturer)

                    @php

                        $categories = $lecturer->expertises
                            ->pluck('category')
                            ->map(function ($c) {
                                return strtolower($c);
                            })
                            ->toArray();

                        $dataExpert = implode(',', $categories);

                    @endphp

                    <article
                        class="si-lecturer si-reveal"
                        data-expert="{{ $dataExpert }}"
                    >

                        @if($lecturer->photo)

                            <img
                                src="{{ asset($lecturer->photo) }}"
                                alt="{{ $lecturer->name }}"
                                class="si-lecturer-photo"
                            >

                        @else

                            <div class="si-lecturer-placeholder">
                                <i class="fa-solid fa-user"></i>
                            </div>

                        @endif


                        <h3 class="si-lecturer-name">
                            {{ $lecturer->name }}
                        </h3>


                        <div class="si-tags">

                            @forelse($lecturer->expertises as $exp)

                                <span class="si-tag">
                                    {{ $exp->name }}
                                </span>

                            @empty

                                <span class="si-tag">
                                    Umum
                                </span>

                            @endforelse

                        </div>

                    </article>

                @empty

                    <div style="
                        grid-column:1/-1;
                        padding:50px;
                        text-align:center;
                        color:var(--si-text-muted);
                    ">
                        Data dosen belum tersedia.
                    </div>

                @endforelse

            </div>

        </div>

    </section>
      {{-- ==================================================
                 JADWAL
                 ================================================== --}}
            <div
                id="jadwal"
                style="margin-top:100px;"
            >

                <div class="si-section-head si-reveal">
                    <div class="si-section-number"></div>

                    <div>
                        <h2 class="si-section-title">
                            Jadwal kelas.
                        </h2>

                        <p class="si-section-desc">
                            Jadwal kuliah mingguan Program Studi
                            Sistem Informasi.
                        </p>
                    </div>
                </div>


                <div class="si-schedule-wrap si-reveal">

                    <table class="si-schedule">

                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Mata Kuliah</th>
                                <th>Dosen</th>
                                <th>Ruangan</th>
                            </tr>
                        </thead>

                        <tbody>

                            @php

                                $scheduleJson = \App\Models\Setting::get(
                                    'class_schedule'
                                );

                                $schedules = $scheduleJson
                                    ? json_decode($scheduleJson, true)
                                    : [
                                        [
                                            "hari" => "Senin",
                                            "jam" => "08:00 - 10:30",
                                            "matkul" => "Big Data Analytics",
                                            "dosen" => "Hesti Lestari, M.C.S.",
                                            "ruangan" => "Lab Komputer 3"
                                        ],
                                        [
                                            "hari" => "Selasa",
                                            "jam" => "10:40 - 13:10",
                                            "matkul" => "IT Governance & Audit",
                                            "dosen" => "Dr. Ahmad Sudrajat, M.T.",
                                            "ruangan" => "Ruang 402"
                                        ],
                                        [
                                            "hari" => "Rabu",
                                            "jam" => "13:30 - 16:00",
                                            "matkul" => "Rekayasa Perangkat Lunak",
                                            "dosen" => "Rina Wijaya, M.Kom.",
                                            "ruangan" => "Ruang 305"
                                        ],
                                        [
                                            "hari" => "Kamis",
                                            "jam" => "08:00 - 10:30",
                                            "matkul" => "Pemrograman Web Lanjut",
                                            "dosen" => "Yusuf Mansur, M.T.",
                                            "ruangan" => "Lab Komputer 1"
                                        ],
                                        [
                                            "hari" => "Jumat",
                                            "jam" => "10:00 - 12:30",
                                            "matkul" => "Cloud Computing",
                                            "dosen" => "Budi Pratama, M.T.I.",
                                            "ruangan" => "Lab Komputer 2"
                                        ]
                                    ];

                            @endphp


                            @forelse($schedules as $sched)

                                <tr>

                                    <td class="day">
                                        {{ $sched['hari'] }}
                                    </td>

                                    <td>
                                        {{ $sched['jam'] }}
                                    </td>

                                    <td class="course">
                                        {{ $sched['matkul'] }}
                                    </td>

                                    <td>
                                        {{ $sched['dosen'] }}
                                    </td>

                                    <td>
                                        <span class="si-room">
                                            {{ $sched['ruangan'] }}
                                        </span>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" style="text-align:center;">
                                        Jadwal perkuliahan belum ditambahkan.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                    <div class="si-schedule-action">
                    <a
                    href="https://baa.lpkia.ac.id/jadwal"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="si-schedule-button"
                    >
                    <span>Lihat Jadwal Lengkap</span>
                    <span class="si-schedule-arrow">→</span>
                    </a>
                    </div>

                </div>

            </div>

        </div>

    </section>


    


    {{-- ======================================================
         BERITA
         ====================================================== --}}
    <section class="si-section si-section-soft" id="berita">

        <div class="si-container">

            <div class="si-section-head si-reveal">
                <div class="si-section-number"></div>

                <div>
                    <h2 class="si-section-title">
                        Yang terbaru
                        dari SI LPKIA.
                    </h2>

                    <p class="si-section-desc">
                        Informasi, kegiatan, dan pengumuman terbaru
                        dari Program Studi Sistem Informasi.
                    </p>
                </div>
            </div>


            @php

                $newsCollection =
                    isset($sliderPosts) && count($sliderPosts) > 0
                        ? $sliderPosts
                        : $posts;

            @endphp


            @if(isset($newsCollection) && count($newsCollection) > 0)

                @php
                    $featuredPost = $newsCollection->first();
                    $otherPosts = $newsCollection->slice(1, 3);
                @endphp


                <div class="si-news-grid">

                    {{-- FEATURED --}}

                    <article class="si-news-feature si-reveal">

                        <a
                            href="{{ route('public.post.show', $featuredPost->slug) }}"
                            class="si-news-feature-image"
                        >

                            @if($featuredPost->featured_image)

                                <img
                                    src="{{ asset($featuredPost->featured_image) }}"
                                    alt="{{ $featuredPost->title }}"
                                >

                            @else

                                <div style="
                                    width:100%;
                                    height:100%;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    background:var(--si-bg-muted);
                                    color:var(--si-text-muted);
                                    font-size:3rem;
                                ">
                                    <i class="fa-regular fa-image"></i>
                                </div>

                            @endif

                            <div class="si-news-feature-overlay"></div>

                        </a>


                        <div class="si-news-feature-content">

                            <div class="si-news-meta">

                                <span>
                                    <i class="fa-regular fa-calendar"></i>

                                    {{ $featuredPost->published_at
                                        ? $featuredPost->published_at->format('d M Y')
                                        : $featuredPost->created_at->format('d M Y')
                                    }}
                                </span>

                                <span>
                                    {{ $featuredPost->author->name }}
                                </span>

                            </div>


                            <h3 class="si-news-title">
                                {{ $featuredPost->title }}
                            </h3>


                            <a
                                href="{{ route('public.post.show', $featuredPost->slug) }}"
                                class="si-news-link"
                                style="color:white;"
                            >
                                Baca selengkapnya
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>

                        </div>

                    </article>


                    {{-- OTHER NEWS --}}

                    <div class="si-news-list">

                        @forelse($otherPosts as $post)

                            <article class="si-news-item si-reveal">

                                <div class="si-news-meta">

                                    <span>
                                        {{ $post->published_at
                                            ? $post->published_at->format('d M Y')
                                            : $post->created_at->format('d M Y')
                                        }}
                                    </span>

                                </div>


                                <h3 class="si-news-item-title">
                                    {{ \Illuminate\Support\Str::limit($post->title, 80) }}
                                </h3>


                                <p style="
                                    margin:10px 0 0;
                                    color:var(--si-text-muted);
                                    font-size:.76rem;
                                    line-height:1.6;
                                ">
                                    {!! \Illuminate\Support\Str::limit(
                                        strip_tags($post->content),
                                        100
                                    ) !!}
                                </p>


                                <a
                                    href="{{ route('public.post.show', $post->slug) }}"
                                    class="si-news-link"
                                >
                                    Baca
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>

                            </article>

                        @empty

                            <div style="
                                padding:40px;
                                color:var(--si-text-muted);
                            ">
                                Tidak ada berita lainnya.
                            </div>

                        @endforelse

                    </div>

                </div>

            @else

                <div style="
                    padding:80px 20px;
                    text-align:center;
                    border:1px solid var(--si-border);
                    color:var(--si-text-muted);
                ">

                    <i
                        class="fa-regular fa-folder-open"
                        style="font-size:2rem;margin-bottom:15px;"
                    ></i>

                    <div>
                        Belum ada berita yang diterbitkan.
                    </div>

                </div>

            @endif

        </div>

    </section>


    {{-- ======================================================
         FOOTER
         ====================================================== --}}
    <footer class="si-footer">

        <div class="si-container">

            <div class="si-footer-grid">

                <div>

                    <div class="si-footer-brand">

                        <img
                            src="{{ asset('images/logo-si-lpkia.png') }}"
                            alt="Sistem Informasi LPKIA"
                            class="si-footer-logo"
                        >

                        <div class="si-footer-brand-text">
                            <strong>SISTEM INFORMASI</strong>
                            <span>LPKIA</span>
                        </div>

                    </div>


                    <p class="si-footer-desc">
                        Program Studi Sistem Informasi yang memadukan
                        teknologi, bisnis, data, dan tata kelola untuk
                        membentuk profesional digital masa depan.
                    </p>

                </div>


                <div>

                    <div class="si-footer-heading">
                        Navigasi
                    </div>

                    <div class="si-footer-links">   
                        <a href="#people">Dosen</a>
                        <a href="#akademik">Akademik</a>
                        <a href="#berita">Berita</a>
                    </div>

                </div>


                <div>

                    <div class="si-footer-heading">
                        Portal
                    </div>

                    <div class="si-footer-links">
                        <a href="https://siakad.lpkia.ac.id/gate/login">
                            Portal Mahasiswa
                        </a>

                        <a href="#jadwal">
                            Jadwal Kuliah
                        </a>

                        <a href="#akademik">
                            Kurikulum
                        </a>
                    </div>

                </div>

            </div>


            <div class="si-footer-bottom">

                <span>
                    © {{ date('Y') }} Sistem Informasi LPKIA.
                </span>

                <span>
                    Dikembangkan oleh
                <button
                     type="button"
                     class="developer-name"
                     onclick="openDeveloperModal()"
                   >
                     Bambang Irwansyah
                </button>
                </span>
            </div>

        </div>

    </footer>

</div>


<div class="developer-modal" id="developerModal">
    <div class="developer-overlay" onclick="closeDeveloperModal()"></div>

    <div class="developer-card">

        <button class="developer-close" onclick="closeDeveloperModal()">
            ×
        </button>

        <div class="developer-icon">
            <i class="fa-solid fa-code"></i>
        </div>

        <h2>Bambang Irwansyah</h2>

        <div class="developer-role">
            
        </div>

        <div class="developer-divider"></div>

        <div class="developer-info">

            <div>
                <span>NIM</span>
                <strong>250514024</strong>
            </div>

            <div>
                <span>STATUS</span>
                <strong>Mahasiswa</strong>
            </div>

        </div>

        <div class="developer-links">
            <a href="https://www.linkedin.com/in/bambangirwks/" target="_blank">
                <i class="fa-brands fa-linkedin"></i>
                LinkedIn
            </a>

            
        </div>

        <div class="developer-copyright">
            <strong>Hak Cipta © 2026 Bambang Irwansyah.</strong>

            <p>
                Sistem ini dilindungi oleh undang-undang hak cipta.
                Penggandaan atau pendistribusian tanpa izin tertulis
                dilarang keras.
            </p>
        </div>

        <button
            class="developer-close-button"
            onclick="closeDeveloperModal()"
        >
            Tutup
        </button>

    </div>
</div>

@endsection


@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ========================================================
       DARK MODE
       ======================================================== */

    const html = document.documentElement;
    const themeToggle = document.getElementById('siThemeToggle');
    const themeIcon = document.getElementById('siThemeIcon');

    function applyTheme(theme) {

        if (theme === 'dark') {

            html.classList.add('dark-mode');

            if (themeIcon) {
                themeIcon.className = 'fa-solid fa-sun';
            }

        } else {

            html.classList.remove('dark-mode');

            if (themeIcon) {
                themeIcon.className = 'fa-solid fa-moon';
            }

        }

    }


    let savedTheme = localStorage.getItem('si-theme');

    if (!savedTheme) {
        savedTheme = window.matchMedia &&
            window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
    }

    applyTheme(savedTheme);


    if (themeToggle) {

        themeToggle.addEventListener('click', function () {

            const newTheme =
                html.classList.contains('dark-mode')
                    ? 'light'
                    : 'dark';

            localStorage.setItem('si-theme', newTheme);

            applyTheme(newTheme);

        });

    }


    /* ========================================================
       MOBILE MENU
       ======================================================== */

    const mobileToggle =
        document.getElementById('siMobileToggle');

    const navMenu =
        document.getElementById('siNavMenu');


    if (mobileToggle && navMenu) {

        mobileToggle.addEventListener('click', function () {

            navMenu.classList.toggle('open');

            const icon =
                mobileToggle.querySelector('i');

            if (navMenu.classList.contains('open')) {
                icon.className = 'fa-solid fa-xmark';
            } else {
                icon.className = 'fa-solid fa-bars';
            }

        });


        navMenu.querySelectorAll('a').forEach(function (link) {

            link.addEventListener('click', function () {

                navMenu.classList.remove('open');

                const icon =
                    mobileToggle.querySelector('i');

                icon.className = 'fa-solid fa-bars';

            });

        });

    }


    /* ========================================================
       NAVBAR SCROLL
       ======================================================== */

    const nav =
        document.getElementById('siNav');


    function updateNavbar() {

        if (!nav) return;

        if (window.scrollY > 15) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }

    }


    window.addEventListener(
        'scroll',
        updateNavbar,
        { passive: true }
    );

    updateNavbar();


    /* ========================================================
       HERO SLIDER
       ======================================================== */

    const slider =
        document.getElementById('siHeroSlider');

    const slides =
        document.querySelectorAll('.si-hero-slide');

    const dots =
        document.querySelectorAll('.si-hero-dot');

    const currentNumber =
        document.getElementById('siHeroCurrent');


    if (slider && slides.length > 1) {

        let currentSlide = 0;

        const intervalTime =
            {{ (int) \App\Models\Setting::get(
                'home_hero_slider_interval',
                5
            ) * 1000 }};

        let interval;


        function goToSlide(index) {

            currentSlide = index;

            slider.style.transform =
                `translateX(-${currentSlide * 100}%)`;


            dots.forEach(function (dot, index) {

                dot.classList.toggle(
                    'active',
                    index === currentSlide
                );

            });


            if (currentNumber) {

                currentNumber.textContent =
                    String(currentSlide + 1).padStart(2, '0');

            }

        }


        function nextSlide() {

            goToSlide(
                (currentSlide + 1) % slides.length
            );

        }


        function startSlider() {

            interval =
                setInterval(
                    nextSlide,
                    intervalTime
                );

        }


        function stopSlider() {

            clearInterval(interval);

        }


        dots.forEach(function (dot) {

            dot.addEventListener('click', function () {

                stopSlider();

                goToSlide(
                    parseInt(
                        dot.dataset.slide,
                        10
                    )
                );

                startSlider();

            });

        });


        startSlider();

    }


    /* ========================================================
       REVEAL ON SCROLL
       ======================================================== */

    const revealElements =
        document.querySelectorAll('.si-reveal');


    if ('IntersectionObserver' in window) {

        const observer =
            new IntersectionObserver(
                function (entries) {

                    entries.forEach(function (entry) {

                        if (entry.isIntersecting) {

                            entry.target.classList.add('visible');

                            observer.unobserve(
                                entry.target
                            );

                        }

                    });

                },
                {
                    threshold: .08
                }
            );


        revealElements.forEach(function (element) {

            observer.observe(element);

        });

    } else {

        revealElements.forEach(function (element) {

            element.classList.add('visible');

        });

    }

});


/* ============================================================
   FILTER DOSEN
   ============================================================ */

function siFilterLecturers(category, button) {

    const buttons =
        document.querySelectorAll('.si-filter-btn');

    buttons.forEach(function (btn) {

        btn.classList.remove('active');

    });


    if (button) {
        button.classList.add('active');
    }


    const lecturers =
        document.querySelectorAll(
            '#siLecturerGrid .si-lecturer'
        );


    lecturers.forEach(function (lecturer) {

        const expert =
            lecturer.getAttribute('data-expert') || '';

        const categories =
            expert.split(',');


        const show =
            category === 'all' ||
            categories.includes(category);


        if (show) {

            lecturer.style.display = '';

            requestAnimationFrame(function () {

                lecturer.style.opacity = '1';
                lecturer.style.transform = 'translateY(0)';

            });

        } else {

            lecturer.style.display = 'none';

        }

    });

}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const navLinks = document.querySelectorAll('.si-nav-link');

    function setActiveMenu() {
        const hash = window.location.hash;

        navLinks.forEach(link => {
            link.classList.remove('active');

            if (hash && link.getAttribute('href').endsWith(hash)) {
                link.classList.add('active');
            }
        });
    }

    setActiveMenu();

    window.addEventListener('hashchange', setActiveMenu);

});
</script>

<script>
function openDeveloperModal() {
    const modal = document.getElementById('developerModal');

    if (!modal) return;

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeveloperModal() {
    const modal = document.getElementById('developerModal');

    if (!modal) return;

    modal.classList.remove('active');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeveloperModal();
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const links = document.querySelectorAll('.si-nav-link[data-section]');

    function updateActiveMenu() {

        const hash = window.location.hash;

        links.forEach(link => {
            link.classList.remove('active');
        });

        if (!hash) return;

        links.forEach(link => {
            if ('#' + link.dataset.section === hash) {
                link.classList.add('active');
            }
        });
    }

    updateActiveMenu();

    window.addEventListener('hashchange', updateActiveMenu);

});
</script>
@endsection