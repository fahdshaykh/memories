@extends('layouts.app')

@section('title', 'User Guide - Wisherpro')

@section('content')
<!-- PAGE TITLE -->
<div class="eskimo-page-title">
    <h1><span>User Guide</span></h1>
    <p class="eskimo-page-subtitle">Learn how to make the most of Wisherpro</p>
</div>

<!-- TABS NAVIGATION -->
<ul class="nav nav-tabs">
    <!-- TAB 1 -->
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#mp-tab-1" aria-expanded="true">
            <i class="fa fa-home"></i> Getting Started
        </a>
    </li>
    <!-- TAB 2 -->
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#mp-tab-2" aria-expanded="false">
            <i class="fa fa-file-text"></i> Browsing Content
        </a>
    </li>
    <!-- TAB 3 -->
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#mp-tab-3" aria-expanded="false">
            <i class="fa fa-download"></i> Downloading
        </a>
    </li>
    <!-- TAB 4 -->
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#mp-tab-4" aria-expanded="false">
            <i class="fa fa-share-alt"></i> Sharing
        </a>
    </li>
</ul>

<!-- TABS CONTENT -->
<div class="eskimo-tabs-content tab-content">
    <!-- TAB 1 -->
    <div class="tab-pane fade active show" id="mp-tab-1" role="tabpanel" aria-expanded="true">
        <h3>Welcome to Wisherpro</h3>
        <p>Wisherpro is your destination for amazing content including blog posts, stunning galleries, and engaging videos. Here's how to get started:</p>

        <h5>Navigation</h5>
        <p>Use the sidebar menu to navigate between different sections:</p>
        <ul>
            <li><strong>Home</strong> - Latest blog posts and updates</li>
            <li><strong>Galleries</strong> - Browse beautiful image collections organized by category</li>
            <li><strong>Videos</strong> - Watch videos organized by category</li>
        </ul>

        <h5>Search</h5>
        <p>Click the search icon in the top right corner to search for specific content. You can search by post titles, content, or categories.</p>

        <h5>Newsletter</h5>
        <p>Subscribe to our newsletter using the form in the footer to receive updates about new content directly in your inbox.</p>
    </div>

    <!-- TAB 2 -->
    <div class="tab-pane fade " id="mp-tab-2" role="tabpanel" aria-expanded="false">
        <h3>Browsing Content</h3>

        <h5>Blog Posts</h5>
        <p>Browse through our collection of blog posts on the homepage. Click on any post title to read the full content. Posts are organized chronologically with the newest first.</p>

        <h5>Galleries</h5>
        <p>Visit the Galleries section to view image collections. Click on any image to view it in our lightbox. Galleries are organized by categories for easy navigation.</p>

        <h5>Videos</h5>
        <p>Watch videos in the Videos section. Click on a category to browse videos in that category. Videos can be played directly on the page and include download options.</p>

        <h5>Categories</h5>
        <p>All content is organized into categories. Use the category links to find content that interests you most.</p>
    </div>

    <!-- TAB 3 -->
    <div class="tab-pane fade " id="mp-tab-3" role="tabpanel" aria-expanded="false">
        <h3>Downloading Content</h3>

        <h5>Video Downloads</h5>
        <p>Each video page includes a download button. Simply click the download button (icon with arrow) to save the video to your device. The download button is located next to the video title and also in the video player.</p>

        <h5>Gallery Downloads</h5>
        <p>In the gallery view, click on any image to open it in the lightbox. The lightbox includes a download button that allows you to save the image to your device.</p>

        <h5>Usage Rights</h5>
        <p>Downloaded content is for personal use only. Please respect copyright and don't redistribute or use content for commercial purposes without permission.</p>
    </div>

    <!-- TAB 4 -->
    <div class="tab-pane fade " id="mp-tab-4" role="tabpanel" aria-expanded="false">
        <h3>Sharing Content</h3>

        <h5>Social Media Sharing</h5>
        <p>We've made it easy to share our content on social media:</p>
        <ul>
            <li><strong>Videos:</strong> Use the share button next to each video to share on Facebook or WhatsApp</li>
            <li><strong>Galleries:</strong> Share images directly from the gallery view using the social sharing buttons</li>
            <li><strong>Blog Posts:</strong> Share posts using your browser's share functionality</li>
        </ul>

        <h5>Direct Links</h5>
        <p>You can also copy the URL from your browser's address bar to share direct links to any content page.</p>

        <h5>Newsletter</h5>
        <p>Know someone who'd love our content? Encourage them to subscribe to our newsletter for regular updates!</p>
    </div>
</div>
@endsection
