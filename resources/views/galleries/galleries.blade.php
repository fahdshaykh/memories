@extends('layouts.app')

@section('title','Welcome to Wisherpro')

@section('content')

<div class="clearfix"></div>
<!-- PAGE TITLE -->
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
        <!-- GALLERY ITEM 1 -->
        {{-- <div class="eskimo-gallery-item">
            <a href="{{ asset('gallery_images').'/'.$gallery->image }}" data-featherlight="{{ asset('gallery_images').'/'.$gallery->image }}" class="eskimo-lightbox">
                <img src="{{ asset('gallery_images').'/'.$gallery->image }}" alt="" />
            </a>
        </div> --}}

        <div class="eskimo-gallery-item">
            <a href="#" data-featherlight="{{ asset('gallery_images').'/'.$gallery->image }}" class="eskimo-lightbox">
                <img src="{{ asset('gallery_images').'/'.$gallery->image }}" width="1200px" height="400px" alt="" />
            </a>
        </div>
        @endforeach
    </div>
</div>
<!-- PAGE TITLE -->


{{ $galleries->links('vendor.pagination.custom') }}

@endsection