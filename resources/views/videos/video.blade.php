@extends('layouts.app')

@section('title','Welcome to Wisherpro')

@section('content')

<div class="clearfix"></div>
<div class="eskimo-page-title">
    <h1><span>{{ $category->title }}</span></h1>
    <p class="eskimo-page-subtitle">{{ $category->title }} videos collection</p>
</div>

@if($category->content)
<div class="mb-4">
    <p>{{ $category->content }}</p>
</div>
@endif

<!-- VIDEO GALLERY -->
<div class="eskimo-masonry-grid eskimo-gallery">
    <div class="eskimo-three-columns" data-columns>
        @forelse($videos as $video)
        <div class="eskimo-gallery-item">
            <div class="video-card">
                <video
                    src="{{ asset('storage/' . $video->video_file) }}"
                    poster="{{ asset('storage/' . $video->thumbnail) }}"
                    controls
                    preload="metadata"
                    class="video-player">
                    Your browser does not support the video tag.
                </video>
                <div class="video-info">
                    <h5>{{ $video->title }}</h5>
                    @if($video->content)
                        <p>{{ Str::limit($video->content, 100) }}</p>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center text-muted">No videos found in this category.</p>
        </div>
        @endforelse
    </div>
</div>

{{ $videos->links('vendor.pagination.custom') }}

@endsection

{{-- Video Gallery Styles --}}
@section('scripts')
<style>
.eskimo-gallery-item {
    margin-bottom: 30px;
}

.video-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.video-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.video-player {
    width: 100%;
    height: 300px;
    object-fit: cover;
    background: #000;
}

.video-info {
    padding: 15px;
}

.video-info h5 {
    margin: 0 0 10px 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.video-info p {
    margin: 0;
    font-size: 14px;
    color: #666;
    line-height: 1.5;
}

/* Pagination */
.eskimo-masonry-grid .pagination {
    margin-top: 40px;
}

/* Responsive */
@media (max-width: 768px) {
    .video-player {
        height: 250px;
    }

    .eskimo-three-columns[data-columns]::before {
        content: '1 .column.size-1of1';
    }
}
</style>
@endsection
