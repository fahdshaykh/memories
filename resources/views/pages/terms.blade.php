@extends('layouts.app')

@section('title', 'Terms of Service - Wisherpro')

@section('content')
<!-- PAGE TITLE -->
<div class="eskimo-page-title">
    <h1><span>Terms of Service</span></h1>
    <p class="eskimo-page-subtitle">Please read these terms carefully</p>
</div>

<div class="eskimo-intro">
    <h3>1. Introduction</h3>
    <p>Welcome to Wisherpro. By accessing or using our website, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our website.</p>

    <h3>2. Use License</h3>
    <p>Permission is granted to temporarily download one copy of the materials on Wisherpro's website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
    <ul>
        <li>modify or copy the materials</li>
        <li>use the materials for any commercial purpose or for any public display</li>
        <li>attempt to reverse engineer any software contained on the website</li>
        <li>remove any copyright or other proprietary notations from the materials</li>
    </ul>

    <h3>3. User Comments and Feedback</h3>
    <p>If you send us creative ideas, suggestions, proposals, plans, or other materials (collectively 'comments'), whether online, by email, by postal mail, or otherwise, you agree that we may, at any time, without restriction, edit, copy, publish, distribute, translate and otherwise use in any medium any comments that you forward to us.</p>

    <h3>4. Content Disclaimer</h3>
    <p>The materials on Wisherpro's website are provided 'as is'. Wisherpro makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>

    <h3>5. Downloaded Content</h3>
    <p>Content downloaded from our website is for personal use only. You may not redistribute, republish, or use downloaded content for commercial purposes without explicit permission from the copyright holder.</p>

    <h3>6. Newsletter Subscription</h3>
    <p>By subscribing to our newsletter, you agree to receive periodic emails about new content, updates, and promotional materials. You may unsubscribe at any time by clicking the unsubscribe link in any email or by contacting us directly.</p>

    <h3>7. Privacy Policy</h3>
    <p>Your privacy is important to us. Please review our Privacy Policy, which also governs the website and explains how we collect, use, and protect your personal data.</p>

    <h3>8. Limitations</h3>
    <p>In no event shall Wisherpro or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on Wisherpro's website.</p>

    <h3>9. Revisions and Errata</h3>
    <p>The materials appearing on Wisherpro's website could include technical, typographical, or photographic errors. We do not warrant that any of the materials on its website are accurate, complete, or current.</p>

    <h3>10. Governing Law</h3>
    <p>These terms and conditions are governed by and construed in accordance with the laws and you irrevocably submit to the exclusive jurisdiction of the courts in that state or location.</p>

    <h3>11. Contact Information</h3>
    <p>If you have any questions about these Terms of Service, please contact us through our contact page.</p>

    <h3>12. Changes to Terms</h3>
    <p>Wisherpro reserves the right to revise these terms at any time. By continuing to use this website after changes are posted, you agree to be bound by the revised terms.</p>
</div>

<!-- ALERT INFO -->
<div class="alert alert-info mt-4">
    <div class="close" data-dismiss="alert">&times;</div>
    <h6>Last Updated</h6>
    <p>These terms were last updated on {{ date('F j, Y') }}. Please check back periodically for any changes.</p>
</div>
@endsection
