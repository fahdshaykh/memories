@extends('layouts.app')

@section('title', 'Contact Us - Wisherpro')

@section('content')
<!-- PAGE TITLE -->
<div class="eskimo-page-title">
    <h1><span>Contact Us</span></h1>
    <p class="eskimo-page-subtitle">We'd love to hear from you</p>
</div>

<div class="row">
    <!-- Contact Form -->
    <div class="col-12 col-lg-8">
        <h5 class="eskimo-title-with-border"><span>Send us a Message</span></h5>

        @if(session('success'))
            <!-- ALERT SUCCESS -->
            <div class="alert alert-success">
                <div class="close" data-dismiss="alert">&times;</div>
                <h6>Success</h6>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form method="post" action="{{ route('contact.submit') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your name">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
            </div>

            <!-- Subject -->
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" required placeholder="What is this about?">
            </div>

            <!-- Message -->
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="6" required placeholder="Your message here..."></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
        </form>
    </div>

    <!-- Contact Info -->
    <div class="col-12 col-lg-4">
        <h5 class="eskimo-title-with-border"><span>Contact Information</span></h5>

        <!-- Email -->
        <div class="eskimo-intro">
            <p><i class="fa fa-envelope"></i> <strong>Email:</strong></p>
            <p>support@wisherpro.com</p>
        </div>

        <!-- Response Time -->
        <hr>
        <div class="eskimo-intro">
            <p><i class="fa fa-clock"></i> <strong>Response Time:</strong></p>
            <p>We typically respond to all inquiries within 24-48 hours during business days.</p>
        </div>

        <!-- Social Media -->
        <hr>
        <div class="eskimo-intro">
            <p><i class="fa fa-share-alt"></i> <strong>Follow Us:</strong></p>
            <p>Stay connected with us on social media for the latest updates and content.</p>
        </div>

        <!-- FAQ Link -->
        <hr>
        <div class="eskimo-intro">
            <p><i class="fa fa-question-circle"></i> <strong>Have Questions?</strong></p>
            <p>Check out our <a href="{{ route('faq') }}">FAQ page</a> for answers to common questions.</p>
        </div>
    </div>
</div>
@endsection
