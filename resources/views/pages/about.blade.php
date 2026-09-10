@extends('layouts.app')

@section('title', 'About Us - Funfillia')
@section('meta_description', 'Discover the story behind Funfillia — your destination for viral entertainment, hilarious challenges, party games, pop culture trends, and creative lifestyle.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Centered Professional Hero Header -->
    <div class="relative text-center py-8 sm:py-12 space-y-4 max-w-3xl mx-auto">
        <!-- Breadcrumbs -->
        <nav class="flex items-center justify-center gap-2 text-xs font-semibold text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Home</a>
            <span>/</span>
            <span class="text-slate-600 dark:text-slate-400">Company</span>
            <span>/</span>
            <span class="text-indigo-600 dark:text-indigo-400">About Us</span>
        </nav>

        <!-- Topic Pill Badge -->
        <div class="flex justify-center">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/80 shadow-sm">
                <span>✦</span>
                <span>Editorial Mission &amp; Vision</span>
            </span>
        </div>

        <!-- Responsive Centered Title -->
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
            Curating Viral Joy, Games &amp; Unforgettable Entertainment
        </h1>

        <!-- Centered Subtitle -->
        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
            Funfillia is a modern digital magazine and entertainment hub dedicated to spreading laughter, thrilling sensory challenges, creative lifestyle trends, and viral internet culture.
        </p>

        <!-- Metadata Chip -->
        <div class="flex items-center justify-center gap-2 pt-1 text-xs text-slate-400">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700/80">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Verified Independent Publication</span>
            </span>
        </div>
    </div>

    <!-- Editorial Values Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl font-bold">
                🎭
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Viral Entertainment &amp; Humor</h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                Clever pranks, comedic breakdowns, trending internet culture, and uplifting stories crafted to make you smile every day.
            </p>
        </div>

        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-xl font-bold">
                🎮
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Interactive Games &amp; Challenges</h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                From blindfolded taste tests and party game setups to digital gaming competitions and brain-teasing party activities.
            </p>
        </div>

        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold">
                ✨
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Culture, Growth &amp; Life Hacks</h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                Inspiring biographies, personal growth hacks, productivity rituals, and creative insights to fuel your daily drive.
            </p>
        </div>
    </div>

    <!-- Editorial Story Body -->
    <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-8 sm:p-12 shadow-sm space-y-6 prose-content">
        <h2>Our Mission &amp; Editorial Philosophy</h2>
        <p>
            In a fast-paced digital world overflowing with monotonous news, Funfillia is built as an oasis of wholesome fun, laughter, and interactive exploration. Whether you're seeking inspiration for your next family game night, diving into hilarious social trends, or exploring captivating success stories, we curate content that connects and delights.
        </p>
        <p>
            Every story, guide, and game breakdown published across our network is produced with care, authentic humor, and verified safety tips for party activities. We believe entertainment should bring people together and spark genuine shared moments.
        </p>
        <blockquote>
            &ldquo;Laughter, curiosity, and play are not just pastimes &mdash; they are the heartbeats of shared human happiness.&rdquo;
        </blockquote>
    </div>

    <!-- Newsletter CTA -->
    <x-newsletter-box />
</div>
@endsection
