@extends('layouts.app')

@section('title', ($searchTerm ? 'Search: ' . $searchTerm : 'Search Content') . ' | Wisherpro')

@section('content')
<div class="clearfix"></div>

<!-- SEARCH HEADER -->
<div class="eskimo-page-title search-page-header">
    <h1>
        <span>
            @if($searchTerm)
                Search: &ldquo;{{ $searchTerm }}&rdquo;
            @else
                Explore All Content
            @endif
        </span>
    </h1>
    <p class="eskimo-page-subtitle">
        @if($totalAll > 0)
            Found <strong>{{ $counts[$type] ?? $totalAll }}</strong> {{ $type === 'all' ? 'results across all collections' : ($type === 'posts' ? 'posts & quotes' : ($type === 'galleries' ? 'gallery items' : 'videos')) }}
        @else
            No results found for your query. Try a different keyword or category.
        @endif
    </p>
</div>

<!-- SEARCH FILTER TABS -->
<div class="search-filter-nav mb-5">
    <div class="search-tabs-wrapper">
        <a href="{{ route('search.posts', ['search' => $searchTerm, 'type' => 'all']) }}"
           class="search-tab-pill {{ $type === 'all' ? 'active' : '' }}">
            <i class="fa fa-th-large"></i> All
            <span class="badge">{{ $counts['all'] }}</span>
        </a>
        <a href="{{ route('search.posts', ['search' => $searchTerm, 'type' => 'posts']) }}"
           class="search-tab-pill {{ $type === 'posts' ? 'active' : '' }}">
            <i class="fa fa-file-text-o"></i> Posts & Quotes
            <span class="badge">{{ $counts['posts'] }}</span>
        </a>
        <a href="{{ route('search.posts', ['search' => $searchTerm, 'type' => 'galleries']) }}"
           class="search-tab-pill {{ $type === 'galleries' ? 'active' : '' }}">
            <i class="fa fa-picture-o"></i> Galleries
            <span class="badge">{{ $counts['galleries'] }}</span>
        </a>
        <a href="{{ route('search.posts', ['search' => $searchTerm, 'type' => 'videos']) }}"
           class="search-tab-pill {{ $type === 'videos' ? 'active' : '' }}">
            <i class="fa fa-play-circle-o"></i> Videos
            <span class="badge">{{ $counts['videos'] }}</span>
        </a>
    </div>
</div>

{{-- EMPTY STATE --}}
@if($totalAll === 0 || ($type !== 'all' && ($counts[$type] ?? 0) === 0))
<div class="search-empty-state">
    <div class="empty-icon">
        <i class="fa fa-search-minus"></i>
    </div>
    <h3>No matching records found</h3>
    <p>We couldn't find any results matching &ldquo;<strong>{{ $searchTerm }}</strong>&rdquo; in {{ $type === 'all' ? 'our database' : $type }}.</p>
    <div class="empty-suggestions">
        <h6>Suggestions:</h6>
        <ul>
            <li>Check for spelling mistakes or typos.</li>
            <li>Try using broader or alternate keywords.</li>
            <li>Switch to the <a href="{{ route('search.posts', ['search' => $searchTerm, 'type' => 'all']) }}"><strong>&ldquo;All&rdquo; tab</strong></a> to search across all content types.</li>
        </ul>
    </div>
</div>
@endif

{{-- ================= TYPE: ALL ================= --}}
@if($type === 'all')

    {{-- POSTS SECTION --}}
    @if(isset($posts) && $posts->count() > 0)
    <div class="search-section-block mb-5">
        <div class="search-section-header d-flex justify-content-between align-items-center mb-4">
            <h4 class="eskimo-title-with-border mb-0">
                <span><i class="fa fa-file-text-o mr-2"></i> Posts & Quotes ({{ $counts['posts'] }})</span>
            </h4>
            @if($counts['posts'] > 6)
            <a href="{{ route('search.posts', ['search' => $searchTerm, 'type' => 'posts']) }}" class="btn btn-sm btn-outline-dark view-more-btn">
                View All {{ $counts['posts'] }} Posts &rarr;
            </a>
            @endif
        </div>
        <div class="eskimo-masonry-grid">
            <div class="eskimo-two-columns" data-columns>
                @foreach ($posts as $post)
                <div class="card-masonry">
                    <div class="card">
                        <a href="{{ route('welcome.show', $post->slug) }}">
                            <img class="card-vertical-img" src="{{ $post->image ? asset('storage/' . $post->image) : asset('default.png') }}" alt="{{ $post->title }}" />
                        </a>
                        <div class="card-border">
                            <div class="card-body">
                                @if($post->category)
                                <div class="card-category">
                                    <span><a href="{{ route('category.posts', $post->category->slug) }}">{{ $post->category->title }}</a></span>
                                </div>
                                @endif
                                <h3 class="card-title">
                                    <a href="{{ route('welcome.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                <p>
                                    {{ Str::limit(strip_tags($post->content), 120) }}
                                </p>
                            </div>
                            <div class="card-footer">
                                <div class="eskimo-date-meta">
                                    <span>{{ $post->created_at ? $post->created_at->diffForHumans() : '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- GALLERIES SECTION --}}
    @if(isset($galleries) && $galleries->count() > 0)
    <div class="search-section-block mb-5">
        <div class="search-section-header d-flex justify-content-between align-items-center mb-4">
            <h4 class="eskimo-title-with-border mb-0">
                <span><i class="fa fa-picture-o mr-2"></i> Galleries & Images ({{ $counts['galleries'] }})</span>
            </h4>
            @if($counts['galleries'] > 6)
            <a href="{{ route('search.posts', ['search' => $searchTerm, 'type' => 'galleries']) }}" class="btn btn-sm btn-outline-dark view-more-btn">
                View All {{ $counts['galleries'] }} Galleries &rarr;
            </a>
            @endif
        </div>
        <div class="eskimo-masonry-grid eskimo-gallery">
            <div class="eskimo-three-columns" data-columns>
                @foreach ($galleries as $gallery)
                <div class="eskimo-gallery-item">
                    <a href="{{ $gallery->image ? asset('storage/' . $gallery->image) : asset('gallery.jpg') }}"
                       data-featherlight="image"
                       class="eskimo-lightbox-item">
                        <img src="{{ $gallery->image ? asset('storage/' . $gallery->image) : asset('gallery.jpg') }}"
                             alt="{{ $gallery->title ?? 'Gallery Image' }}"
                             loading="lazy"
                             class="img-fluid rounded shadow">
                        <div class="gallery-card-meta">
                            <span class="gallery-title">{{ $gallery->title }}</span>
                            @if($gallery->category)
                            <span class="gallery-cat badge badge-primary">{{ $gallery->category->title }}</span>
                            @endif
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- VIDEOS SECTION --}}
    @if(isset($videos) && $videos->count() > 0)
    <div class="search-section-block mb-5">
        <div class="search-section-header d-flex justify-content-between align-items-center mb-4">
            <h4 class="eskimo-title-with-border mb-0">
                <span><i class="fa fa-play-circle-o mr-2"></i> Videos ({{ $counts['videos'] }})</span>
            </h4>
            @if($counts['videos'] > 6)
            <a href="{{ route('search.posts', ['search' => $searchTerm, 'type' => 'videos']) }}" class="btn btn-sm btn-outline-dark view-more-btn">
                View All {{ $counts['videos'] }} Videos &rarr;
            </a>
            @endif
        </div>
        <div class="eskimo-masonry-grid eskimo-gallery">
            <div class="eskimo-three-columns" data-columns>
                @foreach($videos as $video)
                <div class="eskimo-video-item">
                    <div class="video-card" onclick="openVideoLightbox('{{ asset('storage/' . $video->video_file) }}', '{{ addslashes($video->title) }}', '{{ asset('storage/' . $video->video_file) }}')">
                        <video
                            src="{{ asset('storage/' . $video->video_file) }}"
                            preload="metadata"
                            class="video-player">
                        </video>
                        <div class="video-overlay-play">
                            <i class="fa fa-play"></i>
                        </div>
                        <div class="video-info">
                            <div class="video-title-row">
                                <h5>{{ $video->title }}</h5>
                            </div>
                            @if($video->category)
                                <span class="badge badge-secondary mb-2">{{ $video->category->title }}</span>
                            @endif
                            @if($video->content)
                                <p>{{ Str::limit($video->content, 80) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

@endif

{{-- ================= TYPE: POSTS ================= --}}
@if($type === 'posts' && isset($posts) && $posts->count() > 0)
    <div class="eskimo-masonry-grid">
        <div class="eskimo-two-columns" data-columns>
            @foreach ($posts as $post)
            <div class="card-masonry">
                <div class="card">
                    <a href="{{ route('welcome.show', $post->slug) }}">
                        <img class="card-vertical-img" src="{{ $post->image ? asset('storage/' . $post->image) : asset('default.png') }}" alt="{{ $post->title }}" />
                    </a>
                    <div class="card-border">
                        <div class="card-body">
                            @if($post->category)
                            <div class="card-category">
                                <span><a href="{{ route('category.posts', $post->category->slug) }}">{{ $post->category->title }}</a></span>
                            </div>
                            @endif
                            <h3 class="card-title">
                                <a href="{{ route('welcome.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p>
                                {{ Str::limit(strip_tags($post->content), 140) }}
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="eskimo-date-meta">
                                <span>{{ $post->created_at ? $post->created_at->diffForHumans() : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="mt-4">
        {{ $posts->links('vendor.pagination.custom') }}
    </div>
@endif

{{-- ================= TYPE: GALLERIES ================= --}}
@if($type === 'galleries' && isset($galleries) && $galleries->count() > 0)
    <div class="eskimo-masonry-grid eskimo-gallery">
        <div class="eskimo-three-columns" data-columns>
            @foreach ($galleries as $gallery)
            <div class="eskimo-gallery-item">
                <a href="{{ $gallery->image ? asset('storage/' . $gallery->image) : asset('gallery.jpg') }}"
                   data-featherlight="image"
                   class="eskimo-lightbox-item">
                    <img src="{{ $gallery->image ? asset('storage/' . $gallery->image) : asset('gallery.jpg') }}"
                         alt="{{ $gallery->title ?? 'Gallery Image' }}"
                         loading="lazy"
                         class="img-fluid rounded shadow">
                    <div class="gallery-card-meta">
                        <span class="gallery-title">{{ $gallery->title }}</span>
                        @if($gallery->category)
                        <span class="gallery-cat badge badge-primary">{{ $gallery->category->title }}</span>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="mt-4">
        {{ $galleries->links('vendor.pagination.custom') }}
    </div>
@endif

{{-- ================= TYPE: VIDEOS ================= --}}
@if($type === 'videos' && isset($videos) && $videos->count() > 0)
    <div class="eskimo-masonry-grid eskimo-gallery">
        <div class="eskimo-three-columns" data-columns>
            @foreach($videos as $video)
            <div class="eskimo-video-item">
                <div class="video-card" onclick="openVideoLightbox('{{ asset('storage/' . $video->video_file) }}', '{{ addslashes($video->title) }}', '{{ asset('storage/' . $video->video_file) }}')">
                    <video
                        src="{{ asset('storage/' . $video->video_file) }}"
                        preload="metadata"
                        class="video-player">
                    </video>
                    <div class="video-overlay-play">
                        <i class="fa fa-play"></i>
                    </div>
                    <div class="video-info">
                        <div class="video-title-row">
                            <h5>{{ $video->title }}</h5>
                        </div>
                        @if($video->category)
                            <span class="badge badge-secondary mb-2">{{ $video->category->title }}</span>
                        @endif
                        @if($video->content)
                            <p>{{ Str::limit($video->content, 100) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="mt-4">
        {{ $videos->links('vendor.pagination.custom') }}
    </div>
@endif

<!-- Video Lightbox Modal -->
<div id="video-lightbox" class="video-lightbox" onclick="closeVideoLightbox()">
    <div class="lightbox-content" onclick="event.stopPropagation()">
        <button class="lightbox-close" onclick="closeVideoLightbox()">
            <i class="fa fa-times"></i>
        </button>
        <div class="lightbox-header">
            <h3 id="lightbox-title"></h3>
            <a id="lightbox-download" href="" download class="btn btn-default download-btn-lightbox">
                <i class="fa fa-download"></i> <span>Download</span>
            </a>
        </div>
        <div class="lightbox-video">
            <video id="lightbox-video-element" controls autoplay>
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.gallery.min.css">
<script src="https://cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.gallery.min.js"></script>

<style>
/* Search Page Styles - Strict Sharp Rectangular Theme */
.search-page-header h1 span {
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.search-filter-nav {
    display: flex;
    justify-content: center;
    margin: 25px 0 35px;
}

.search-tabs-wrapper {
    display: inline-flex;
    background: #ffffff;
    padding: 0;
    border-radius: 0 !important;
    border: 2px solid #212529;
    flex-wrap: wrap;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
}

.search-tab-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 22px;
    border-radius: 0 !important;
    border-right: 1px solid #e9ecef;
    color: #495057;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-decoration: none;
    transition: all 0.15s ease;
}

.search-tab-pill:last-child {
    border-right: none;
}

.search-tab-pill i {
    font-size: 14px;
}

.search-tab-pill .badge {
    background: #e9ecef;
    color: #212529;
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 0 !important;
}

.search-tab-pill:hover {
    color: #111;
    background: #f8f9fa;
    text-decoration: none;
}

.search-tab-pill.active {
    background: #212529 !important;
    color: #ffffff !important;
    border-radius: 0 !important;
}

.search-tab-pill.active .badge {
    background: rgba(255,255,255,0.25);
    color: #ffffff;
    border-radius: 0 !important;
}

.search-section-header {
    border-bottom: 2px solid #212529;
    padding-bottom: 12px;
}

.view-more-btn {
    border-radius: 0 !important;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 7px 18px;
    font-size: 12px;
    border: 2px solid #212529;
    background: transparent;
    color: #212529;
    transition: all 0.15s ease;
}

.view-more-btn:hover {
    background: #212529;
    color: #ffffff;
}

/* Empty State - Sharp Rectangular */
.search-empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #fafbfc;
    border-radius: 0 !important;
    border: 2px dashed #212529;
    margin: 40px auto;
    max-width: 600px;
}

.empty-icon {
    font-size: 56px;
    color: #212529;
    margin-bottom: 20px;
}

.search-empty-state h3 {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 10px;
    color: #212529;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.empty-suggestions {
    background: #ffffff;
    border: 1px solid #212529;
    border-radius: 0 !important;
    padding: 18px 24px;
    text-align: left;
    display: inline-block;
    margin-top: 20px;
}

.empty-suggestions h6 {
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.empty-suggestions ul {
    margin: 0;
    padding-left: 20px;
    color: #495057;
}

/* Gallery Items - Sharp Rectangular */
.eskimo-gallery-item {
    position: relative;
    border-radius: 0 !important;
    overflow: hidden;
    margin-bottom: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    border: 1px solid #e9ecef;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.eskimo-gallery-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

.eskimo-gallery-item img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    display: block;
    border-radius: 0 !important;
    transition: transform 0.35s ease;
}

.eskimo-gallery-item:hover img {
    transform: scale(1.04);
}

.gallery-card-meta {
    padding: 12px 14px;
    background: #ffffff;
    border-radius: 0 !important;
    border-top: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.gallery-card-meta .gallery-title {
    font-size: 14px;
    font-weight: 700;
    color: #212529;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.gallery-card-meta .badge,
.badge {
    border-radius: 0 !important;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Video Grid Item - Clean Transparent Column Wrapper */
.eskimo-video-item {
    margin-bottom: 25px;
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
}

/* Video Card - Single Solid Card (Sharp Rectangular) */
.video-card {
    background: #ffffff;
    border-radius: 0 !important;
    overflow: hidden;
    border: 1px solid #e9ecef;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    transition: all 0.25s ease;
    position: relative;
    cursor: pointer;
    margin-bottom: 0 !important;
}

.video-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.12);
}

.video-player {
    width: 100%;
    height: 220px;
    object-fit: cover;
    background: #000000;
    border-radius: 0 !important;
    pointer-events: none;
}

.video-overlay-play {
    position: absolute;
    top: 90px;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 48px;
    height: 48px;
    background: #212529;
    border-radius: 0 !important;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 16px;
    transition: all 0.2s ease;
}

.video-card:hover .video-overlay-play {
    background: #f5593d;
}

.video-info {
    padding: 15px;
    border-radius: 0 !important;
}

.video-info h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #212529;
}

.video-info p {
    margin: 6px 0 0;
    font-size: 13px;
    color: #6c757d;
}

/* Video Lightbox - Sharp Rectangular */
.video-lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    z-index: 9999999;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.video-lightbox.active {
    display: flex;
}

.lightbox-content {
    position: relative;
    max-width: 960px;
    width: 100%;
    background: #000000;
    border-radius: 0 !important;
    border: 2px solid #333333;
    overflow: hidden;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.7);
}

.lightbox-close {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 42px;
    height: 42px;
    background: #212529;
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 0 !important;
    color: #ffffff;
    cursor: pointer;
    z-index: 15;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.lightbox-close:hover {
    background: #f5593d;
}

.lightbox-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    background: linear-gradient(to bottom, rgba(0,0,0,0.85), transparent);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 10;
}

.lightbox-header h3 {
    margin: 0;
    color: #ffffff;
    font-size: 18px;
    font-weight: 700;
    flex: 1;
    padding-right: 20px;
}

.download-btn-lightbox {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #333333;
    color: #ffffff;
    text-decoration: none;
    border-radius: 0 !important;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-right: 45px;
    border: 1px solid #555555;
}

.download-btn-lightbox:hover {
    background: #f5593d;
    color: #ffffff;
    border-color: #f5593d;
}

.lightbox-video video {
    width: 100%;
    max-height: 75vh;
    display: block;
    border-radius: 0 !important;
}

/* Post Cards */
.card-masonry .card,
.card-masonry .card-border {
    border-radius: 0 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Featherlight Lightbox for Galleries
    if (typeof $.fn.featherlightGallery !== 'undefined') {
        $('.eskimo-lightbox-item').featherlightGallery({
            previousIcon: '‹',
            nextIcon: '›',
            galleryFadeIn: 300,
            galleryFadeOut: 300,
            closeOnClick: 'background',
            closeIcon: '✕'
        });
    }
});

// Video Lightbox Functions
function openVideoLightbox(videoSrc, title, downloadSrc) {
    const lightbox = document.getElementById('video-lightbox');
    const videoElement = document.getElementById('lightbox-video-element');
    const titleElement = document.getElementById('lightbox-title');
    const downloadLink = document.getElementById('lightbox-download');

    if (!lightbox || !videoElement) return;

    videoElement.src = videoSrc;
    titleElement.textContent = title;
    downloadLink.href = downloadSrc;

    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeVideoLightbox() {
    const lightbox = document.getElementById('video-lightbox');
    const videoElement = document.getElementById('lightbox-video-element');

    if (!lightbox || !videoElement) return;

    videoElement.pause();
    videoElement.src = '';
    lightbox.classList.remove('active');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeVideoLightbox();
    }
});
</script>
@endsection
