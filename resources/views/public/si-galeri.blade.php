@extends('layouts.public')

@section('title', 'Galeri Sistem Informasi LPKIA')

@section('styles')
<style>

    :root {
        --sig-bg: #ffffff;
        --sig-bg-soft: #f8fafc;
        --sig-card: #ffffff;
        --sig-border: rgba(15, 23, 42, .10);
        --sig-text: #0f172a;
        --sig-muted: #64748b;
        --sig-blue: #2563eb;
        --sig-blue-soft: rgba(37, 99, 235, .08);
        --sig-nav-bg: rgba(255,255,255,.97);
    }

    html.dark-mode {
        --sig-bg: #070b14;
        --sig-bg-soft: #0c1220;
        --sig-card: #101827;
        --sig-border: rgba(255,255,255,.09);
        --sig-text: #f5f7fb;
        --sig-muted: #98a5ba;
        --sig-blue: #5da2ff;
        --sig-blue-soft: rgba(93,162,255,.12);
        --sig-nav-bg: rgba(7,11,20,.97);
    }

    * {
        box-sizing: border-box;
    }

    html,
    body {
        background: var(--sig-bg);
        color: var(--sig-text);
        transition: background .25s ease, color .25s ease;
    }

    body {
        margin: 0;
    }

    /* =========================================
       PAGE
    ========================================= */

    .sig-page {
        min-height: 100vh;
        overflow: visible;
        background:
            radial-gradient(
                circle at 80% 5%,
                rgba(93,162,255,.08),
                transparent 30%
            ),
            var(--sig-bg);
        color: var(--sig-text);
    }

    .sig-container {
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* =========================================
       HERO
    ========================================= */

    .sig-hero {
        padding: 150px 0 100px;
        border-bottom: 1px solid var(--sig-border);
    }

    .sig-label {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 30px;

        color: var(--sig-blue);
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .16em;
        text-transform: uppercase;
    }

    .sig-label::before {
        content: "";
        width: 32px;
        height: 1px;
        background: var(--sig-blue);
    }

    .sig-hero-grid {
        display: grid;
        grid-template-columns: 1.15fr .85fr;
        gap: 80px;
        align-items: end;
    }

    .sig-title {
        margin: 0;

        font-size: clamp(4rem, 8vw, 8.5rem);
        line-height: .84;
        letter-spacing: -.065em;
        font-weight: 900;
    }

    .sig-title span {
        color: var(--sig-blue);
    }

    .sig-hero-desc {
        max-width: 500px;
        margin: 0;

        color: var(--sig-muted);
        font-size: 1.05rem;
        line-height: 1.8;
    }

    .sig-hero-note {
        margin-top: 30px;

        color: #dce4f0;
        font-size: .8rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }


    /* =========================================
       GALERI BRAND / LOGO
    ========================================= */

    .sig-gallery-brand {
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
        padding: 26px 0 20px;
    }

    .sig-gallery-brand-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .sig-gallery-brand-link {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: inherit;
        text-decoration: none;
    }

    .sig-theme-toggle {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--sig-border);
        border-radius: 12px;
        background: transparent;
        color: var(--sig-text);
        cursor: pointer;
        font-size: 1rem;
        transition: .25s ease;
    }

    .sig-theme-toggle:hover {
        color: var(--sig-blue);
        border-color: var(--sig-blue);
        background: var(--sig-blue-soft);
    }

    .sig-gallery-logo {
        width: 52px !important;
        height: 52px !important;
        max-width: 52px;
        max-height: 52px;
        object-fit: contain;
        display: block;
        flex: 0 0 52px;
    }

    .sig-gallery-brand-text {
        display: flex;
        flex-direction: column;
        gap: 3px;
        line-height: 1.05;
    }

    .sig-gallery-brand-text span {
        color: var(--sig-blue);
        font-size: .62rem;
        font-weight: 800;
        letter-spacing: .14em;
        line-height: 1;
    }

    .sig-gallery-brand-text strong {
        color: var(--sig-text);
        font-size: .82rem;
        font-weight: 800;
        letter-spacing: .04em;
        line-height: 1.2;
    }

    /* =========================================
       CATEGORY
    ========================================= */

    .sig-filter-wrap {
        position: relative;
        width: 100%;
    }

    .sig-sticky-bar {
        position: sticky;
        top: 0;
        z-index: 1000;
        width: 100%;
        background: var(--sig-nav-bg);
        border-top: 1px solid var(--sig-border);
        border-bottom: 1px solid var(--sig-border);
        box-shadow: 0 8px 24px rgba(15, 23, 42, .08);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
    }

    .sig-filter-spacer {
        display: none;
        height: 0;
    }

    .sig-filter-wrap.is-pinned .sig-filter-spacer {
        display: block;
    }

    .sig-categories {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
        gap: 10px;
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
        padding: 16px 0;
        overflow-x: auto;
        overflow-y: hidden;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }

    .sig-categories::-webkit-scrollbar {
        display: none;
    }

    .sig-category {
        flex: 0 0 auto;
        white-space: nowrap;
        padding: 10px 18px;
        border: 1px solid var(--sig-border);
        border-radius: 999px;
        background: transparent;
        color: var(--sig-muted);
        text-decoration: none;
        font-size: .78rem;
        font-weight: 700;
        transition: .25s ease;
    }

    .sig-category:hover,
    .sig-category.active {
        border-color: var(--sig-blue);
        background: var(--sig-blue-soft);
        color: var(--sig-blue);
    }


    /* =========================================
       FEATURE
    ========================================= */

    .sig-section {
        padding: 110px 0;
    }

    .sig-section-head {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 30px;
        margin-bottom: 45px;
    }

    .sig-section-number {
        color: var(--sig-blue);
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .sig-section-title {
        margin: 8px 0 0;

        font-size: clamp(2.5rem, 5vw, 5rem);
        line-height: .95;
        letter-spacing: -.05em;
        font-weight: 900;
    }

    .sig-section-description {
        max-width: 430px;

        margin: 0;

        color: var(--sig-muted);
        line-height: 1.7;
    }


    /* =========================================
       FEATURE CARD
    ========================================= */

    .sig-feature {
        display: grid;
        grid-template-columns: 1.5fr .8fr;

        min-height: 520px;

        border: 1px solid var(--sig-border);
        background: var(--sig-card);

        overflow: hidden;
    }

    .sig-feature-image {
        position: relative;
        min-height: 520px;
        overflow: hidden;
    }

    .sig-feature-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;

        transition: transform .6s ease;
    }

    .sig-feature:hover img {
        transform: scale(1.04);
    }

    .sig-feature-image::after {
        content: "";
        position: absolute;
        inset: 0;

        background: linear-gradient(
            to top,
            rgba(0,0,0,.75),
            transparent 60%
        );
    }

    .sig-feature-content {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;

        padding: 42px;
    }

    .sig-meta {
        color: var(--sig-blue);

        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .sig-feature-title {
        margin: 14px 0;

        font-size: 2.3rem;
        line-height: 1;
        letter-spacing: -.04em;
        font-weight: 900;
    }

    .sig-feature-text {
        margin: 0;

        color: var(--sig-muted);
        line-height: 1.7;
    }


    /* =========================================
       GALLERY GRID
    ========================================= */

    .sig-gallery {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .sig-gallery-card {
        position: relative;

        height: 380px;

        overflow: hidden;

        border: 1px solid var(--sig-border);
        background: var(--sig-card);
    }

    .sig-gallery-card:nth-child(1) {
        grid-column: span 2;
    }

    .sig-gallery-card:nth-child(4) {
        grid-column: span 2;
    }

    .sig-gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;

        display: block;

        transition: transform .6s ease;
    }

    .sig-gallery-card:hover img {
        transform: scale(1.06);
    }

    .sig-gallery-card::after {
        content: "";
        position: absolute;
        inset: 0;

        background: linear-gradient(
            to top,
            rgba(0,0,0,.85),
            rgba(0,0,0,.05) 65%
        );
    }

    .sig-gallery-info {
        position: absolute;
        z-index: 2;

        left: 26px;
        right: 26px;
        bottom: 24px;
    }

    .sig-gallery-info span {
        color: var(--sig-blue);

        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .sig-gallery-info h3 {
        margin: 7px 0 0;

        color: #fff;

        font-size: 1.45rem;
        line-height: 1.05;
        font-weight: 900;
    }


    /* =========================================
       INFORMAL / STORIES
    ========================================= */

    .sig-stories {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .sig-story {
        padding: 30px;

        border: 1px solid var(--sig-border);
        background: var(--sig-bg-soft);

        transition: .25s ease;
    }

    .sig-story:hover {
        border-color: var(--sig-blue);
        transform: translateY(-4px);
    }

    .sig-story-number {
        color: var(--sig-blue);

        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .1em;
    }

    .sig-story h3 {
        margin: 35px 0 15px;

        font-size: 1.45rem;
        line-height: 1.1;
        letter-spacing: -.025em;
    }

    .sig-story p {
        margin: 0;

        color: var(--sig-muted);
        line-height: 1.7;
    }

    .sig-story-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        margin-top: 25px;

        color: var(--sig-text);
        text-decoration: none;

        font-size: .8rem;
        font-weight: 800;
    }

    .sig-story-link:hover {
        color: var(--sig-blue);
    }


    /* =========================================
       HIMA
    ========================================= */

    .sig-hima {
        display: grid;
        grid-template-columns: .8fr 1.2fr;
        gap: 70px;
        align-items: center;

        padding: 70px;

        border: 1px solid var(--sig-border);
        background:
            linear-gradient(
                135deg,
                rgba(93,162,255,.08),
                transparent 55%
            );
    }

    .sig-hima-title {
        margin: 10px 0 20px;

        font-size: clamp(2.5rem, 5vw, 5rem);
        line-height: .9;
        letter-spacing: -.05em;
        font-weight: 900;
    }

    .sig-hima-text {
        color: var(--sig-muted);
        line-height: 1.8;
    }

    .sig-hima-list {
        display: grid;
        gap: 12px;
    }

    .sig-hima-item {
        display: flex;
        justify-content: space-between;
        align-items: center;

        padding: 20px 0;

        border-bottom: 1px solid var(--sig-border);
    }

    .sig-hima-item strong {
        font-size: 1rem;
    }

    .sig-hima-item span {
        color: var(--sig-muted);
        font-size: .75rem;
    }


    /* =========================================
       CTA
    ========================================= */

    .sig-cta {
        padding: 100px 0 130px;

        text-align: center;
    }

    .sig-cta h2 {
        max-width: 850px;
        margin: 0 auto 25px;

        font-size: clamp(3rem, 7vw, 7rem);
        line-height: .88;
        letter-spacing: -.06em;
        font-weight: 900;
    }

    .sig-cta p {
        max-width: 550px;
        margin: 0 auto;

        color: var(--sig-muted);
        line-height: 1.7;
    }


    /* Keep anchor targets visible below the fixed navbar + filter. */
    #kegiatan,
    #kampus,
    #hima,
    #santai,
    #cerita {
        scroll-margin-top: 150px;
    }

    /* =========================================
       RESPONSIVE
    ========================================= */

    @media (max-width: 900px) {

        .sig-hero-grid,
        .sig-feature,
        .sig-hima {
            grid-template-columns: 1fr;
        }

        .sig-gallery,
        .sig-stories {
            grid-template-columns: repeat(2, 1fr);
        }

        .sig-gallery-card:nth-child(1),
        .sig-gallery-card:nth-child(4) {
            grid-column: auto;
        }

        .sig-feature-image {
            min-height: 380px;
        }

        .sig-hima {
            padding: 40px;
        }
    }


    @media (max-width: 600px) {

        .sig-container {
            width: min(100% - 30px, 1180px);
        }

        .sig-gallery-brand {
            width: min(100% - 30px, 1180px);
        }

        .sig-gallery-brand {
            padding: 22px 0 16px;
        }

        .sig-gallery-brand-row {
            gap: 12px;
        }

        .sig-theme-toggle {
            width: 42px;
            height: 42px;
            flex-basis: 42px;
            border-radius: 11px;
        }

        .sig-categories {
            width: 100%;
            padding: 14px 15px;
            gap: 10px;
        }

        .sig-category {
            padding: 11px 20px;
            font-size: .82rem;
        }

        .sig-hero {
            padding: 110px 0 70px;
        }

        .sig-title {
            font-size: 4rem;
        }

        .sig-section {
            padding: 75px 0;
        }

        .sig-gallery,
        .sig-stories {
            grid-template-columns: 1fr;
        }

        .sig-gallery-card {
            height: 300px;
        }

        .sig-feature-content {
            padding: 28px;
        }

        .sig-hima {
            padding: 30px;
        }

        .sig-section-head {
            display: block;
        }

        .sig-section-description {
            margin-top: 20px;
        }
    }

</style>
@endsection


@section('content')

    <div class="sig-page">

    <!-- =====================================
         GALERI HEADER / LOGO
    ====================================== -->

    <div class="sig-gallery-brand">
        <div class="sig-gallery-brand-row">
            <a href="{{ route('home') }}" class="sig-gallery-brand-link" aria-label="Prodi Sistem Informasi LPKIA">
                <img
                    src="{{ asset('images/logo-lpkiaa.png') }}"
                    alt="Logo LPKIA"
                    class="sig-gallery-logo"
                >
                <div class="sig-gallery-brand-text">
                    <span>PRODI</span>
                    <strong>SISTEM INFORMASI</strong>
                </div>
            </a>

            <button
                type="button"
                class="sig-theme-toggle"
                id="sigThemeToggle"
                aria-label="Ganti mode tampilan"
                title="Ganti mode tampilan"
            >
                <i class="fa-solid fa-moon" id="sigThemeIcon"></i>
            </button>
        </div>
    </div>

    <!-- =====================================
         CATEGORY
    ====================================== -->

    <div class="sig-filter-wrap" id="sigFilterWrap">
        <div class="sig-sticky-bar" id="sigStickyBar">
            <div class="sig-categories">

    {{-- SEMUA --}}
    <a
        href="{{ route('si.galeri') }}#kampus"
        class="sig-category {{ !request('category') ? 'active' : '' }}"
    >
        Semua
    </a>

    {{-- KATEGORI DARI DATABASE --}}
    @foreach($categories as $category)

        <a
            href="{{ route('si.galeri', ['category' => $category]) }}#kampus"
            class="sig-category {{ request('category') === $category ? 'active' : '' }}"
        >
            {{ $category }}
        </a>

    @endforeach

            </div>
        </div>
        <div class="sig-filter-spacer" id="sigFilterSpacer"></div>
    </div>


    <!-- =====================================
         FEATURE
    ====================================== -->

    <section class="sig-section" id="kegiatan">

        <div class="sig-container">

            <div class="sig-section-head">

                <div>

                    <div class="sig-section-number">
                        
                    </div>

                    <h2 class="sig-section-title">
                        Apa yang<br>
                        sedang terjadi?
                    </h2>

                </div>

                <p class="sig-section-description">
                    Cerita terbaru dari lingkungan Sistem Informasi,
                    mulai dari kegiatan mahasiswa sampai aktivitas
                    organisasi dan kampus.
                </p>

            </div>


            @php
                $featuredGallery = $galleries->first();
            @endphp

            <article class="sig-feature">

                <div class="sig-feature-image">

                    @if($featuredGallery && $featuredGallery->image)
                        <img
                            src="{{ filter_var($featuredGallery->image, FILTER_VALIDATE_URL) ? $featuredGallery->image : asset(ltrim($featuredGallery->image, '/')) }}"
                            alt="{{ $featuredGallery->title }}"
                        >
                    @else
                        <img
                            src="{{ asset('images/gallery/kegiatan-1.png') }}"
                            alt="Kegiatan mahasiswa Sistem Informasi"
                        >
                    @endif

                </div>

                <div class="sig-feature-content">

                    <div class="sig-meta">
                        {{ $featuredGallery->category ?? 'Kegiatan SI' }}
                    </div>

                    <h3 class="sig-feature-title">
                        {{ $featuredGallery->title ?? 'Belajar, berkarya, dan berkembang bersama.' }}
                    </h3>

                    <p class="sig-feature-text">
                        {{ $featuredGallery->description ?? 'Ruang untuk mendokumentasikan berbagai kegiatan mahasiswa Sistem Informasi LPKIA.' }}
                    </p>

                </div>

            </article>

        </div>

    </section>


    <!-- =====================================
         GALERI
    ====================================== -->

    <section class="sig-section" id="kampus">

        <div class="sig-container">

            <div class="sig-section-head">

                <div>

                    <div class="sig-section-number">
                        02 / Gallery
                    </div>

                    <h2 class="sig-section-title">
                        Kegiatan
                        <br>
                        mahasiswa.
                    </h2>

                </div>

                <p class="sig-section-description">
                    Dokumentasi aktivitas, acara, pembelajaran,
                    seminar, dan momen mahasiswa Sistem Informasi.
                </p>

            </div>


           <div class="sig-gallery">

    @forelse($galleries as $gallery)

        <article class="sig-gallery-card">

            @if($gallery->image)
                <img
                    src="{{ asset($gallery->image) }}"
                    alt="{{ $gallery->title }}"
                >
            @endif

            <div class="sig-gallery-info">

                <span>
                    {{ $gallery->category }}
                </span>

                <h3>
                    {{ $gallery->title }}
                </h3>

            </div>

        </article>

    @empty

        <div style="
            grid-column: 1 / -1;
            padding: 80px 20px;
            text-align: center;
            color: var(--sig-muted);
        ">
            <i
                class="fa-regular fa-images"
                style="
                    font-size: 3rem;
                    margin-bottom: 20px;
                    display: block;
                    opacity: .5;
                "
            ></i>

            <h3
                style="
                    color: var(--sig-text);
                    margin-bottom: 10px;
                "
            >
                Belum ada foto
            </h3>

            <p>
                Belum ada foto pada kategori ini.
            </p>
        </div>

    @endforelse

</div>

        </div>

    </section>


    <!-- =====================================
         HIMA
    ====================================== -->

    <section class="sig-section" id="hima">

        <div class="sig-container">

            <div class="sig-hima">

                <div>

                    <div class="sig-section-number">
                        03 / HIMA
                    </div>

                    <h2 class="sig-hima-title">
                        HIMA<br>
                        SI.
                    </h2>

                    <p class="sig-hima-text">
                        Tempat untuk mengenal lebih dekat kegiatan,
                        program kerja, komunitas, dan aktivitas
                        mahasiswa Sistem Informasi.
                    </p>

                </div>


                <div class="sig-hima-list">

                    <div class="sig-hima-item">
                        <strong>Program Kerja</strong>
                        <span>HIMA SI</span>
                    </div>

                    <div class="sig-hima-item">
                        <strong>Kegiatan Mahasiswa</strong>
                        <span>Student Activity</span>
                    </div>

                    <div class="sig-hima-item">
                        <strong>Seminar & Workshop</strong>
                        <span>Event</span>
                    </div>

                    <div class="sig-hima-item">
                        <strong>Kolaborasi</strong>
                        <span>Community</span>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================
         INFORMAL
    ====================================== -->

    <section class="sig-section" id="santai">

    <div class="sig-container">

        <div class="sig-section-head">

            <div>

                <div class="sig-section-number">
                    04 / Berita Terbaru
                </div>

                <h2 class="sig-section-title">
                    Berita
                    <br>
                    Sistem Informasi.
                </h2>

            </div>

            <p class="sig-section-description">
                Informasi terbaru dari lingkungan Sistem Informasi,
                mulai dari kegiatan mahasiswa, akademik, hingga
                berbagai informasi kampus.
            </p>

        </div>


        @php
            $latestNews = \App\Models\Post::with('category')
                ->where('status', 'published')
                ->orderByDesc('published_at')
                ->take(3)
                ->get();
        @endphp


        <div class="sig-stories">

            @forelse($latestNews as $index => $post)

                <article class="sig-story">

                    <div class="sig-story-number">
                        BERITA {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    <h3>
                        {{ $post->title }}
                    </h3>

                    <p>
                        {{ \Illuminate\Support\Str::limit(strip_tags($post->excerpt ?? $post->content ?? ''), 130) }}
                    </p>

                    <a
                        href="{{ route('public.post.show', $post->slug) }}"
                        class="sig-story-link"
                    >
                        Baca berita →
                    </a>

                </article>

            @empty

                <div style="
                    grid-column: 1 / -1;
                    padding: 60px 20px;
                    text-align: center;
                    color: var(--sig-muted);
                ">
                    Belum ada berita.
                </div>

            @endforelse

        </div>

    </div>

</section>


    <!-- =====================================
         CTA
    ====================================== -->

    <section class="sig-cta" id="cerita">

        <div class="sig-container">

            <h2>
                Satu jurusan.
                <br>
                Banyak cerita.
            </h2>

            <p>
                SI Galeri menjadi ruang untuk mengenal
                Sistem Informasi LPKIA dari sisi yang lebih dekat,
                lebih manusiawi, dan lebih nyata.
            </p>

        </div>

    </section>


    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const root = document.documentElement;
        const toggle = document.getElementById('sigThemeToggle');
        const icon = document.getElementById('sigThemeIcon');

        if (!toggle) return;

        const savedTheme = localStorage.getItem('si-theme');

        if (savedTheme === 'dark') {
            root.classList.add('dark-mode');
        } else if (savedTheme === 'light') {
            root.classList.remove('dark-mode');
        }

        function updateThemeIcon() {
            const isDark = root.classList.contains('dark-mode');

            if (icon) {
                icon.className = isDark
                    ? 'fa-solid fa-sun'
                    : 'fa-solid fa-moon';
            }
        }

        updateThemeIcon();

        toggle.addEventListener('click', function () {
            const isDark = root.classList.toggle('dark-mode');

            localStorage.setItem(
                'si-theme',
                isDark ? 'dark' : 'light'
            );

            updateThemeIcon();
        });
    });
    </script>

@endsection
