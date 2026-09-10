@extends('layouts.app')

@section('title', 'Terms & Conditions - Funfillia')
@section('meta_description', 'Terms and conditions governing the use of Funfillia magazine and its services.')

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
            <span class="text-indigo-600 dark:text-indigo-400">Terms</span>
        </nav>

        <!-- Topic Pill Badge -->
        <div class="flex justify-center">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/80 shadow-sm">
                <span>⚖</span>
                <span>User Terms &amp; Guidelines</span>
            </span>
        </div>

        <!-- Responsive Centered Title -->
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
            Terms &amp; Conditions
        </h1>

        <!-- Centered Subtitle -->
        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
            Clear guidelines and conditions governing the access, entertainment content, and reader community participation on Funfillia.
        </p>

        <!-- Metadata Chip -->
        <div class="flex items-center justify-center gap-2 pt-1 text-xs text-slate-400">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700/80">
                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Effective Date: {{ date('F d, Y') }}</span>
            </span>
        </div>
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
