@extends('layouts.app')

@section('title','Welcome to Wisherpro')

@section('content')

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

        <div class="card-masonry card-small">
            <div class="card">
                <a href="{{ route('video.show', $category->slug) }}">
                    <img class="card-vertical-img" src="{{ asset('category_images').'/'.$category->image }}" alt="{{ $category->slug }}" />    
                </a>
                <div class="card-border">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('video.show', $category->slug) }}"> {{ $category->title }} </a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- PAGINATION -->



@endsection