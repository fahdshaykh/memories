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
</script>

<style>
.eskimo-gallery-item {
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