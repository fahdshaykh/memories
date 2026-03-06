@extends('layouts.app')

@section('title', 'Privacy Policy - Wisherpro')

@section('content')
<!-- PAGE TITLE -->
<div class="eskimo-page-title">
    <h1><span>Privacy Policy</span></h1>
    <p class="eskimo-page-subtitle">Your privacy is important to us</p>
</div>

<div class="eskimo-intro">
    <h3>1. Information We Collect</h3>

    <h5>Personal Information</h5>
    <p>When you subscribe to our newsletter, we collect your email address. This information is voluntarily provided by you and is used solely for sending newsletters and updates.</p>

    <h5>Automatically Collected Information</h5>
    <p>We may automatically collect certain information about your visit, including:</p>
    <ul>
        <li>IP address</li>
        <li>Browser type and version</li>
        <li>Operating system</li>
        <li>Referring website</li>
        <li>Pages viewed and time spent on pages</li>
    </ul>

    <h3>2. How We Use Your Information</h3>
    <p>We use the information we collect to:</p>
    <ul>
        <li>Send you newsletters and updates about new content</li>
        <li>Improve our website and user experience</li>
        <li>Analyze website traffic and usage patterns</li>
        <li>Respond to your inquiries and requests</li>
    </ul>

    <h3>3. Newsletter Subscription</h3>
    <p>By subscribing to our newsletter:</p>
    <ul>
        <li>You will receive periodic emails about new posts, videos, and gallery content</li>
        <li>Your email address will be stored securely</li>
        <li>You can unsubscribe at any time using the link in every email</li>
        <li>We will not sell, rent, or share your email with third parties</li>
    </ul>

    <h3>4. Cookies and Web Beacons</h3>
    <p>Like many websites, we use cookies to enhance your experience and analyze site usage. Cookies are small files stored on your device that remember your preferences. You can control cookie settings through your browser.</p>

    <h3>5. Third-Party Services</h3>
    <p>We may use third-party services that collect, use, and analyze data. These include:</p>
    <ul>
        <li>Email service providers for newsletter delivery</li>
        <li>Analytics services to understand website usage</li>
        <li>Content delivery networks</li>
    </ul>

    <h3>6. Data Security</h3>
    <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet is 100% secure.</p>

    <h3>7. Your Rights</h3>
    <p>You have the right to:</p>
    <ul>
        <li>Access your personal information</li>
        <li>Correct inaccurate information</li>
        <li>Request deletion of your information</li>
        <li>Opt-out of marketing communications</li>
        <li>Unsubscribe from our newsletter at any time</li>
    </ul>

    <h3>8. Children's Privacy</h3>
    <p>Our website is not intended for children under 13. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe your child has provided us with personal information, please contact us.</p>

    <h3>9. Changes to This Policy</h3>
    <p>We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last Updated" date.</p>

    <h3>10. Contact Us</h3>
    <p>If you have any questions about this privacy policy or our data practices, please contact us through our <a href="{{ route('contact') }}">contact page</a>.</p>
</div>

<!-- ALERT SUCCESS -->
<div class="alert alert-success mt-4">
    <div class="close" data-dismiss="alert">&times;</div>
    <h6>Our Commitment</h6>
    <p>We are committed to protecting your privacy and ensuring the security of your personal information. Your trust is important to us.</p>
</div>
@endsection
