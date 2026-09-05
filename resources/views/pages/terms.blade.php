@extends('layouts.app')

@section('title', 'Terms & Conditions - Funfillia')
@section('meta_description', 'Terms and conditions governing the use of Funfillia magazine and its services.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <div class="space-y-3">
        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Legal Agreement</span>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight">Terms &amp; Conditions</h1>
        <p class="text-xs text-slate-400">Effective Date: {{ date('F d, Y') }}</p>
    </div>

    <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-8 sm:p-12 shadow-sm space-y-8 prose-content">
        <h2>1. Acceptance of Terms</h2>
        <p>
            By accessing and reading Funfillia (located at <code>funfillia.com</code> or any affiliated subdomains), you agree to comply with and be bound by these Terms and Conditions. If you disagree with any part of these terms, please do not use our services.
        </p>

        <h2>2. Intellectual Property Rights</h2>
        <p>
            All original articles, photographs, custom graphics, challenge guides, layout designs, and branding marks published on Funfillia are protected by applicable intellectual property and copyright laws. You may quote excerpts or share links provided proper attribution and a direct backlink to the original article are included.
        </p>

        <h2>3. User Conduct &amp; Comments</h2>
        <p>
            When submitting comments on articles, you agree not to submit content that is defamatory, abusive, offensive, unlawful, or constitutes unsolicited promotional spam. Funfillia reserves the right to review, edit, or reject any comment that violates these guidelines.
        </p>

        <h2>4. Informational &amp; Safety Disclaimer</h2>
        <p>
            The party game rules, mystery food tasting challenges, humor skits, and entertainment guides published on Funfillia are provided for general recreational and entertainment purposes only. Always prioritize personal safety, hygiene, allergy awareness, and food temperature precautions when engaging in sensory or party challenges.
        </p>

        <h2>5. Changes to Terms</h2>
        <p>
            We may revise these Terms and Conditions at our sole discretion. Your continued use of the website following the posting of revised terms indicates your acceptance of those changes.
        </p>
    </div>
</div>
@endsection
