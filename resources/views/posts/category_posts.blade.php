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
        @foreach ($posts as $post)
        <div class="card-masonry">
            <div class="card">
                <a href="{{ route('welcome.show', $post->slug) }}">
                    <img class="card-vertical-img" src="{{ asset('post_images').'/'.$post->image }}" alt="{{ $post->slug }}" />   
                </a>
                <div class="card-border">
                    <div class="card-body">
                        <div class="card-category">
                            <span><a href="{{ route('category.posts', $post->category->slug) }}"> {{ $post->category->title }} </a></span>
                        </div>
                        <h3 class="card-title">
                            <a href="{{ route('welcome.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p>
                            @php
                                $words = explode(' ', $post->content);
                                $firstPart = implode(' ', array_slice($words, 0, 25));
                            @endphp

                            {!! $firstPart !!}

                            @if (count($words) > 25)
                                ... <a href="{{ route('welcome.show', $post->slug) }}">Read More</a>
                            @endif
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="eskimo-date-meta">
                            <a href="single-post.html"> {{ $post->created_at->diffForHumans(); }} </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- PAGINATION -->


{{ $posts->links('vendor.pagination.custom') }}

@endsection