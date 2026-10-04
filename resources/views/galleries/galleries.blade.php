@extends('layouts.app')

@section('title', $category->title . ' Galleries | Wisherpro')

@section('content')

<div class="clearfix"></div>
<div class="eskimo-page-title">
    <h1><span>Galleries</span></h1>
    <p class="eskimo-page-subtitle">You can see {{ $category->title }} galleries...</p>
</div>

<h2>{{ $category->title }}</h2>
<p>{{ $category->content }}</p>

<!-- IMAGE GALLERY -->
<div class="eskimo-masonry-grid eskimo-gallery">
    <div class="eskimo-three-columns" data-columns>
        @foreach ($galleries as $gallery)
        <div class="eskimo-gallery-item">
            <div class="share-dropdown" onclick="event.stopPropagation()">
                <button class="share-toggle" onclick="toggleShare(this)" title="Share Image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="18" cy="5" r="3"></circle>
                        <circle cx="6" cy="12" r="3"></circle>
                        <circle cx="18" cy="19" r="3"></circle>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                    </svg>
                </button>
                <div class="share-menu">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($gallery->image ? asset('storage/' . $gallery->image) : url()->current()) }}" target="_blank" class="share-option facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                        <span>Facebook</span>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode(($gallery->title ? $gallery->title . ' - ' : '') . ($gallery->image ? asset('storage/' . $gallery->image) : url()->current())) }}" target="_blank" class="share-option whatsapp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        <span>WhatsApp</span>
                    </a>
                </div>
            </div>
            <a href="{{ $gallery->image ? asset('storage/' . $gallery->image) : asset('placeholder.jpg') }}"
               data-featherlight="image"
               class="eskimo-lightbox-item">
                <img src="{{ $gallery->image ? asset('storage/' . $gallery->image) : asset('placeholder.jpg') }}"
                     alt="{{ $gallery->title ?? 'Gallery Image' }}"
                     loading="lazy"
                     class="img-fluid shadow">
            </a>
        </div>
        @endforeach
    </div>
</div>

{{ $galleries->links('vendor.pagination.custom') }}

@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.gallery.min.css">

<script src="https://cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.gallery.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.eskimo-lightbox-item').featherlightGallery({
        previousIcon: '‹',
        nextIcon: '›',
        galleryFadeIn: 300,
        galleryFadeOut: 300,
        closeOnClick: 'background',
        closeIcon: '✕',
        openSpeed: 300,
        closeSpeed: 300,

        afterContent: function() {
            this.$instance.find('.featherlight-caption').remove();
            var caption = this.$currentTarget.find('img').attr('alt') || 'Gallery Image';
            this.$instance.find('.featherlight-content').append(
                '<div class="featherlight-caption">' + caption + '</div>'
            );
        },

        beforeClose: function() {
            this.$instance.find('.featherlight-caption').remove();
        }
    });
});

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
</script>

<style>
.eskimo-gallery-item {
    position: relative;
    margin-bottom: 20px;
    overflow: hidden;
    border-radius: 0 !important;
    border: 1px solid #e9ecef;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    transition: all 0.25s ease;
}
.eskimo-gallery-item:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.12);
}
.eskimo-gallery-item img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-radius: 0 !important;
    transition: transform 0.4s ease;
}
.eskimo-gallery-item:hover img {
    transform: scale(1.06);
}

/* Share Dropdown - Identical to Video Listing */
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
    width: 40px;
    height: 40px;
    border-radius: 0 !important;
    background: #212529;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.share-toggle:hover {
    background: #f5593d;
    transform: scale(1.05);
}

.share-menu {
    position: absolute;
    top: calc(100% + 4px);
    right: 0;
    background: #fff;
    border-radius: 0 !important;
    border: 1px solid #212529;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    min-width: 160px;
    overflow: hidden;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-6px);
    transition: all 0.2s ease;
    z-index: 100;
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

@media (max-width: 768px) {
    .share-toggle {
        width: 36px;
        height: 36px;
    }
    .share-dropdown {
        top: 10px;
        right: 10px;
    }
}

/* Featherlight Custom - Sharp Rectangular */
.featherlight .featherlight-content {
    border: 4px solid #fff;
    border-radius: 0 !important;
    box-shadow: 0 0 40px rgba(0,0,0,0.5);
}
.featherlight-next span, .featherlight-previous span {
    font-size: 60px !important;
    color: #fff;
    text-shadow: 0 0 10px rgba(0,0,0,0.8);
}
.featherlight-close-icon {
    background: #212529;
    width: 40px;
    height: 40px;
    line-height: 40px;
    border-radius: 0 !important;
    font-size: 18px;
}
.featherlight-caption {
    background: rgba(0,0,0,0.85);
    color: #fff;
    padding: 12px 20px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: center;
    border-radius: 0 !important;
    margin-top: 10px;
}
.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 50px auto;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
@endsection