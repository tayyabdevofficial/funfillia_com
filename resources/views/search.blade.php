@extends('layouts.app')

@section('title', (!empty($searchTerm) ? 'Search: ' . e($searchTerm) : 'Search Stories & Trends') . ' - Funfillia')
@section('meta_description', 'Search and discover viral entertainment stories, funny pranks, comedy clips, party challenges, and modern pop trends on Funfillia.')
@section('extra_head')
    <meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Search Banner -->
    <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-8 sm:p-12 shadow-sm text-center max-w-3xl mx-auto space-y-6">
        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
            Search Funfillia Stories
        </h1>

        <form action="{{ route('search') }}" method="GET" class="relative max-w-xl mx-auto">
            <input type="search" 
                   name="q" 
                   value="{{ $searchTerm ?? '' }}"
                   placeholder="Search viral challenges, pranks, comedy, memes, gaming..." 
                   class="w-full rounded-2xl bg-slate-100 dark:bg-slate-800 py-4 pl-5 pr-28 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-medium text-base border-0">
            <button type="submit" class="absolute right-2 top-2 bottom-2 px-5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs sm:text-sm transition-colors shadow-md">
                Search
            </button>
        </form>

        @if(!empty($searchTerm))
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Showing results for <span class="font-bold text-slate-900 dark:text-white">&ldquo;{{ $searchTerm }}&rdquo;</span>
            </p>
        @endif
    </div>

    <!-- Results Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Results Column (8 cols on lg) -->
        <div class="lg:col-span-8 space-y-8">
            @if(!empty($blogs) && count($blogs) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($blogs as $blog)
                        <x-blog-card :blog="$blog" type="grid" />
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16 px-4 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 mx-auto flex items-center justify-center text-2xl">
                        🔍
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">No stories found</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 max-w-sm mx-auto">
                        We couldn't find any articles matching your search. Try different keywords or browse our categories.
                    </p>
                </div>
            @endif
        </div>

        <!-- Sidebar (4 cols on lg) -->
        <aside class="lg:col-span-4 space-y-8">
            <!-- Topics -->
            @if(!empty($allCategories) && count($allCategories) > 0)
                <div class="rounded-3xl bg-white dark:bg-slate-900 p-6 border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">Popular Categories</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($allCategories as $cat)
                            <a href="{{ route('category.show', $cat['slug'] ?? '#') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 dark:hover:text-white text-slate-700 dark:text-slate-300 transition-all">
                                {{ $cat['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recent Stories Widget -->
            @if(!empty($recentBlogs) && count($recentBlogs) > 0)
                <div class="rounded-3xl bg-white dark:bg-slate-900 p-6 border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">Recent Stories</h3>
                    <div class="space-y-2 divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach(collect($recentBlogs)->take(4) as $rec)
                            <x-blog-card :blog="$rec" type="compact" />
                        @endforeach
                    </div>
                </div>
            @endif
        </aside>
    </div>
</div>
@endsection
