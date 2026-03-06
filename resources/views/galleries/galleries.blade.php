@extends('layouts.app')

@section('title','Welcome to Wisherpro')

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
                     class="img-fluid rounded shadow">
            </a>
        </div>
        @endforeach
    </div>
</div>

{{ $galleries->links('vendor.pagination.custom') }}

@endsection

{{-- YE SAB NAYA ADD KARO (END MEIN) --}}
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

        // YE FIXED HAI — SIRF EK BAR CAPTION ADD HOGA
        afterContent: function() {
            // Purani caption remove karo (agar hai to)
            this.$instance.find('.featherlight-caption').remove();

            // Nayi caption add karo
            var caption = this.$currentTarget.find('img').attr('alt') || 'Gallery Image';
            this.$instance.find('.featherlight-content').append(
                '<div class="featherlight-caption">' + caption + '</div>'
            );
        },

        // Jab lightbox band ho → caption bhi clear ho jaye
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
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
.eskimo-gallery-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}
.eskimo-gallery-item img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.eskimo-gallery-item:hover img {
    transform: scale(1.08);
}

/* Featherlight Custom */
.featherlight .featherlight-content {
    border: 8px solid #fff;
    box-shadow: 0 0 40px rgba(0,0,0,0.5);
}
.featherlight-next span, .featherlight-previous span {
    font-size: 60px !important;
    color: #fff;
    text-shadow: 0 0 10px rgba(0,0,0,0.8);
}
.featherlight-close-icon {
    background: rgba(0,0,0,0.6);
    width: 40px;
    height: 40px;
    line-height: 40px;
    border-radius: 50%;
    font-size: 20px;
}
.featherlight-caption {
    background: rgba(0,0,0,0.8);
    color: #fff;
    padding: 12px 20px;
    font-size: 16px;
    text-align: center;
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