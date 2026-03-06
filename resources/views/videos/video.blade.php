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
            <div class="video-card" onclick="openVideoLightbox('{{ asset('storage/' . $video->video_file) }}', '{{ $video->title }}', '{{ asset('storage/' . $video->video_file) }}')">
                <div class="share-dropdown" onclick="event.stopPropagation()">
                    <button class="share-toggle" onclick="toggleShare(this)" title="Share Video">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="18" cy="5" r="3"></circle>
                            <circle cx="6" cy="12" r="3"></circle>
                            <circle cx="18" cy="19" r="3"></circle>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                        </svg>
                    </button>
                    <div class="share-menu">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-option facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                            <span>Facebook</span>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($video->title) }}%20{{ urlencode(url()->current()) }}" target="_blank" class="share-option whatsapp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                </div>
                <video
                    src="{{ asset('storage/' . $video->video_file) }}"
                    poster="{{ asset('storage/' . $video->thumbnail) }}"
                    preload="metadata"
                    class="video-player">
                    Your browser does not support the video tag.
                </video>
                <div class="video-info">
                    <div class="video-title-row">
                        <a href="{{ asset('storage/' . $video->video_file) }}" download class="btn btn-default download-btn" title="Download Video" onclick="event.stopPropagation()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            <span></span>
                        </a>
                        <h5>{{ $video->title }}</h5>
                    </div>
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

<!-- Video Lightbox -->
<div id="video-lightbox" class="video-lightbox" onclick="closeVideoLightbox()">
    <div class="lightbox-content" onclick="event.stopPropagation()">
        <button class="lightbox-close" onclick="closeVideoLightbox()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="lightbox-header">
            <h3 id="lightbox-title"></h3>
            <a id="lightbox-download" href="" download class="btn btn-default download-btn-lightbox" style="margin-right: 40px">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Download</span>
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
    position: relative;
    cursor: pointer;
}

.video-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.share-dropdown {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 10;
}

.share-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #333;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.share-toggle:hover {
    background: #222;
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.share-menu {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    min-width: 160px;
    overflow: hidden;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.share-dropdown.active .share-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.share-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: #333;
    text-decoration: none;
    transition: all 0.2s ease;
    border-bottom: 1px solid #f0f0f0;
}

.share-option:last-child {
    border-bottom: none;
}

.share-option:hover {
    background: #f8f8f8;
}

.share-option.facebook:hover {
    background: #f0f6ff;
    color: #1877f2;
}

.share-option.whatsapp:hover {
    background: #f0fff4;
    color: #25d366;
}

.share-option span {
    font-size: 14px;
    font-weight: 500;
}

.video-player {
    width: 100%;
    height: 300px;
    object-fit: cover;
    background: #000;
    pointer-events: none;
}

.video-info {
    padding: 15px;
}

.video-title-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
}

.download-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 5px 10px;
    font-size: 10px;
    white-space: nowrap;
    flex-shrink: 0;
}

.download-btn svg {
    flex-shrink: 0;
}

.video-info h5 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
    flex: 1;
}

.video-info p {
    margin: 0;
    font-size: 14px;
    color: #666;
    line-height: 1.5;
}

/* Lightbox Styles */
.video-lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.video-lightbox.active {
    display: flex;
}

.lightbox-content {
    position: relative;
    max-width: 1000px;
    width: 100%;
    background: #000;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.5);
}

.lightbox-close {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 44px;
    height: 44px;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-close:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: rotate(90deg);
}

.lightbox-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 25px;
    background: linear-gradient(to bottom, rgba(0,0,0,0.8), transparent);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5;
}

.lightbox-header h3 {
    margin: 0;
    color: #fff;
    font-size: 20px;
    font-weight: 600;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    flex: 1;
    padding-right: 20px;
}

.download-btn-lightbox {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #333;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.download-btn-lightbox:hover {
    background: #222;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.lightbox-video {
    width: 100%;
    background: #000;
}

.lightbox-video video {
    width: 100%;
    max-height: 80vh;
    display: block;
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

    .video-title-row {
        gap: 8px;
    }

    .download-btn {
        padding: 6px 12px;
        font-size: 13px;
    }

    .download-btn span {
        display: none;
    }

    .video-info h5 {
        font-size: 16px;
    }

    .share-dropdown {
        top: 10px;
        right: 10px;
    }

    .share-toggle {
        width: 40px;
        height: 40px;
    }

    .share-menu {
        min-width: 150px;
    }

    .lightbox-content {
        max-width: 100%;
    }

    .lightbox-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        padding: 15px;
    }

    .lightbox-header h3 {
        font-size: 16px;
        padding-right: 0;
    }

    .download-btn-lightbox {
        padding: 8px 16px;
        font-size: 13px;
    }

    .lightbox-close {
        width: 38px;
        height: 38px;
    }
}
</style>

<script>
function toggleShare(button) {
    const dropdown = button.closest('.share-dropdown');
    const wasActive = dropdown.classList.contains('active');

    // Close all other dropdowns
    document.querySelectorAll('.share-dropdown').forEach(dd => {
        dd.classList.remove('active');
    });

    // Toggle current dropdown
    if (!wasActive) {
        dropdown.classList.add('active');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.share-dropdown')) {
        document.querySelectorAll('.share-dropdown').forEach(dd => {
            dd.classList.remove('active');
        });
    }
});

// Video Lightbox Functions
function openVideoLightbox(videoSrc, title, downloadSrc) {
    const lightbox = document.getElementById('video-lightbox');
    const videoElement = document.getElementById('lightbox-video-element');
    const titleElement = document.getElementById('lightbox-title');
    const downloadLink = document.getElementById('lightbox-download');

    videoElement.src = videoSrc;
    titleElement.textContent = title;
    downloadLink.href = downloadSrc;

    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeVideoLightbox() {
    const lightbox = document.getElementById('video-lightbox');
    const videoElement = document.getElementById('lightbox-video-element');

    videoElement.pause();
    videoElement.src = '';
    lightbox.classList.remove('active');
    document.body.style.overflow = '';
}

// Close lightbox on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeVideoLightbox();
    }
});
</script>
@endsection
