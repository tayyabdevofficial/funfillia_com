@extends('layouts.app')

@section('title', 'Cookie Policy - Funfillia')
@section('meta_description', 'Learn about how Funfillia uses cookies and browser storage to provide a personalized, fast reading experience.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <div class="space-y-3">
        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Transparency &amp; Choices</span>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight">Cookie Policy</h1>
        <p class="text-xs text-slate-400">Last Revised: {{ date('F d, Y') }}</p>
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
