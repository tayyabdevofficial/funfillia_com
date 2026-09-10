@extends('layouts.app')

@section('title', 'Privacy Policy - Funfillia')
@section('meta_description', 'Privacy Policy for Funfillia magazine and digital publications network.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <!-- Centered Professional Hero Header -->
    <div class="relative text-center py-8 sm:py-12 space-y-4 max-w-3xl mx-auto">
        <!-- Breadcrumbs -->
        <nav class="flex items-center justify-center gap-2 text-xs font-semibold text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Home</a>
            <span>/</span>
            <span class="text-slate-600 dark:text-slate-400">Legal</span>
            <span>/</span>
            <span class="text-indigo-600 dark:text-indigo-400">Privacy</span>
        </nav>

        <!-- Topic Pill Badge -->
        <div class="flex justify-center">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/80 shadow-sm">
                <span>🛡</span>
                <span>Legal &amp; Privacy Standards</span>
            </span>
        </div>

        <!-- Responsive Centered Title -->
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
            Privacy Policy
        </h1>

        <!-- Centered Subtitle -->
        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
            Our commitment to transparency, reader privacy, and the responsible handling of personal data across the Funfillia digital network.
        </p>

        <!-- Metadata Chip -->
        <div class="flex items-center justify-center gap-2 pt-1 text-xs text-slate-400">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700/80">
                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Last Updated: {{ date('F d, Y') }}</span>
            </span>
        </div>
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
