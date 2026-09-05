@extends('layouts.app')

@php
    $catName = $category['name'] ?? 'Category';
    $catDesc = $category['description'] ?? 'Browse curated stories in ' . $catName . '.';
    $subCategories = $category['sub_categories'] ?? [];
    $catImage = blogger_media_url($category['thumbnail'] ?? null);
@endphp

@section('title', $catName . ' - Funfillia')
@section('meta_description', $catDesc)
@section('og_image', $catImage ?: asset('images/logo.png'))
@section('og_type', 'website')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Category Hero Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white p-8 sm:p-12 shadow-xl">
        <div class="max-w-2xl space-y-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                {{ $isSubCategory ? 'Subcategory' : 'Category' }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                {{ $catName }}
            </h1>
            <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                {{ $catDesc }}
            </p>
        </div>

        <!-- Subcategories Filter Pills -->
        @if(!empty($subCategories) && count($subCategories) > 0)
            <div class="mt-8 pt-6 border-t border-white/10 flex items-center gap-2 flex-wrap">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 mr-2">Topics:</span>
                @foreach($subCategories as $sub)
                    <a href="{{ route('subcategory.show', $sub['slug'] ?? '#') }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white/10 hover:bg-white/20 text-white transition-all backdrop-blur-md">
                        {{ $sub['name'] }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Main Content & Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Articles Grid (8 cols on lg) -->
        <div class="lg:col-span-8 space-y-8">
            @if(!empty($blogs) && count($blogs) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($blogs as $blog)
                        <x-blog-card :blog="$blog" type="grid" />
                    @endforeach
                </div>

                <!-- Custom Pagination -->
                @if(isset($pagination['last_page']) && $pagination['last_page'] > 1)
                    <div class="pt-8 flex items-center justify-center gap-2">
                        @for($i = 1; $i <= $pagination['last_page']; $i++)
                            <a href="?page={{ $i }}" 
                               class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold transition-all {{ ($pagination['current_page'] ?? 1) == $i ? 'bg-indigo-600 text-white shadow-md' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700' }}">
                                {{ $i }}
                            </a>
                        @endfor
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16 px-4 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 mx-auto flex items-center justify-center text-2xl">
                        ✦
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">No stories published in this category yet</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 max-w-sm mx-auto">
                        We are crafting new articles for this section. Check back soon or explore our other trending topics!
                    </p>
                    <a href="{{ route('home') }}" class="inline-block px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-md hover:bg-indigo-700 transition-colors">
                        Back to Home
                    </a>
                </div>
            @endif
        </div>

        <!-- Sidebar (4 cols on lg) -->
        <aside class="lg:col-span-4 space-y-8">
            <!-- Explore Topics with Curated Category Colors -->
            @if(!empty($allCategories) && count($allCategories) > 0)
                @php
                    $palette = [
                        ['bg' => 'bg-indigo-50/80 dark:bg-indigo-950/50', 'border' => 'border-indigo-200/80 dark:border-indigo-800/80', 'text' => 'text-indigo-700 dark:text-indigo-300', 'dot' => 'bg-indigo-500'],
                        ['bg' => 'bg-rose-50/80 dark:bg-rose-950/50', 'border' => 'border-rose-200/80 dark:border-rose-800/80', 'text' => 'text-rose-700 dark:text-rose-300', 'dot' => 'bg-rose-500'],
                        ['bg' => 'bg-amber-50/80 dark:bg-amber-950/50', 'border' => 'border-amber-200/80 dark:border-amber-800/80', 'text' => 'text-amber-700 dark:text-amber-300', 'dot' => 'bg-amber-500'],
                        ['bg' => 'bg-emerald-50/80 dark:bg-emerald-950/50', 'border' => 'border-emerald-200/80 dark:border-emerald-800/80', 'text' => 'text-emerald-700 dark:text-emerald-300', 'dot' => 'bg-emerald-500'],
                        ['bg' => 'bg-sky-50/80 dark:bg-sky-950/50', 'border' => 'border-sky-200/80 dark:border-sky-800/80', 'text' => 'text-sky-700 dark:text-sky-300', 'dot' => 'bg-sky-500'],
                        ['bg' => 'bg-purple-50/80 dark:bg-purple-950/50', 'border' => 'border-purple-200/80 dark:border-purple-800/80', 'text' => 'text-purple-700 dark:text-purple-300', 'dot' => 'bg-purple-500'],
                    ];
                @endphp
                <div class="rounded-3xl bg-white dark:bg-slate-900 p-6 border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                        <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider">Other Categories</h3>
                    </div>
                    <div class="space-y-2.5">
                        @foreach($allCategories as $index => $cat)
                            @php
                                $color = $palette[$index % count($palette)];
                                $isCurrent = ($cat['slug'] ?? '') === ($category['slug'] ?? '');
                            @endphp
                            <a href="{{ route('category.show', $cat['slug'] ?? '#') }}" 
                               class="group flex items-center justify-between p-3 rounded-2xl border transition-all duration-200 {{ $isCurrent ? 'ring-2 ring-indigo-500 bg-indigo-50 dark:bg-indigo-950/70' : $color['bg'] . ' ' . $color['border'] . ' hover:scale-[1.02] hover:shadow-sm' }}">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $color['dot'] }} group-hover:scale-125 transition-transform"></span>
                                    <span class="text-sm font-bold {{ $color['text'] }}">{{ $cat['name'] }}</span>
                                </div>
                                <span class="w-6 h-6 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-xs text-slate-400 group-hover:text-slate-900 dark:group-hover:text-white shadow-xs transition-colors">
                                    &rarr;
                                </span>
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
