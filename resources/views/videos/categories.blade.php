@extends('layouts.app')

@section('title','Video Categories - Wisherpro')

@section('content')

<style>
.video-card-modern {
    position: relative;
    background: #fff;
    border-radius: 0 !important;
    border: 1px solid #e9ecef;
    margin-bottom: 30px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    transition: all 0.25s ease;
}

.video-card-modern:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
}

.video-card-modern .video-thumb {
    position: relative;
    height: 220px;
    overflow: hidden;
    border-radius: 0 !important;
}

.video-card-modern .video-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0 !important;
    transition: transform 0.5s ease;
}

.video-card-modern:hover .video-thumb img {
    transform: scale(1.1);
}

.video-card-modern .video-overlay {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #212529;
    color: #fff;
    padding: 6px 14px;
    border-radius: 0 !important;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.video-card-modern .video-body {
    padding: 20px;
}

.video-card-modern .video-body h3 {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 12px 0;
    color: #212529;
}

.video-card-modern .video-stats {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}

.video-card-modern .stat {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #777;
}

.video-card-modern .stat i {
    font-size: 14px;
    color: #212529;
}

.video-card-modern .video-desc {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
    margin-bottom: 15px;
}

.video-card-modern .video-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #f0f0f0;
}

.video-card-modern .view-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    background: #212529;
    color: #fff;
    text-decoration: none;
    border-radius: 0 !important;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.2s ease;
}

.video-card-modern .view-link:hover {
    background: #f5593d;
    color: #fff;
}

.video-card-modern .date-info {
    font-size: 12px;
    color: #999;
}

@media (max-width: 768px) {
    .video-card-modern .video-thumb {
        height: 180px;
    }
}
</style>

<div class="clearfix"></div>
<!-- PAGE TITLE -->
<div class="eskimo-page-title">
    <h1 class="no-border">Video Collections</h1>
</div>

<!-- Video Categories Grid -->
<div class="eskimo-masonry-grid">
    <div class="eskimo-two-columns" data-columns>
        @foreach ($categories as $index => $category)
            @php
                $videoCount = \App\Models\Video::where('category_id', $category->id)->count();
            @endphp

            <div class="card-masonry card-small">
                <div class="video-card-modern">
                    <div class="video-thumb">
                        <a href="{{ route('video.show', $category->slug) }}">
                            <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('gallery.jpg') }}"
                                 alt="{{ $category->title }}">
                        </a>
                        @if($index === 0)
                            {{-- <span class="video-overlay">⭐ Featured</span> --}}
                        @endif
                    </div>

                    <div class="video-body">
                        <h3>{{ $category->title }}</h3>

                        <div class="video-stats">
                            <div class="stat">
                                <i class="fas fa-video"></i>
                                <span>{{ $videoCount }} {{ $videoCount == 1 ? 'Video' : 'Videos' }}</span>
                            </div>
                            @if($category->description)
                            <div class="stat">
                                <i class="fas fa-align-left"></i>
                                <span>{{ Str::limit(strip_tags($category->description), 20) }}</span>
                            </div>
                            @endif
                        </div>

                        @if($category->description)
                        <p class="video-desc">{{ Str::limit(strip_tags($category->description), 80) }}</p>
                        @endif

                        <div class="video-footer">
                            <span class="date-info">
                                <i class="far fa-calendar-alt"></i>
                                {{ $category->created_at->format('M Y') }}
                            </span>
                            <a href="{{ route('video.show', $category->slug) }}" class="view-link">
                                Watch Videos
                            </a>
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
        <i class="fas fa-video" style="font-size: 64px; color: #ddd; margin-bottom: 20px;"></i>
        <h3 style="color: #666;">No Video Categories Found</h3>
        <p style="color: #999;">Check back later for new video categories!</p>
    </div>
@endif

@endsection
