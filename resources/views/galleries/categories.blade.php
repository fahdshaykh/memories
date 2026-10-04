@extends('layouts.app')

@section('title','Gallery Categories - Wisherpro')

@section('content')

<style>
/* ========================================================
   Redesigned Gallery Category Card - Big Album Showcase
   ======================================================== */
.gallery-album-card {
    display: flex;
    flex-direction: column;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 0 !important;
    overflow: hidden;
    margin-bottom: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

.gallery-album-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
    border-color: #cbd5e1;
}

/* Big Photo Showcase Cover */
.gallery-album-cover {
    position: relative;
    width: 100%;
    height: 270px;
    overflow: hidden;
    background: #0f172a;
    border-radius: 0 !important;
}

.gallery-album-cover a {
    display: block;
    width: 100%;
    height: 100%;
}

.gallery-album-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    border-radius: 0 !important;
    transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
}

.gallery-album-card:hover .gallery-album-cover img {
    transform: scale(1.06);
}

/* Subtle overlay on cover */
.gallery-cover-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        180deg,
        rgba(15, 23, 42, 0.4) 0%,
        rgba(15, 23, 42, 0) 40%,
        rgba(15, 23, 42, 0.65) 100%
    );
    pointer-events: none;
}

/* Badges floating on cover */
.gallery-cover-tag {
    position: absolute;
    top: 14px;
    left: 14px;
    background: #0284c7;
    color: #ffffff;
    padding: 5px 12px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border-radius: 0 !important;
    box-shadow: 0 2px 10px rgba(2, 132, 199, 0.35);
    display: inline-flex;
    align-items: center;
    gap: 5px;
    z-index: 2;
}

.gallery-cover-date {
    position: absolute;
    top: 14px;
    right: 14px;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(6px);
    color: #ffffff;
    padding: 5px 12px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    border-radius: 0 !important;
    border: 1px solid rgba(255, 255, 255, 0.15);
    display: inline-flex;
    align-items: center;
    gap: 5px;
    z-index: 2;
}

.gallery-cover-count {
    position: absolute;
    bottom: 14px;
    left: 14px;
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(6px);
    color: #ffffff;
    padding: 6px 14px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    border-radius: 0 !important;
    border: 1px solid rgba(255, 255, 255, 0.15);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    z-index: 2;
}

/* Album Content Section */
.gallery-album-body {
    padding: 24px 26px 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
    background: #ffffff;
}

.gallery-album-title {
    font-size: 22px;
    font-weight: 800;
    line-height: 1.35;
    margin: 0 0 10px 0;
    color: #0f172a;
}

.gallery-album-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s ease;
}

.gallery-album-card:hover .gallery-album-title a {
    color: #f5593d;
}

.gallery-album-desc {
    font-size: 14px;
    color: #64748b;
    line-height: 1.6;
    margin: 0 0 20px 0;
    flex-grow: 1;
}

.gallery-album-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
}

.gallery-album-hint {
    color: #94a3b8;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-gallery-showcase {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #0f172a;
    color: #ffffff !important;
    text-decoration: none !important;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border-radius: 0 !important;
    transition: all 0.25s ease;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.15);
}

.gallery-album-card:hover .btn-gallery-showcase {
    background: #f5593d;
    transform: translateX(3px);
    box-shadow: 0 4px 15px rgba(245, 89, 61, 0.3);
}

@media (max-width: 767px) {
    .gallery-album-cover {
        height: 220px;
    }
    .gallery-album-title {
        font-size: 19px;
    }
    .gallery-album-body {
        padding: 20px;
    }
}
</style>

<div class="clearfix"></div>
<!-- PAGE TITLE -->
<div class="eskimo-page-title">
    <h1 class="no-border">Gallery Collections</h1>
</div>

<!-- GALLERY CATEGORIES GRID -->
<div class="eskimo-masonry-grid">
    <div class="eskimo-two-columns" data-columns>
        @foreach ($categories as $category)
            @php
                $galleryCount = \App\Models\Gallery::where('category_id', $category->id)->where('status', 1)->count();
                $imagePath = $category->image;
                if ($imagePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                    $catImg = asset('storage/' . $imagePath);
                } elseif ($imagePath && file_exists(public_path('category_images/' . basename($imagePath)))) {
                    $catImg = asset('category_images/' . basename($imagePath));
                } else {
                    $catImg = asset('default.png');
                }
            @endphp

        <div class="card-masonry">
            <div class="gallery-album-card">
                <!-- Big Photo Showcase Cover -->
                <div class="gallery-album-cover">
                    <a href="{{ route('gallery.show', $category->slug) }}">
                        <img src="{{ $catImg }}" alt="{{ $category->title }}" loading="lazy" />
                    </a>
                    <div class="gallery-cover-gradient"></div>

                    <!-- Top Left Tag -->
                    <span class="gallery-cover-tag">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg> Photos
                    </span>

                    <!-- Top Right Date -->
                    @if($category->created_at)
                    <span class="gallery-cover-date">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> {{ $category->created_at->format('M Y') }}
                    </span>
                    @endif

                    <!-- Bottom Left Photo Count Pill -->
                    <span class="gallery-cover-count">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg> {{ $galleryCount }} {{ $galleryCount == 1 ? 'Photo' : 'Photos' }}
                    </span>
                </div>

                <!-- Album Body -->
                <div class="gallery-album-body">
                    <h3 class="gallery-album-title">
                        <a href="{{ route('gallery.show', $category->slug) }}">{{ $category->title }}</a>
                    </h3>

                    @if($category->content)
                        <p class="gallery-album-desc">{{ Str::limit(strip_tags($category->content), 120) }}</p>
                    @else
                        <p class="gallery-album-desc">Explore beautiful high-resolution image memories and photo galleries in this collection.</p>
                    @endif

                    <div class="gallery-album-footer">
                        <span class="gallery-album-hint">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg> Photo Album
                        </span>
                        <a href="{{ route('gallery.show', $category->slug) }}" class="btn-gallery-showcase">
                            <span>View Gallery</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@if($categories->isEmpty())
    <div class="text-center" style="padding: 60px 20px;">
        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 20px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
        <h3 style="color: #666;">No Gallery Categories Found</h3>
        <p style="color: #999;">Check back later for new photo galleries!</p>
    </div>
@endif

@endsection
