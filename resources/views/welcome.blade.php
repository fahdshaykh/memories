@extends('layouts.app')

@section('title', 'Wisherpro - Inspiring Memories, Quotes & Stories')
@section('meta_description', 'Discover heartfelt quotes, cherished memories, life stories, photo collections, and inspirational videos on Wisherpro.')
@section('meta_keywords', 'quotes, life quotes, inspirational memories, wisdom, daily quotes, photo stories, video quotes')
@section('canonical_url', url('/'))

@section('schema_json')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "Wisherpro - Inspiring Memories, Quotes & Stories",
    "description": "Discover heartfelt quotes, cherished memories, life stories, photo collections, and inspirational videos.",
    "url": "{{ url('/') }}",
    "mainEntity": {
        "@type": "ItemList",
        "itemListElement": [
            @foreach($posts->take(10) as $index => $item)
            {
                "@type": "ListItem",
                "position": {{ $index + 1 }},
                "url": "{{ route('welcome.show', $item->slug) }}",
                "name": "{{ addslashes($item->title) }}"
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
}
</script>
@endsection

@section('content')

<div class="clearfix"></div>
<!-- PAGE TITLE -->

<div class="eskimo-page-title">
    <h1 class="no-border">Inspiring Memories & Quotes</h1>
</div>
<!-- BLOG POSTS -->
<div class="eskimo-masonry-grid">
    <div class="eskimo-two-columns" data-columns>
        <!-- POST 1 -->
        @foreach ($posts as $post)
        <div class="card-masonry">
            <div class="card">
                <a href="{{ route('welcome.show', $post->slug) }}">
                    <img class="card-vertical-img" src="{{ $post->image ? asset('storage/' . $post->image) : asset('default.png') }}" alt="{{ $post->title }}" loading="lazy" decoding="async" />   
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