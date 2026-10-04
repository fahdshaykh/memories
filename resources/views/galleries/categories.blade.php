@extends('layouts.app')

@section('title','Gallery Categories - Wisherpro')

@section('content')

<style>
.gallery-count-badge {
    display: inline-block;
    background: #212529;
    color: #fff;
    padding: 4px 12px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 0 !important;
}

.card-title-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title-wrapper h5 {
    margin: 0;
}
</style>

<div class="clearfix"></div>
<!-- PAGE TITLE -->

<div class="eskimo-page-title">
    <h1 class="no-border">Gallery Collections</h1>
</div>
<!-- BLOG POSTS -->
<div class="eskimo-masonry-grid">
    <div class="eskimo-two-columns" data-columns>
        <!-- POST 1 -->
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

        <div class="card-masonry card-small">
            <div class="card" style="border-radius: 0 !important;">
                <a href="{{ route('gallery.show', $category->slug) }}">
                    <img class="card-vertical-img" src="{{ $catImg }}" alt="{{ $category->title }}" style="border-radius: 0 !important;" />
                </a>
                <div class="card-border">
                    <div class="card-body">
                        <div class="card-title-wrapper">
                            <h5 class="card-title">
                                <a href="{{ route('gallery.show', $category->slug) }}">{{ $category->title }}</a>
                            </h5>
                            <span class="gallery-count-badge">
                                <i class="fas fa-images"></i> {{ $galleryCount }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- PAGINATION -->



@endsection
