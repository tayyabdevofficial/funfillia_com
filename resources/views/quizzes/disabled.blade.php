@extends('layouts.app')

@section('title', $siteTitle ?? 'Quiz Inactive - Funfillia')
@section('meta_description', 'This quiz or challenge is currently paused. Check out our other active friendship dares and quizzes on Funfillia!')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-100 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- Inactive Card Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xl p-8 sm:p-12 text-center">
            <div class="absolute -right-16 -top-16 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-xl mx-auto space-y-5">
                <div class="w-20 h-20 mx-auto rounded-3xl bg-amber-50 dark:bg-amber-950/40 text-amber-500 flex items-center justify-center text-4xl shadow-inner border border-amber-200/60 dark:border-amber-800/40">
                    ⏸️
                </div>

                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 text-xs font-bold uppercase tracking-wider">
                    Temporarily Unavailable
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ $quizTitle ?? 'This Quiz' }} Is Currently Inactive
                </h1>

                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                    {{ $message ?? 'This quiz has been paused by the admin or creator. New challenge creations and responses are temporarily paused.' }}
                </p>

                <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('quizzes.index') }}" class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-purple-600 via-pink-600 to-rose-500 hover:from-purple-500 hover:to-rose-400 text-white font-black text-sm sm:text-base shadow-lg shadow-pink-500/25 transition-all hover:scale-105 inline-flex items-center gap-2">
                        <span>✨ Explore Active Quizzes</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ route('home') }}" class="px-5 py-3.5 rounded-2xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-sm transition-colors inline-flex items-center gap-2">
                        <span>Back to Homepage</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Other Available Quizzes Section -->
        @if(!empty($otherQuizzes) && count($otherQuizzes) > 0)
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <span>🔥</span> Other Popular Quizzes You'll Love
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Pick any challenge below and dare your friends!</p>
                    </div>
                    <a href="{{ route('quizzes.index') }}" class="text-xs sm:text-sm font-bold text-pink-600 dark:text-pink-400 hover:underline">
                        View All →
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(array_slice($otherQuizzes, 0, 3) as $oq)
                        <div class="group rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between hover:-translate-y-1">
                            <div>
                                <div class="relative h-44 w-full bg-slate-900 overflow-hidden">
                                    @if(!empty($oq['image_url']))
                                        <img src="{{ $oq['image_url'] }}" alt="{{ $oq['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 flex items-center justify-center text-4xl">
                                            🎯
                                        </div>
                                    @endif
                                    <div class="absolute top-3 left-3">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-pink-600 text-white shadow-md">
                                            {{ $oq['badge'] ?? 'HOT' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors line-clamp-1">
                                        {{ $oq['title'] }}
                                    </h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 line-clamp-2">
                                        {{ $oq['description'] ?? 'Fun viral friendship dare quiz for friends.' }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-5 pt-0">
                                <a href="{{ route('quizzes.create', $oq['slug']) }}" class="w-full py-2.5 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:bg-pink-600 dark:hover:bg-pink-500 dark:hover:text-white font-bold text-xs flex items-center justify-center gap-2 transition-colors">
                                    <span>Start This Dare</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
