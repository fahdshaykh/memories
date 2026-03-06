@extends('layouts.app')

@section('title', 'FAQ - Wisherpro')

@section('content')
<!-- PAGE TITLE -->
<div class="eskimo-page-title">
    <h1><span>Frequently Asked Questions</span></h1>
    <p class="eskimo-page-subtitle">Find answers to common questions</p>
</div>

<!-- ACCORDION -->
<div id="mp-accordion-1" data-children=".mp-accordion-item" class="mp-accordion">
    <!-- ACCORDION ITEM 1 -->
    <div class="mp-accordion-item">
        <a class="mp-accordion-title " data-toggle="collapse" data-parent="#mp-accordion-1" href="#mp-accordion-item-1" aria-expanded="false" aria-controls="mp-accordion-item-1">
            <i class="fa fa-question-circle"></i> What is Wisherpro?
        </a>
        <div id="mp-accordion-item-1" class="collapse show" role="tabpanel">
            <div class="mp-accordion-content">
                <p>Wisherpro is a comprehensive platform for sharing and discovering amazing content including blog posts, galleries, and videos. We provide a space for creators to showcase their work and connect with audiences worldwide.</p>
            </div>
        </div>
    </div>

    <!-- ACCORDION ITEM 2 -->
    <div class="mp-accordion-item">
        <a class="mp-accordion-title collapsed" data-toggle="collapse" data-parent="#mp-accordion-1" href="#mp-accordion-item-2" aria-expanded="false" aria-controls="mp-accordion-item-2">
            <i class="fa fa-user"></i> How do I create an account?
        </a>
        <div id="mp-accordion-item-2" class="collapse" role="tabpanel">
            <div class="mp-accordion-content">
                <p>Currently, you can enjoy our content without creating an account. However, subscribing to our newsletter will keep you updated with the latest posts, galleries, and videos. Simply enter your email in the newsletter subscription form in the footer.</p>
            </div>
        </div>
    </div>

    <!-- ACCORDION ITEM 3 -->
    <div class="mp-accordion-item">
        <a class="mp-accordion-title collapsed" data-toggle="collapse" data-parent="#mp-accordion-1" href="#mp-accordion-item-3" aria-expanded="false" aria-controls="mp-accordion-item-3">
            <i class="fa fa-envelope"></i> How do I subscribe to the newsletter?
        </a>
        <div id="mp-accordion-item-3" class="collapse" role="tabpanel">
            <div class="mp-accordion-content">
                <p>You can subscribe to our newsletter by entering your email address in the subscription form located in the footer of any page. You'll receive updates about new posts, videos, and gallery additions.</p>
            </div>
        </div>
    </div>

    <!-- ACCORDION ITEM 4 -->
    <div class="mp-accordion-item">
        <a class="mp-accordion-title collapsed" data-toggle="collapse" data-parent="#mp-accordion-1" href="#mp-accordion-item-4" aria-expanded="false" aria-controls="mp-accordion-item-4">
            <i class="fa fa-download"></i> Can I download content from the site?
        </a>
        <div id="mp-accordion-item-4" class="collapse" role="tabpanel">
            <div class="mp-accordion-content">
                <p>Yes! We provide download buttons on our video and gallery pages. You can download videos and images for personal use. Please respect copyright and don't redistribute content without permission.</p>
            </div>
        </div>
    </div>

    <!-- ACCORDION ITEM 5 -->
    <div class="mp-accordion-item">
        <a class="mp-accordion-title collapsed" data-toggle="collapse" data-parent="#mp-accordion-1" href="#mp-accordion-item-5" aria-expanded="false" aria-controls="mp-accordion-item-5">
            <i class="fa fa-share-alt"></i> Can I share content on social media?
        </a>
        <div id="mp-accordion-item-5" class="collapse" role="tabpanel">
            <div class="mp-accordion-content">
                <p>Absolutely! We encourage sharing our content on social media platforms. Use the share buttons on video and gallery pages to share directly to Facebook, WhatsApp, and other platforms.</p>
            </div>
        </div>
    </div>

    <!-- ACCORDION ITEM 6 -->
    <div class="mp-accordion-item">
        <a class="mp-accordion-title collapsed" data-toggle="collapse" data-parent="#mp-accordion-1" href="#mp-accordion-item-6" aria-expanded="false" aria-controls="mp-accordion-item-6">
            <i class="fa fa-times-circle"></i> How do I unsubscribe from the newsletter?
        </a>
        <div id="mp-accordion-item-6" class="collapse" role="tabpanel">
            <div class="mp-accordion-content">
                <p>Every email we send includes an unsubscribe link. Simply click on "click here to unsubscribe" link in the footer of any newsletter email. You'll be immediately removed from our mailing list.</p>
            </div>
        </div>
    </div>

    <!-- ACCORDION ITEM 7 -->
    <div class="mp-accordion-item">
        <a class="mp-accordion-title collapsed" data-toggle="collapse" data-parent="#mp-accordion-1" href="#mp-accordion-item-7" aria-expanded="false" aria-controls="mp-accordion-item-7">
            <i class="fa fa-question"></i> How can I contact support?
        </a>
        <div id="mp-accordion-item-7" class="collapse" role="tabpanel">
            <div class="mp-accordion-content">
                <p>You can reach us through our contact page. We typically respond to all inquiries within 24-48 hours. For technical issues or general questions, don't hesitate to reach out!</p>
            </div>
        </div>
    </div>
</div>
@endsection
