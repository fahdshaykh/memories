@extends('layouts.app')

@section('title','Gallery Categories - Wisherpro')

@section('content')

<style>
.gallery-count-badge {
    display: inline-block;
    background: #333;
    color: #fff;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 3px;
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
    <h1 class="no-border">Welcome Memories Quotes</h1>
</div>
<!-- BLOG POSTS -->
<div class="eskimo-masonry-grid">
    <div class="eskimo-two-columns" data-columns>
        <!-- POST 1 -->
        @foreach ($categories as $category)
            @php
                $galleryCount = \App\Models\Gallery::where('category_id', $category->id)->count();
            @endphp

        <div class="card-masonry card-small">
            <div class="card">
                <a href="{{ route('gallery.show', $category->slug) }}">
                    <img class="card-vertical-img" src="{{ $category->image ? asset('storage/' . $category->image) : asset('default.png') }}" alt="{{ $category->slug }}" />
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
