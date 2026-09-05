@props(['blog' => [], 'type' => 'grid', 'rank' => null])

@php
    $title = $blog['title'] ?? 'Untitled Story';
    $slug = $blog['slug'] ?? '#';
    $detailUrl = route('blog.show', $slug);
    $date = blogger_format_date($blog['published_at'] ?? $blog['created_at'] ?? null);
    $category = $blog['category']['name'] ?? 'General';
    $categorySlug = $blog['category']['slug'] ?? null;
    $commentsCount = $blog['active_comments_count'] ?? $blog['comments_count'] ?? 0;
    
    // Views count
    $viewsCount = $blog['views_count'] ?? (is_array($blog['views'] ?? null) ? count($blog['views']) : ($blog['views'] ?? 0));
    
    // Resolve image via proxy helper
    $rawImage = $blog['image_400x300'] ?? $blog['image_850x500'] ?? $blog['image_url'] ?? $blog['thumbnail'] ?? null;
    $imageUrl = blogger_media_url($rawImage);
@endphp

@if($type === 'compact')
    <!-- Compact horizontal card for Recent Stories & Sidebars -->
    <div onclick="window.location.href='{{ $detailUrl }}'" 
         class="group flex items-center gap-3.5 p-2.5 rounded-2xl hover:bg-slate-100/80 dark:hover:bg-slate-800/70 transition-all duration-200 cursor-pointer">
        <div class="relative shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden shimmer-loading shadow-sm bg-slate-200 dark:bg-slate-800">
            <img src="{{ $imageUrl }}" alt="{{ $title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        </div>
        <div class="flex-1 min-w-0">
            @if($categorySlug)
                <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 mb-0.5">
                    {{ $category }}
                </span>
            @endif
            <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                {{ $title }}
            </h4>
            <div class="flex items-center gap-3 text-[11px] text-slate-400 mt-1">
                <span>{{ $date }}</span>
                @if($viewsCount > 0)
                    <span>&bull;</span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>{{ number_format((int)$viewsCount) }}</span>
                    </span>
                @endif
            </div>
        </div>
    </div>

@elseif($type === 'numbered')
    <!-- Numbered item for Today's Top trending ranking -->
    <div onclick="window.location.href='{{ $detailUrl }}'"
         class="group flex items-start gap-4 p-4 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/50 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
        <div class="text-3xl font-black text-slate-300 dark:text-slate-600 group-hover:text-indigo-500 dark:group-hover:text-indigo-400 transition-colors w-9 shrink-0 text-center font-mono">
            {{ sprintf('%02d', $rank ?? 1) }}
        </div>
        <div class="flex-1 min-w-0">
            @if($categorySlug)
                <span class="inline-block text-[11px] font-bold uppercase tracking-wider text-rose-500 mb-1">
                    {{ $category }}
                </span>
            @endif
            <h4 class="text-sm font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                {{ $title }}
            </h4>
            <div class="flex items-center gap-3 text-xs text-slate-400 mt-2">
                <span>{{ $date }}</span>
                <span>&bull;</span>
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>{{ number_format((int)$viewsCount) }} views</span>
                </span>
            </div>
        </div>
    </div>

@elseif($type === 'horizontal')
    <!-- Full-width Horizontal Featured Card -->
    <div onclick="window.location.href='{{ $detailUrl }}'"
         class="group bg-white dark:bg-slate-800/80 rounded-3xl border border-slate-200/80 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 grid grid-cols-1 md:grid-cols-12 gap-0 cursor-pointer">
        <div class="md:col-span-5 relative aspect-[16/10] md:aspect-auto overflow-hidden shimmer-loading bg-slate-100 dark:bg-slate-800">
            <img src="{{ $imageUrl }}" alt="{{ $title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @if($categorySlug)
                <span class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-indigo-600 dark:text-indigo-400 shadow-sm">
                    {{ $category }}
                </span>
            @endif
        </div>
        <div class="md:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 text-xs text-slate-400 mb-2">
                    <span>{{ $date }}</span>
                    <span>&bull;</span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>{{ number_format((int)$viewsCount) }} views</span>
                    </span>
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-snug mb-3">
                    {{ $title }}
                </h3>
                @if(!empty($blog['short_description']))
                    <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-3 leading-relaxed">
                        {{ $blog['short_description'] }}
                    </p>
                @endif
            </div>

            <div class="flex items-center justify-between pt-6 mt-4 border-t border-slate-100 dark:border-slate-700/60">
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span>{{ $commentsCount }} comments</span>
                    </span>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 dark:text-indigo-400 group-hover:translate-x-1 transition-transform">
                    Read Story &rarr;
                </span>
            </div>
        </div>
    </div>

@else
    <!-- Standard Grid Card -->
    <article onclick="window.location.href='{{ $detailUrl }}'"
             class="group bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col cursor-pointer">
        <!-- Thumbnail -->
        <div class="relative aspect-[16/10] overflow-hidden shimmer-loading bg-slate-100 dark:bg-slate-800">
            <img src="{{ $imageUrl }}" alt="{{ $title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            
            @if($categorySlug)
                <span class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-indigo-600 dark:text-indigo-400 shadow-sm">
                    {{ $category }}
                </span>
            @endif
        </div>

        <!-- Content Body -->
        <div class="p-6 flex-1 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-400 mb-2.5">
                    <span>{{ $date }}</span>
                    <span>&bull;</span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>{{ number_format((int)$viewsCount) }} views</span>
                    </span>
                </div>

                <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2 leading-snug mb-3">
                    {{ $title }}
                </h3>

                @if(!empty($blog['short_description']))
                    <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-2 leading-relaxed mb-4">
                        {{ $blog['short_description'] }}
                    </p>
                @endif
            </div>

            <!-- Footer Meta -->
            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700/60 text-xs">
                <div class="flex items-center gap-1.5 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>{{ $commentsCount }} comments</span>
                </div>

                <span class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 dark:text-indigo-400 group-hover:translate-x-1 transition-transform">
                    Read &rarr;
                </span>
            </div>
        </div>
    </article>
@endif
