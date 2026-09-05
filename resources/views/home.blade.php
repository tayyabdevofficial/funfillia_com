@extends('layouts.app')

@section('title', 'Funfillia - Modern Stories, Recipes, Fashion & Trends')
@section('meta_description', 'Discover fresh recipes, trendy styles, lifestyle hacks, and viral stories curated daily on Funfillia.')

@section('content')
    <!-- Hero Slider / Top Spotlight -->
    @if(!empty($headerSliderBlogs) && count($headerSliderBlogs) > 0)
        <x-hero-slider :blogs="$headerSliderBlogs" />
    @endif

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-16">

        <!-- Featured Stories & Top 5 Trending Ranking -->
        <section>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-500">Editor's Choice</span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Featured Highlights</h2>
                </div>
                <div class="h-1 flex-1 mx-6 bg-slate-100 dark:bg-slate-800 rounded-full hidden md:block"></div>
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Curated Daily</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Main Featured Articles (8 cols on lg) -->
                <div class="lg:col-span-8 space-y-8">
                    @if(!empty($featuredBlogs) && count($featuredBlogs) > 0)
                        <!-- Large Horizontal Feature -->
                        <x-blog-card :blog="$featuredBlogs[0]" type="horizontal" />

                        <!-- Sub-grid of remaining featured -->
                        @if(count($featuredBlogs) > 1)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                                @foreach(array_slice($featuredBlogs, 1, 4) as $featured)
                                    <x-blog-card :blog="$featured" type="grid" />
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Today's Top Most Viewed Ranking Sidebar (4 cols on lg) -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="rounded-3xl bg-slate-100/70 dark:bg-slate-900/60 p-6 border border-slate-200/80 dark:border-slate-800">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
                            <h3 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">Most Popular Today</h3>
                        </div>

                        <div class="space-y-4">
                            @if(!empty($todayTopBlogs) && count($todayTopBlogs) > 0)
                                @foreach(collect($todayTopBlogs)->take(5) as $index => $topBlog)
                                    <x-blog-card :blog="$topBlog" type="numbered" :rank="$index + 1" />
                                @endforeach
                            @elseif(!empty($recentBlogs))
                                @foreach(collect($recentBlogs)->take(5) as $index => $topBlog)
                                    <x-blog-card :blog="$topBlog" type="numbered" :rank="$index + 1" />
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Category Cloud Widget -->
                    @if(!empty($allCategories) && count($allCategories) > 0)
                        <div class="rounded-3xl bg-white dark:bg-slate-900/80 p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                            <h3 class="text-base font-black text-slate-900 dark:text-white mb-4">Explore Topics</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($allCategories as $cat)
                                    <a href="{{ route('category.show', $cat['slug'] ?? '#') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 dark:hover:text-white text-slate-700 dark:text-slate-300 transition-all">
                                        {{ $cat['name'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Newsletter Subscription Callout -->
        <x-newsletter-box />

        <!-- Recent Articles Feed -->
        <section>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Latest Updates</span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Recent Stories</h2>
                </div>
                <a href="{{ route('search') }}" class="text-xs sm:text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                    <span>View All Articles</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recentBlogs as $blog)
                    <x-blog-card :blog="$blog" type="grid" />
                @endforeach
            </div>
        </section>

    </div>
@endsection
