@extends('layouts.public')

@section('title', $post->title . ' - Sistem Informasi LPKIA')

@section('styles')
<style>
    .post-detail-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 40px;
        margin-top: 40px;
    }
    .post-main-content {
        background-color: var(--bg-white);
        border-radius: var(--border-radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }
    .post-meta-details {
        display: flex;
        gap: 20px;
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }
    .post-featured-image {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: var(--border-radius);
        margin-bottom: 30px;
    }
    .post-body-text {
        font-size: 1.05rem;
        color: var(--text-dark);
        line-height: 1.8;
    }
    .post-body-text p {
        margin-bottom: 20px;
    }
    .sidebar-widget {
        background-color: var(--bg-white);
        border-radius: var(--border-radius-lg);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        margin-bottom: 30px;
    }
    .sidebar-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary);
        border-bottom: 2px solid var(--secondary);
        padding-bottom: 8px;
        margin-bottom: 15px;
    }
    .categories-list {
        list-style: none;
    }
    .categories-list li {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.9rem;
    }
    .recent-posts-list {
        list-style: none;
    }
    .recent-posts-list li {
        margin-bottom: 15px;
        font-size: 0.88rem;
    }
    .recent-posts-list li a {
        color: var(--primary);
        font-weight: 600;
        line-height: 1.4;
        display: block;
    }
    .recent-posts-list li a:hover {
        color: var(--secondary);
    }
    .recent-posts-list li span {
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    
    /* Comments section */
    .comments-wrapper {
        margin-top: 40px;
        border-top: 1px solid var(--border-color);
        padding-top: 30px;
    }
    .comments-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 25px;
    }
    .comment-card {
        background-color: #F8FAFC;
        padding: 20px;
        border-radius: var(--border-radius);
        margin-bottom: 20px;
        border-left: 4px solid var(--primary);
    }
    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.85rem;
    }
    .comment-author {
        font-weight: 700;
        color: var(--primary);
    }
    .comment-date {
        color: var(--text-muted);
    }
    .comment-body {
        font-size: 0.92rem;
    }
    
    .comment-form-card {
        background-color: var(--bg-white);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-lg);
        padding: 30px;
        margin-top: 45px;
    }
    
    @media(max-width: 768px) {
        .post-detail-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="post-detail-layout">
        
        <!-- Main Post Details -->
        <div class="post-main-content">
            <h2 style="font-size: 2.2rem; font-weight: 800; color: var(--primary); line-height: 1.2; margin-bottom: 15px;">
                {{ $post->title }}
            </h2>
            
            <div class="post-meta-details">
                <span><i class="fa-solid fa-folder-open"></i> {{ $post->category->name }}</span>
                <span><i class="fa-solid fa-calendar-days"></i> {{ $post->published_at ? $post->published_at->format('d M Y H:i') : $post->created_at->format('d M Y') }}</span>
                <span><i class="fa-solid fa-user"></i> {{ $post->author->name }}</span>
            </div>

            @if($post->featured_image)
                <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="post-featured-image">
            @endif

            <div class="post-body-text">
                {!! $post->content !!}
            </div>

            <!-- Toast Success Alerts for Comments -->
            @if(session('success'))
                <div class="alert alert-success" style="margin-top: 30px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Comments List -->
            <div class="comments-wrapper">
                <h3 class="comments-title"><i class="fa-solid fa-comments"></i> Komentar ({{ count($post->comments) }})</h3>
                
                @forelse($post->comments as $comment)
                    <div class="comment-card">
                        <div class="comment-header">
                            <span class="comment-author"><i class="fa-solid fa-user-circle"></i> {{ $comment->author_name }}</span>
                            <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="comment-body">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p style="color: var(--text-muted); font-style: italic;">Belum ada komentar untuk postingan ini. Jadilah yang pertama berkomentar!</p>
                @endforelse
            </div>

            <!-- Comment Submission Form -->
            <div class="comment-form-card">
                <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--primary); margin-bottom: 20px;">
                    Tinggalkan Komentar
                </h4>
                <form action="{{ route('public.comment.store', $post->id) }}" method="POST">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="author_name">Nama Lengkap *</label>
                            <input type="text" name="author_name" id="author_name" class="form-control" required value="{{ old('author_name') }}">
                            @error('author_name')
                                <span style="font-size: 0.75rem; color: var(--danger);">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="author_email">Alamat Email *</label>
                            <input type="email" name="author_email" id="author_email" class="form-control" required value="{{ old('author_email') }}">
                            @error('author_email')
                                <span style="font-size: 0.75rem; color: var(--danger);">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="content">Isi Komentar *</label>
                        <textarea name="content" id="content" rows="5" class="form-control" required style="resize: vertical;">{{ old('content') }}</textarea>
                        @error('content')
                            <span style="font-size: 0.75rem; color: var(--danger);">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                </form>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <aside>
            <div class="sidebar-widget">
                <h4 class="sidebar-title">Kategori Halaman</h4>
                <ul class="categories-list">
                    @foreach($categories as $category)
                        <li>
                            <span>{{ $category->name }}</span>
                            <span class="badge badge-secondary">{{ $category->posts_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="sidebar-widget">
                <h4 class="sidebar-title">Postingan Terbaru</h4>
                <ul class="recent-posts-list">
                    @forelse($recentPosts as $rp)
                        <li>
                            <a href="{{ route('public.post.show', $rp->slug) }}">{{ $rp->title }}</a>
                            <span>{{ $rp->published_at ? $rp->published_at->format('d M Y') : $rp->created_at->format('d M Y') }}</span>
                        </li>
                    @empty
                        <li>Tidak ada postingan lain.</li>
                    @endforelse
                </ul>
            </div>
        </aside>
        
    </div>
</div>
@endsection
