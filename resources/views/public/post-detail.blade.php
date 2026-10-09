@extends('layouts.public')

@section('title', $post->title . ' - Sistem Informasi LPKIA')

@section('styles')
<style>
    :root {
        --news-blue: #0b63f6;
        --news-blue-dark: #084bb8;
        --news-dark: #101828;
        --news-muted: #667085;
        --news-border: #e4e7ec;
        --news-bg: #f8fafc;
        --news-white: #ffffff;
    }

    * {
        box-sizing: border-box;
    }

    body {
        background: var(--news-bg);
        color: var(--news-dark);
    }

    /* ==============================
       PAGE WRAPPER
    ============================== */

    .news-page {
        padding: 55px 0 90px;
        min-height: 100vh;
    }

    .news-container {
        width: min(1180px, calc(100% - 40px));
        margin: 0 auto;
    }

    .news-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 30px;
        align-items: start;
    }

    /* ==============================
       MAIN ARTICLE
    ============================== */

    .article-card {
        background: #fff;
        border: 1px solid var(--news-border);
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(16, 24, 40, 0.06);
    }

    .article-inner {
        padding: 38px 42px 45px;
    }

    /* Breadcrumb */

    .news-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
        margin-bottom: 28px;
        font-size: 13px;
        color: var(--news-muted);
    }

    .news-breadcrumb a {
        color: var(--news-blue);
        text-decoration: none;
        font-weight: 700;
    }

    .news-breadcrumb a:hover {
        text-decoration: underline;
    }

    .breadcrumb-separator {
        color: #98a2b3;
    }

    /* Category */

    .article-category {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 13px;
        background: #eaf2ff;
        color: var(--news-blue);
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: 17px;
    }

    /* Title */

    .article-title {
        margin: 0;
        font-size: clamp(2rem, 4vw, 3.25rem);
        line-height: 1.08;
        letter-spacing: -0.04em;
        font-weight: 850;
        color: #101828;
        max-width: 900px;
    }

    /* Meta */

    .article-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 18px;
        margin-top: 22px;
        padding-bottom: 25px;
        border-bottom: 1px solid var(--news-border);
    }

    .article-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--news-muted);
        font-size: 14px;
    }

    .article-meta-item i {
        color: var(--news-blue);
    }

    .article-author {
        font-weight: 700;
        color: #344054;
    }

    /* Featured Image */

    .article-featured {
        margin: 30px 0 35px;
        border-radius: 17px;
        overflow: hidden;
        background: #eef2f6;
    }

    .article-featured img {
        display: block;
        width: 100%;
        max-height: 620px;
        object-fit: cover;
    }

    .article-no-image {
        min-height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        color: #98a2b3;
        background: linear-gradient(135deg, #f2f4f7, #e4e7ec);
    }

    .article-no-image i {
        font-size: 45px;
    }

    /* Content */

    .article-content {
        color: #344054;
        font-size: 17px;
        line-height: 1.9;
        word-break: break-word;
    }

    .article-content p {
        margin: 0 0 22px;
    }

    .article-content h1,
    .article-content h2,
    .article-content h3,
    .article-content h4 {
        color: #101828;
        line-height: 1.3;
        margin-top: 35px;
        margin-bottom: 15px;
    }

    .article-content h2 {
        font-size: 27px;
    }

    .article-content h3 {
        font-size: 22px;
    }

    .article-content a {
        color: var(--news-blue);
        font-weight: 600;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 14px;
        margin: 20px 0;
    }

    .article-content blockquote {
        margin: 30px 0;
        padding: 20px 24px;
        border-left: 4px solid var(--news-blue);
        background: #f5f9ff;
        border-radius: 0 12px 12px 0;
        color: #475467;
    }

    .article-content ul,
    .article-content ol {
        padding-left: 28px;
        margin-bottom: 24px;
    }

    /* ==============================
   BERITA TERBARU
============================== */

.recent-news-section {
    margin-top: 60px;
    padding-top: 45px;
    border-top: 1px solid var(--news-border);
}

.recent-news-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 30px;
    margin-bottom: 28px;
}

.recent-news-label {
    display: block;
    margin-bottom: 10px;

    color: var(--news-blue);

    font-size: 11px;
    font-weight: 800;
    letter-spacing: .14em;
}

.recent-news-header h2 {
    margin: 0;

    color: #101828;

    font-size: clamp(25px, 3vw, 34px);
    line-height: 1.15;
    letter-spacing: -.04em;
}

.recent-news-header p {
    max-width: 600px;
    margin: 10px 0 0;

    color: var(--news-muted);

    font-size: 14px;
    line-height: 1.7;
}

.recent-news-link {
    color: var(--news-blue);
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    white-space: nowrap;
}

.recent-news-link:hover {
    text-decoration: underline;
}


/* GRID */

.recent-news-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}


/* CARD */

.recent-news-card {
    display: flex;
    flex-direction: column;

    overflow: hidden;

    background: #fff;

    border: 1px solid var(--news-border);
    border-radius: 16px;

    text-decoration: none;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}

.recent-news-card:hover {
    transform: translateY(-5px);

    border-color: rgba(11, 99, 246, .35);

    box-shadow:
        0 18px 40px rgba(16, 24, 40, .10);
}


/* IMAGE */

.recent-news-image {
    width: 100%;
    height: 175px;

    overflow: hidden;

    background: #eef2f6;
}

.recent-news-image img {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;

    transition: transform .45s ease;
}

.recent-news-card:hover .recent-news-image img {
    transform: scale(1.05);
}

.recent-news-no-image {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    background: linear-gradient(
        135deg,
        #eef4ff,
        #dbeafe
    );

    color: var(--news-blue);

    font-size: 32px;
}


/* CONTENT */

.recent-news-content {
    display: flex;
    flex-direction: column;

    flex: 1;

    padding: 20px;
}

.recent-news-category {
    display: inline-block;

    margin-bottom: 9px;

    color: var(--news-blue);

    font-size: 10px;
    font-weight: 800;

    text-transform: uppercase;
    letter-spacing: .08em;
}

.recent-news-content h3 {
    margin: 0;

    color: #101828;

    font-size: 17px;
    line-height: 1.35;
    letter-spacing: -.02em;
}

.recent-news-date {
    display: flex;
    align-items: center;
    gap: 6px;

    margin-top: 14px;

    color: #98a2b3;

    font-size: 11px;
}

.recent-news-read {
    margin-top: auto;
    padding-top: 18px;

    color: var(--news-blue);

    font-size: 12px;
    font-weight: 800;
}


/* EMPTY */

.recent-news-empty {
    padding: 25px;

    border: 1px dashed var(--news-border);
    border-radius: 14px;

    color: var(--news-muted);

    text-align: center;
    font-size: 14px;
}


/* RESPONSIVE */

@media (max-width: 900px) {

    .recent-news-grid {
        grid-template-columns: 1fr 1fr;
    }

}

@media (max-width: 600px) {

    .recent-news-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .recent-news-grid {
        grid-template-columns: 1fr;
    }

    .recent-news-image {
        height: 210px;
    }

}

    /* ==============================
       COMMENTS
    ============================== */

    .comments-section {
        margin-top: 42px;
        padding-top: 35px;
        border-top: 1px solid var(--news-border);
    }

    .comments-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 10px;
        color: #101828;
        font-size: 23px;
        font-weight: 800;
    }

    .comments-heading i {
        color: var(--news-blue);
    }

    .comments-description {
        color: var(--news-muted);
        font-size: 14px;
        margin-bottom: 25px;
    }

    .comment-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 30px;
    }

    .comment-item {
        padding: 20px;
        border: 1px solid var(--news-border);
        border-radius: 15px;
        background: #fff;
    }

    .comment-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 12px;
    }

    .comment-author {
        font-weight: 800;
        color: #101828;
    }

    .comment-date {
        color: #98a2b3;
        font-size: 12px;
    }

    .comment-text {
        color: #475467;
        line-height: 1.7;
        font-size: 14px;
        margin: 0;
    }

    .comment-form {
        background: #f8fafc;
        border: 1px solid var(--news-border);
        border-radius: 18px;
        padding: 27px;
    }

    .comment-form-title {
        margin: 0 0 22px;
        color: #101828;
        font-size: 18px;
        font-weight: 800;
    }

    .comment-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 17px;
    }

    .comment-field {
        margin-bottom: 17px;
    }

    .comment-field.full {
        grid-column: 1 / -1;
    }

    .comment-field label {
        display: block;
        margin-bottom: 7px;
        color: #344054;
        font-size: 13px;
        font-weight: 700;
    }

    .comment-field input,
    .comment-field textarea {
        width: 100%;
        border: 1px solid #d0d5dd;
        border-radius: 11px;
        background: #fff;
        padding: 12px 14px;
        font-family: inherit;
        font-size: 14px;
        color: #101828;
        outline: none;
        transition: .2s ease;
    }

    .comment-field input {
        height: 46px;
    }

    .comment-field textarea {
        min-height: 135px;
        resize: vertical;
    }

    .comment-field input:focus,
    .comment-field textarea:focus {
        border-color: var(--news-blue);
        box-shadow: 0 0 0 4px rgba(11, 99, 246, .10);
    }

    .comment-submit {
        border: none;
        border-radius: 10px;
        padding: 12px 20px;
        background: linear-gradient(135deg, var(--news-blue), #3984ff);
        color: #fff;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(11, 99, 246, .22);
        transition: .2s ease;
    }

    .comment-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 11px 25px rgba(11, 99, 246, .28);
    }

    /* ==============================
       SIDEBAR
    ============================== */

    .news-sidebar {
        display: flex;
        flex-direction: column;
        gap: 22px;
        position: sticky;
        top: 25px;
    }

    .sidebar-card {
        background: #fff;
        border: 1px solid var(--news-border);
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 10px 28px rgba(16, 24, 40, .05);
    }

    .sidebar-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 18px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--news-border);
        color: #101828;
        font-size: 17px;
        font-weight: 800;
    }

    .sidebar-title::before {
        content: "";
        width: 4px;
        height: 22px;
        border-radius: 999px;
        background: var(--news-blue);
    }

    /* Category */

    .category-list {
        display: flex;
        flex-direction: column;
    }

    .category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 12px 0;
        color: #344054;
        text-decoration: none;
        border-bottom: 1px solid #f2f4f7;
        font-size: 14px;
        transition: .2s ease;
    }

    .category-link:last-child {
        border-bottom: none;
    }

    .category-link:hover {
        color: var(--news-blue);
        padding-left: 4px;
    }

    .category-count {
        min-width: 28px;
        height: 26px;
        padding: 0 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f2f4f7;
        color: #667085;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
    }

    /* Latest Posts */

    .latest-post {
        display: grid;
        grid-template-columns: 76px minmax(0, 1fr);
        gap: 12px;
        padding: 13px 0;
        border-bottom: 1px solid #f2f4f7;
        text-decoration: none;
    }

    .latest-post:last-child {
        border-bottom: none;
    }

    .latest-post-image {
        width: 76px;
        height: 64px;
        border-radius: 10px;
        overflow: hidden;
        background: #f2f4f7;
    }

    .latest-post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .latest-post-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #98a2b3;
    }

    .latest-post-title {
        margin: 0 0 7px;
        color: #101828;
        font-size: 13px;
        font-weight: 800;
        line-height: 1.4;
    }

    .latest-post-date {
        color: #98a2b3;
        font-size: 11px;
    }

    .latest-post:hover .latest-post-title {
        color: var(--news-blue);
    }

    /* ==============================
       RESPONSIVE
    ============================== */

    @media (max-width: 950px) {
        .news-grid {
            grid-template-columns: 1fr;
        }

        .news-sidebar {
            position: static;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 700px) {
        .news-page {
            padding: 25px 0 55px;
        }

        .news-container {
            width: min(100% - 24px, 1180px);
        }

        .article-inner {
            padding: 25px 20px 30px;
        }

        .article-title {
            font-size: 2rem;
        }

        .article-meta {
            gap: 11px;
        }

        .article-featured {
            margin: 22px 0 27px;
            border-radius: 12px;
        }

        .article-content {
            font-size: 16px;
            line-height: 1.8;
        }

        .comment-form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .comment-field.full {
            grid-column: auto;
        }

        .news-sidebar {
            grid-template-columns: 1fr;
        }

        .sidebar-card {
            padding: 20px;
        }
    }
</style>
@endsection


@section('content')

<div class="news-page">

    <div class="news-container">

        <div class="news-grid">

            {{-- =====================================
                 ARTICLE
            ====================================== --}}

            <main>

                <article class="article-card">

                    <div class="article-inner">

                        {{-- Breadcrumb --}}
                        <nav class="news-breadcrumb">

                            <a href="{{ route('home') }}">
                                <i class="fa-solid fa-house"></i>
                                Beranda
                            </a>

                            <span class="breadcrumb-separator">/</span>

                            <a href="{{ route('public.posts') }}">
                                Berita
                            </a>

                            <span class="breadcrumb-separator">/</span>

                            <span>
                                {{ \Illuminate\Support\Str::limit($post->title, 40) }}
                            </span>

                        </nav>


                        {{-- Category --}}
                        @if($post->category)
                            <div class="article-category">
                                <i class="fa-solid fa-folder"></i>

                                {{ $post->category->name }}
                            </div>
                        @endif


                        {{-- Title --}}
                        <h1 class="article-title">
                            {{ $post->title }}
                        </h1>


                        {{-- Metadata --}}
                        <div class="article-meta">

                            <span class="article-meta-item">
                                <i class="fa-regular fa-calendar"></i>

                                {{ $post->published_at
                                    ? $post->published_at->format('d M Y')
                                    : $post->created_at->format('d M Y') }}
                            </span>

                            <span class="article-meta-item">
                                <i class="fa-regular fa-clock"></i>

                                {{ $post->published_at
                                    ? $post->published_at->format('H:i')
                                    : $post->created_at->format('H:i') }}
                            </span>

                            @if($post->author)
                                <span class="article-meta-item article-author">
                                    <i class="fa-regular fa-user"></i>

                                    {{ $post->author->name }}
                                </span>
                            @endif

                        </div>


                        {{-- Featured Image --}}
                        <div class="article-featured">

                            @if($post->featured_image)

                                <img
                                    src="{{ asset($post->featured_image) }}"
                                    alt="{{ $post->title }}"
                                >

                            @else

                                <div class="article-no-image">
                                    <i class="fa-regular fa-image"></i>
                                    <span>Tidak ada gambar utama</span>
                                </div>

                            @endif

                        </div>


                        {{-- Article Content --}}
                        <div class="article-content">

                            {!! $post->content !!}

                        </div>

                        {{-- =====================================
     BERITA TERBARU
====================================== --}}

<section class="recent-news-section">

    <div class="recent-news-header">

        <div>
            <span class="recent-news-label">
                BERITA TERBARU
            </span>

            <h2>
                Berita terbaru dari Sistem Informasi
            </h2>

            <p>
                Informasi, kegiatan, dan kabar terbaru dari Program Studi Sistem Informasi LPKIA.
            </p>
        </div>

        <a href="{{ route('public.posts') }}" class="recent-news-link">
            Lihat semua berita →
        </a>

    </div>


    @php
        $latestPosts = \App\Models\Post::with(['category'])
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where(function($query) {
                $query->whereNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->take(3)
            ->get();
    @endphp


    @if($latestPosts->count())

        <div class="recent-news-grid">

            @foreach($latestPosts as $latest)

                <a
                    href="{{ route('public.post.show', $latest->slug) }}"
                    class="recent-news-card"
                >

                    <div class="recent-news-image">

                        @if($latest->featured_image)

                            <img
                                src="{{ asset($latest->featured_image) }}"
                                alt="{{ $latest->title }}"
                            >

                        @else

                            <div class="recent-news-no-image">
                                <i class="fa-regular fa-newspaper"></i>
                            </div>

                        @endif

                    </div>


                    <div class="recent-news-content">

                        @if($latest->category)

                            <span class="recent-news-category">
                                {{ $latest->category->name }}
                            </span>

                        @endif


                        <h3>
                            {{ $latest->title }}
                        </h3>


                        <div class="recent-news-date">

                            <i class="fa-regular fa-calendar"></i>

                            {{ $latest->published_at
                                ? $latest->published_at->format('d M Y')
                                : $latest->created_at->format('d M Y') }}

                        </div>


                        <span class="recent-news-read">
                            Baca berita →
                        </span>

                    </div>

                </a>

            @endforeach

        </div>

    @else

        <div class="recent-news-empty">
            Belum ada berita lainnya.
        </div>

    @endif

</section>

                        {{-- =====================================
                             COMMENTS
                        ====================================== --}}

                        <section class="comments-section">

                            <h2 class="comments-heading">

                                <i class="fa-regular fa-comments"></i>

                                Komentar
                                ({{ $post->comments->where('status', 'approved')->count() }})

                            </h2>

                            <p class="comments-description">

                                Silakan berikan komentar atau pendapat kamu mengenai berita ini.

                            </p>


                            {{-- Comment List --}}
                            <div class="comment-list">

                                @forelse(
                                    $post->comments->where('status', 'approved')
                                    as $comment
                                )

                                    <div class="comment-item">

                                        <div class="comment-top">

                                            <span class="comment-author">
                                                {{ $comment->author_name }}
                                            </span>

                                            <span class="comment-date">
                                                {{ $comment->created_at->format('d M Y H:i') }}
                                            </span>

                                        </div>

                                        <p class="comment-text">
                                            {{ $comment->content }}
                                        </p>

                                    </div>

                                @empty

                                    <div class="comment-item">

                                        <p class="comment-text">
                                            Belum ada komentar untuk postingan ini.
                                            Jadilah yang pertama berkomentar!
                                        </p>

                                    </div>

                                @endforelse

                            </div>


                            {{-- Comment Form --}}
                            <div class="comment-form">

                                <h3 class="comment-form-title">
                                    Tinggalkan Komentar
                                </h3>


                                @if(session('success'))

                                    <div style="
                                        margin-bottom:20px;
                                        padding:12px 15px;
                                        border-radius:10px;
                                        background:#ecfdf3;
                                        color:#027a48;
                                        border:1px solid #abefc6;
                                        font-size:14px;
                                        font-weight:600;
                                    ">
                                        {{ session('success') }}
                                    </div>

                                @endif


                                @if($errors->any())

                                    <div style="
                                        margin-bottom:20px;
                                        padding:12px 15px;
                                        border-radius:10px;
                                        background:#fef3f2;
                                        color:#b42318;
                                        border:1px solid #fecdca;
                                        font-size:14px;
                                    ">

                                        @foreach($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach

                                    </div>

                                @endif


                                <form
                                    action="{{ route('public.comment.store', $post->id) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <div class="comment-form-grid">

                                        <div class="comment-field">

                                            <label for="author_name">
                                                Nama Lengkap *
                                            </label>

                                            <input
                                                type="text"
                                                id="author_name"
                                                name="author_name"
                                                value="{{ old('author_name') }}"
                                                placeholder="Masukkan nama lengkap"
                                                required
                                            >

                                        </div>


                                        <div class="comment-field">

                                            <label for="author_email">
                                                Alamat Email *
                                            </label>

                                            <input
                                                type="email"
                                                id="author_email"
                                                name="author_email"
                                                value="{{ old('author_email') }}"
                                                placeholder="Masukkan email"
                                                required
                                            >

                                        </div>


                                        <div class="comment-field full">

                                            <label for="content">
                                                Isi Komentar *
                                            </label>

                                            <textarea
                                                id="content"
                                                name="content"
                                                placeholder="Tulis komentar Anda di sini..."
                                                required
                                            >{{ old('content') }}</textarea>

                                        </div>

                                    </div>


                                    <button
                                        type="submit"
                                        class="comment-submit"
                                    >

                                        <i class="fa-solid fa-paper-plane"></i>

                                        Kirim Komentar

                                    </button>

                                </form>

                            </div>

                        </section>

                    </div>

                </article>

            </main>


            {{-- =====================================
                 SIDEBAR
            ====================================== --}}

            <aside class="news-sidebar">


                {{-- Categories --}}
                <div class="sidebar-card">

                    <h3 class="sidebar-title">
                        Kategori Berita
                    </h3>

                    <div class="category-list">

                        @php
                            $categories = \App\Models\Category::withCount([
                                'posts' => function ($query) {
                                    $query->where('status', 'published');
                                }
                            ])->get();
                        @endphp


                        @forelse($categories as $category)

                            <a
                                href="{{ route('public.posts', ['category_id' => $category->id]) }}"
                                class="category-link"
                            >

                                <span>
                                    {{ $category->name }}
                                </span>

                                <span class="category-count">
                                    {{ $category->posts_count }}
                                </span>

                            </a>

                        @empty

                            <span style="
                                color:#98a2b3;
                                font-size:13px;
                            ">
                                Belum ada kategori.
                            </span>

                        @endforelse

                    </div>

                </div>


                


            </aside>

        </div>

    </div>

</div>

@endsection