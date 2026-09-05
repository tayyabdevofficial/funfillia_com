@extends('layouts.app')

@section('title', 'Privacy Policy - Funfillia')
@section('meta_description', 'Privacy Policy for Funfillia magazine and digital publications network.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <div class="space-y-3">
        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Legal &amp; Transparency</span>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight">Privacy Policy</h1>
        <p class="text-xs text-slate-400">Last Updated: {{ date('F d, Y') }}</p>
    </div>

    <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-8 sm:p-12 shadow-sm space-y-8 prose-content">
        <h2>1. Information We Collect</h2>
        <p>
            At Funfillia, we respect your privacy and are committed to protecting any personal information you share with us. We collect minimal information required to deliver high-quality content and seamless reader interactions:
        </p>
        <ul>
            <li><strong>Voluntary Information:</strong> Name and email address when you voluntarily subscribe to our newsletter, post comments, or submit inquiries through our contact form.</li>
            <li><strong>Automated Analytics:</strong> Aggregated anonymous data regarding visits, referring sources, browser user agents, and IP addresses to measure article popularity and safeguard against abusive traffic.</li>
        </ul>

        <h2>2. Use of Information</h2>
        <p>We use the information we collect solely to:</p>
        <ul>
            <li>Deliver requested newsletter digests and editorial updates.</li>
            <li>Moderate, approve, and display community discussion comments.</li>
            <li>Analyze reading trends to continually optimize and produce engaging entertainment, challenges, humor, and lifestyle stories.</li>
            <li>Detect and mitigate spam, bot intrusions, or malicious requests.</li>
        </ul>

        <h2>3. Third-Party Sharing</h2>
        <p>
            We do not sell, rent, trade, or share your personal data with third-party advertisers or external marketing brokers under any circumstance.
        </p>

        <h2>4. Data Security</h2>
        <p>
            Our server-to-server infrastructure employs cryptographic HMAC authentication, local caching proxies, and modern encryption standards (TLS/SSL) to protect your communications against unauthorized access or tampering.
        </p>

        <h2>5. Your Rights</h2>
        <p>
            You have the right to request access to any personal information we hold about you, request corrections, or ask for complete deletion of your subscriber data by contacting us at <code>privacy@funfillia.com</code> or clicking the unsubscribe link in any email newsletter.
        </p>
    </div>
</div>
@endsection
