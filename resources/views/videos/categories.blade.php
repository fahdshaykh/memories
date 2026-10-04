@extends('layouts.app')

@section('title','Video Categories - Wisherpro')

@section('content')

<style>
/* Video Category Card - Full Bleed Filled Background Image (Image 3 Style) */
.video-card-filled {
    position: relative;
    height: 390px;
    border-radius: 0 !important;
    overflow: hidden;
    margin-bottom: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    background: #090d16;
}

.video-card-filled:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.28);
    border-color: rgba(245, 89, 61, 0.5);
}

.video-filled-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
    background-position: center;
    border-radius: 0 !important;
    transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
}

.video-card-filled:hover .video-filled-bg {
    transform: scale(1.08);
}

.video-filled-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        180deg,
        rgba(15, 23, 42, 0.35) 0%,
        rgba(15, 23, 42, 0.65) 45%,
        rgba(10, 15, 29, 0.95) 100%
    );
    border-radius: 0 !important;
    transition: opacity 0.3s ease;
}

.video-card-filled:hover .video-filled-overlay {
    background: linear-gradient(
        180deg,
        rgba(15, 23, 42, 0.25) 0%,
        rgba(15, 23, 42, 0.6) 40%,
        rgba(10, 15, 29, 0.96) 100%
    );
}

.video-filled-link {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
}

.video-filled-content {
    position: relative;
    z-index: 3;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    padding: 26px 28px;
    pointer-events: none;
}

.video-filled-content a,
.video-filled-content button,
.video-filled-btn {
    pointer-events: auto;
}

.video-filled-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.video-filled-tag {
    background: #f5593d;
    color: #ffffff;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 5px 12px;
    border-radius: 0 !important;
    box-shadow: 0 2px 10px rgba(245, 89, 61, 0.35);
}

.video-filled-count {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 5px 12px;
    border-radius: 0 !important;
}

.video-filled-bottom {
    display: flex;
    flex-direction: column;
}

.video-filled-title {
    font-size: 24px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.3;
    margin: 0 0 10px 0;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
}

.video-filled-title a {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.2s ease;
}

.video-filled-title a:hover {
    color: #f5593d;
}

.video-filled-desc {
    font-size: 14px;
    color: #cbd5e1;
    line-height: 1.55;
    margin: 0 0 18px 0;
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.6);
}

.video-filled-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 14px;
    border-top: 1px solid rgba(255, 255, 255, 0.12);
}

.video-filled-date {
    color: #94a3b8;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.video-filled-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #ffffff;
    color: #0f172a !important;
    text-decoration: none !important;
    padding: 8px 16px;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 0 !important;
    transition: all 0.25s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.video-card-filled:hover .video-filled-btn {
    background: #f5593d;
    color: #ffffff !important;
    transform: translateX(4px);
}

.video-filled-btn-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    background: #0f172a;
    color: #ffffff;
    border-radius: 0 !important;
    font-size: 10px;
    transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
}

.video-card-filled:hover .video-filled-btn-icon {
    background: #ffffff;
    color: #f5593d;
    transform: translateX(2px);
}

/* Center Film Strip Play Button Overlay (Image 3 style) */
.video-filled-play {
    position: absolute;
    top: 42%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    align-items: center;
    justify-content: center;
    filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.65));
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    z-index: 2;
    pointer-events: none;
}

.video-card-filled:hover .video-filled-play {
    transform: translate(-50%, -50%) scale(1.14);
    filter: drop-shadow(0 14px 30px rgba(245, 89, 61, 0.55));
}

@media (max-width: 767px) {
    .video-card-filled {
        height: 360px;
    }
    .video-filled-title {
        font-size: 20px;
    }
    .video-filled-content {
        padding: 20px;
    }
    .video-filled-play {
        top: 38%;
        transform: translate(-50%, -50%) scale(0.9);
    }
    .video-card-filled:hover .video-filled-play {
        transform: translate(-50%, -50%) scale(1.02);
    }
}
</style>

<div class="clearfix"></div>
<!-- PAGE TITLE -->
<div class="eskimo-page-title">
    <h1 class="no-border">Video Collections</h1>
</div>

<!-- VIDEO CATEGORIES GRID -->
<div class="eskimo-masonry-grid">
    <div class="eskimo-two-columns" data-columns>
        @foreach ($categories as $index => $category)
            @php
                $videoCount = \App\Models\Video::where('category_id', $category->id)->where('status', 1)->count();
                $imagePath = $category->image;
                if ($imagePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                    $videoImg = asset('storage/' . $imagePath);
                } elseif ($imagePath && file_exists(public_path('category_images/' . basename($imagePath)))) {
                    $videoImg = asset('category_images/' . basename($imagePath));
                } else {
                    $videoImg = asset('gallery.jpg');
                }
            @endphp

            <div class="card-masonry">
                <div class="video-card-filled">
                    <div class="video-filled-bg" style="background-image: url('{{ $videoImg }}');"></div>
                    <div class="video-filled-overlay"></div>

                    <!-- Center Film Strip Play Icon (Image 3 style) -->
                    

                    <a href="{{ route('video.show', $category->slug) }}" class="video-filled-link" aria-label="{{ $category->title }}"></a>

                    <div class="video-filled-content">
                        <!-- Top header row -->
                        <div class="video-filled-top">
                            <span class="video-filled-tag">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" style="display:inline-block; vertical-align:middle; margin-right:4px; margin-top:-2px;"><polygon points="6,4 20,12 6,20"/></svg>Videos
                            </span>
                            <span class="video-filled-count">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-right:5px; margin-top:-2px;"><rect x="2" y="2" width="20" height="20" rx="2" ry="2"></rect><line x1="7" y1="2" x2="7" y2="22"></line><line x1="17" y1="2" x2="17" y2="22"></line><line x1="2" y1="12" x2="22" y2="12"></line><line x1="2" y1="7" x2="7" y2="7"></line><line x1="2" y1="17" x2="7" y2="17"></line><line x1="17" y1="17" x2="22" y2="17"></line><line x1="17" y1="7" x2="22" y2="7"></line></svg>{{ $videoCount }} {{ $videoCount == 1 ? 'Video' : 'Videos' }}
                            </span>
                        </div>

                        <!-- Bottom info block -->
                        <div class="video-filled-bottom">
                            <h3 class="video-filled-title">
                                <a href="{{ route('video.show', $category->slug) }}">{{ $category->title }}</a>
                            </h3>

                            @if($category->content)
                                <p class="video-filled-desc">{{ Str::limit(strip_tags($category->content), 95) }}</p>
                            @else
                                <p class="video-filled-desc">Watch all video stories, quotes, and cinematic clips in this collection.</p>
                            @endif

                            <div class="video-filled-footer">
                                <span class="video-filled-date">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-right:4px; margin-top:-2px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>{{ $category->created_at->format('M Y') }}
                                </span>
                                <a href="{{ route('video.show', $category->slug) }}" class="video-filled-btn">
                                    <span>Watch Videos</span>
                                    <span class="video-filled-btn-icon">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Empty State -->
@if($categories->isEmpty())
    <div class="text-center" style="padding: 60px 20px;">
        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 20px;"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
        <h3 style="color: #666;">No Video Categories Found</h3>
        <p style="color: #999;">Check back later for new video categories!</p>
    </div>
@endif

@endsection
