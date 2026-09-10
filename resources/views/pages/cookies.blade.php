@extends('layouts.app')

@section('title', 'Cookie Policy - Funfillia')
@section('meta_description', 'Learn about how Funfillia uses cookies and browser storage to provide a personalized, fast reading experience.')

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
            <span class="text-indigo-600 dark:text-indigo-400">Cookies</span>
        </nav>

        <!-- Topic Pill Badge -->
        <div class="flex justify-center">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/80 shadow-sm">
                <span>🍪</span>
                <span>Transparency &amp; Cookies</span>
            </span>
        </div>

        <!-- Responsive Centered Title -->
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
            Cookie Policy
        </h1>

        <!-- Centered Subtitle -->
        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
            How Funfillia utilizes browser storage and essential cookies to provide a personalized, lightning-fast digital reading experience.
        </p>

        <!-- Metadata Chip -->
        <div class="flex items-center justify-center gap-2 pt-1 text-xs text-slate-400">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700/80">
                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Last Revised: {{ date('F d, Y') }}</span>
            </span>
        </div>
    </div>

    <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-8 sm:p-12 shadow-sm space-y-8 prose-content">
        <h2>1. What Are Cookies?</h2>
        <p>
            Cookies are small text files that are stored on your device (computer, tablet, or mobile phone) when you visit websites. They help websites recognize your browser, maintain session state, remember your visual preferences, and improve your navigation speed.
        </p>

        <h2>2. How Funfillia Uses Cookies</h2>
        <p>We use cookies and modern browser storage (e.g. LocalStorage) for the following essential purposes:</p>
        <ul>
            <li><strong>Strictly Necessary Cookies:</strong> Required to maintain security sessions, handle CSRF protection tokens during comment and form submissions, and manage system operations.</li>
            <li><strong>Functional / Aesthetic Preferences:</strong> We use LocalStorage (<code>funfillia_theme</code>) to preserve your preferred dark or light mode theme across visits with zero visual flicker.</li>
            <li><strong>Consent Management:</strong> We record your cookie preference (<code>funfillia_cookie_consent</code>) so you aren't repeatedly prompted by our consent banner.</li>
        </ul>

        <h2>3. Managing Your Preferences</h2>
        <p>
            You can modify your cookie settings at any time through your web browser preferences or clear your local browser storage. Disabling essential session cookies may affect your ability to post comments or submit forms.
        </p>

        <h2>4. Contact Us</h2>
        <p>
            If you have questions or concerns regarding our Cookie Policy, please reach out via our <a href="{{ route('pages.contact') }}">Contact Page</a> or write to <code>privacy@funfillia.com</code>.
        </p>
    </div>
</div>
@endsection
