@extends('layouts.app')

@section('title', ($category->seo_title ?: $category->title . ' Quotes & Stories') . ' | Wisherpro')
@section('meta_description', $category->seo_description ?: ('Explore inspiring ' . $category->title . ' quotes, thoughts, and memories on Wisherpro.'))
@section('meta_keywords', $category->seo_keywords ?: ($category->title . ', ' . $category->title . ' quotes, life quotes, inspirational thoughts, memories'))
@section('canonical_url', $category->canonical_url ?: route('category.posts', $category->slug))
@section('og_type', 'website')
@if($category->image)
    @section('og_image', asset('storage/' . $category->image))
@endif

@section('schema_json')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "{{ addslashes($category->title) }} Quotes & Stories",
    "description": "{{ addslashes($category->seo_description ?: 'Explore inspiring ' . $category->title . ' quotes, thoughts, and memories on Wisherpro.') }}",
    "url": "{{ route('category.posts', $category->slug) }}",
    "mainEntity": {
        "@type": "ItemList",
        "itemListElement": [
            @foreach ($posts as $index => $post)
            {
                "@type": "ListItem",
                "position": {{ $index + 1 }},
                "url": "{{ route('welcome.show', $post->slug) }}",
                "name": "{{ addslashes($post->title) }}"
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ url('/') }}"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "Categories",
            "item": "{{ url('/') }}"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": "{{ addslashes($category->title) }}",
            "item": "{{ route('category.posts', $category->slug) }}"
        }
    ]
}
</script>
@endsection

@section('content')

<div class="clearfix"></div>

<!-- BREADCRUMB NAVIGATION -->
<nav aria-label="breadcrumb" class="mb-3" style="font-size: 0.85rem; margin-top: 15px;">
    <ol class="breadcrumb" style="background: transparent; padding: 0; margin-bottom: 0; display: flex; flex-wrap: wrap; list-style: none;">
        <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: #64748b; text-decoration: none;"><i class="fa fa-home"></i> Home</a></li>
        <li style="margin: 0 8px; color: #cbd5e1;">/</li>
        <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: #64748b; text-decoration: none;">Quotes</a></li>
        <li style="margin: 0 8px; color: #cbd5e1;">/</li>
        <li class="breadcrumb-item active" aria-current="page" style="color: #0f172a; font-weight: 600;">{{ $category->title }}</li>
    </ol>
</nav>

<!-- PAGE TITLE -->
<div class="eskimo-page-title">
    <h1 class="no-border">{{ $category->title }} Quotes</h1>
    @if($category->content)
        <p class="eskimo-page-subtitle" style="margin-top: 8px; color: #64748b; font-size: 1rem;">{{ $category->content }}</p>
    @endif
</div>

<!-- BLOG POSTS -->
<div class="eskimo-masonry-grid">
    <div class="eskimo-two-columns" data-columns>
        @forelse ($posts as $post)
        <div class="card-masonry">
            <article class="card">
                <a href="{{ route('welcome.show', $post->slug) }}" aria-label="{{ $post->title }}">
                    <img class="card-vertical-img" 
                         src="{{ $post->image ? asset('storage/' . $post->image) : asset('default.png') }}" 
                         alt="{{ $post->title }} - {{ $category->title }} quote"
                         loading="lazy" />   
                </a>
                <div class="card-border">
                    <div class="card-body">
                        <div class="card-category">
                            <span><a href="{{ route('category.posts', $category->slug) }}">{{ $category->title }}</a></span>
                            <span class="eskimo-reading-time" style="color: #94a3b8; font-size: 0.75rem; margin-left: 10px;">
                                <i class="fa fa-clock-o"></i> {{ $post->reading_time ?? '2 min read' }}
                            </span>
                        </div>
                        <h2 class="card-title" style="font-size: 1.35rem; line-height: 1.3; margin-top: 6px;">
                            <a href="{{ route('welcome.show', $post->slug) }}">{{ $post->title }}</a>
                        </h2>
                        <p>
                            @php
                                $words = explode(' ', strip_tags($post->content));
                                $firstPart = implode(' ', array_slice($words, 0, 25));
                            @endphp

                            {{ $firstPart }}

                            @if (count($words) > 25)
                                ... <a href="{{ route('welcome.show', $post->slug) }}" aria-label="Read more about {{ $post->title }}">Read More</a>
                            @endif
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="eskimo-date-meta">
                            <time datetime="{{ $post->created_at->toIso8601String() }}">{{ $post->created_at->diffForHumans() }}</time>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p style="color: #64748b; font-size: 1.1rem;">No quotes found in this category yet. Check back soon!</p>
            <a href="{{ url('/') }}" class="btn btn-default" style="border-radius: 0 !important;">Explore All Quotes</a>
        </div>
        @endforelse
    </div>
</div>

<!-- PAGINATION -->
{{ $posts->links('vendor.pagination.custom') }}

@endsection