@php
    $seoTitle = trim($__env->yieldContent('title')) ?: config('app.name', 'Wisherpro') . ' - Memories, Quotes & Stories';
    $seoDescription = trim($__env->yieldContent('meta_description')) ?: 'Discover beautiful life quotes, inspiring memories, photo galleries, and video stories on Wisherpro.';
    $seoKeywords = trim($__env->yieldContent('meta_keywords')) ?: 'quotes, memories, life quotes, inspirational stories, photography, video quotes, wisherpro';
    $canonicalUrl = trim($__env->yieldContent('canonical_url')) ?: url()->current();
    $ogType = trim($__env->yieldContent('og_type')) ?: 'website';
    $ogImage = trim($__env->yieldContent('og_image')) ?: asset('default.png');
    $metaRobots = trim($__env->yieldContent('meta_robots')) ?: 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
@endphp

<!-- Primary Meta Tags -->
<title>{{ $seoTitle }}</title>
<meta name="title" content="{{ $seoTitle }}">
<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="{{ $seoKeywords }}">
<meta name="robots" content="{{ $metaRobots }}">
<meta name="author" content="Wisherpro">
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:site_name" content="Wisherpro">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:locale" content="en_US">
@yield('og_article_tags')

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $canonicalUrl }}">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">

<!-- RSS Feed -->
<link rel="alternate" type="application/rss+xml" title="Wisherpro RSS Feed" href="{{ url('/feed') }}">

<!-- Universal WebSite & Sitelinks Search Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "Wisherpro",
    "url": "{{ url('/') }}",
    "description": "Inspiring quotes, memories, photo collections, and video stories.",
    "potentialAction": {
        "@type": "SearchAction",
        "target": {
            "@type": "EntryPoint",
            "urlTemplate": "{{ url('/search') }}?search={search_term_string}&type=all"
        },
        "query-input": "required name=search_term_string"
    }
}
</script>

<!-- Organization Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Wisherpro",
    "url": "{{ url('/') }}",
    "logo": {
        "@type": "ImageObject",
        "url": "{{ asset('default.png') }}"
    }
}
</script>

<!-- Page Specific JSON-LD Schema -->
@yield('schema_json')
