@extends('layouts.public')

@section('title', 'Berita & Pengumuman Terbaru - Sistem Informasi LPKIA')

@section('styles')
<style>
    .posts-page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
        margin-bottom: 50px;
        position: relative;
        overflow: hidden;
    }
    .posts-page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(124, 58, 237, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }
    .posts-page-header h2 {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 10px;
    }
    .posts-page-header p {
        font-size: 1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    .pagination-wrapper {
        margin-top: 50px;
        display: flex;
        justify-content: center;
    }
    .pagination {
        display: flex;
        list-style: none;
        padding-left: 0;
        border-radius: 4px;
        gap: 8px;
    }
    .page-item .page-link {
        display: block;
        padding: 10px 18px;
        color: var(--primary);
        background-color: var(--bg-white);
        border: 1px solid var(--border-color);
        text-decoration: none;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 0.9rem;
        transition: var(--transition);
    }
    .page-item.active .page-link, .page-item .page-link:hover {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    .page-item.disabled .page-link {
        color: var(--text-light);
        pointer-events: none;
        background-color: #F8FAFC;
        border-color: var(--border-color);
    }
</style>
@endsection

@section('content')
    <!-- Page Header Banner -->
    <div class="posts-page-header">
        <div class="container">
            <h2>Berita & Informasi Terbaru</h2>
            <p>Ikuti perkembangan terbaru, agenda akademik, prestasi mahasiswa, dan pengumuman resmi Program Studi Sistem Informasi LPKIA.</p>
        </div>
    </div>

    <!-- Posts Grid Listing -->
    <section class="content-section" style="padding-top: 0;">
        <div class="container">
            <div class="grid-3-col">
                @forelse($posts as $post)
                    <article class="post-card" style="background-color: var(--bg-white);">
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
                    <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: var(--text-muted);">
                        <i class="fa-regular fa-folder-open fa-3x" style="margin-bottom: 15px; display: block;"></i>
                        Belum ada berita yang diterbitkan saat ini.
                    </div>
                @endforelse
            </div>

            <!-- Custom Styled Pagination -->
            @if($posts->hasPages())
                <div class="pagination-wrapper">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
